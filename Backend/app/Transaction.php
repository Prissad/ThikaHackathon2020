<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = ['sender_id', 'receiver_id', 'amount'];
    protected $casts = ['amount' => 'float'];
}
