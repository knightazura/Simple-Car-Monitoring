<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name', 'slug'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_users');
    }

    // more info : https://laravel-news.com/authorization-gates
}
