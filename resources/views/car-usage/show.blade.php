@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-8">

      <!-- Card -->
      <div class="card">
        <h4 class="card-header">
          <b># {{ $usage->id }} - Tujuan: {{ $usage->destination }}</b>
        </h4>
        <div class="card-body">
          @include('car-usage.detail', ['usage' => $usage])
        </div>
        <div class="card-footer">
          <!-- Button data controls -->
          <div class="float-left">
            <div class="btn-group" aria-label="Positive Group">
              <a href="{{ route('car-usage.edit', $usage->id) }}" class="btn btn-sm btn-primary">Edit</a>
              <button type="button" class="btn btn-sm btn-success"
                data-toggle="modal"
                data-target="#finishedForm">
                  Pemakaian Selesai
              </button>
            </div>
            <div class="btn-group" aria-label="Danger Group">
              <a class="btn btn-sm btn-danger text-white delete-button"
                data-id="/car-usage/{{ $usage->id }}"
                data-token="{{ csrf_token() }}">
                  Hapus
              </a>
            </div>
          </div>

          <!-- Output buttons -->
          <div class="float-right">
            <a class="btn btn-sm btn-success" href="{{ route('stream-second-doc', $usage->id) }}">
              <i class="fa fa-print" aria-hidden="true"></i> Surat Jalan
            </a>
          </div>
        </div>
      </div>

      <a href="{{ route('car-usage.index') }}" class="btn my-3">
        <i class="el-icon-arrow-left"></i> Kembali
      </a>

    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="finishedForm" aria-hidden="true" id="finishedForm">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <finished-form entity="{{ $usage->id }}"></finished-form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
