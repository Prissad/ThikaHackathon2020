<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends User
{
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->role_id = Role::where('name', 'admin')->first()->id;
        });
    }

    public function newQuery()
    {
        $adminRoleId = Role::where('name', 'admin')->first()->id;
        return parent::newQuery()
            ->where('role_id', $adminRoleId);
    }
}
