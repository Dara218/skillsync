<?php

namespace App\Http\Controllers\User\Profile;

use App\Enums\common\UserGuard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\{
    UpdateEmailRequest,
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
use Symfony\Component\HttpFoundation\Response;

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
     * View user email address update page.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     *
     * @throws \Exception
     */
    public function viewUpdateEmailPage()
    {
        try {
            return view('user.update-email.index');
        } catch (\Exception $e) {
            LogService::error(
                'Error showing update email address page.',
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

    /**
     * Sends the verification link to the provided email address.
     *
     * @param \App\Http\Requests\Profile\UpdateProfileRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmailAddressLink(UpdateEmailRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $newEmail = $request->validated()['email'];

            $this->profileService->handleSendEmailAddressLink($newEmail);

            DB::commit();

            return back()->with('success', __('message.success.a_link_has_been_sent_to_the_provided_email'));
        } catch (\Exception $e) {
            DB::rollBack();

            LogService::error(
                'Error updating the user email address.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', __('message.error.failed_handling_the_process'));
        }
    }

    /**
     * Update the user email address.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmailAddress(Request $request): RedirectResponse
    {
        $user = collect(Auth::guard(UserGuard::USER->value)->user())
            ->only(['id', 'email']);

        // Abort if the verification link is reused or invalid
        abort_if($user['email'] === $request->new_email, Response::HTTP_FORBIDDEN);
        abort_if(!$request->hasValidSignature(), Response::HTTP_FORBIDDEN);

        DB::beginTransaction();

        try {
            $this->profileService->handleUpdateEmailAddress(
                $request->new_email,
                $user['id'],
            );

            DB::commit();

            return redirect()
                ->route('user.dashboard')
                ->with('success', __('message.success.your_email_address_has_been_updated'));
        } catch (\Exception $e) {
            DB::rollBack();

            LogService::error(
                'Error updating the user email address.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', __('message.error.failed_handling_the_process'));
        }
    }
}
