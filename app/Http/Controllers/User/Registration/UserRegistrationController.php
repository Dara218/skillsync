<?php

namespace App\Http\Controllers\User\Registration;

use App\Enums\common\UserGuard;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use App\Service\Common\{
    AuthService,
    LogService,
};
use App\Service\User\Registration\UserRegisterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserRegistrationController extends Controller
{
    /**
     * UserRegisterService instance.
     *
     * @var \App\Service\User\Registration\UserRegisterService $userRegisterService
     */
    protected UserRegisterService $userRegisterService;

    /**
     * AuthUserService instance.
     *
     * @var \App\Service\Common\AuthService $authService
     */
    protected AuthService $authService;

    /**
     * Constructor for initializing UserRegistrationController.
     *
     * @param \App\Service\User\Registration\UserRegisterService $userRegisterService
     */
    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
        $this->authService = app(AuthService::class);
    }

    /**
     * View user registration page.
     *
     * @return \Illuminate\View\View;
     */
    public function index(): View
    {
        return view('user.register.index');
    }

    /**
     * Handle the user registration process.
     *
     * @param \App\Http\Requests\User\UserRegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRegisterRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $this->userRegisterService
                ->handleRegistration($request->validated());

            $guard = UserGuard::USER->value;

            $this->authService->handleLogin(
                $request->only('email', 'password'),
                $guard,
            );

            DB::commit();

            return redirect()
                ->route('user.verify.index')
                ->with('success', __('message.success.successful_email_registration'));
        } catch (\Exception $e) {
            DB::rollBack();

            LogService::error(
                'Error processing user registration.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', __('message.error.failed_handling_the_process'));
        }
    }
}
