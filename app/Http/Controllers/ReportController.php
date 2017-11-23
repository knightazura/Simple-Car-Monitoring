<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function index()
    {
      $years = \App\Models\HistoryCarUsage::select(DB::raw('year(start_use) as year'))
        ->distinct()
        ->get();
      if ($years->isEmpty()) {
        $years = date('Y');
      }

      $months = [
          1 => 'Januari',
          2 => 'Februari', 
          3 => 'Maret', 
          4 => 'April', 
          5 => 'Mei', 
          6 => 'Juni', 
          7 => 'Juli', 
          8 => 'Agustus', 
          9 => 'September', 
          10 => 'Oktober', 
          11 => 'November', 
          12 => 'Desember'
        ];
      return view('reports.index', compact('years', 'months'));
    }
}
