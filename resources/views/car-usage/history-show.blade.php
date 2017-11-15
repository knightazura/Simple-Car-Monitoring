@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-8">
      <div class="card">
        <h4 class="card-header">
          <b># {{ $usage->usage_id }} - Tujuan: {{ $usage->destination }}</b>
        </h4>
        <div class="card-body">
          <!-- Nama Pegawai -->
          <h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->employee_name }} ({{ $usage->employee_nip }})</h6>
          <p class="card-text text-secondary">
            <small>Nama Pegawai (Pemohon)</small>
          </p>

          <!-- Jabatan & Divisi Pegawai -->
          <h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->employee_position }} / {{ $usage->employee_division }}</h6>
          <p class="card-text text-secondary">
            <small>Jabatan / Divisi</small>
          </p>

          <!-- Data Sopir -->
          <h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->driver }}</h6>
          <p class="card-text text-secondary">
            <small>Nama Sopir</small>
          </p>

          <!-- Data Sopir Pengganti (Jika ada) -->
          @if (!is_null($usage->backup_driver))
            <h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->backup_driver }}</h6>
            <p class="card-text text-secondary">
              <small>Sopir Pengganti</small>
            </p>
          @endif

          <!-- Data Kendaraan yang dipakai -->
          <h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->car }}</h6>
          <p class="card-text text-secondary">
            <small>Kendaraan yang dipakai</small>
          </p>

          <!-- Jumlah Penumpang -->
          <h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->total_passengers }} orang</h6>
          <p class="card-text text-secondary">
            <small>Jumlah penumpang</small>
          </p>

          <!-- Keperluan -->
          <h6 class="card-title" style="margin-bottom: 0">{{ $usage->necessity }}</h6>
          <p class="card-text text-secondary">
            <small>Keperluan</small>
          </p>

          <!-- Status BBM -->
          <h6 class="card-title" style="margin-bottom: 0">{{ $usage->fuel_status }} ({{ $usage->fuel_usage }} L)</h6>
          <p class="card-text text-secondary">
            <small>Status BBM</small>
          </p>

          <!-- Waktu keberangkatan -->
          <h6 class="card-title" style="margin-bottom: 0">{{ $usage->desire_time }}</h6>
          <p class="card-text text-secondary">
            <small>Waktu keberangkatan yang diinginkan</small>
          </p>

          <!-- Perkiraan waktu pemakaian -->
          <h6 class="card-title" style="margin-bottom: 0">{{ $usage->estimates_time }} hari</h6>
          <p class="card-text text-secondary">
            <small>Perkiraan waktu pemakaian kendaraan</small>
          </p>

          <!-- Keterangan tambahan -->
          <h6 class="card-title" style="margin-bottom: 0">
            @if (is_null($usage->additional_description))
              -
            @else
              {{ $usage->additional_description }}
            @endif
          </h6>
          <p class="card-text text-secondary">
            <small>Keterangan tambahan</small>
          </p>

          <!-- Mulai digunakan & Posisi KM -->
          <h6 class="card-title" style="margin-bottom: 0">{{ date('F d, Y (H:i:s)', strtotime($usage->start_use)) }} & {{ $usage->start_km_pos }} KM</h6>
          <p class="card-text text-secondary">
            <small>Waktu mulainya penggunaan & Posisi KM</small>
          </p>

          <!-- Mulai digunakan & Posisi KM -->
          <h6 class="card-title" style="margin-bottom: 0">{{ date('F d, Y (H:i:s)', strtotime($usage->end_use)) }} & {{ $usage->end_km_pos }} KM</h6>
          <p class="card-text text-secondary">
            <small>Waktu selesainya penggunaan & Posisi KM</small>
          </p>

          <!-- Lamanya waktu pemakaian -->
          <h6 class="card-title" style="margin-bottom: 0">{{ $usage->usage_time }}</h6>
          <p class="card-text text-secondary">
            <small>Lamanya waktu pemakaian</small>
          </p>

        </div>

        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('stream-third-doc', $usage->usage_id) }}" class="btn btn-sm btn-success">
              <i class="fa fa-print" aria-hidden="true"></i> Print
            </a>
          </div>
        </div>
      </div> <!-- End Card element -->
    </div>
  </div>

  <div class="row justify-content-md-center my-4">
    <div class="col-sm-12 col-md-8" id="finishedForm">
      <a href="{{ route('car-usage-history-index') }}" class="btn">
        <i class="el-icon-arrow-left"></i> Kembali
      </a>
    </div>
  </div>
</div>
@endsection
