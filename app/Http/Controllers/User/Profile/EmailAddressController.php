<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateEmailRequest;
use App\Interfaces\{
    Job\JobInterface,
    User\UserInterface,
};
use App\Service\Common\LogService;
use App\Service\User\Profile\EmailAddressService;
use App\Traits\HasUserAuthentication;
use Illuminate\Http\{
    RedirectResponse,
    Request,
};
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EmailAddressController extends Controller
{
    use HasUserAuthentication;

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
     * EmailAddressService instance.
     *
     * @var \App\Service\User\Profile\EmailAddressService $emailAddressService
     */
    protected EmailAddressService $emailAddressService;

    /**
     * Constructor for initializing ProfileController.
     *
     * @param \App\Interfaces\Job\JobInterface $jobInterface
     */
    public function __construct(JobInterface $jobInterface)
    {
        $this->jobInterface = $jobInterface;
        $this->emailAddressService = app(EmailAddressService::class);
        $this->userInterface = app(UserInterface::class);
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

            $this->emailAddressService->handleSendEmailAddressLink($newEmail);

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
        $user = $this->getAuthUserAsCollection(['id', 'email']);

        // Abort if the verification link is reused or invalid
        abort_if($user['email'] === $request->new_email, Response::HTTP_NOT_FOUND);
        abort_if(!$request->hasValidSignature(), Response::HTTP_FORBIDDEN);

        DB::beginTransaction();

        try {
            $this->emailAddressService->handleUpdateEmailAddress(
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
