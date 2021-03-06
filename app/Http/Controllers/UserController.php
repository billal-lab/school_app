<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * list all users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $mots = null;
        $type = null;

        if($request->get("mots")){
            $mots = $request->get("mots");
        }

        if($request->get("type")){
            $type = $request->get("type");
        }
        
        $users = User::findWithFilter($mots, $type);

        return View('user.index', compact('users'));
    }


    /**
     * Show edit personal information.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit_profil_show(Request $request)
    {
        $user = Auth::user();

        if($request->get("id")){
            $user = User::where('id', $request->get("id"))->first();
        }

        if(!$user){
            return redirect("home");
        }

        if(Auth::user()->type!="admin" && $user->id != Auth::user()->id){
            return redirect("home");
        }

        
        $formations = Formation::all();
        
        return View('user.edit_profil', compact('user', 'formations'));
    }

    /**
     * Show edit personal information.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit_profil(Request $request)
    {   
        $user =  Auth::user();

        if($request->get("userId")){
            $user = User::where('id', $request->get("userId"))->first();
        }

        if(!$user){
            return redirect("home");
        }

        if(Auth::user()->type!="admin" && $user->id != Auth::user()->id){
            return redirect("home");
        }

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255']
        ]);

        if(Auth::user()->type=='admin' && $user->type!="admin"){
            $data['formation_id'] = $request['formation_id'];
            $data['type']= $request['type'];
        }

        User::where('id', $user->id)
            ->update($data);

        session()->flash('success', "le profil a ??t?? modifi??");
    
        return redirect()->route('home');
    }


    /**
     * Show edit personal information.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit_password_show(Request $request)
    {
        $user = Auth::user();

        if($request->get("id")){
            $user = User::where('id', $request->get("id"))->first();
        }
        
        if(!$user){
            return redirect("home");
        }

        if(Auth::user()->type!="admin" && $user->id != Auth::user()->id){
            return redirect("home");
        }

        return View('user.edit_password', compact('user'));

    }

    /**
     * Show edit personal information.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit_password(Request $request)
    {   
        $user =  Auth::user();

        if($request->get("userId")){
            $user = User::where('id', $request->get("userId"))->first();
        }

        if(!$user){
            return redirect("home");
        }

        if(Auth::user()->type!="admin" && $user->id != Auth::user()->id){
            return redirect("home");
        }

        $data = $request->validate([
            'mdp' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        User::where('id', $user->id)
        ->update([
            'mdp' => Hash::make($data['mdp'])
        ]);

        session()->flash('success', "le mot de passe a ??t?? modifi??");

        return redirect()->route('home');
    }

    /**
     * Show edit personal information.
     * Voir force_delete dans Models\User
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete(Request $request)
    {   

        if($request->get("userId")){
            $user = User::where('id', $request->get("userId"))->first();
        }

        if($user==null){
            return redirect("home");
        }

        $user->force_delete();

        User::destroy($user->id);

        session()->flash('success', "l'utilisateur a ??t?? supprim??");
        return redirect()->route('users_index');
        
    }

    /**
     * Show new user form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create_show()
    {
        $formations = Formation::all();

        return View('user.create', compact('formations'));
    }

    /**
     *  new user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'mdp' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        
        $data['mdp'] = Hash::make($data['mdp']);

        if(Auth::user()->type=='admin'){
            $data['formation_id'] = $request['formation_id'];
            $data['type']= $request['type'];
        }
        
        User::create($data);

        session()->flash('success', "l'utilisateur a ??t?? cr??e");
        return redirect()->route('users_index');
    }
}
