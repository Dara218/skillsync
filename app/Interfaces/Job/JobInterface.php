<?php

namespace App\Interfaces\Job;

use App\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Collection;

interface JobInterface extends BaseInterface
{
    /**
     * Get the suggested jobs for the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSuggestedJobs(): Collection;
}
