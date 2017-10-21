<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryCarUsage extends Model
{
    protected $guarded = [];
    public $timestamps = true;

    // Mutators
    public function setStartUseAttribute ($value)
    {
      $this->attributes['start_use'] = date("Y-m-d H:i:s", strtotime($value));
    }

    public function setEndUseAttribute ($value)
    {
      $this->attributes['end_use'] = date("Y-m-d H:i:s", strtotime($value));
    }
}
