<?php $no = 1; ?>

@extends('layouts.app')

@push('dt-css')
  <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-md-8">
      @if ($employees->isNotEmpty())
        <div class="card pb-3">
          <div class="card-header">
            <span style="font-size: 14pt"><b>Daftar Pegawai</b></span>
            <a href="{{ route('employee.create') }}" class="btn btn-sm btn-primary float-right">Daftar</a>
          </div>
          <div class="card-body">
            <p class="card-text">Daftar pegawai yang terdaftar pada aplikasi Monitoring.</p>
          </div>
          <table class="table table-hover table-responsive"
            cellspacing="0"
            width="100%" 
            id="dt-employee"
            style="font-size: 11pt"
          >
            <thead class="thead-inverse">
              <tr>
                <th class="text-center">#</th>
                <th class="w-10">NIP</th>
                <th>Nama Lengkap</th>
                <th class="w-20">Posisi / Jabatan</th>
                <th class="w-20">Divisi</th>
                <th class="w-10">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($employees as $emp)
                <tr>
                  <th scope="head" class="text-center align-middle">{{ $no++ }}</td>
                  <td class="align-middle">{{ $emp->nip }}</td>
                  <td class="align-middle">{{ $emp->employee_name }}</td>
                  <td class="align-middle">{{ $emp->employee_position }}</td>
                  <td class="align-middle">{{ $emp->division }}</td>
                  <td class="text-center align-middle">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-primary" type="button" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="el-icon-more" aria-hidden="true"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('employee.edit', $emp->nip) }}">Edit</a>
                        @if (is_null($emp->request))
                          <a class="dropdown-item text-danger delete-button"
                            data-id="/employee/{{ $emp->nip }}"
                            data-token="{{ csrf_token() }}">
                              Hapus
                          </a>
                        @else
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
            <span style="font-size: 14pt"><b>Daftar Pegawai</b></span>
            <a href="{{ route('employee.create') }}" class="btn btn-sm btn-dark float-right">Daftar</a>
          </div>
          <div class="card-body">
            Belum ada data pegawai untuk saat ini, silahkan tambah terlebih dahulu.
          </div>
        </div>
      @endif

      <div class="card text-white bg-info mt-3">
        <div class="card-body">
          <h5>Batch Insert</h5>
          <p class="card-text">
            Upload data pegawai dalam jumlah banyak menggunakan file excel. Gunakan template yang telah disediakan.
          </p>
          <form action="{{ route('employee.batch') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" name="excel"><br>
            <input type="submit" value="Upload" class="mt-3 btn btn-sm btn-light">
            <a href="{{ route('download-ebt') }}" class="mt-3 btn btn-sm btn-light">Download Template</a>
          </form>
        </div>
      </div>
      
      <div class="row my-3">
        <div class="col-sm-12 col-md-6">
          <a href="{{ route('home') }}">
            <i class="el-icon-arrow-left"></i> Kembali
          </a>
        </div>
        <div class="col-sm-12 col-md-6 float-right">
          <div class="alert alert-warning" role="alert">
            <small>
              <b>Catatan: </b> Pegawai yang sedang melakukan perjalanan / pemakaian kendaraan, untuk sementara tidak bisa dihapus.
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
