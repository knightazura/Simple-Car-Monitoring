<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverCar extends Model
{
  protected $primaryKey = 'car_plat_number';
  protected $guarded = [];
  public $timestamps = true;
  public $incrementing = false;

  // Relationships
  public function withDriver()
  {
    return $this->belongsTo('\App\Models\Driver', 'driver_id', 'id');
  }

  public function withCar()
  {
    return $this->belongsTo('\App\Models\Car', 'car_plat_number', 'plat_number');
  }
}
