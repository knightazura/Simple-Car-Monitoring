<?php

namespace App\Support;

trait CarUsageMisc
{
  public static function setStatus($id, $model, $status)
  {
    $model = "App\\Models\\{$model}";
    $entity = $model::findOrFail($id);
    $entity->status = $status;
    $entity->save();
  }
}
