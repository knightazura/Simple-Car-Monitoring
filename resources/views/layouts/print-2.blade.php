@extends('layouts.print-wrapper')

@section('content')
<div class="container" style="border: 3px double #999">

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
        <tr>
          <td colspan="12" class="text-center">
            <b>SURAT PENUGASAN PEMAKAIAN KENDARAAN SEWA</b> <br>
            <small>Nomor: ....... / MUM.00.07 / UIPSULBAGSEL / {{date('Y')}} </small>
          </td>
        </tr>
        <tr>
          <td colspan="12">
            <small>Dengan ini menugaskan PT. Induk Sulmapa Kekar untuk pemakaian kendaraan sewa dalam/luar kota, sesuai dengan
            <u>Form Permohonan Pemakaian Kendaraan Dinas</u>.</small>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Tempat Tujuan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->destination }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Jenis Kendaraan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->car_plat_number }} ({{ $data->carStatus->theCar->car_name }})</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Lama Perjalanan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->estimates_time }} hari, tanggal {{ date('d-m-Y', strtotime($data->desire_time)) }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Maksud Perjalanan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->necessity }}</small></td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="6" class="w-50 text-center">
            <small>Menyetujui,<br>
            <b>DIREKTUR</b><br>
            <b>{{ $data->drivenBy->workOn->company_name }}</b>
            <br><br><br>
            <b>{{ $data->drivenBy->workOn->company_director }}</b></small>
          </td>
          <td colspan="6" class="w-50 align-top text-center">
            <small>Makassar, {{ date('d-m-Y') }}<br>
            <b>DM SDM DAN UMUM</b></small>
          </td>
        </tr>
        <tr>
          <td colspan="12">
            <small>KET:<br>
            Lembar Asli untuk tagihan ke PLN</small>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <!-- 2nd table -->
  <div class="row justify-content-md-center mt-2" style="font-size: 10pt">
    <div class="col-md-12">
      <table>
        <tr>
          <td colspan="4" class="w-40">
            <b><u>{{ $data->drivenBy->workOn->company_name }}</u></b>
          </td>
          <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="12" class="text-center">
            <b>SURAT PENUGASAN PEMAKAIAN KENDARAAN SEWA</b> <br>
            <small>Nomor: ...................................... </small>
          </td>
        </tr>
        <tr>
          <td colspan="12">
            <small>Dengan ini menugaskan :</small>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Nama Pengemudi</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->drivenBy->driver_name }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Tempat Tujuan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->destination }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Jenis Kendaraan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->car_plat_number }} ({{ $data->carStatus->theCar->car_name }})</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Lama Perjalanan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->estimates_time }} hari, tanggal {{ date('d-m-Y', strtotime($data->desire_time)) }}</small></td>
        </tr>
        <tr>
          <td colspan="2" class="w-20"><small>Maksud Perjalanan</small></td>
          <td colspan="10" style="border-bottom: 1px solid #999" class="text-left"><small>: {{ $data->necessity }}</small></td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="6" class="w-50 text-center">
            <small>Menyetujui,<br>
            <b>DIREKTUR</b><br>
            <b>{{ $data->drivenBy->workOn->company_name }}</b>
            <br><br><br>
            <b>{{ $data->drivenBy->workOn->company_director }}</b></small>
          </td>
          <td colspan="6" class="w-50 align-top text-center">
            <small>Makassar, {{ date('d-m-Y') }}<br>
            <b>DM SDM DAN UMUM</b></small>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <!--
  3rd table 
  <div class="row justify-content-md-center mt-2">
    <div class="col-md-12">
      <table style="font-size: 8pt; border: 1px solid #aaa">
        <tr><td colspan="12" class="w-100"><u><i>Dinas Keluar Kota:</i></u></td></tr>
        <tr>
          <td colspan="4" class="w-30">
            <table style="border: 1px solid #666">
              <tr><td colspan="2">KET :</td></tr>
              <tr><td colspan="2">Tiba kembali di Makassar :</td></tr>
              <tr>
                <td>Hari/Tanggal </td>
                <td>: .......................................... {{ date('Y') }}</td>
              </tr>
              <tr>
                <td>Ttd/Paraf {{ $data->drivenBy->company }} </td>
                <td>: ..........................................</td>
              </tr>
            </table>
          </td>
          <td colspan="2" class="w-10">&nbsp;</td>
          <td colspan="6" class="w-60">
            <table style="border: 1px solid #666">
              <tr><td colspan="2">Perpanjangan Perjalanan Keluar Daerah:</td></tr>
              <tr><td colspan="2">................................................................</td></tr>
              <tr>
                <td class="w-70">&nbsp;</td>
                <td class="w-30 text-right"><br>Paraf SPV ADM UMUM</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr><td colspan="12">&nbsp;</td></tr>
        <tr>
          <td colspan="4" class="w-40">
            <table class="p-5" style="border: 1px solid #666">
              <tr><td colspan="2">RINCIAN PERJALANAN DINAS PENGEMUDI :</td></tr>
              <tr><td colspan="2">Tarif Uang Saku :</td></tr>
              <tr>
                <td>Ibukota Propinsi</td>
                <td>: Rp. 250.000,-</td>
              </tr>
              <tr>
                <td>diluar Ibukota Propinsi</td>
                <td>: Rp. 200.000,-</td>
              </tr>
              <tr><td colspan="2">&nbsp;</td></tr>
              <tr>
                <td colspan="2">Jumlah Hari: ........... (.......................)</td>
              </tr>
            </table>
          </td>
          <td colspan="8" class="w-60">&nbsp;</td>
        </tr>
      </table>
    </div>
  </div>
  -->

</div>
@endsection
