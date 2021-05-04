<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\CoursUser;
use App\Models\Formation;
use App\Models\Planning;
use App\Models\User;
use Illuminate\Http\Request;

class CourController extends Controller
{
    /**
     * lister tout les cours
     */
    public function index(Request $request){

        $intitule=null;
        $enseignant_id = null;

        if($request->get('intitule')){
            $intitule= $request->get('intitule');
        }

        if($request->get('enseignant')){
            $enseignant_id = $request->get('enseignant');
        }

        $cours = Cour::findWithFilter($intitule, $enseignant_id);

        $enseignants = User::where('type', 'ENSEIGNANT')->get();

        return View('cour.index', compact('cours', 'enseignants'));
    }

    /**
     * afficher le formulaire de creation d'un cours
     */
    public function create_show(Request $request){

        $enseignants = User::where('type', 'ENSEIGNANT')->get();

        $formations = Formation::all();

        return View('cour.create', [
            'formations' => $formations,
            'enseignants' =>$enseignants
        ]);
    }

    /**
     * submission du formulaire de creation d'un cours
     */
    public function create(Request $request){

        $data = $request->validate([
            'intitule' => ['required', 'string', 'max:255'],
            'user_id' => ['required'],
            'formation_id' => ['required'],
        ]);
        
        Cour::create($data);

        session()->flash('success', "le cours a été crée");
        return redirect()->route('cours_index');
    }


    /**
     * afficher le formulaire d'edition d'un cours
     */
    public function edit_show(Request $request){

        $enseignants = User::where('type', 'ENSEIGNANT')->get();

        $formations = Formation::all();

        $cour = Cour::where('id', $request->get('id'))->first();

        if($cour==null){
            return redirect('home');
        }

        return View('cour.edit', [
            'formations' => $formations,
            'enseignants' =>$enseignants,
            'cour' => $cour
        ]);
    }

    /**
     * submission du formulaire de edition d'un cours
     */
    public function edit(Request $request){
 
        $data = $request->validate([
            'intitule' => ['required', 'string', 'max:255'],
            'user_id' => ['required'],
            'formation_id' => ['required'],
        ]);

        $cour = Cour::where('id', $request->get('id'))->first();

        if($cour==null){
            return redirect('home');
        }
        
        $cour->intitule = $data["intitule"];
        $cour->user_id = $data["user_id"];
        $cour->formation_id = $data["formation_id"];

        $cour->save();

        session()->flash('success', "le cours a été modifié");
        return redirect()->route('cours_index');
    }

    /**
     * supression d'un cours
     */
    public function delete(Request $request){

        $cour = Cour::where('id', $request->get('courId'))->first();

        if($cour==null){
            return redirect('home');
        }

        $cour->force_delete();
        
        session()->flash('success', "le cours a été supprimé");
        
        return redirect()->route('cours_index');
    }
}
