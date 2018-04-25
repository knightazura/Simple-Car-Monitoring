<?php

namespace App\Support;

trait CarUsageMisc
{
  public static function setStatus($id, $model, $status)
  {
    $model = "App\\Models\\{$model}";
    $entity = $model::findOrFail($id);
    $entity->status = $status;
    if ($entity->save()) {
      return true;
    }
    else {
      return false;
    }
  }

  public static function estimatesTime($et)
  {
    if ($et >= 24) {
      $et_d = intdiv($et, 24);
      $et_h = $et % 24;
      $et = ($et_h > 0) ? $et_d." hari ".$et_h." jam" : $et_d." hari ";
    } else if ($et < 24) {
      $et = $et . " jam";
    }

    return $et;
  }
}
