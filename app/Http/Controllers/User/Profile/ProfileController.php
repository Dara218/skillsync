<?php

namespace App\Http\Controllers\User\Profile;

use App\Enums\common\UserGuard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Interfaces\Job\JobInterface;
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
    public function index(Request $request)
    {
        try {
            $user = Auth::guard(UserGuard::USER->value)->user();

            return view('user.profile.index', compact('user'));
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

        try {
            $isUpdated = $this->profileService
                ->updateProfile($request->validated(), $id);

            if (!$isUpdated) {
                DB::rollBack();

                return back()->with('error', $errorMessage);
            }

            DB::commit();

            return back()->with('success', __('message.success.resume_uploaded_successfully'));
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
}
