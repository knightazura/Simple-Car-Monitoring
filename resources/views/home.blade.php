@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <b>Dashboard</b>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{ route('car_exp') }}">Car Experiment</a>
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
