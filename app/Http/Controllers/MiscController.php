<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryCarUsage;
use App\Support\DateIndonesia;
use Storage;
use Artisan;
use Excel;
use PDF;

class MiscController extends Controller
{
  use DateIndonesia;

  public function index()
  {
    return view('misc.index');
  }

  public function snapshotsBackup(Request $request, $command)
  {
    $temp_name = "app-randis-" . date('mdY-His');
    $params = ['name' => $temp_name];

    try {
      Artisan::call('snapshot:create', $params);
      $path_file = database_path("snapshots/{$temp_name}.sql");
      
      return response()
        ->download($path_file);
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  public function snapshotRestore(Request $request)
  {
    $file = $request->file('snapshot');
    $file_name = $file->getClientOriginalName();
    $file_name = str_replace(".sql", "", $file_name);
    
    $file->move(database_path('snapshots'), $file->getClientOriginalName());

    $params = ['name' => $file_name];
    try {
      Artisan::call('snapshot:load', $params);
      return back()->with('status', 'Data berhasil dipulihkan kembali');
    } catch (Exception $e) {
      return back()->with('status', $e->getMessage());
    }
  }

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
    $data = \App\Models\HistoryCarUsage::findOrFail($id);
    $cd = date('Y-m-d');

    $excel = Excel::create("form-sppd-{$id}-{$cd}", function ($excel) use ($data) {
      $excel->sheet('Laporan Kembali', function ($sheet) use ($data) {
        $sheet->setWidth(array(
          'A' => 1.83,
          'B' => 20.83,
          'C' => 2.17,
          'N' => 1.83
        ));

        for($i = 1; $i <= 34; $i++) {
          $rows[$i] = 20;
        }
        $sheet->setHeight($rows);

        // Company Name on left top
        $company = ($data->backup_driver_company != "-") ? $data->backup_driver_company : $data->driver_company;
        $company_director = ($data->backup_company_director != "-") ? $data->backup_company_director : $data->company_director;

        $sheet->cell('B1', function ($cell) use ($company) {
          $cell->setValue($company);
          $cell->setFontSize(14);
          $cell->setFontWeight('bold');
        });

        // Title
        $sheet->mergeCells('B3:M3');
        $sheet->cell('B3', function ($cell) {
          $cell->setValue('SURAT LAPORAN KEMBALI PEMAKAIAN KENDARAAN');
          $cell->setFontSize(16);
          $cell->setFontWeight('bold');
          $cell->setAlignment('center');
        });
        
        // Number
        $sheet->mergeCells('B4:M4');
        $sheet->cell('B4', function ($cell) use ($data) {
          $cell->setValue('Nomor: ' . $data->usage_id);
          $cell->setAlignment('center');
        });

        // Contents
        $sheet->cell('B6', function ($cell) { $cell->setValue('Dengan ini menerangkan:'); });
        
        $driver = ($data->backup_driver != "-") ? "{$data->backup_driver} (sopir pengganti)" : $data->driver;
        $driver_name = ($data->backup_driver != "-") ? $data->backup_driver : $data->driver;

        $column_fields = array(
          7 => array( 'fn' => 'Nama Pengemudi', 'fv' => $driver ),
          array( 'fn' => 'Tempat Tujuan', 'fv' => $data->destination ),
          array( 'fn' => 'Plat Kendaraan / Jenis Kendaraan', 'fv' => $data->car ),
          array( 'fn' => 'Lama Perjalanan', 'fv' => $data->usage_time ),
          array( 'fn' => 'Waktu Berangkat', 'fv' => $data->start_use ),
          array( 'fn' => 'Waktu Kembali', 'fv' => $data->end_use ),
          array( 'fn' => 'Maksud Perjalanan', 'fv' => $data->necessity ),
          array( 'fn' => 'Posisi KM Awal', 'fv' => $data->start_km_pos ),
          array( 'fn' => 'Posisi KM Kembali', 'fv' => $data->end_km_pos ),
          array( 'fn' => 'Status BBM', 'fv' => "{$data->fuel_status} (Penggunaan BBM: {$data->fuel_usage})" )
        );

        foreach ($column_fields as $key => $value) {
          $sheet->mergeCells("D{$key}:M{$key}");
          $sheet->cell("B{$key}", function ($cell) use ($key, $value) {
            $cell->setValue($value['fn']); 
            $cell->setAlignment('left');
            $cell->setValignment('center');
          });
          $sheet->cell("C{$key}", function ($cell) {
            $cell->setValue(':');
            $cell->setAlignment('center');
          });
          $sheet->cell("D{$key}", function ($cell) use ($key, $value) {
            $cell->setValue($value['fv']);
            $cell->setAlignment('left');
            $cell->setValignment('center');
            $cell->setBorder('none', 'none', 'thin', 'none');
          });
        }

        // Left Footer
        $left_footer_cells = array(
          18 => "DIREKTUR",
          19 => $company
        );
        foreach ($left_footer_cells as $key => $value) {
          $sheet->mergeCells("B{$key}:D{$key}");
          $sheet->cell("B{$key}", function ($cell) use ($value) {
            $cell->setValue($value);
            $cell->setFontWeight('bold');
            $cell->setAlignment('center');
            $cell->setValignment('center');
          });
        }
        $sheet->mergeCells("B24:D24");
        $sheet->cell("B24", function ($cell) use ($company_director) {
          $cell->setValue($company_director);
          $cell->setFontWeight('bold');
          $cell->setAlignment('center');
          $cell->setValignment('center');
        });

        // Right Footer
        $sheet->mergeCells('I19:K19');
        $sheet->cell('I19', function ($cell) {
          $cell->setValue('PENGEMUDI');
          $cell->setFontWeight('bold');
          $cell->setAlignment('center');
          $cell->setValignment('center');
        });

        $sheet->mergeCells('I24:K24');
        $sheet->cell('I24', function ($cell) use ($driver_name) {
          $cell->setValue($driver_name);
          $cell->setFontWeight('bold');
          $cell->setAlignment('center');
          $cell->setValignment('center');
        });

        // Additional footer
        $sheet->cell('B26:L26', function ($cell) { $cell->setBorder('none', 'none', 'dotted', 'none'); });
        $sheet->cell('B33:L33', function ($cell) { $cell->setBorder('none', 'none', 'mediumDashDot', 'none'); });

        $small_caf = ['G', 'M'];
        foreach ($small_caf as $key => $value) {
          $sheet->setWidth($value, 1);
          for($i = 28; $i <= 32; $i++) {
            $sheet->cell("{$value}{$i}", function ($cell) use ($i, $value) {
              if ($value == 'G') {
                if ($i == 28) $cell->setBorder('thin', 'none', 'none', 'thin');
                else if ($i == 32) $cell->setBorder('none', 'none', 'thin', 'thin');
                else $cell->setBorder('none', 'none', 'none', 'thin');
              }
              else {
                if ($i == 28) $cell->setBorder('thin', 'thin', 'none', 'none');
                else if ($i == 32) $cell->setBorder('none', 'thin', 'thin', 'none');
                else $cell->setBorder('none', 'thin', 'none', 'none');
              }
            });
          }
        }

        $additional_footer_cells = array(
          28 => "Perpanjangan Perjalanan Keluar Daerah :",
          29 => ". . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . ."
        );
        foreach ($additional_footer_cells as $key => $value) {
          $sheet->mergeCells("H{$key}:L{$key}");
          $sheet->cell("H{$key}", function ($cell) use ($key, $value) {
            $cell->setValue($value);
            if ($key == 28) $cell->setBorder('thin', 'none', 'none', 'none');
          });
        }
        $sheet->mergeCells('H32:L32');
        $sheet->cell('H32', function ($cell) {
          $cell->setValue('Paraf SPV ADM UMUM');
          $cell->setAlignment('right');
          $cell->setBorder('none', 'none', 'thin', 'none');
        });

        // $sheet->protect('secret');
      });
    })->download('xls');

    if ($excel) {
      return redirect()->route('car-usage.index');
    }
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
    $sdfn = date("Ymd", mktime(0,0,0,$request->start_month,1,date('Y')));
    $edfn = date("Ymd", strtotime("+".($request->report_period - 1)."months", strtotime($sdfn)));
    $filename = "report-rekap-".$sdfn."-".$edfn;

    Excel::create($filename, function ($excel) use ($request) {
      // Init options
      $column = $request->filter_by;
      $sd     = date("Y-m-d H:i:s", mktime(0,0,0,$request->start_month,1,$request->year));
      $ed     = date("Y-m-d H:i:s", strtotime("+{$request->report_period} months", strtotime($sd)));
      $edw    = date("Y-m-d H:i:s", strtotime("+".($request->report_period - 1)."months", strtotime($sd)));
      // Report period sentence
      $rps    = ($request->report_period > 1) ? DateIndonesia::show_indo($sd, 'bulan_tahun') . ' - ' . DateIndonesia::show_indo($edw, 'bulan_tahun') : DateIndonesia::show_indo($sd, 'bulan_tahun');
      
      // Data
      $header = ['NOMOR SURAT', 'NIP','NAMA PEGAWAI','JABATAN','DIVISI','JENIS KENDARAAN','SOPIR','SOPIR PENGGANTI','JUMLAH PENUMPANG','TUJUAN','KEPERLUAN','STATUS BBM','PENGGUNAAN BBM','KETERANGAN TAMBAHAN','KM AWAL','KM KEMBALI','WAKTU PENGGUNAAN','WAKTU KEMBALI'];
      $fields = ['usage_id',
        'employee_nip',
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
          ->orderBy('usage_id', 'asc')
          ->get();
      }
      else {
        $model = HistoryCarUsage::select($fields)
          ->whereBetween($column, [$sd, $ed])
          ->orderBy('usage_id', 'asc')
          ->get();
      }

      // Create Sheet
      $excel->sheet('Sheet 1', function ($sheet) use ($model, $header, $rps) {
        $sheet->setWidth('A', 15);

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
