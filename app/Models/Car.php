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

    public function responsibleBy()
    {
      return $this->hasOne('App\Models\DriverCar', 'car_plat_number');
    }

    // Observe this model being deleted and delete the child
    protected static function boot()
    {
      parent::boot();

      static::deleting(function ($car) {
        // Status
        foreach ($car->hasStatus()->get() as $status) {
          $status->delete();
        }
        // DriverCar
        foreach ($car->responsibleBy()->get() as $drv_car) {
          $drv_car->delete();
        }
      });
    }
}
