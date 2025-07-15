<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'user_role',
        'resume_path',
        'tel',
        'birth_date',
        'profile_picture_path',
        'address',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    /**
     * Get the resume file name from the resume path.
     *
     * @return string
     */
    public function getResumeFileNameAttribute(): string
    {
        // Removes both slash (/) and backslash (\)
        return basename($this->resume_path);
    }

    /**
     * Get the profile photo file name from the resume path.
     *
     * @return string
     */
    public function getProfilePictureAttribute(): ?string
    {
        return $this->profile_picture_path
            ? Storage::disk('s3')->url($this->profile_picture_path)
            : null;
    }

    /**
     * Get the associated user codes for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<UserSignUpCode, User>
     */
    public function userSignupCodes()
    {
        return $this->hasMany(UserSignupCode::class);
    }
}
