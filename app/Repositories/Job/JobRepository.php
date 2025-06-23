<?php

namespace App\Repositories\Job;

use App\Enums\common\JobPublishTag;
use App\Interfaces\Job\JobInterface;
use App\Models\Job;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
            ->with('company')
            ->take(config('constants.suggested_company_count'))
            ->inRandomOrder()
            ->get();
    }

    /**
     * Get the jobs data.
     *
     * @param ?string $job The job title {jobs.title}
     * @param ?int $paginationCount The pagination count of the list
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function get(?string $job = null, ?int $paginationCount = null)
    {
        $query = $this->model->search($job);

        return $paginationCount
            ? $query->paginate($paginationCount)
            : $query->get();
    }
}
