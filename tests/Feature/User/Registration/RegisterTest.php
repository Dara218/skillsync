<?php

namespace Tests\Feature\User\Registration;

use App\Enums\common\{
    UserGuard,
    UserRole,
};
use App\Mail\UserRegisterMail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\{
    Auth,
    Mail,
};
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * The user guard.
     *
     * @return string
     */
    protected const GUARD = UserGuard::USER->value;

    /**
     * The registration details of the user.
     *
     * @var array $registerData
     */
    protected array $registerData;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerData = [
            'name' => 'test name',
            'email' => 'test@example.com',
            'password' => 'Qwerty123@',
            'role' => UserRole::JOB_SEEKER->value,
        ];
    }

    /**
     * Test if a user can register successfully.
     *
     * @return void
     */
    public function testUserCanRegisterSuccessfully(): void
    {
        // Arrange
        Mail::fake();

        // Act
        $response = $this->post(
            route('user.register.store'), $this->registerData
        );

        $user = Auth::guard(self::GUARD)->user();
        $this->get(route('user.verify.index'));

        // Assert
        $response->assertRedirect(route('user.verify.index'));
        $this->assertAuthenticatedAs($user, self::GUARD)
            ->assertDatabaseHas('users', [
                'name' => 'test name',
                'email' => 'test@example.com',
                'password' => $user->password,
                'user_role' => UserRole::JOB_SEEKER->value,
            ]);

        // Assert email was sent
        Mail::assertSent(UserRegisterMail::class, fn($mail) => $mail->hasTo($user->email));
    }

    /**
     * Test if a user cannot register.
     *
     * @return void
     */
    public function testUserFailsToRegister(): void
    {
        // Arrange
        Mail::fake();

        $invalidDetails = [
            'name' => '',
            'email' => 'test',
            'password' => 'password',
        ];

        // Act
        $response = $this->post(
            route('user.register.store'), $invalidDetails
        );

        // Assert
        $response->assertRedirectBack()
            ->assertSessionHasErrors(array_keys($invalidDetails));

        $this->assertGuest(self::GUARD)
            ->assertDatabaseMissing('users', $invalidDetails);

        // Assert email was not sent
        Mail::assertNotSent(UserRegisterMail::class, fn($mail) => $mail->hasTo($invalidDetails['email']));
    }
}
