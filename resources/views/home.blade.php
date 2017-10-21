@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Dashboard -->
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            @include('dashboard.main', [
                'car_usages' => $car_usages,
                'username' => Auth::user()->name
            ])
        </div>
    </div>

    <!-- Highlight items -->
    @include('dashboard.highlight-items', ['highlights_data' => $highlights_data])

    <!-- Request Form -->
    <div class="row justify-content-md-center my-4">
        <div class="col-md-8">
            @include('main.request-form', ['meta' => $meta])
        </div>
    </div>
</div>
@endsection
