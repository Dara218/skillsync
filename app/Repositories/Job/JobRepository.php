<?php

namespace App\Repositories\Job;

use App\Enums\common\JobPublishTag;
use App\Interfaces\Job\JobInterface;
use App\Models\Job;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class JobRepository extends BaseRepository implements JobInterface
{
    /**
     * Constructor for initializing JobRepository.
     *
     * @param \App\Models\Job $model
     */
    public function __construct(Job $model)
    {
        parent::__construct($model);
    }

    /**
     * Get the suggested jobs for the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSuggestedJobs(): Collection
    {
        return $this->model
            ->where('is_published', JobPublishTag::PUBLISHED->value)
            ->latest()
            ->with('company')
            ->take(config('constants.suggested_company_count'))
            ->get();
    }
}
