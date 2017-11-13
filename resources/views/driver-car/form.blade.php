@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-10">
      <div class="card">
        <h5 class="card-header">
          <b>Form Pengaturan Sopir & Mobil</b>
        </h5>
        <div class="card-body">
          <driver-car-form
            meta="{{ $data['meta'] }}"
            entity_id="{{ $data['entity_id'] }}"></driver-car-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
