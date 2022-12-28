<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * 外部サービスの認証ページへリダイレクトする。
     */
    public function redirectToProvider() {
        // dd(Socialite::driver('line'));
        return Socialite::driver('line')->redirect();
    }

    /**
     * 外部サービスからユーザー情報を取得し、ログインする。
     */
    public function handleProviderCallback(Request $request) {
        // dd($request->all());
        // $url = 'https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1657775756&redirect_uri=https://1fcc-126-51-90-37.ngrok.io/login/line/callback&state='.$request->state.'&scope=profile%20openid';
        // $response = Http::post($url);
        // dd($response);
        dd(Socialite::driver('line')->user());
        $line_user = Socialite::driver('line')->stateless();

        $user = User::firstOrCreate(
            ['line_user_id' => $line_user->id],
            ['name' => $line_user->name]
        );

        $this->guard()->login($user, true);
        return $this->sendLoginResponse($request);
    }

    // public function handleProviderCallback($provider)
    // {
    //     $provided_user = Socialite::driver('line')->stateless()->user();

    //     $user = User::where('provider', $provider)
    //         ->where('provided_user_id', $provided_user->id)
    //         ->first();

    //     if ($user === null) {
    //         $user = User::create([
    //             'name'               => $provided_user->name,
    //             'provider'           => $provider,
    //             'provided_user_id'   => $provided_user->id,
    //         ]);
    //     }

    //     Auth::login($user);
    // }
}
