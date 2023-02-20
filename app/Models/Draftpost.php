<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draftpost extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function views()
    {
        return $this->morphMany(View::class, 'post');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'post');
    }

    public function likes()
    {
        return $this->morphMany(Likepost::class, 'post');
    }

    public function shares()
    {
        return $this->morphMany(Sharepost::class, 'post');
    }

    
    public function countLikes()
    {
        return Likepost::where([
            ['post_type', '=', 2],
            ['post_id', '=', $this->id] 
        ])->count();
    }

    public function countShares()
    {
        return Sharepost::where([
            ['post_type', '=', 2],
            ['post_id', '=', $this->id] 
        ])->count();
    }

    public function countViews()
    {
        return View::where([
            ['post_type', '=', 2],
            ['post_id', '=', $this->id] 
        ])->count();
    }

    public function countComments()
    {
        return Comment::where([
            ['post_type', '=', 2],
            ['post_id', '=', $this->id] 
        ])->count();
    }

    public function checkUserLike($user_id){
        return Likepost::where([
            ['post_type', '=', 2],
            ['post_id', '=', $this->id],
            ['user_id', '=', $user_id]  
        ])->exists();
    }

    public function postComments(){
        return Comment::where([
            ['post_type', '=', 2],
            ['post_id', '=', $this->id], 
            ['parent_id', '=', null], 
        ])->paginate(5);
    }
}
