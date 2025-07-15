<?php

namespace App\Http\Controllers\User\Profile;

use App\Enums\common\UserGuard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\{
    UpdateProfilePhotoRequest,
    UpdateProfileRequest,
};
use App\Interfaces\{
    Job\JobInterface,
    User\UserInterface,
};
use App\Service\Common\LogService;
use App\Service\User\Profile\ProfileService;
use Illuminate\Http\{
    RedirectResponse,
    Request,
};
use Illuminate\Support\Facades\{
    Auth,
    DB,
};

class ProfileController extends Controller
{
    /**
     * JobInterface instance.
     *
     * @var \App\Interfaces\Job\JobInterface $jobInterface
     */
    protected JobInterface $jobInterface;

    /**
     * UserInterface instance.
     *
     * @var \App\Interfaces\User\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

    /**
     * ProfileService instance.
     *
     * @var \App\Service\User\Profile\ProfileService $profileService
     */
    protected ProfileService $profileService;

    /**
     * Constructor for initializing ProfileController.
     *
     * @param \App\Interfaces\Job\JobInterface $jobInterface
     */
    public function __construct(JobInterface $jobInterface)
    {
        $this->jobInterface = $jobInterface;
        $this->profileService = app(ProfileService::class);
        $this->userInterface = app(UserInterface::class);
    }

    /**
     * View user profile update page.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     *
     * @throws \Exception
     */
    public function index(Request $request, string $username)
    {
        try {
            $user = Auth::guard(UserGuard::USER->value)->user();
            $this->authorize('view', [$user, $username]);

            return view('user.profile.index', compact('user', 'username'));
        } catch (\Exception $e) {
            LogService::error(
                'Error showing update profile page.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            throw $e;
        }
    }

    /**
     * Update the user personal information.
     *
     * @param \App\Http\Requests\Profile\UpdateProfileRequest $request
     * @param int $id The user's id (users.id)
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request, int $id): RedirectResponse
    {
        DB::beginTransaction();

        $errorMessage = __('message.error.failed_handling_the_process');
        $user = $this->userInterface->find($id);

        $this->authorize('update', $user);

        try {
            $isUpdated = $this->profileService
                ->updateProfile($request->validated(), $id);

            if (!$isUpdated) {
                DB::rollBack();

                return back()->with('error', $errorMessage);
            }

            DB::commit();

            // Re-fetch the updated user to get the new username
            $updatedUser = $this->userInterface->find($id);

            return redirect()
                ->route('user.profile.index', ['username' => $updatedUser->username])
                ->with('success', __('message.success.resume_uploaded_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            LogService::error(
                'Error updating user profile.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Update the user profile photo.
     *
     * @param \App\Http\Requests\Profile\UpdateProfileRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfilePhoto(UpdateProfilePhotoRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $this->profileService->handleProfilePhotoUpload(
                $request->validated('profile_picture_path')
            );

            DB::commit();

            return back()->with('success', __('message.success.profile_photo_uploaded_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            LogService::error(
                'Error uploading the profile photo.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', __('message.error.failed_handling_the_process'));
        }
    }

    /**
     * Delete the user profile photo.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProfilePhoto(): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $this->profileService->handleProfilePhotoDelete();

            DB::commit();

            return back()->with('success', __('message.success.profile_photo_deleted_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            LogService::error(
                'Error deleting the profile photo.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', __('message.error.failed_handling_the_process'));
        }
    }
}
