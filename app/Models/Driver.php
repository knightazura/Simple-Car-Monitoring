<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $guarded = [];
    public $timestamps = true;

    // Relationships
    public function driveOn()
    {
      return $this->hasOne('App\Models\CarUsage', 'driver_id', 'id');
    }

    public function backupDriveOn()
    {
      return $this->hasOne('App\Models\CarUsage', 'backup_driver_id', 'id');
    }

    public function responsibleTo()
    {
      return $this->hasOne('App\Models\DriverCar', 'driver_id', 'id');
    }

    public function workOn()
    {
        return $this->belongsTo('App\Models\DriverCompany', 'company_id');
    }
}
