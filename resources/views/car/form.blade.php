@extends('layouts.app')

<?php
  if ($meta == 'Create') {
    $storeURL     = ["/car", "POST"];
    $car_name     = '';
    $plat_number  = '';
  }
  else if ($meta == 'Edit') {
    $storeURL     = ["/car/{$car[0]->plat_number}", "PUT"];
    $car_name     = $car[0]->car_name;
    $plat_number  = $car[0]->plat_number;
  }
?>

@section('content')
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-10">
      <div class="card">
        <h4 class="card-header">Form Daftar Mobil</h4>
        <div class="card-body">
          <form class="default-form" method="POST" action="{{ $storeURL[0] }}">
            
            {{ method_field($storeURL[1]) }}
            {{ csrf_field() }}

            <div class="form-group">
              <label for="carName">Jenis Mobil</label>
              <input type="text" name="car_name" class="form-control" id="carName" aria-describedby="carName" placeholder="Contoh: Innova" value="{{ $car_name }}">
            </div>
            <div class="form-group">
              <label for="platNumber">Nomor Plat Kendaraan</label>
              <input type="text" name="plat_number" class="form-control" id="platNumber" placeholder="Contoh: DD1234AB" value="{{ $plat_number }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('car.index') }}" class="btn btn-default">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
