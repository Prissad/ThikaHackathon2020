<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends UuidModel
{
    protected $fillable =
        [
            'client_id','verified','code','point'
        ];
    public function client (){
        return $this->belongsTo(Client::Class);
    }
}
