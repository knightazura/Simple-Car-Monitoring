@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 5%">

    <!-- Highlight items -->
    @include('dashboard.highlight-items', ['highlights_data' => $highlights_data])

    <!-- Main Menu -->
    <div class="row justify-content-md-center mt-5">
        <div class="col-sm-12 col-md-8 col-xl-7">
            <div class="row">
                <!-- Request button -->
                <div class="col text-right">
                    <a href="{{ route('car-usage.index') }}" class="btn btn-outline-primary">
                        <i class="fa fa-tasks fa-5x p-4" aria-hidden="true"></i>
                    </a>
                    <div class="row">
                        <div class="col text-right">Pengajuan Pemakaian</div>
                    </div>
                </div>
                <!-- History button -->
                <div class="col text-left">
                    <a href="{{ route('car-usage-history-index') }}" class="btn btn-outline-primary">
                        <i class="fa fa-history fa-5x p-4" aria-hidden="true"></i>
                    </a>
                    <div class="row">
                        <div class="col text-left">History Pemakaian</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
