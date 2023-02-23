<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait,SoftDeletes;

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

    protected $dates = ['deleted_at'];

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

    public function saves()
    {
        return $this->hasMany(Savepost::class);
    }

    /**
     * Get the posts for this user.
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }

    // users that are followed by this user
    public function following() {
        return $this->hasMany(Followuser::class, 'follower_user_id');
    }

    // users that follow this user
    public function followers() {
        return $this->hasMany(Followuser::class, 'following_user_id');
    }

    /**
     * Get the following user with their latest post.
     */
    public function followingUser()
    {
        return $this->belongsTo(User::class, 'following_user_id');
    }

    // public function blockedUser()
    // {
    //     return $this->hasMany(BlockUser::class, 'blocked_user_id');
    // }

    public function blockedBy()
    {
        return $this->hasMany(BlockUser::class, 'blocked_user_id');
    }

    public function blocking()
    {
        return $this->hasMany(BlockUser::class, 'block_by_user_id');
    }

    // Hide posts
    public function hideposts() {
        return $this->hasMany(Hidepost::class);
    }
}
