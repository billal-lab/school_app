<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\CoursUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CourUserController extends Controller
{
    public function index(Request $request){

        $mots = null;

        if($request->get("mots")){
            $mots = $request->get("mots");
        }

        $cours = Auth::user()->formation->cours($mots);

        return View('cours_user.index', compact('cours'));
    }

    public function register(Request $request){
        CoursUser::create([
            'user_id' => Auth::user()->id,
            'cours_id' => $request->get('courId')
        ]);
        return redirect()->route('cours_users_index');
    }

    
    public function unregister(Request $request){


        $cour_user = CoursUser::where('cours_id',$request->get('courId'))->where('user_id',Auth::user()->id);

        $cour_user->delete();

        return redirect()->route('cours_users_index');

    }

    public function index_registred()
    {
        $cours_user = CoursUser::where('user_id', Auth::user()->id)->get();

        $cours = [];

        foreach ($cours_user as $cour_user) {
            $cours [] = $cour_user->cour;
        }

        return View('cours_user.index_registred', compact('cours'));
    }


    public function index_responsable_cours()
    {
        
        $cours = Auth::user()->cours_enseigant;
            
        return View('cours_user.index_registred', compact('cours'));

    }
}
