@extends('layouts.app')

<?php
  // Init
  if ($meta == 'Create') {
    $storeURL      = ["/car", "POST"];
    $car_name      = '';
    $plat_number   = '';
    $full_disabled = '';
  }
  else if ($meta == 'Edit') {
    $full_disabled = ($car->hasStatus->status == 1) ? "disabled" : "";
    $storeURL      = ["/car/{$car->plat_number}", "PUT"];
    $car_name      = $car->car_name;
    $plat_number   = $car->plat_number;
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
            <div class="form-group">
              @foreach ($car_status as $key => $label)
                @php
                  $class_disabled = ($key == 1) ? "disabled" : "";
                  if ($meta == 'Edit') {
                    $checked = ($car->hasStatus->status == $key) ? "checked" : "";
                  } else {
                    $checked = ($key == 0) ? "checked" : "";
                  }
                @endphp
                <div class="form-check form-check-inline {{ $class_disabled }} {{ $full_disabled }}">
                  <label class="form-check-label">
                    <input type="radio"
                      class="form-check-input"
                      name="car_status"
                      id="inlineRadio{{ $key }}"
                      value="{{ $key }}"
                      {{ $checked }} {{ $class_disabled }} {{ $full_disabled }}> {{ $label }}
                  </label>
                </div>
              @endforeach
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
