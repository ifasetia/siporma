<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use App\Models\Profile;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

// / helper function
    public function isRole($role)
    {
        return $this->role === $role;
    }
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }

    public function profile()
{
    return $this->hasOne(Profile::class, 'user_id', 'id');
}

    protected static function booted()
{
    static::created(function ($user) {
        $user->profile()->create([
            'pr_id'   => Str::uuid(),
            'pr_nama' => $user->name,
        ]);
    });
}


public function projects()
{
    return $this->belongsToMany(
        Project::class,
        'project_members',
        'user_id',
        'project_id'
    );
}


}
