<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\CoursUser;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;

class CourController extends Controller
{
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

    public function create_show(Request $request){

        $enseignants = User::where('type', 'ENSEIGNANT')->get();

        $formations = Formation::all();

        return View('cour.create', [
            'formations' => $formations,
            'enseignants' =>$enseignants
        ]);
    }


    public function create(Request $request){

        $data = $request->validate([
            'intitule' => ['required', 'string', 'max:255'],
            'user_id' => ['required'],
            'formation_id' => ['required'],
        ]);
        
        Cour::create($data);

        return redirect('home');
    }

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

        return redirect('home');
    }


    public function delete(Request $request){

        $cour = Cour::where('id', $request->get('courId'))->first();

        if($cour==null){
            return redirect('home');
        }

        foreach ($cour->cours_users as $cour_user) {
            CoursUser::where('cours_id',$cour->id)->delete();
        }

        Cour::destroy($cour->id);

        return redirect('home');
    }
}
