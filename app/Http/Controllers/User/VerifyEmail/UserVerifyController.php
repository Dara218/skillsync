<?php

namespace App\Http\Controllers\User\VerifyEmail;

use App\Exceptions\{
    CodeExpiredException,
    CodeLatestException,
};
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserVerificationRequest;
use App\Service\Common\LogService;
use App\Service\User\Verification\UserVerificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserVerifyController extends Controller
{
    /**
     * UserVerificationService instance.
     *
     * @var \App\Service\User\Verification\UserVerificationService $verificationService
     */
    protected UserVerificationService $verificationService;

    /**
     * Constructor for initializing UserVerifyController.
     *
     * @param \App\Service\User\Verification\UserVerificationService $verificationService
     */
    public function __construct(UserVerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    /**
     * View user verification page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('user.verify.index');
    }

    /**
     * Process user verification process.
     *
     * @param \App\Http\Requests\User\UserVerificationRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function verify(UserVerificationRequest $request)
    {
        DB::beginTransaction();

        try {
            $code = $request->validated('code');

            if ($this->verificationService->handleVerification($code)) {
                DB::commit();

                return redirect()
                    ->route('user.dashboard')
                    ->with('success', __('message.success.your_account_has_been_verified'));
            }

            DB::rollBack();

            return back()->with('error', __('message.error.verification_expired_sent_a_new_one'));
        } catch (CodeLatestException | CodeExpiredException $e) {
            return back()->withErrors([
                'code' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            LogService::error(
                'Error processing the code verification.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', __('message.error.failed_handling_the_process'));
        }
    }
}
