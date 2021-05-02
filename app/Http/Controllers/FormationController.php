<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Formation;
use App\Models\User;
use Facade\FlareClient\View;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index(){

        $formations = Formation::all();

        return View('formation.index', compact('formations'));

    }

    public function create_show(){

        return View('formation.create');

    }

    public function create(Request $request){

        $data = $request->validate([
            'intitule' => ['required', 'string', 'max:255']
        ]);

        Formation::create([
            'intitule' => $data['intitule']
        ]);
        return redirect('home');
    }


    public function edit_show(Request $request){

        $formation = Formation::where('id', $request->get('id'))->first();

        if($formation==null){
            return redirect('home');
        }

        return View('formation.edit', compact('formation'));
    }

    public function edit(Request $request){

        $data = $request->validate([
            'intitule' => ['required', 'string', 'max:255']
        ]);

        $formation = Formation::where('id', $request->get('id'))->first();

        if($formation==null){
            return redirect('home');
        }

        $formation->intitule = $data['intitule'];

        $formation->save();
        
        return redirect('home');
    }

    public function delete(Request $request){

        if($request->get("formationId")){
            $formation = Formation::where('id', $request->get("formationId"))->first();
        }

        if($formation==null){
            return redirect("home");
        }
 
        foreach ($formation->cours() as $cour) {
            Cour::destroy($cour->id);
        }
        
        foreach ($formation->users as $user) {
            $user->formation_id=null;
            $user->save();
        }

        Formation::destroy($formation->id);

        return View('home');
    } 
}
