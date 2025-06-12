<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRegisterRequest;
use App\Service\Common\LogService;
use App\Service\User\{
    Authentication\AuthUserService,
    Registration\UserRegisterService,
};
use Illuminate\Http\RedirectResponse;
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
     * @var \App\Service\User\Authentication\AuthUserService $authUserService
     */
    protected AuthUserService $authUserService;

    /**
     * Constructor for initializing UserRegistrationController.
     *
     * @param \App\Service\User\Registration\UserRegisterService $userRegisterService
     */
    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
        $this->authUserService = app(AuthUserService::class);
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
        try {
            $this->userRegisterService
                ->handleRegistration($request->validated());

            $this->authUserService->handleLogin(
                $request->only('email', 'password')
            );

            return redirect()
                ->route('user.verify.index')
                ->with('success', __('message.success.successful_email_registration'));
        } catch (\Exception $e) {
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
