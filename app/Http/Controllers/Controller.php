<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function createDistinctApiData($model_name, $field)
    {
        $entities = $model_name::select($field)
            ->distinct()
            ->get();
        foreach ($entities as $key => $value) {
            $result[$key]['value'] = $value->$field;
            $result[$key]['label'] = $value->$field;
        }
        return $result;
    }

    public function driverStatus()
    {
        $output = array(
            '0' => array('status' => 'Stand By', 'class' => 'success'),
            '1' => array('status' => 'Bertugas', 'class' => 'info'),
            '2' => array('status' => 'Sakit/Izin', 'class' => 'warning'),
            '3' => array('status' => 'Tidak ada informasi', 'class' => 'danger')
        );

        return $output;
    }
}
