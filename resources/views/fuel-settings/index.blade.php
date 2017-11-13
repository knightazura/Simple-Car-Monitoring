@extends('layouts.app')
<?php
  $current_year = date('Y');
?>
@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-8">
      <div class="card mb-3">
        <div class="card-header">
          <span style="font-size: 14pt;"><b>Jatah BBM</b></span>
          <select class="w-10 form-control form-sm float-right" id="fuelPreserveYear">
            @if($psv_year->isNotEmpty())
              @foreach($psv_year as $year)
                <option value="{{ route('fuel-custom-index', $year->year) }}"
                  @if($selected_year == $year->year)
                    selected="selected"
                  @endif
                  >{{ $year->year }}</option>
              @endforeach
            @else
              <option value="{{ route('fuel-custom-index', $current_year) }}">{{ $current_year }}</option>
            @endif
          </select>
        </div>
        @if($fuels->isNotEmpty())
          <div class="card-body">
            Daftar jatah bahan bakar tiap bulannya untuk tahun {{ date('Y') }}.
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>Bulan</th>
                <th>Jumlah BBM</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($fuels as $fd)
              <tr>
                <td>{{ date('F', mktime(0,0,0,$fd->month,10)) }}</td>
                <td>{{ $fd->fuel_ratio }}</td>
                <td class="w-10">
                  <a href="{{ route('fuel.edit', $fd->id) }}" class="btn btn-sm btn-primary">Edit</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="card-body">
            Nothing
          </div>
        @endif
      </div>

      <fuel-form meta="{{ $data['meta'] }}" entity_id="{{ $data['entity_id'] }}"></fuel-form>
    </div>
  </div>
</div>
@endsection
