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
}
