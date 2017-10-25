@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 15%">

    <!-- Main Menu -->
    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-8 col-xl-7">
            <div class="row">
                <div class="col text-center">
                    <a href="{{ route('car-usage.index') }}" class="btn btn-outline-primary">
                        <i class="fa fa-tasks fa-5x p-4" aria-hidden="true"></i>
                    </a>
                    <div class="row">
                        <div class="col text-center">Pemakaian</div>
                    </div>
                </div>
                <div class="col text-center">
                    <a href="{{ route('car.index') }}" class="btn btn-outline-primary">
                        <i class="fa fa-car fa-5x p-4" aria-hidden="true"></i>
                    </a>
                    <div class="row">
                        <div class="col text-center">Mobil</div>
                    </div>
                </div>
                <div class="col text-center">
                    <a href="{{ route('employee.index') }}" class="btn btn-outline-primary">
                        <i class="fa fa-group fa-5x p-4" aria-hidden="true"></i>
                    </a>
                    <div class="row">
                        <div class="col text-center">Pegawai</div>
                    </div>
                </div>
                <div class="col text-center">
                    <a href="{{ route('driver.index') }}" class="btn btn-outline-primary">
                        <i class="fa fa-drivers-license fa-5x p-4" aria-hidden="true"></i>
                    </a>
                    <div class="row">
                        <div class="col text-center">Sopir</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Highlight items -->
    @include('dashboard.highlight-items', ['highlights_data' => $highlights_data])
</div>
@endsection
