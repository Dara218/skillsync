<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Service\Common\LogService;
use App\Service\User\Profile\UpdatePasswordService;
use App\Traits\HasUserAuthentication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UpdatePasswordController extends Controller
{
    use HasUserAuthentication;

    /**
     * UpdatePasswordService instance.
     *
     * @var \App\Service\User\Profile\UpdatePasswordService $passwordService
     */
    protected UpdatePasswordService $passwordService;

    /**
     * Constructor for initializing ResumeController.
     *
     * @param \App\Service\User\Profile\UpdatePasswordService $passwordService
     */
    public function __construct(UpdatePasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    /**
     * View update password page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     *
     * @throws \Exception
     */
    public function index()
    {
        try {
            $user = $this->getAuthUser();

            $this->authorize('view', [$user, $user->username]);

            return view('user.update-password.index');
        } catch (\Exception $e) {
            LogService::error(
                'Error showing update password page.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            throw $e;
        }
    }

    /**
     * Update the user password.
     *
     * @param \App\Http\Requests\Profile\UpdatePasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $user = $this->getAuthUser();

            $this->passwordService->handleUpdate(
                $user->id,
                $request->validated(),
            );

            DB::commit();

            return redirect()
                ->back()
                ->with('success', __('message.success.your_password_has_been_updated_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            LogService::error(
                'Error updating user profile.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', __('message.error.failed_handling_the_process'));
        }
    }
}
