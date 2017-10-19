@extends('layouts.app')

<?php
  if ($meta == 'Create') {
    $title        = "Registrasi";
    $storeURL     = ["/driver", "POST"];
    $driver_name  = '';
    $company      = '';
  }
  else if ($meta == 'Edit') {
    $title        = "ubah data";
    $storeURL     = ["/driver/{$driver->id}", "PUT"];
    $driver_name  = $driver->driver_name;
    $company      = $driver->company;
  }
?>

@section('content')
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-10">
      <div class="card">
        <h4 class="card-header">Form {{ $title }} Driver</h4>
        <div class="card-body">
          <form class="default-form" method="POST" action="{{ $storeURL[0] }}">
            
            {{ method_field($storeURL[1]) }}
            {{ csrf_field() }}

            <div class="form-group">
              <label for="driverName">Nama Driver</label>
              <input type="text" name="driver_name" class="form-control" id="driverName" aria-describedby="driverName" placeholder="Contoh: Saiko Mizuki" value="{{ $driver_name }}">
            </div>
            <div class="form-group">
              <label for="company">Nama Perusahaan</label>
              <input type="text" name="company" class="form-control" id="company" aria-describedby="company" placeholder="Contoh: PT. IPS" value="{{ $company }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('driver.index') }}" class="btn btn-default">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
