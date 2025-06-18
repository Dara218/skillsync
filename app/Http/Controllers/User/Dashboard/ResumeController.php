<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UploadResumeRequest;
use App\Service\Common\LogService;
use App\Service\User\Dashboard\ResumeService;
use Illuminate\Http\RedirectResponse;

class ResumeController extends Controller
{
    /**
     * ResumeService provider.
     *
     * @var \App\Service\User\Dashboard\ResumeService $resumeService
     */
    protected ResumeService $resumeService;

    /**
     * Constructor for initializing ResumeController.
     *
     * @param \App\Service\User\Dashboard\ResumeService $resumeService
     */
    public function __construct(ResumeService $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    /**
     * Process resume upload.
     *
     * @param \App\Http\Requests\Dashboard\UploadResumeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(UploadResumeRequest $request): RedirectResponse
    {
        try {
            $this->resumeService->handleResumeUpload($request->validated('resume_path'));

            return back()->with('success', __('message.success.resume_uploaded_successfully'));
        } catch (\Exception $e) {
            LogService::error(
                'Error uploading the resume.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', __('message.error.failed_handling_the_process'));
        }
    }

    /**
     * Process resume delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        try {
            $this->resumeService->handleResumeDelete();

            return back()->with('success', __('message.success.resume_deleted_successfully'));
        } catch (\Exception $e) {
            LogService::error(
                'Error deleting the resume.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return back()->with('error', __('message.error.failed_handling_the_process'));
        }
    }
}
