<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        return view('users.home-users')
            ->withCat('null');
    }

    public function addUsers(Request $request , User $user) {
        try {

            $validation = $request->validate([
                'email' =>  'required|email',
                'name'  =>   'required|string',
                'phone' =>  'required|string|max:9|min:9',
                'typeUser'  =>  'required|string'
            ],[
                'required'  =>  '`:attribute` requis!'
            ]);

            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->name =  $request->input('name');
            $user->role = $request->input('typeUser');
            $user->state = true;
            $user->password = bcrypt('bonjour');
            
            $user->save();

            return response()
                ->json('done');
        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }
}
