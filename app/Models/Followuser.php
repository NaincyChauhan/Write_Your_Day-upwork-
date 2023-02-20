<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followuser extends Model
{
    use HasFactory;

    public function follow_user()
    {
        return $this->belongsTo(User::class,'follower_user_id');
    }

    public function following_user()
    {
        return $this->belongsTo(User::class,'following_user_id');
    }
}
