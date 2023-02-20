<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sharepost extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'post_id', 'post_type'];

    public function post()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
