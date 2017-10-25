<?php $no = 1; ?>
@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-10">
      @if ($car_usages->isNotEmpty())
        <div class="card border-info my-4">
          <h4 class="card-header text-white bg-info">
            Rekap Penggunaan Kendaraan 
          </h4>
          <div class="card-body">
            <p class="card-text">
              Berikut rekap seluruh data untuk penggunaan kendaraan yang dilakukan.
            </p>
          </div>
          <table class="table table-hover table-striped table-responsive">
            <thead>
              <th class="text-center">#</th>
              <th>Pegawai</th>
              <th>Sopir</th>
              <th>Kendaraan</th>
              <th>Tempat Tujuan</th>
              <th>Tanggal mulai</th>
              <th>Tanggal selesai</th>
              <th>Total Waktu</th>
            </thead>
            <tbody>
            @foreach ($car_usages as $usage)
              <tr>
                <td class="text-center">
                  <a href="{{ route('car-usage-history-show', $usage->usage_id) }}">{{ $no++ }}</a>
                </td>
                <td>{{ $usage->employee_name }}</td>
                <td>{{ $usage->driver }}</td>
                <td>{{ $usage->car }}</td>
                <td>{{ $usage->destination }}</td>
                <td>{{ $usage->start_use }}</td>
                <td>{{ $usage->end_use }}</td>
                <td>{{ $usage->usage_time }}</td>
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
            <b>Rekap penggunaan kendaraan</b>
          </h5>
          <div class="card-body">
            Saat ini belum ada catatan untuk rekap penggunaan kendaraan.
          </div>
        </div>
      @endif
      <!-- <a href="{{ route('car-usage.index') }}" class="btn"> -->
      <a href="{{ route('car-usage.index') }}" class="btn">
        <i class="el-icon-arrow-left"></i> Kembali
      </a>
    </div>
  </div>
</div>
@endsection
