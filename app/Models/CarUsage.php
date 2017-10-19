<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarUsage extends Model
{
    protected $guarded = [];
    public $timestamps = true;
    public $incrementing = false; // this is for eloquent doesn't expect the primary key to be an autoIncrement

    // Relationships
    public function carStatus()
    {
      return $this->belongsTo('App\Models\CarStatus', 'car_plat_number', 'car_plat_number');
    }

    public function requestedBy()
    {
      return $this->belongsTo('App\Models\Employee', 'nip', 'nip');
    }

    public function drivenBy()
    {
      return $this->belongsTo('App\Models\Driver', 'id', 'driver_id');
    }
}
