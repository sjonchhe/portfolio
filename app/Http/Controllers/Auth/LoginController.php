<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use App\Role;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/dashboard';

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
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        //dd($socialUser);
        //add user to the database

/*return $socialUser->email;*/
    $user=User::where('email',$socialUser->getEmail())->first();
    if(!$user)
    {
        
    $user= User::create([
            'email' => $socialUser->getEmail(),
            'name' => $socialUser->getName(),
            'provider_id' => $socialUser->getId(),
            'provider' => $provider,

        ]);

    //Adding default role
    $user->attachRole(Role::where('name','administrator')->first());
   
    }
        //login the user
        Auth::login($user,true);

        return redirect($this->redirectTo);

        // $user->token;
    }
}
