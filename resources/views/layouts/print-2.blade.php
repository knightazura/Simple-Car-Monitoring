@extends('layouts.print-wrapper')

@section('content')
<div class="container" style="border: 1px double #999">

  <!-- 1st table -->
  <div class="row justify-content-md-center pb-2" style="border-bottom: 1px dashed #999; font-size: 10pt">
    <div class="col-md-12">
      <table>
        <tr>
          <td colspan="4" class="w-40">
            <b><u>PLN UIP SULBAGSEL</u></b>
          </td>
          <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="12" class="text-center">
            <b>SURAT PERMOHONAN PENGGUNAAN KENDARAAN DINAS OPERASIONAL</b> <br>
            <small>Nomor: {{ $data->id }} / MUM.00.07 / BIDKSDM / {{date('Y')}} </small>
          </td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="12">
            <small>Dengan ini mengajukan permohonan penggunaan kendaraan dinas operasional dalam kota/luar kota :</small>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Nama Pemohon</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->requestedBy->employee_name }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Jabatan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->requestedBy->employee_position }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Jenis Kendaraan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->car_plat_number }} ({{ $data->carStatus->theCar->car_name }})</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Jumlah Penumpang</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->total_passengers }} orang</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Tempat Tujuan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->destination }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Maksud Perjalanan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->necessity }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Tanggal yang diinginkan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ date('d-m-Y H:i:s', strtotime($data->desire_time)) }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Pengambilan BBM</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->fuel_usage }} L</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Estimasi waktu penggunaan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->estimates_time }} hari</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Keterangan</small></td>
          <td colspan="10" class="text-left"><small>: 
            @if(is_null($data->additional_description))
              . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
            @else
              {{ $data->additional_description }}
            @endif
          </small></td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="6" class="w-50 text-center">
            <small>Mengetahui / Menyetujui<br>
            <b>DM SDM DAN UMUM</b>
            <br><br><br><br>
            <b>SYAMSU ALAM</b></small>
          </td>
          <td colspan="6" class="w-50 align-top text-center">
            <small>Makassar, {{ date('d-m-Y') }}<br>
            <b>PEMOHON</b>
            <br><br><br><br>
            <b>{{ $data->requestedBy->employee_name }}</b></small>
          </td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="12">
            <small>KET: Lembar Asli untuk tagihan ke PLN</small>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <!-- 2nd table || Surat Penugasan -->
  <div class="row justify-content-md-center mt-2" style="font-size: 10pt">
    <div class="col-md-12">
      <table>
        <tr>
          <td colspan="4" class="w-40">
            <b><u>PLN UIP SULBAGSEL</u></b>
          </td>
          <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="12" class="text-center">
            <b>SURAT PENUGASAN PENGGUNAAN KENDARAAN DINAS OPERASIONAL</b> <br>
            <small>Nomor: {{ $data->id }} / MUM.00.07 / UIPSULBAGSEL / {{date('Y')}}</small>
          </td>
        </tr>
        <!-- <tr><td colspan="12">&nbsp;</td></tr> -->
        <tr>
          <td colspan="12">
            <small>Dengan ini menugaskan {{ $data->drivenBy->workOn->company_name }}
              sesuai dengan <u>Form Permohonan Penggunaan Kendaraan Dinas Operasional</u> :</small>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Nama Pemohon</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->requestedBy->employee_name }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Jabatan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->requestedBy->employee_position }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Jenis Kendaraan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->car_plat_number }} ({{ $data->carStatus->theCar->car_name }})</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Jumlah Penumpang</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->total_passengers }} orang</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Tempat Tujuan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->destination }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Maksud Perjalanan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->necessity }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Tanggal yang diinginkan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ date('d-m-Y H:i:s', strtotime($data->desire_time)) }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-25"><small>Estimasi waktu penggunaan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->estimates_time }} hari</small></td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="6" class="w-50 align-top text-center">
            <small>Menyetujui,<br>
            <b>{{ $data->drivenBy->workOn->company_name }}</b>
            <br><br><br><br>
            <b>{{ $data->drivenBy->workOn->company_director }}</b></small>
          </td>
          <td colspan="6" class="w-50 align-top text-center">
            <small>Makassar, {{ date('d-m-Y') }}<br>
            <b>DM SDM DAN UMUM
            <br><br><br><br>
            SYAMSU ALAM</b></small>
          </td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="12">
            <small>KET: Lembar Asli untuk tagihan ke PLN</small>
          </td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
      </table>
    </div>
  </div>

</div>
@endsection
