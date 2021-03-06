<?php $no = 1; ?>
@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-10">
      <div class="card border-info my-4">
        <h4 class="card-header text-white bg-info">
          Daftar Penggunaan Kendaraan 
        </h4>
        <div class="card-body">
          @if ($car_usages->isNotEmpty())
            <p class="card-text">
              Berikut seluruh data untuk penggunaan kendaraan yang masih aktif saat ini.
            </p>
            <table class="table table-hover table-striped table-responsive">
              <thead>
                <th class="text-center">#</th>
                <th>Pegawai</th>
                <th>Sopir</th>
                <th>Kendaraan</th>
                <th>Tempat Tujuan</th>
                <th>Tanggal mulai penggunaan</th>
                <th class="text-center">Perkiraan waktu</th>
              </thead>
              <tbody>
              @foreach ($car_usages as $usage)
                <tr>
                  <td class="text-center">
                    <a href="{{ route('car-usage.show', $usage->id) }}">{{ $no++ }}</a>
                  </td>
                  <td>{{ $usage->requestedBy->employee_name }}</td>
                  <td>{{ $usage->drivenBy->driver_name }}</td>
                  <td>{{ $usage->car_plat_number }} ({{ $usage->carStatus->theCar->car_name }})</td>
                  <td>{{ $usage->destination }}</td>
                  <td>{{ $usage->desire_time }}</td>
                  <td class="text-center">{{ $usage->estimates_time }} hari</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          @else
            <div class="alert alert-warning" role="alert">
              Belum ada permohonan penggunaan kendaraan untuk saat ini.
            </div>
          @endif
        </div>
        <div class="card-footer">
          @include('layouts.cf-navigation', [
            'collection' => $car_usages,
            'entity_name' => 'data penggunaan kendaraan'
          ])
        </div>
      </div>
      <a href="{{ route('car-usage-history-index') }}" class="btn btn-info float-right ml-2">Rekap</a>
      <a href="{{ route('car-usage.create') }}" class="btn btn-success float-right">Request Baru</a>
    </div>
  </div>
</div>
@endsection
