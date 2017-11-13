@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <user-form entity_id="{{ $user->id }}" role_id="{{ $user->roles[0]->id }}"></user-form>
    </div>
  </div>
</div>
@endsection
