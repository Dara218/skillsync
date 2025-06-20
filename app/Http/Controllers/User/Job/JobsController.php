<?php

namespace App\Http\Controllers\User\Job;

use App\Http\Controllers\Controller;
use App\Interfaces\Job\JobInterface;
use App\Service\Common\LogService;
use Illuminate\Support\Facades\Request;

class JobsController extends Controller
{
    /**
     * JobInterface instance.
     *
     * @var \App\Interfaces\Job\JobInterface $jobInterface
     */
    protected JobInterface $jobInterface;

    /**
     * Constructor for initializing JobsController.
     *
     * @param \App\Interfaces\Job\JobInterface $jobInterface
     */
    public function __construct(JobInterface $jobInterface)
    {
        $this->jobInterface = $jobInterface;
    }

    /**
     * View user jobs page.
     *
     * @param \Illuminate\Support\Facades\Request $request
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     */
    public function index(Request $request)
    {
        try {
            $jobs = $this->jobInterface->get();

            return view('user.jobs.index', compact('jobs'));
        } catch (\Exception $e) {
            LogService::error(
                'Error uploading the resume.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            // Todo: return 500 error page and apply to other pages.
        }
    }
}
