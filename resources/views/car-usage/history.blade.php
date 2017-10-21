<?php $no = 1; ?>
@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-10">
      <div class="card border-info my-4">
        <h4 class="card-header text-white bg-info">
          Rekap Penggunaan Kendaraan 
        </h4>
        <div class="card-body">
          <p class="card-text">
            Berikut rekap seluruh data untuk penggunaan kendaraan yang dilakukan.
          </p>
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
                <td>{{ $usage->employee }}</td>
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
        </div>
        <div class="card-footer">
          @include('layouts.cf-navigation', [
            'collection' => $car_usages,
            'entity_name' => 'data penggunaan kendaraan'
          ])
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
