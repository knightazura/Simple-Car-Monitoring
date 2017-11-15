<?php $no = 1; ?>
@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-10">
      @if ($car_usages->isNotEmpty())
        <div class="card border-info my-4">
          <div class="card-header text-white bg-info">
            <span style="font-size: 14pt"><b>Daftar Penggunaan Kendaraan</b></span>
            <a href="{{ route('car-usage.create') }}" class="btn btn-sm btn-dark float-right">Request Baru</a>
          </div>
          <div class="card-body">
            <p class="card-text">
              Berikut seluruh data untuk penggunaan kendaraan yang masih aktif saat ini.
            </p>
          </div>
          <table class="table table-hover table-striped table-sm table-responsive">
            <thead>
              <th class="text-center">#</th>
              <th>Pegawai</th>
              <th>Driver</th>
              <th>Kendaraan</th>
              <th>Tempat Tujuan</th>
              <th>Tanggal mulai penggunaan</th>
              <th class="text-center">Perkiraan waktu</th>
              <th>&nbsp;</th>
            </thead>
            <tbody>
            @foreach ($car_usages as $usage)
              <tr>
                <td class="text-center align-middle">
                  {{ $no++ }}
                </td>
                <td class="align-middle">{{ $usage->requestedBy->employee_name }}</td>
                <td class="align-middle">
                  @if (!is_null($usage->backupDrivenBy))
                    {{ $usage->backupDrivenBy->driver_name }}*
                  @else
                    {{ $usage->drivenBy->driver_name }}
                  @endif
                </td>
                <td class="align-middle">{{ $usage->car_plat_number }} ({{ $usage->carStatus->theCar->car_name }})</td>
                <td class="align-middle">{{ $usage->destination }}</td>
                <td class="align-middle">{{ $usage->desire_time }}</td>
                <td class="text-center align-middle">{{ $usage->estimates_time }} hari</td>
                <td class="align-middle text-right">
                  <a href="{{ route('car-usage.show', $usage->id) }}"
                    class="btn btn-sm btn-primary"
                    data-toggle="tooltip" data-placement="top" title="Lihat detail">
                      <i class="fa fa-bookmark" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
          <div class="card-footer">
          @include('layouts.cf-navigation', [
            'collection' => $car_usages,
            'entity_name' => 'data penggunaan kendaraan'
          ])
        </div>
      </div>
      @else
        <div class="card text-white bg-warning my-4">
          <div class="card-header">
            <span style="font-size: 14pt"><b>Daftar Penggunaan Kendaraan</b></span>
            <a href="{{ route('car-usage.create') }}" class="btn btn-sm btn-dark float-right">Request Baru</a>
          </div>
          <div class="card-body">
            <p class="card-text">Belum ada permohonan penggunaan kendaraan untuk saat ini.</p>
          </div>
        </div>
      @endif

      <div class="row my-3">
        <div class="col-sm-12 col-md-6">
          <a href="{{ route('home') }}">
            <i class="el-icon-arrow-left"></i> Kembali
          </a>
        </div>
        @if ($car_usages->isNotEmpty())
          <div class="col-sm-12 col-md-6">
            <div class="alert alert-warning">
              <b>*</b> Driver pengganti
            </div>
          </div>
        @endif
      </div>
      
    </div>
  </div>
</div>
@endsection
