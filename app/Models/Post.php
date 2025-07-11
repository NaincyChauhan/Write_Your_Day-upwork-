<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
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

    public function saves()
    {
        return $this->hasMany(Savepost::class);
    }

    public function hidepost(){
        return $this->belongsTo(Hidepost::class);
    }

    public function canBeEdited()
    {
        $created = Carbon::parse($this->created_at);
        $maxEditTime = $this->max_edit_time;

        return Carbon::now()->lt($created->addSeconds($maxEditTime));
    }
}
