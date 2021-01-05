<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UsuariosController extends Controller
{
    public function index() {
        $users = User::all();
        return view('admin.usuarios.index', compact('users'));
    }

    public function edit($user_id) {
        $user = User::find($user_id);
        return view('admin.usuarios.edit', compact('user'));
    }

    public function update($user_id, Request $request) {
        $user = User::find($user_id);
        $user->fill([
            'user_type' => $request->user_type
        ]);
        $user->save();

        return redirect()->route('users.edit', [$user]);
    }
}
