<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Exceptions\AppException;
use Illuminate\Support\Facades\Auth;
use App\User;



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

    public function connexion(Request $request , User $user) {
        try {
            
            $validation = $request->validate([
                'email' =>  'required|email',
                'password'  =>  'required|string'
            ],[
                'required'  =>  'Le champs `:attribute` requis !',
                'email' =>  'Le champs `:attribute` doit etre une adresse email valide !',
                'string'    =>  'Le champs `:attribute` doit etre une chaine de caractere'
            ]);

            $credentials = $request->only('email','password');
            // $user->email = $request->input('email');
            // $user->password = $request->input('password');
            
            if(Auth::attempt($credentials)) {
                // connecte
                return response()
                    ->json('done');
            }
            else {
                // erreur tentative de connexion
                throw new AppException("Email ou Mot de passe invalide !");
            }
        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }
}
