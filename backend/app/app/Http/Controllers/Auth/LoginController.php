<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    // public function login (Request $request) {
    //     $user = User::where($request->only('name'));
    //     if ($user->exists()) {
    //         return response()->json(['status' => true, 'user' => Auth::loginUsingId($user->first()->id, true)], 200);
    //     } else {
    //         return response()->json(['status' => false], 400);
    //     }
    // }

    public function redirectToProvider() {
        $url = Socialite::driver('line')->redirect()->getTargetUrl();
        return response()->json(['status' => true, 'url' => $url], 200);
    }

    public function handleProviderCallback(Request $request) {
        $line_user = Socialite::driver('line')->user();

        $user = User::firstOrCreate(
            ['line_user_id' => $line_user->id],
            ['name' => $line_user->name]
        );

        Auth::login($user, true);


        return redirect('/');
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
