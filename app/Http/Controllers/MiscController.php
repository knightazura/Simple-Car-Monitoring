<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryCarUsage;
use App\Support\DateIndonesia;
use Excel;
use PDF;

class MiscController extends Controller
{
  use DateIndonesia;

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

  public function streamThirdDoc($id)
  {
    $data = \App\Models\CarUsage::findOrFail($id);
    return view('layouts.print-3', compact('data'));

    // view()->share('data', $data);
    // $genTime = date('FdYHis');

    // $pdf = PDF::loadView('layouts.print-3')
    //   ->setPaper('a4')
    //   ->save("requestDoc-{$genTime}.pdf");

    // return $pdf->inline();
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

  // Excel files
  public function excelFristReport(Request $request)
  {
    $sd = date("Y-m-d H:i:s", mktime(0,0,0,$request->start_month,1,date('Y')));
    $ed = date('Y-m-d H:i:s', strtotime('+'.$request->report_period.' months', strtotime($sd)));

    Excel::create('filename', function ($excel) use ($request) {
      // Init options
      $column = $request->filter_by;
      $sd     = date("Y-m-d H:i:s", mktime(0,0,0,$request->start_month,1,date('Y')));
      $ed     = date("Y-m-d H:i:s", strtotime("+{$request->report_period} months", strtotime($sd)));
      // Report period sentence
      $rps    = ($request->report_period > 1) ? DateIndonesia::show_indo($sd, 'bulan_tahun') . ' - ' . DateIndonesia::show_indo($ed, 'bulan_tahun') : DateIndonesia::show_indo($sd, 'bulan_tahun');
      
      // Data
      $header = ['NIP','NAMA PEGAWAI','JABATAN','DIVISI','JENIS KENDARAAN','SOPIR','SOPIR PENGGANTI','JUMLAH PENUMPANG','TUJUAN','KEPERLUAN','STATUS BBM','PENGGUNAAN BBM','KETERANGAN TAMBAHAN','KM AWAL','KM KEMBALI','WAKTU PENGGUNAAN','WAKTU KEMBALI'];
      $fields = ['employee_nip',
        'employee_name',
        'employee_position',
        'employee_division',
        'car',
        'driver',
        'backup_driver',
        'total_passengers',
        'destination',
        'necessity',
        'fuel_status',
        'fuel_usage',
        'additional_description',
        'start_km_pos',
        'end_km_pos',
        'start_use',
        'end_use'
      ];

      if ($column == "dual") {
        $model = HistoryCarUsage::select($fields)
          ->whereBetween('start_use', [$sd, $ed])
          ->orWhereBetween('end_use', [$sd, $ed])
          ->orderBy('start_use', 'asc')
          ->get();
      }
      else {
        $model = HistoryCarUsage::select($fields)
          ->whereBetween($column, [$sd, $ed])
          ->orderBy('start_use', 'asc')
          ->get();
      }

      // Create Sheet
      $excel->sheet('Sheet 1', function ($sheet) use ($model, $header, $rps) {

        /**
         *  General settings & header report init
         */
        $sheet->cell('A1', function ($cell) {
          $cell->setValue('Rekap laporan pemakaian kendaraan');
          $cell->setFontSize(14);
          $cell->setFontWeight('bold');
        });
        $sheet->cell('A2', function ($cell) use ($rps) {
          $cell->setValue('Periode laporan: ' . $rps);
        });
        // Paper Orientation
        $sheet->setOrientation('landscape');
        $data_header = array($header);

        /**
         *  Data
         */
        // Set header
        $sheet->fromArray($data_header, null, 'A4', false, false);
        // Print data
        $sheet->fromArray($model, null, 'A4', false, false);
      });

    })->download('xls');
  } 

}
