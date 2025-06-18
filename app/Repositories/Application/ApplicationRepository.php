<?php

namespace App\Repositories\Application;

use App\Interfaces\Application\ApplicationInterface;
use App\Models\Application;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class ApplicationRepository extends BaseRepository implements ApplicationInterface
{
    /**
     * Constructor for initializing ApplicationRepository.
     *
     * @param \App\Models\Job $model
     */
    public function __construct(Application $model)
    {
        parent::__construct($model);
    }

    /**
     * Get the recent application for the user.
     *
     * @param int $userId The user id (users.id)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecent(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->with('job.company')
            ->latest()
            ->take(config('constants.recent_user_application_count'))
            ->get();
    }
}
