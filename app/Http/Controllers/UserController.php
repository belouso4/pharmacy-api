<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $user = User::all();
        return response()->json(['data'=> $user], 200);
    }

    public function find($id) {
        $user = User::find($id);
        return response()->json($user, 200);
    }

    public function destroy($id) {
        $user = User::find($id);

        $user->delete();
    }
}
