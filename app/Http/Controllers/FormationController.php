<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Formation;
use App\Models\User;
use Facade\FlareClient\View;
use Illuminate\Http\Request;

class FormationController extends Controller
{

    /**
     * lister toute les formation
     */
    public function index(){

        $formations = Formation::all();

        return View('formation.index', compact('formations'));

    }


    /**
     * afficher le formaulaire de creation d'une formation
     */
    public function create_show(){

        return View('formation.create');

    }


    /**
     * persister le formualaire de creation d'une nouvelle formation 
     */
    public function create(Request $request){

        $data = $request->validate([
            'intitule' => ['required', 'string', 'max:255']
        ]);

        Formation::create([
            'intitule' => $data['intitule']
        ]);

        session()->flash('success', "la formation a été crée");
        return redirect()->route('formations_index');
    }

    /**
     * afficher le formulaire d'edition d'une formation
     */
    public function edit_show(Request $request){

        $formation = Formation::where('id', $request->get('id'))->first();

        if($formation==null){
            return redirect('home');
        }

        return View('formation.edit', compact('formation'));
    }


    /**
     * persister le formulaire d'edition d'une formation
     */
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

        session()->flash('success', "la formation a été modifié");
        return redirect()->route('formations_index');

    }


    /**
     * suprimmer une formation
     * voir force_delete Dans Models\Formation
     */
    public function delete(Request $request){

        if($request->get("formationId")){
            $formation = Formation::where('id', $request->get("formationId"))->first();
        }

        if($formation==null){
            return redirect("home");
        }
 
        $formation->force_delete();
        
        session()->flash('success', "la formation a été supprimé");
        return redirect()->route('formations_index');
    } 
}
