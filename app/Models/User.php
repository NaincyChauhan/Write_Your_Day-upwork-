<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Permissions\HasPermissionsTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
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
    ];

    public function usersqualification()
    {
        return $this->hasMany(Usersqualification::class);
    }
    
    public function usersexprience()
    {
        return $this->hasMany(Usersexprience::class);
    }

    public function usersepermissions()
    {     
        return $this->hasMany(Users_permissions::class);
    }    

    public function userseroles()
    {     
        return $this->hasMany(Users_roles::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function userapplication()
    {
        return $this->hasMany(Userapplication::class);
    }
}
