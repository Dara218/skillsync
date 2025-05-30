<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTagJob extends Model
{
    /** @use HasFactory<\Database\Factories\JobTagJobFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_tag_jobs';

    /**
     * Disable timestamps update in the table.
     *
     * @var
     */
    public $timestamps = false;
}
