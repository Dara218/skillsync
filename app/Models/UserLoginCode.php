<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_login_code';

    /**
     * Get the associated user for the user code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, UserLoginCode>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email');
    }
}
