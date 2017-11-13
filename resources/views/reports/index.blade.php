@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-6">
      <div class="card">
        <div class="card-body">
          <h3 class="text-center">Download Laporan</h3>
          <form action="{{ route('excel-first-report') }}" method="POST">
            {{ csrf_field() }}

            <!-- Month range -->
            <div class="form-group">
              <label for="report_period">Periode Laporan</label>
              <select class="form-control" name="report_period">
                <option value="1">1 Bulan</option>
                <option value="3">3 Bulan</option>
                <option value="6">6 Bulan</option>
                <option value="12">1 Tahun</option>
              </select>
            </div>

            <!-- Start Month -->
            <div class="form-group">
              <label for="start_month">Bulan 
                <a href="" data-toggle="modal" data-target="#info-1">
                  <small><i class="el-icon-information"></i></small>
                </a>
              </label>
              <select class="form-control" name="start_month" id="start_month">
                @foreach($months as $key => $label)
                  <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
              <!-- Modal Info-1 -->
              <div class="modal fade" id="info-1" tabindex="-1" role="dialog" aria-labelledby="First information" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-body">
                      <h3 class="text-center">Informasi</h3>
                      <div class="alert alert-info mt-3" role="alert">Bulan yang dipilih adalah bulan awal mulainya laporan.<br>
                      Contoh, periode 3 bulan. Lalu bulan yang dipilih Maret,
                      maka laporan akan mencari data selama 3 bulan (Maret, April, Mei).</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <hr>
            <div class="form-group">
              <label for="filter_by">Parameter waktu pemakaian
                <!-- <a href="" data-toggle="modal" data-target="#info-2">
                  <small><i class="el-icon-information"></i></small>
                </a> -->
              </label>
              <select name="filter_by" id="filter_by" class="form-control">
                <option value="start_use">Waktu Keberangkatan</option>
                <option value="end_use">Waktu Kembali</option>
                <option value="dual" selected>Gabungan</option>
              </select>
              <!-- Modal Info-2 
              <div class="modal fade" id="info-2" tabindex="-1" role="dialog" aria-labelledby="Second information" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-body">
                      <h3 class="text-center">Informasi</h3>
                      <div class="alert alert-info mt-3" role="alert">
                        Fungsi ini adalah parameter "waktu" pemakaian kendaraan untuk pengambilan data pada laporan.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              -->
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Download</button>
          </form>
        </div>
      </div>      
    </div>
  </div>
</div>

@endsection
