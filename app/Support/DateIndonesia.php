<?php

namespace App\Support;

trait DateIndonesia
{
  public static function show_indo($date, $format) // date format Y-m-d
  {
    // Take 10th first characters
    $date = substr($date, 0, 10);

    $month = array(
      1 => 'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );

    $splitted = explode('-', $date);

    switch ($format) {
      case 'lengkap':
        $output = $splitted[2] . " " . $month[(int)$splitted[1]] . " " . $splitted[0];
        break;
      case 'bulan_tahun':
        $output = $month[(int)$splitted[1]] . " " . $splitted[0];
        break;
      
      default:
        $output = $splitted[2] . " " . $month[(int)$splitted[1]] . " " . $splitted[0];
        break;
    }
    return $output;
  }
}
