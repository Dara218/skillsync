<?php

namespace Tests\Feature\User\Profile;

use App\Enums\common\{
    UserGuard,
    UserRole,
};
use App\Models\User;
use App\Service\Common\S3Service;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\{
    Testing\File,
    UploadedFile,
};
use Tests\TestCase;

class UploadResumeTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * User model instance.
     *
     * @var \App\Models\User $user
     */
    protected User $user;

    /**
     * The user guard.
     *
     * @return string
     */
    protected const GUARD = UserGuard::USER->value;

    /**
     * The resume file path (user/resume/).
     *
     * @return string
     */
    protected const RESUME_FILE_PATH = config('filesystems.paths.resume');

    /**
     * The fake resume.
     *
     * @var \Illuminate\Http\Testing\File $fakeResume
     */
    protected File $fakeResume;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeResume = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf');

        $this->user = User::factory()->create([
            'user_role' => UserRole::JOB_SEEKER,
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'resume_path' => null,
        ]);

        $this->actingAs($this->user, self::GUARD);
    }

    /**
     * Test if user can upload the resume successfully.
     *
     * @return void
     */
    public function testUserCanUploadResumeSuccessfully(): void
    {
        // Arrange
        $fakeResumePath = self::RESUME_FILE_PATH . $this->fakeResume->getClientOriginalName();

        // Act
        $this->mock(S3Service::class, function($mock) use ($fakeResumePath) {
            // Check if resume exists
            $mock->shouldReceive('exists')
                ->with($this->fakeResume->getClientOriginalName())
                ->andReturn(false); // No existing resume

            // Update resume
            $mock->shouldReceive('put')
                ->withArgs(fn ($path, $contents) => str_contains($path, $fakeResumePath))
                ->once();
        });

        $response = $this->put(route('user.resume.upload'), [
            'resume_path' => $this->fakeResume,
        ]);

        // Assert
        $response->assertRedirectBack()
            ->assertSessionHas('success', __('message.success.resume_uploaded_successfully'));

        $this->assertDatabaseHas('users', [
            'resume_path' => $fakeResumePath,
        ]);
    }

    /**
     * Test if user can replace the resume successfully.
     *
     * @return void
     */
    public function testUserCanReplaceResumeSuccessfully(): void
    {
        // Arrange
        $oldResumePath = self::RESUME_FILE_PATH . $this->fakeResume->getClientOriginalName();
        $newResume = UploadedFile::fake()->create('new_resume.pdf', 200, 'application/pdf');

        $this->updateUserResumePath($oldResumePath);

        // Act
        $this->mock(S3Service::class, function ($mock) use ($oldResumePath, $newResume) {
            // Check if resume exists
            $mock->shouldReceive('exists')
                ->with($oldResumePath)
                ->andReturn(true) // Existing resume
                ->once();

            // Delete existing
            $mock->shouldReceive('delete')
                ->with($oldResumePath)
                ->once();

            // Update resume
            $mock->shouldReceive('put')
                ->withArgs(fn ($path, $contents) => str_contains($path, $newResume->getClientOriginalName()))
                ->once();
        });

        $response = $this->put(route('user.resume.upload'), [
            'resume_path' => $newResume,
        ]);

        // Assert
        $response->assertRedirectBack()
            ->assertSessionHas('success', __('message.success.resume_uploaded_successfully'));

        $this->assertDatabaseHas('users', [
            'resume_path' => self::RESUME_FILE_PATH . $newResume->getClientOriginalName(),
        ]);
    }

    /**
     * Test if user can delete the resume successfully.
     *
     * @return void
     */
    public function testUserCanDeleteResumeSuccessfully(): void
    {
        // Arrange
        $fakeResumePath = self::RESUME_FILE_PATH . $this->fakeResume->getClientOriginalName();

        $this->updateUserResumePath($fakeResumePath);

        // Act
        $this->mock(S3Service::class, function ($mock) use ($fakeResumePath) {
            // Check if resume exists
            $mock->shouldReceive('exists')
                ->with($fakeResumePath)
                ->andReturn(true) // Existing resume
                ->once();

            // Delete existing
            $mock->shouldReceive('delete')
                ->with($fakeResumePath)
                ->andReturn(true)
                ->once();
        });

        $response = $this->delete(route('user.resume.delete'));

        // Assert
        $response->assertRedirectBack()
            ->assertSessionHas('success', __('message.success.resume_deleted_successfully'));

        $this->assertDatabaseMissing('users', [
            'resume_path' => $fakeResumePath,
        ]);
    }

    /**
     * Update the user resume path.
     *
     * @param mixed $resumePath (users.resume_path) value
     *
     * @return void
     */
    public function updateUserResumePath($resumePath): void
    {
        $this->user->update([
            'resume_path' => $resumePath,
        ]);

        $this->user->refresh();
    }
}
