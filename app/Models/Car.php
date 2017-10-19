<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $primaryKey = 'plat_number';
    protected $guarded = [];
    public $timestamps = true;
    public $incrementing = false; // this is for eloquent doesn't expect the primary key to be an autoIncrement

    // Relationships
    public function hasStatus()
    {
      return $this->hasOne('App\Models\CarStatus', 'car_plat_number');
    }
}
