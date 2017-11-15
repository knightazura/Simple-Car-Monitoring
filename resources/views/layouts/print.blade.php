@extends('layouts.print-wrapper')
@php setlocale(LC_ALL, 'INDONESIA'); @endphp
@section('content')
<div class="container">

  <!-- 1st table -->
  <div class="row justify-content-md-center pb-4" style="border-bottom: 1px dashed #666">
    <div class="col-md-12">
      <table class="table-print">
        <tr>
          <td class="border-top-0" colspan="1" rowspan="2">
            <img src="{{ asset('images/pln.png') }}" height="30%" alt="Header Logo">
          </td>
          <td colspan="11" class="align-middle text-center print-head border-dark border-top-0">
            PT. PLN (PERSERO)<br>
            UNIT INDUK PEMBANGUNAN SULBAGSEL
          </td>
        </tr>
        <tr>
          <td colspan="6" class="w-60 border-0">&nbsp;</td>
          <td colspan="5" class="border-0 text-center print-head">No. {{ $data->id }}</td>
        </tr>
        <tr style="border-top: 1px solid #222">
          <td class="text-left border-dark" colspan="12">
            <u><b>Daftar : C</b></u>
          </td>
        </tr>
        <tr>
          <td colspan="12" class="text-center font-weight-bold border-0">
            <u>PERMOHONAN ANGKUTAN BERMOTOR UNTUK KEPERLUAN <br>
            DINAS / SOSIAL / ...........................</u>
          </td>
        </tr>
      </table>
      <table class="table-print w-100" style="font-size: 11pt">
        <tr>
          <td colspan="4" class="border-0 w-40">
            Nama: {{ $data->requestedBy->employee_name }}
          </td>
          <td colspan="8" class="text-center border-0 w-60">
            Bagian: {{ $data->requestedBy->division }}
          </td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Jabatan: {{ $data->requestedBy->employee_position }}</td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Macam kendaraan yang diperlukan : {{ $data->car_plat_number }} ({{ $data->carStatus->theCar->car_name }})</td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Banyaknya Penumpang yang ikut: {{ $data->total_passengers }} orang</td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Tujuan / keperluan: {{ $data->necessity }}</td>
        </tr>
        <tr>
          <td colspan="10" class="w-50 border-0">Tanggal yang diinginkan: {{ date('d-m-Y', strtotime($data->desire_time)) }}</td>
          <td colspan="2" class="border-0">jam: {{ date('H:i:s', strtotime($data->desire_time)) }}</td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Kendaraan akan dipergunakan kira - kira: {{ $data->estimates_time }} hari/jam</td>
        </tr>
        <tr>
          <td colspan="6" class="border-0">&nbsp;</td>
          <td colspan="6" class="text-center border-0">
            Makassar, {{ strftime('%e %B %Y') }}
          </td>
        </tr>
        <tr>
          <td colspan="6" class="border-0 w-50 text-center">Mengetahui / Menyetujui</td>
          <td colspan="6" class="border-0 w-50 text-center">Pemohon</td>
        </tr>
        <tr><td colspan="12" class="border-0">&nbsp;</td></tr>
        <tr><td colspan="12" class="border-0">&nbsp;</td></tr>
        <tr>
          <!-- <td colspan="1" class="w-10">&nbsp;</td> -->
          <td colspan="6" class="border-0 w-50 text-center">( .............................................. )</td>
          <td colspan="6" class="border-0 w-50 text-center">( .............................................. )</td>
        </tr>
      </table>
    </div>
  </div>

  <!-- 2nd table -->
  <div class="row justify-content-md-center mt-4">
    <div class="col-md-12">
      <table class="table-print">
        <tr>
          <td class="border-top-0" colspan="1" rowspan="2">
            <img src="{{ asset('images/pln.png') }}" height="30%" alt="Header Logo">
          </td>
          <td colspan="11" class="align-middle text-center print-head border-dark border-top-0">
            PT. PLN (PERSERO)<br>
            UNIT INDUK PEMBANGUNAN SULBAGSEL
          </td>
        </tr>
        <tr>
          <td colspan="6" class="w-60 border-0">&nbsp;</td>
          <td colspan="5" class="border-0 text-center print-head">No. {{ $data->id }}</td>
        </tr>
        <tr style="border-top: 1px solid #222">
          <td class="border-dark" colspan="12">
            <u><b>Daftar : C</b></u>
          </td>
        </tr>
        <tr>
          <td colspan="12" class="text-center font-weight-bold border-0">
            <u>PERMOHONAN ANGKUTAN BERMOTOR UNTUK KEPERLUAN <br>
            DINAS / SOSIAL / ...........................</u>
          </td>
        </tr>
      </table>
      <table class="table-print w-100" style="font-size: 11pt">
        <tr>
          <td colspan="4" class="border-0 w-40">
            Nama: {{ $data->requestedBy->employee_name }}
          </td>
          <td colspan="8" class="text-center border-0 w-60">
            Bagian: {{ $data->requestedBy->division }}
          </td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Jabatan: {{ $data->requestedBy->employee_position }}</td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Macam kendaraan yang diperlukan : {{ $data->car_plat_number }} ({{ $data->carStatus->theCar->car_name }})</td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Banyaknya Penumpang yang ikut: {{ $data->total_passengers }} orang</td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Tujuan / keperluan: {{ $data->necessity }}</td>
        </tr>
        <tr>
          <td colspan="10" class="w-50 border-0">Tanggal yang diinginkan: {{ date('d-m-Y', strtotime($data->desire_time)) }}</td>
          <td colspan="2" class="border-0">jam: {{ date('H:i:s', strtotime($data->desire_time)) }}</td>
        </tr>
        <tr>
          <td colspan="12" class="border-0">Kendaraan akan dipergunakan kira - kira: {{ $data->estimates_time }} hari/jam</td>
        </tr>
        <tr>
          <td colspan="6" class="border-0">&nbsp;</td>
          <td colspan="6" class="text-center border-0">
            Makassar, {{ strftime('%e %B %Y') }}
          </td>
        </tr>
        <tr>
          <td colspan="6" class="border-0 w-50 text-center">Mengetahui / Menyetujui</td>
          <td colspan="6" class="border-0 w-50 text-center">Pemohon</td>
        </tr>
        <tr><td colspan="12" class="border-0">&nbsp;</td></tr>
        <tr><td colspan="12" class="border-0">&nbsp;</td></tr>
        <tr>
          <!-- <td colspan="1" class="w-10">&nbsp;</td> -->
          <td colspan="6" class="border-0 w-50 text-center">( .............................................. )</td>
          <td colspan="6" class="border-0 w-50 text-center">( .............................................. )</td>
        </tr>
      </table>
    </div>
  </div>

</div>
@endsection
