<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'nip';
    protected $guarded = [];
    public $timestamps = true;
    public $incrementing = false; // this is for eloquent doesn't expect the primary key to be an autoIncrement

    // Relationships
    public function request()
    {
      return $this->hasOne('App\Models\CarUsage', 'nip', 'nip');
    }
}
