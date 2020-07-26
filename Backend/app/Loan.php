<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //
    protected $fillable = ['period', 'interest', 'amount', 'user_id', 'state', 'score'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
