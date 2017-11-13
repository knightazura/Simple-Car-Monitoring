<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ManageUsersController extends Controller
{
  public function index()
  {
    $users = User::all();
    return view('manage-users.index', compact('users'));
  }

  public function edit($id)
  {
    return $this->show($id);
  }

  public function show($id)
  {
    $user = User::findOrFail($id);
    return view('manage-users.show', compact('user'));
  }

  public function apiShow($id)
  {
    $user = User::with('roles')->findOrFail($id);
    // $user = User::findOrFail($id);
    return response()
      ->json([
        'model' => $user
      ]);
  }

  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $user->fill([
      'name' => $request->name,
      'username' => $request->username,
      'email' => $request->email,
      'password' => bcrypt($request->password)
    ]);

    if ($user->save()) {
      return response()
        ->json([
          'message' => 'Akun berhasil di-update',
          'redirect_url' => '/manage-users'
        ]);
    }
  }

  public function destroy($id)
  {
    // Init
    $user = User::findOrFail($id);
    $data = array(
      'message' => "Akun {$user->name} telah berhasil dihapus!",
      'redirect_url' => "/manage-users"
    );

    // Destroy entity (and its relationships)
    if ($user->delete()) {
      return response()
        ->json([
            'data' => $data
        ]);
    }
  }
}
