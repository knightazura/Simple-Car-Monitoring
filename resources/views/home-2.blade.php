@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 5%">

    <!-- Highlight items -->
    @include('dashboard.highlight-items', ['highlights_data' => $highlights_data])

    <!-- Main Menu -->
    <div class="row justify-content-md-center mt-5">
        <div class="col-sm-12 col-md-8">
            <div class="row">
                <div class="col">
                    <div class="card-deck">
                        <div class="card text-center py-2">
                            <a href="{{ route('car-usage.index') }}" class="btn mx-2">
                                <i class="fa fa-tasks fa-4x" aria-hidden="true"></i>
                            </a>
                            PENGAJUAN PEMAKAIAN
                        </div>
                        <div class="card text-center py-2">
                            <a href="{{ route('car-usage-history-index') }}" class="btn mx-2">
                                <i class="fa fa-history fa-4x" aria-hidden="true"></i>
                            </a>
                            HISTORY PEMAKAIAN
                        </div>
                        @if (Auth::user()->inRole('administrator'))
                        <div class="card text-center py-2">
                            <a href="{{ route('report-home') }}" class="btn mx-2">
                                <i class="fa fa-file fa-4x" aria-hidden="true"></i>
                            </a>
                            PELAPORAN PEMAKAIAN
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
