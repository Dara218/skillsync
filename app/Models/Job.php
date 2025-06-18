<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * Get the associated company codes for the job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Company, Job>
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
