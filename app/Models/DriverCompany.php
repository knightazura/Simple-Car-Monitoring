<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverCompany extends Model
{
    protected $guarded = [];
    public $timestamps = true;

    // Relationships
    public function theDriver()
    {
      return $this->hasMany('App\Models\Driver', 'company_id');
    }
}
