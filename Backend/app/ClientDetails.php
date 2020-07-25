<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientDetails extends UuidModel
{
    protected $fillable = [
        'grade',
        'birthday',
        'establishment',
        'region',
        'subscription_id',
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
