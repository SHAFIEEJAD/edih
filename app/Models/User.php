<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'password_confirmation',
        'role',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getPermissionsAttribute(){
        return [
            'superadmin' => in_array($this->role, [1]),
            'user_show' => in_array($this->role, [1,2]),
            'user_manage' => in_array($this->role, [1,2]),
            'test_show' => in_array($this->role, [1,2,3]),
            'test_manage' => in_array($this->role, [1,2,3]),
            'email_show' => in_array($this->role, [1,2,3]),
            'email_manage' => in_array($this->role, [1,2,3]),
            'department_show' => in_array($this->role, [1,2,3]),
            'department_manage' => in_array($this->role, [1,2,3])
        ];
    }
}
