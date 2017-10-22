@extends('layouts.app')

<?php
  if ($meta == 'Create') {
    $storeURL       = ["/employee", "POST"];
    $employee_name  = '';
    $nip            = '';
    $employee_pos   = '';
    $division       = '';
  }
  else if ($meta == 'Edit') {
    $storeURL       = ["/employee/{$employee->nip}", "PUT"];
    $nip            = $employee->nip;
    $employee_name  = $employee->employee_name;
    $employee_pos   = $employee->employee_position;
    $division       = $employee->division;
  }
?>

@section('content')
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-md-10">
      <div class="card">
        <h4 class="card-header">Form Registrasi Pegawai</h4>
        <div class="card-body">
          <form class="default-form" method="POST" action="{{ $storeURL[0] }}">
            
            {{ method_field($storeURL[1]) }}
            {{ csrf_field() }}

            <div class="form-group">
              <label for="nip">Nomor Induk Pegawai</label>
              <input type="text" name="nip" class="form-control" id="nip" placeholder="Contoh: 123456789" value="{{ $nip }}">
            </div>
            <div class="form-group">
              <label for="employeeName">Nama Pegawai</label>
              <input type="text" name="employee_name" class="form-control" id="employeeName" aria-describedby="employeeName" placeholder="Contoh: Saiko Mizuki" value="{{ $employee_name }}">
            </div>
            <div class="form-group">
              <label for="employeePosition">Posisi</label>
              <input type="text" name="employee_position" class="form-control" id="employeePosition" aria-describedby="employeePosition" placeholder="Contoh: Ketua" value="{{ $employee_pos }}">
            </div>
            <div class="form-group">
              <label for="division">Divisi</label>
              <input type="text" name="division" class="form-control" id="division" aria-describedby="division" placeholder="Contoh: General Affairs" value="{{ $division }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('employee.index') }}" class="btn btn-default">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
