@extends('layouts.app')

@section('content')
<div class="row justify-content-md-center my-4">
    <div class="col-md-8">
        @include('main.request-form', ['meta' => $meta, 'entity_id' => $id])
    </div>
</div>
@endsection
