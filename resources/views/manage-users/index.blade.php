@extends('layouts.app')
<?php $no = 1; ?>
@section('content')
  <div class="container-fluid">
    <div class="row justify-content-md-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <span style="font-size: 14pt"><b>User Account</b></span>
            <a href="{{ route('register') }}" class="btn btn-sm btn-primary float-right">Tambah</a>
            <a href="{{ route('manage-users.show', Auth::user()->id) }}" class="btn btn-sm btn-dark float-right mr-2">Akunku</a>
          </div>
          <div class="card-body">
            Daftar akun pengguna yang terdaftar pada aplikasi.
          </div>
          <table class="table">
            <thead>
              <th>#</th>
              <th>Nama Lengkap</th>
              <th>Username</th>
              <th>Alamat e-mail</th>
              <th>Role</th>
              <th>&nbsp;</th>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->username }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->roles[0]->name }}</td>
                  <td>
                    <a href="{{ route('manage-users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                    @if ($user->id != Auth::user()->id)
                      <a href="#" class="btn btn-sm btn-danger delete-button"
                        data-id="/manage-users/{{ $user->id }}"
                        data-token="{{ csrf_token() }}">
                          <i class="el-icon-delete"></i>
                      </a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
