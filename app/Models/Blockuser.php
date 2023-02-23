<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blockuser extends Model
{
    use HasFactory;

    public function blockedUser()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }

    public function blockByUser()
    {
        return $this->belongsTo(User::class, 'block_by_user_id');
    }
}
