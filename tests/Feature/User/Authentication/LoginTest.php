<?php 

namespace Tests\Feature\User\Authentication;

use App\Enums\common\{
    UserGuard,
    UserRole,
};
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * User model instance.
     *
     * @var \App\Models\User $user
     */
    protected User $user;

    /**
     * The user login info.
     *
     * @var array $loginCredentials
     */
    protected array $loginCredentials;

    /**
     * The user guard.
     *
     * @return string
     */
    protected const GUARD = UserGuard::USER->value;

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
        ]);

        $this->loginCredentials = [
            'email' => $this->user->email,
            'password' => 'password123',
        ];
    }

    /**
     * Test if user redirects to user dashboard page if verified.
     *
     * @return void
     */
    public function testLoginVerifiedUserRedirectsToDashboardSuccessfully(): void
    {
        // Act
        $this->post(
            route('user.login.authenticate'), $this->loginCredentials
        );

        $response = $this->get(route('user.dashboard'));

        // Assert
        $this->assertAuthenticatedAs($this->user, self::GUARD);

        $response->assertSuccessful();
    }

    /**
     * Test if user cannot login with invalid login details.
     *
     * @return void
     */
    public function testLoginUserFailsToLoginWithInvalidCredentials()
    {
        // Arrange
        $this->loginCredentials = [
            'email' => 'invalidEmail@example.com',
            'password' => 'invalidPassword',
        ];

        // Act
        $response = $this->post(
            route('user.login.authenticate'), $this->loginCredentials
        );

        // Assert
        $response->assertRedirectBack()->assertSessionHasErrors('error');
        $this->assertGuest(self::GUARD);
    }

    /**
     * Test if user redirects to verify page if not verified.
     *
     * @return void
     */
    public function testLoginUnverifiedUserLoginRedirectsToVerifyPageSuccessfully(): void
    {
        // Arrange
        $this->user->update(['email_verified_at' => null]);

        // Act
        $this->post(
            route('user.login.authenticate'), $this->loginCredentials
        );

        $response = $this->get(route('user.verify.index'));

        // Assert
        $this->assertAuthenticatedAs($this->user, self::GUARD);

        $response->assertSuccessful();
    }
}
