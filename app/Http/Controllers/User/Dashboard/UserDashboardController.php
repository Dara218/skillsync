<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Enums\common\UserGuard;
use App\Http\Controllers\Controller;
use App\Interfaces\{
    Application\ApplicationInterface,
    Job\JobInterface,
};
use App\Service\Common\LogService;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
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
     * View user dashboard page.
     *
     * @return \Illuminate\Contracts\View\View|void
     */
    public function index()
    {
        try {
            $user = Auth::guard(UserGuard::USER->value)->user();

            $suggestedJobs = $this->jobInterface->getSuggestedJobs();
            $recentApplications = $this->applicationInterface->getRecent($user->id);

            return view('user.dashboard.index', compact(
                'user',
                'suggestedJobs',
                'recentApplications',
            ));
        } catch (\Exception $e) {
            LogService::error(
                'Error fetching the needed data.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );
        }
    }
}
