<?php

namespace App\Interfaces\Job;

use App\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface JobInterface extends BaseInterface
{
    /**
     * Get the suggested jobs for the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSuggestedJobs(): Collection;

    /**
     * Get the jobs data.
     *
     * @param ?string $job The job title {jobs.title}
     * @param ?int $paginationCount The pagination count of the list
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function get(?string $job = null, ?int $paginationCount = null);
}
