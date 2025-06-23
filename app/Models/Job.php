<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{
    Builder,
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
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job',
        'title',
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

    /**
     * Search job by title (jobs.title).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param ?string $jobTitle The job title {jobs.title}
     *
     * @return Builder
     */
    public function scopeSearch(Builder $query, ?string $jobTitle): Builder
    {
        return $query
            ->when($jobTitle, function ($query, $jobTitle) {
                $query->where('title', 'LIKE', "%$jobTitle%");
            })
            ->with('company');
    }
}
