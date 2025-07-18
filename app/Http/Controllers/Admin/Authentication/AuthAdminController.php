<?php

namespace App\Http\Controllers\Admin\Authentication;

use App\Enums\common\UserGuard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Service\Common\{
    AuthService,
    LogoutService,
    LogService,
};
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthAdminController extends Controller
{
    /**
     * AuthService instance.
     *
     * @var \App\Service\Common\AuthService $authService
     */
    protected AuthService $authService;

    /**
     * LogoutService instance.
     *
     * @var \App\Service\Common\LogoutService $logoutService
     */
    protected LogoutService $logoutService;

    /**
     * Constructor for initializing AuthUserController.
     *
     * @param \App\Service\Common\AuthService $authService
     * @param \App\Service\Common\LogoutService $logoutService
     */
    public function __construct(
        AuthService $authService,
        LogoutService $logoutService,
    ) {
        $this->authService = $authService;
        $this->logoutService = $logoutService;
    }

    /**
     * View Login admin page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('admin.auth.index');
    }

    /**
     * Process user login process.
     *
     * @param \App\Http\Requests\Admin\AdminLoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function authenticate(AdminLoginRequest $request): RedirectResponse
    {
        try {
            $guard = UserGuard::ADMIN->value;

            $isSuccessLogin = $this->authService
                ->handleLogin($request->validated(), $guard);

            if (!$isSuccessLogin) {
                return back()
                    ->withInput()
                    ->withErrors(['error' => __('validation.custom.invalid_credentials')]);
            }

            return redirect()->route('admin.dashboard');
        } catch (\Exception $e) {
            LogService::error(
                'Error showing admin login.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ],
            );

            return back()->withInput(['email']);
        }
    }

    /**
     * Process admin logout.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            $guard = UserGuard::ADMIN->value;

            $this->logoutService->handleLogout($request, $guard);

            return redirect()->route('admin.login.index');
        } catch (\Exception $e) {
            LogService::error(
                'Error processing admin logout.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return redirect()
                ->route('admin.login.index')
                ->with('error', __('message.error.failed_handling_the_process'));
        }
    }
}
