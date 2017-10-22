<?php $no = 1; ?>
@extends('layouts.app')

@section('content')

<div class="container-fluid">

  <div class="row justify-content-md-center">
    <div class="col-md-8">
      @if ($cars->isNotEmpty())
        <div class="card">
          <div class="card-header">
            <span style="font-size: 14pt"><b>Daftar Mobil</b></span>
            <a href="{{ route('car.create') }}" class="btn btn-sm btn-primary float-right">Buat</a>
          </div>
          <div class="card-body">
            <p class="card-text">Berikut daftar mobil dan status ketersediaannya.</p>
            <table class="table table-hover table-responsive">
              <thead class="thead-inverse">
                <tr>
                  <th>#</th>
                  <th class="w-25">Nomor Plat</th>
                  <th>Jenis Mobil</th>
                  <th class="w-25">Status</th>
                  <th class="w-10">&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cars as $car)
                  <tr>
                    <th scope="row">{{ $no++ }}</th>
                    <td class="align-middle">{{ $car->plat_number }}</td>
                    <td class="align-middle">{{ $car->car_name }}</td>
                    <td class="align-middle">{{ $car_status[$car->hasStatus->status] }}</td>
                    <td class="text-center align-middle">
                      <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="el-icon-more" aria-hidden="true"></i>
                        </button>
                        @if ($car->hasStatus->status == 1)
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item disabled" href="#">Edit</a>
                            <a class="dropdown-item disabled" href="#">Hapus</a>
                          </div>
                        @else
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('car.edit', $car->plat_number) }}">Edit</a>
                            <a class="dropdown-item text-danger delete-button"
                              data-id="/car/{{ $car->plat_number }}"
                              data-token="{{ csrf_token() }}">
                                Hapus
                            </a>
                          </div>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            @include('layouts.cf-navigation', ['collection' => $cars, 'entity_name' => 'mobil'])
          </div>
        </div>

        <div class="alert alert-warning my-3 w-50 float-right" role="alert">
          <small>
            <b>Catatan: </b> Kendaraan yang sedang digunakan untuk sementara tidak bisa dihapus.
          </small>
        </div>
      @else
        <div class="card text-white bg-warning">
          <div class="card-header">
            <span style="font-size: 14pt"><b>Daftar Kendaraan (Mobil)</b></span>
            <a href="{{ route('car.create') }}" class="btn btn-sm btn-dark float-right">Daftar</a>
          </div>
          <div class="card-body">
            Belum ada data kendaraan untuk saat ini, silahkan tambah terlebih dahulu.
          </div>
        </div>
      @endif
    </div>
  </div>
</div>

@endsection
