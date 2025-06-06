<?php

namespace App\Http\Controllers\User\Authentication;

use App\Enums\common\UserGuard;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Service\Common\LogoutService;
use App\Service\User\Authentication\AuthUserService;
use Illuminate\Http\{
    RedirectResponse,
    Request,
};
use Illuminate\View\View;

class AuthUserController extends Controller
{
    /**
     * AuthUserService instance.
     *
     * @var \App\Service\User\Authentication\AuthUserService $authUserService
     */
    protected AuthUserService $authUserService;

    /**
     * LogoutService instance.
     *
     * @var \App\Service\Common\LogoutService $logoutService
     */
    protected LogoutService $logoutService;

    /**
     * Constructor for initializing AuthUserController.
     *
     * @param \App\Service\User\Authentication\AuthUserService $authUserService
     * @param \App\Service\Common\LogoutService $logoutService
     */
    public function __construct(
        AuthUserService $authUserService,
        LogoutService $logoutService,
    ) {
        $this->authUserService = $authUserService;
        $this->logoutService = $logoutService;
    }

    /**
     * View Login user page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('user.auth.login');
    }

    /**
     * Process user login process.
     *
     * @param \App\Http\Requests\User\UserLoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function authenticate(UserLoginRequest $request): RedirectResponse
    {
        try {
            $isSuccessLogin = $this->authUserService
                ->handleLogin($request->validated());

            if (!$isSuccessLogin) {
                return back()
                    ->withInput()
                    ->withErrors(['error' => 'Invalid Credentials.']);
            }

            return redirect()
                ->route('user.dashboard')
                ->with('sucess', 'Success!');
        } catch (\Exception $e) {
            // Todo: Create a log error.

            return back()->withInput(['email']);
        }
    }

    /**
     * Process user logout.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            $guard = UserGuard::USER->value;

            $this->logoutService->handleLogout($request, $guard);

            return redirect()->route('user.login.index');
        } catch (\Throwable $th) {
            // Todo: Create a log error.
            // Todo: Finish this: Add flash message
            return redirect()
                ->route('user.login.index')
                ->with('Error', 'Theres a problem.');
        }
    }
}
