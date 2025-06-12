<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSignupCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_signup_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'code',
    ];

    /**
     * Get the associated user for the user code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, UserSignupCode>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email');
    }
}
