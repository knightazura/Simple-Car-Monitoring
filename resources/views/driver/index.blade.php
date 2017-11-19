<?php $no = 1; ?>

@extends('layouts.app')

@push('dt-css')
  <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-md-8">
      @if ($drivers->isNotEmpty())
        <div class="card">
          <div class="card-header">
            <span style="font-size: 14pt"><b>Daftar Sopir (Driver)</b></span>
            <a href="{{ route('driver.create') }}" class="btn btn-sm btn-primary float-right">Daftar</a>
            <a href="{{ route('driver-company.index') }}" class="btn btn-sm btn-warning float-right mr-2">Perusahaan Vendor Driver</a>
          </div>
          <div class="card-body"></div>
          <table class="table table-hover table-responsive"
            cellspacing="0"
            width="100%" 
            id="dt-driver"
            style="font-size: 11pt">
            <thead class="thead-inverse">
              <tr>
                <th class="text-center">#</th>
                <th>Nama Lengkap</th>
                <th>Nomor HP</th>
                <th>Perusahaan</th>
                <th>Status</th>
                <th class="w-10">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($drivers as $driv)
                <tr>
                  <th scope="head" class="text-center align-middle">{{ $no++ }}</td>
                  <td class="align-middle"><b>{{ $driv->driver_name }}</b></td>
                  <td class="align-middle">{{ $driv->phonenumber }}</td>
                  <td class="align-middle">
                    @if (!is_null($driv->workOn))
                      {{ $driv->workOn->company_name }}
                    @else
                      -
                    @endif
                  </td>
                  <td class="align-middle">
                    <span class="badge badge-pill badge-{{ $driver_status[$driv->status]['class'] }} p-2">
                      {{ $driver_status[$driv->status]['status'] }}
                    </span>
                  </td>
                  <td class="text-center align-middle">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="el-icon-more" aria-hidden="true"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if ($driv->status != 1)
                          <a class="dropdown-item" href="{{ route('driver.edit', $driv->id) }}">Edit</a>
                          <a class="dropdown-item text-danger delete-button"
                            data-id="/driver/{{ $driv->id }}"
                            data-token="{{ csrf_token() }}">
                              Hapus
                          </a>
                        @else
                          <a class="dropdown-item disabled" href="#">Edit</a>
                          <a href="#" class="dropdown-item disabled">Hapus</a>
                        @endif
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="card text-white bg-warning">
          <div class="card-header">
            <span style="font-size: 14pt"><b>Daftar Sopir (Driver)</b></span>
            <a href="{{ route('driver.create') }}" class="btn btn-sm btn-dark float-right">Daftar</a>
            <a href="{{ route('driver-company.index') }}" class="btn btn-sm btn-light float-right mr-2">Perusahaan Vendor Driver</a>
          </div>
          <div class="card-body">
            Belum ada data sopir untuk saat ini, silahkan tambah terlebih dahulu.
          </div>
        </div>
      @endif

      <div class="row my-3">
        <div class="col-sm-12 col-md-6">
          <a href="{{ route('home') }}">
            <i class="el-icon-arrow-left"></i> Kembali
          </a>
        </div>
        <div class="col-sm-12 col-md-6 float-right">
          <div class="alert alert-warning" role="alert">
            <small>
              <b>Catatan: </b> Sopir yang sedang melakukan tugas, untuk sementara tidak bisa dihapus.
            </small>
          </div>
        </div>
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
