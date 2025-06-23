<?php

namespace App\Http\Controllers\User\Job;

use App\Http\Controllers\Controller;
use App\Interfaces\Job\JobInterface;
use App\Service\Common\LogService;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     *
     * @throws \Exception
     */
    public function index(Request $request)
    {
        try {
            $keyword = $request->job;
            $paginateCount = config('constants.pagination.jobs');

            $jobs = $this->jobInterface->get($keyword, $paginateCount);
            $lastPage = $jobs->lastPage();
            $redirectRoute = 'user.jobs.index';

            if ($redirect = redirectIfPageExceeds($request, $lastPage, $redirectRoute)) {
                return $redirect;
            };

            return view('user.jobs.index', compact(
                'jobs',
                'keyword',
            ));
        } catch (\Exception $e) {
            LogService::error(
                'Error uploading the resume.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            throw $e;
        }
    }
}
