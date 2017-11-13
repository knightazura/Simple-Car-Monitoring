@extends('layouts.app')
@php $no = 1; @endphp
@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-8">
      @if($driver_car->isNotEmpty())
        <div class="card">
          <div class="card-header">
            <span style="font-size: 14pt"><b>Daftar Sopir & Mobil</b></span>
            <!-- <a href="{{ route('driver-car.create') }}" class="btn btn-sm btn-primary float-right">Atur</a> -->
          </div>
          <div class="card-body">
            <p class="card-text">Daftar sopir & mobil yang terdaftar pada aplikasi Monitoring.</p>
          </div>
          <table class="table table-hover table-responsive">
            <thead class="thead-inverse">
              <tr>
                <th class="text-center">#</th>
                <th>Nama Sopir</th>
                <th>Mobil</th>
                <th>Perusahaan</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($driver_car as $dc)
                <tr>
                  <th scope="head" class="text-center align-middle">{{ $no++ }}</td>
                  <td class="align-middle">{{ $dc->car_plat_number }} - {{ $dc->withCar->car_name }}</td>
                  @if (!is_null($dc->withDriver))
                    <td class="align-middle"><b>{{ $dc->withDriver->driver_name }}</b></td>
                    <td class="align-middle">{{ $dc->withDriver->company }}</td>
                  @else
                    <td class="align-middle"><b> - </b></td>
                    <td class="align-middle"> - </td>
                  @endif
                  <td class="text-center align-middle">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="el-icon-more" aria-hidden="true"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          @if ($dc->withCar->hasStatus->status == 1)
                            @if(!is_null($dc->withDriver))
                              @if ($dc->withDriver->status > 0)
                                <a class="dropdown-item disabled" href="#">Edit</a>
                              @endif
                            @endif
                          @else
                            <a class="dropdown-item" href="{{ route('driver-car.edit', $dc->car_plat_number) }}">Edit</a>
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
            <span style="font-size: 14pt"><b>Daftar Sopir & Mobil</b></span>
            <a href="{{ route('driver-car.create') }}" class="btn btn-sm btn-dark float-right">Atur</a>
          </div>
          <div class="card-body">
            Oops! Ada kesalahan. Belum ada pengaturan untuk Data Sopir & Mobil, silahkan buat terlebih dahulu.
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
              <b>Catatan: </b><br>
                <ul>
                  <li>Data akan otomatis terhapus jika data mobilnya dihapus</li>
                  <li>Sopir & mobilnya yang sedang melakukan tugas, untuk sementara tidak bisa diubah.</li>
                </ul>
            </small>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
