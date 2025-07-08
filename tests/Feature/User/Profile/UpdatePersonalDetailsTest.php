<?php

namespace Tests\Feature\User\Profile;

use App\Enums\common\{
    UserGuard,
    UserRole,
};
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdatePersonalDetailsTest extends TestCase
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
     * The old personal details of the user.
     *
     * @var array
     */
    protected array $oldDetails;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->oldDetails = [
            'name' => 'old name',
            'address' => 'old address',
            'tel' => '09999999999',
            'birth_date' => '2004-08-22',
        ];

        $this->user = User::factory()->create([
            'user_role' => UserRole::JOB_SEEKER,
            'email_verified_at' => now(),
            ...$this->oldDetails,
        ]);

        $this->actingAs($this->user, self::GUARD);
    }

    /**
     * Test if user can upload personal details successfully.
     *
     * @return void
     */
    public function testUserCanUpdatePersonalDetailsSuccessfully(): void
    {
        // Act
        $response = $this->put(route('user.profile.update', ['id' => $this->user->id]), [
            'name' => 'updated name',
            'address' => 'test address',
            'tel' => '09689090293',
            'birth_date' => '2004-08-21',
        ]);

        $this->user->refresh();

        // Assert
        $response->assertRedirectBack()
            ->assertSessionHas('success', __('message.success.resume_uploaded_successfully'));

        $this->assertDatabaseMissing('users', $this->oldDetails);
    }
}
