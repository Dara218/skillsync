<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\{
    Application\ApplicationInterface,
    Job\JobInterface,
};
use App\Service\Common\LogService;
use App\Traits\HasAdminAuthentication;

class AdminDashboardController extends Controller
{
    use HasAdminAuthentication;

    /**
     * JobInterface instance.
     *
     * @var \App\Interfaces\Job\JobInterface $jobInterface
     */
    protected JobInterface $jobInterface;

    /**
     * ApplicationInterface instance.
     *
     * @var \App\Interfaces\Application\ApplicationInterface $applicationInterface
     */
    protected ApplicationInterface $applicationInterface;

    /**
     * Constructor for initializing UserDashboardController.
     *
     * @param \App\Interfaces\Job\JobInterface $jobInterface
     * @param \App\Interfaces\Application\ApplicationInterface $applicationInterface
     */
    public function __construct(
        JobInterface $jobInterface,
        ApplicationInterface $applicationInterface,
    ) {
        $this->jobInterface = $jobInterface;
        $this->applicationInterface = $applicationInterface;
    }

    /**
     * View admin dashboard page.
     *
     * @return \Illuminate\Contracts\View\View|void
     *
     * @throws \Exception
     */
    public function index()
    {
        try {
            return view('admin.dashboard.index');
        } catch (\Exception $e) {
            LogService::error(
                'Error showing the admin dashboard page.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            throw $e;
        }
    }
}
