<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * login form
     */
    public function index(){

        return view('auth/login');

    }

    /**
     * login submit
     */
    public function login(Request $request){

        $user = User::where('login', $request->get('login'))->first();

        if($user==null){
            session()->flash('error', "Invalid credentials");
            return redirect()->route('login_index');
        }

        if(!in_array($user->type,['admin', 'enseignant', 'etudiant'])){
            session()->flash('error', "Votre compte nécessite l'approbation d'un admin");
            return redirect()->route('login_index');
        }

        if(!password_verify($request->get('mdp'),$user->mdp)){
            session()->flash('error', "Invalid credentials");
            return redirect()->route('login_index');
        }

        Auth::login($user);

        session()->flash('success', "Bienvenu a votre dashbord.");

        return redirect()->route('home');
    }

    public function logout(Request $request){
       
        if(Auth::user()!=null){
            Auth::logout();
        }
        return redirect()->route('login_index');
    }
}
