@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-8">
      <div class="card">
        <h4 class="card-header">
          <b># {{ $usage->id }} - Tujuan: {{ $usage->destination }}</b>
        </h4>
        <div class="card-body">
          @include('car-usage.detail', ['usage' => $usage])

          <!-- Button data controls -->
          <div class="float-right">
            <div class="btn-group" aria-label="Positive Group">
              <a href="{{ route('car-usage.edit', $usage->id) }}" class="btn btn-sm btn-primary">Edit</a>
              <a href="#finishedForm" class="btn btn-sm btn-success"
                data-toggle="collapse"
                aria-expanded="false"
                aria-controls="multiCollapseExample1">
                  Pemakaian Selesai
              </a>
            </div>
            <div class="btn-group" aria-label="Danger Group">
              <a href="" class="btn btn-sm btn-danger">Hapus</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-md-center my-4">
    <div class="col-sm-12 col-md-8" id="finishedForm">
      <finished-form entity="{{ $usage->id }}"></finished-form>
    </div>
  </div>
</div>
@endsection
