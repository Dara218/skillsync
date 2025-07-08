<?php

namespace Tests\Feature\User\Verify;

use App\Enums\common\{
    UserGuard,
    UserRole,
};
use App\Models\{
    User,
    UserSignupCode,
};
use App\Service\User\Verification\UserVerificationService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VerifyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * The user guard.
     *
     * @return string
     */
    protected const GUARD = UserGuard::USER->value;

    /**
     * User model instance.
     *
     * @var \App\Models\User $user
     */
    protected User $user;

    /**
     * UserSignupCode model instance.
     *
     * @var \App\Models\UserSignupCode $signupCode
     */
    protected UserSignupCode $signupCode;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'user_role' => UserRole::JOB_SEEKER,
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => null,
        ]);

        $this->signupCode = UserSignupCode::factory()->create([
            'email' => $this->user->email,
        ]);

        $this->actingAs($this->user, self::GUARD);
    }

    /**
     * Test if a user can verify email successfully.
     *
     * @return void
     */
    public function testUserCanVerifyEmailSuccessfully(): void
    {
        // Arrange
        $singupCode = $this->signupCode->code;

        // Act
        // $this->mock(UserVerificationService::class, function ($mock) use ($singupCode) {
        //     $mock->shouldReceive('handleVerification')
        //         ->with($singupCode)
        //         ->once()
        //         ->andReturn(true);
        // });

        $response = $this->post(route('user.verify.index'), [
            'code' => $singupCode
        ]);

        $this->user->refresh();

        // Assert
        $response->assertRedirect(route('user.dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => $this->user->email,
            'email_verified_at' => $this->user->email_verified_at,
        ]);
    }

    /**
     * Test if a user cannot verify email.
     *
     * @return void
     */
    public function testUserFailsToVerifyEmail(): void
    {
        // Arrange
        $this->signupCode->forceFill([
            'created_at' => now()->subDays(2),
        ])->save();

        // Act
        $response = $this->post(route('user.verify.index'), [
            'code' => $this->signupCode->code]
        );

        // Assert
        $response->assertRedirectBack()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'email' => $this->user->email,
            'email_verified_at' => null,
        ]);
    }
}
