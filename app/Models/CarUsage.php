<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarUsage extends Model
{
    protected $guarded = [];
    public $timestamps = true;
    public $incrementing = true;

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
      return $this->belongsTo('App\Models\Driver', 'driver_id');
    }

    // Mutators
    // Change the format into UNIX timestamp, because the format that provided from VueJS is ISO8601
    public function setDesireTimeAttribute ($value)
    {
        $this->attributes['desire_time'] = date("Y-m-d H:i:s", strtotime($value));
    }

    // If the current's entity was removed, update the Car status to available
    protected static function boot()
    {
        parent::boot();

        // Set the Driver & Car status into available state
        static::deleting(function ($usage) {
            static::setStatus($usage, 0);
        });

        // Set the Driver & Car status into busy
        static::creating(function ($usage) {
            static::setStatus($usage, 1);
        });

        static::updating(function ($usage) {
            static::setStatus($usage, 1);
        });
    }

    protected static function setStatus($usage, $status) {
        foreach ($usage->drivenBy()->get() as $driver) {
            $driver->status = $status;
            $driver->save();
        }
        foreach ($usage->carStatus()->get() as $car) {
            $car->status = $status;
            $car->save();
        }
    }
}
