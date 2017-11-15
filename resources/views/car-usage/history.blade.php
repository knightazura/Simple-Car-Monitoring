<?php $no = 1; ?>
@extends('layouts.app')

@push('dt-css')
  <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid" id="history-usage">
  <div class="row justify-content-md-center">
    <div class="col-sm-12">
      @if ($car_usages->isNotEmpty())
        <div class="card border-info my-4 pb-3">
          <div class="card-header text-white bg-info">
            <span style="font-size: 14pt"><b>Rekap Penggunaan Kendaraan </b></span>
            <a href="#filter-search" data-toggle="collapse" aria-expanded="false" aria-controls="filter-search" class="btn btn-sm btn-dark float-right">Filter</a>
            @if($mode == 'filter')
              <a href="{{ route('car-usage-history-index') }}" class="btn btn-sm btn-light mx-3 float-right">Hapus Filter</a>
            @endif
          </div>

            <!-- Form Filter -->
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <div class="collapse p-3" id="filter-search">
                  <form class="form-inline" action="{{ route('history-filter') }}" method="POST">
                    {{ csrf_field() }}
                    <label for="from">Pilih range tanggal : </label>
                    <input type="text" name="from" id="dtp" class="form-control mx-3 w-50">
                    <button type="submit" class="btn btn-sm btn-success">Cari</button>
                  </form>
                </div>
            </div>
            
          </div>
          <div class="card-body">
            <p class="card-text">
            Berikut rekap seluruh data untuk penggunaan kendaraan yang dilakukan.
            </p>
          </div>
          <table class="table table-hover table-striped table-responsive"
            cellspacing="0"
            width="100%" 
            id="dt-history-usage"
            style="font-size: 11pt">
            <thead>
              <th class="text-center">#</th>
              <th>Pegawai</th>
              <th>Sopir</th>
              <th>Kendaraan</th>
              <th>Tempat Tujuan</th>
              <th>Waktu berangkat</th>
              <th>Waktu kembali</th>
              <th>Total Waktu</th>
            </thead>
            <tbody>
            @foreach ($car_usages as $usage)
              <tr>
                <td class="text-center align-middle">
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-primary" id="dropdownMenuButton"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{ route('car-usage-history-show', $usage->usage_id) }}">Lihat</a>
                      @if (Auth::user()->inRole('administrator'))
                        <a class="dropdown-item text-danger delete-button"
                          data-id="{{ route('history-delete', $usage->usage_id) }}"
                          data-token="{{ csrf_token() }}">
                            Hapus
                        </a>
                      @endif
                    </div>
                  </div>
                </td>
                <td class="align-middle">{{ $usage->employee_name }}</td>
                <td class="align-middle">{{ $usage->driver }}</td>
                <td class="align-middle">{{ $usage->car }}</td>
                <td class="align-middle">{{ $usage->destination }}</td>
                <td class="align-middle">{{ date('F d, Y H:i', strtotime($usage->start_use)) }}</td>
                <td class="align-middle">{{ date('F d, Y H:i', strtotime($usage->end_use)) }}</td>
                <td class="align-middle">{{ $usage->usage_time }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
          <!-- <div class="card-footer mt-2">
            <p class="card-text">Total rekap data penggunaan kendaraan: {{ $car_usages->count() }}</p>
          </div> -->
        </div>
      @else
        <div class="card text-white bg-warning my-4">
          <div class="card-header">
            <span style="font-size: 14pt"><b>Rekap Penggunaan Kendaraan </b></span>
            <a href="#filter-search" data-toggle="collapse" aria-expanded="false" aria-controls="filter-search" class="btn btn-sm btn-dark float-right">Filter</a>
            <a href="{{ route('car-usage-history-index') }}" class="btn btn-sm btn-light mx-3 float-right">Hapus Filter</a>
          </div>
          <div class="card-body">
            @if($mode == 'filter')
              <b>Filter: </b>Tidak ada penggunaan kendaraan pada range tanggal {{ date('F d, Y', strtotime($from)) }} sampai {{ date('F d, Y', strtotime($to)) }}.
            @else
              Saat ini belum ada catatan untuk rekap penggunaan kendaraan.
            @endif
          </div>
        </div>
      @endif

      <div class="row my-3">
        <div class="col-sm-12 col-md-6">
          <a href="{{ route('home') }}" class="btn">
            <i class="el-icon-arrow-left"></i> Kembali
          </a>
        </div>
        @if($mode == 'filter')
          <div class="col-sm-12 col-md-6 float-right">
            <div class="alert alert-warning" role="alert">
              <small>
                <b>Filter: </b> Mulai sejak tanggal keberangkatan {{ date('F d, Y', strtotime($from)) }} dan penggunaan kendaraan selesai pada tanggal {{ date('F d, Y', strtotime($to)) }}
              </small>
            </div>
          </div>
        @endif
      </div>
    
    </div>
  </div>

</div>
@endsection

@push('dt')
  <script src="{{ asset('js/datatables.min.js') }}"></script>
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset('js/daterangepicker.js') }}"></script>
  <script src="{{ asset('js/dt-init.js') }}"></script>
@endpush
