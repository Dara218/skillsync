<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{
    Model,
    SoftDeletes,
};

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => \App\Enums\common\JobType::class,
    ];

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
