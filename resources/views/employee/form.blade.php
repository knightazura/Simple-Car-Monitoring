@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-10">
      <div class="card">
        <h5 class="card-header">
          <b>Form Registrasi Pegawai</b>
        </h5>
        <div class="card-body">
          <employee-form
            meta="{{ $data['meta'] }}"
            entity_id="{{ $data['entity_id'] }}"></employee-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
