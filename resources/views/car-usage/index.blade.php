<?php $no = 1; ?>
@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-10">
      @if ($car_usages->isNotEmpty())
        <div class="card border-info my-4">
          <h4 class="card-header text-white bg-info">
            Daftar Penggunaan Kendaraan 
          </h4>
          <div class="card-body">
            <p class="card-text">
              Berikut seluruh data untuk penggunaan kendaraan yang masih aktif saat ini.
            </p>
          </div>
          <table class="table table-hover table-striped table-sm table-responsive">
            <thead>
              <th class="text-center">#</th>
              <th>Pegawai</th>
              <th>Sopir</th>
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
                <td class="align-middle">{{ $usage->drivenBy->driver_name }}</td>
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
          <h5 class="card-header">
            <b>Daftar pemakaian kendaraan</b>
          </h5>
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
        <div class="col-sm-12 col-md-6">
          <a href="{{ route('car-usage.create') }}" class="btn btn-success float-right">Request Baru</a>
        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection
