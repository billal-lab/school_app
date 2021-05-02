<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Planning;
use App\Models\User;
use Illuminate\Http\Request;

class PlanningController extends Controller
{

    public function index(Request $request){

        $user = User::find($request['userId']);

        if(!$user){
            return redirect()->route('home');
        }
        
        $plannings = Planning::planning_perso($user->type , $user->id);

        return View('planning.index',compact('plannings'));

    }

    public function create_show(Request $request){

        $cours = Cour::where('user_id', $request['userId'])->get();

        return View('planning.create',compact('cours'));

    }

    public function create(Request $request){
        
        $data = $request->validate([
            'cours_id'=>['required'],
            'date_debut'=> ['required','date' ,'after:yesterday'],
            'date_fin'=> ['required','date'],
        ]);

        array_merge($request->validate([
            'date_fin'=> ['after:'.$data['date_debut']],
        ]), $data);

        Planning::create($data);

        return redirect()->route('home');

    }

}
