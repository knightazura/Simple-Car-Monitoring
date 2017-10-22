@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-10">
      <div class="card">
        <h4 class="card-header">Form Daftar Mobil</h4>
        <div class="card-body">
          <car-form
            meta="{{ $data['meta'] }}"
            entity_id="{{ $data['entity_id'] }}"></car-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
