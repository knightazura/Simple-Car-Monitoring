<?php $no = 1; ?>
@extends('layouts.app')

@section('content')

<div class="container-fluid">

  @if (session('status'))
  <div class="row justify-content-md-end">
    <div class="col-md-4">
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ session('status') }}
      </div>
    </div>
  </div>
  @endif

  <div class="row justify-content-md-center">
    <div class="col-md-8">
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
                  <td>{{ $car->plat_number }}</td>
                  <td>{{ $car->car_name }}</td>
                  <td>{{ $car_status[$car->hasStatus->status] }}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('car.edit', $car->plat_number) }}">Edit</a>
                        <a class="dropdown-item text-danger delete-button"
                          data-id="/car/{{ $car->plat_number }}"
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
          @include('layouts.cf-navigation', ['collection' => $cars, 'entity_name' => 'mobil'])
        </div>
      </div>      
    </div>
  </div>
</div>

@push('misc')
  <script src="{{ asset('js/misc.js') }}"></script>
@endpush

@endsection
