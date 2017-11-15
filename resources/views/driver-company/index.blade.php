@extends('layouts.app')
<?php $no = 1; ?>
@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">

    <div class="col-md-8">
      @if ($dcs->isNotEmpty())
        <div class="card">
          <div class="card-header">
            <span style="font-size: 14pt"><b>Daftar Perusahaan Vendor Driver</b></span>
            <a href="{{ route('driver-company.create') }}" class="btn btn-sm btn-primary float-right">Daftar</a>
          </div>
          <div class="card-body">
            <p class="card-text">Daftar perusahaan vendor driver (Sopir) yang terdaftar pada aplikasi Monitoring.</p>
          </div>
          <table class="table table-hover table-responsive">
            <thead class="thead-inverse">
              <tr>
                <th class="text-center">#</th>
                <th>Nama Perusahaan</th>
                <th>Direktur Perusahaan</th>
                <th>Jumlah Sopir</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($dcs as $dc)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $dc->company_name }}</td>
                  <td>{{ $dc->company_director }}</td>
                  <td>{{ $dc->theDriver->count() }}</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="el-icon-more" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a href="{{ route('driver-company.edit', $dc->id) }}" class="dropdown-item">Edit</a>
                      <a class="dropdown-item text-danger delete-button"
                        data-id="/driver-company/{{ $dc->id }}"
                        data-token="{{ csrf_token() }}">
                          Hapus
                        </a>
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
            <span style="font-size: 14pt"><b>Daftar Perusahaan Vendor Driver</b></span>
            <a href="{{ route('driver-company.create') }}" class="btn btn-sm btn-dark float-right">Daftar</a>
          </div>
          <div class="card-body">
            Belum ada data perusahaan untuk vendor driver, silahkan tambah terlebih dahulu.
          </div>
        </div>
      @endif

      <div class="row my-3">
        <div class="col-sm-12 col-md-6">
          <a href="{{ route('driver.index') }}">
            <i class="el-icon-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
