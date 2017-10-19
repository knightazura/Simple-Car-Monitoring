<?php $no = 1; ?>

@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <span style="font-size: 14pt"><b>Daftar Driver (Sopir)</b></span>
          <a href="{{ route('driver.create') }}" class="btn btn-sm btn-primary float-right">Daftar</a>
        </div>
        <div class="card-body">
          <p class="card-text">Berikut daftar driver (Sopir) yang terdaftar pada aplikasi Monitoring.</p>
          <table class="table table-hover table-responsive">
            <thead class="thead-inverse">
              <tr>
                <th>#</th>
                <th>Nama Lengkap</th>
                <th class="w-20">Perusahaan</th>
                <th class="w-10">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($drivers as $driv)
                <tr>
                  <th scope="row" class="align-middle">{{ $no++ }}</td>
                  <td class="align-middle">{{ $driv->driver_name }}</td>
                  <td class="align-middle">{{ $driv->company }}</td>
                  <td class="text-center">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        *
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('driver.edit', $driv->id) }}">Edit</a>
                        <a class="dropdown-item text-danger delete-button"
                          data-id="/driver/{{ $driv->id }}"
                          data-token="{{ csrf_token() }}">
                            Hapus
                        </a>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          @include('layouts.cf-navigation', ['collection' => $drivers, 'entity_name' => 'driver (sopir)'])
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
