<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class MiscController extends Controller
{
  public function streamFirstDoc($id)
  {
    $data = \App\Models\CarUsage::findOrFail($id);
    view()->share('data', $data);
    $genTime = date('FdYHis');

    $pdf = PDF::loadView('layouts.print')
      ->setPaper('a4')
      ->save("requestDoc-{$genTime}.pdf");

    return $pdf->inline();
  }

  public function streamSecondDoc($id)
  {
    $data = \App\Models\CarUsage::findOrFail($id);
    // return view('layouts.print-2', compact('data'));

    /*
    */
    view()->share('data', $data);
    $genTime = date('FdYHis');

    $pdf = PDF::loadView('layouts.print-2')
      ->setPaper('a4')
      ->save("requestDoc2-{$genTime}.pdf");
    
    return $pdf->inline();
  }

  public function historyFilter(Request $request)
  {
    $mode = 'filter';
    $range = explode(" - ", $request->from);
    $from = date('Y-m-d H:i:s', strtotime($range[0]));
    $to = date('Y-m-d H:i:s', strtotime($range[1]));

    $car_usages = \App\Models\HistoryCarUsage::whereBetween('start_use', [$from, $to])
      // ->whereBetween('start_use', [$from, $to])
      ->get();

    return view('car-usage.history', compact('car_usages', 'mode', 'from', 'to'));
  }

}
