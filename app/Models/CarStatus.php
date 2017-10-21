<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarStatus extends Model
{
    protected $primaryKey = 'car_plat_number';
    protected $guarded = [];
    public $timestamps = true;
    public $incrementing = false;

    // Relationships
    public function theCar()
    {
      return $this->belongsTo('App\Models\Car', 'car_plat_number');
    }

    public function usage()
    {
      return $this->hasOne('App\Models\CarUsage', 'car_plat_number', 'car_plat_number');
    }

    // Touching parent timestamps
    protected $touches = ['theCar'];
}
