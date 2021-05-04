<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Planning;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanningController extends Controller
{

    /**
     * afficher le planning en intégral/par enseignant/par semaine d'un enseignant ou d'un etudiant
     */
    public function index(Request $request){

        $user = User::find($request['userId']); 

        $cours = $request['coursId'];

        $date_debut= null;

        if($request['date_debut']){

            $request->validate([
                'date_debut' => ['date']
            ]);

            $date_debut = new DateTime($request['date_debut']);

        }

        if(!$user || ($user->type!="enseignant" && $user->type!="etudiant")){
            return redirect()->route('home');
        }

        $plannings = Planning::planning_perso($user->type , $user->id, $cours, $date_debut);

        $cours = [];

        foreach ($plannings as $planning) {
            if(!in_array([$planning->cours_id=>$planning->intitule], $cours)){
                $cours[$planning->cours_id] = $planning->intitule;
            }
        }

        return View('planning.index',compact('plannings','user', 'cours'));
    }

    /**
     * afficher le formulaire de création d'une nouvelle séance
     */
    public function create_show(Request $request){
        
        $user = User::find($request['userId']);
        
        $cours = Cour::where('user_id', $request['userId'])->get();

        return View('planning.create',compact('cours', 'user'));

    }


    /**
     * persister lee formulaire de création d'une séance
     */
    public function create(Request $request){
        
        $user = User::find($request['userId']);

        $data = $request->validate([
            'cours_id'=>['required'],
            'date_debut'=> ['required','date' ,'after:yesterday'],
            'date_fin'=> ['required','date'],
        ]);
        
        array_merge($request->validate([
            'date_fin'=> ['after:'.$data['date_debut']],
        ]), $data);

        Planning::create($data);

        session()->flash('success', "la séance a été crée");

        return redirect()->route('planning_index',['userId'=>$user->id]);

    }

    /**
     * afficher le formulaire de edition d'une nouvelle séance
     */
    public function edit_show(Request $request){
        
        $user = User::find($request['userId']);

        $planning = Planning::where('id', $request['planningId'])->first();
        
        if(!$planning){
            return redirect()->route('planning_index');
        }

        $cours = Cour::find($planning->cours_id);

        if($cours->enseignant!= $user){
            return redirect()->route('home');
        }

        return View('planning.edit', compact('planning', 'cours','user'));
    }

    /**
     * persister lee formulaire de edition d'une séance
     */
    public function edit(Request $request){

        $user = User::find($request['userId']);

        $data = $request->validate([
            'date_debut'=> ['required','date' ,'after:yesterday'],
            'date_fin'=> ['required','date'],
        ]);

        array_merge($request->validate([
            'date_fin'=> ['after:'.$data['date_debut']],
        ]), $data);
        
        $planning = Planning::where('id', $request['planningId'])->first();

        if(!$planning){
            return redirect()->route('planning_index');
        }

        $planning->date_debut = $data['date_debut'];

        $planning->date_fin = $data['date_fin'];

        $planning->save();

        session()->flash('success', "la séance a été modifié");
        return redirect()->route('planning_index',['userId'=>$user->id]);
    }


    /**
     * supression d'une séance
     */
    public function delete(Request $request){

        $user = User::find($request['userId']);

        Planning::destroy($request['planningId']);

        session()->flash('success', "la séance a été supprimé");
        return redirect()->route('planning_index',['userId'=>$user->id]);
    }
}
