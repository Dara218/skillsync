<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => \App\Enums\common\ApplicationStatus::class,
    ];

    /**
     * Get the associated jobs for the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Job, Application>
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the formatted date when the application was submitted.
     *
     * Returns the date in the format: "10:20 PM in 6/13/2025"
     * Example output: "11:54 AM in 6/10/2025"
     *
     * @return string Formatted date string
     */
    public function getAppliedDateAttribute(): string
    {
        return $this->created_at->format('g:i A \i\n n/j/Y');
    }
}
