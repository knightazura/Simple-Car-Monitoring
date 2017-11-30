@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      @if (session('status'))
        <div class="row mt-5">
          <div class="col-sm-12">
            <div class="card bg-success text-white">
              <div class="card-body">
                  <p class="card-text">{!! session('status') !!}</p>
              </div>
            </div>
          </div>    
        </div>
      @elseif (session('error'))
        <div class="row mt-5">
          <div class="col-sm-12">
            <div class="card bg-danger text-white">
              <div class="card-body">
                  <p class="card-text">{!! session('error') !!}</p>
              </div>
            </div>
          </div>    
        </div>
      @endif

      <div class="row mt-5">
        <div class="card bg-warning text-white w-100">
          <h5 class="card-header">Backup Database</h5>
          <div class="card-body">
            <p class="card-text">Backup seluruh data pada aplikasi.</p>
            <form method="POST" action="{{ route('misc.snapshot-backup', 'snapshot:create') }}">
              {{ csrf_field() }}
              <input type="hidden" name="command" value="snapshot:create" />
              <button type="submit" class="btn btn-sm btn-dark">Backup</button>
            </form>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="card bg-info text-white w-100">
          <h5 class="card-header">Restore Database</h5>
          <div class="card-body">
            <p class="card-text">Upload file backup untuk memulihkan kembali data - data dari pemakaian aplikasi sebelumnya atau komputer lain.</p>
            <form action="{{ route('misc.snapshot-restore') }}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="file" name="snapshot"><br>
              <input type="submit" value="Upload" class="mt-3 btn btn-sm btn-light">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
