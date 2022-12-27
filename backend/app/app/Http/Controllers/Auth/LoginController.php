<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login (Request $request) {
        $user = User::where($request->only($request->name));
        if ($user->exists()) {
            return response()->json(['status' => true, 'user' => Auth::loginUsingId($user->first()->id, true)], 200);
        } else {
            return response()->json(['status' => false], 400);
        }
    }

    public function logout () {
        try {
            Auth::logout();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['status' => false]);
        }
    }

    public function check () {
        return Auth::check();
    }
}
