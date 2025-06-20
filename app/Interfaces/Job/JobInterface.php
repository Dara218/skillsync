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
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function get(): LengthAwarePaginator;
}
