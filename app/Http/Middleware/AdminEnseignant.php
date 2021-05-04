<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class AdminEnseignant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::find($request['userId']);
        
        if($request->user()->type!="admin" && $request->user()->type!="enseignant"){ // si l'utilisateur n'est ni admin n'est enseignant
            return redirect()->route('home');
        }

        if($request->user()->type=="enseignant" && $user!=$request->user()){ // si ce n'est pas le meme enseignant
            return redirect()->route('home');
        }

        if(!$user || $user->type!="enseignant"){  // si on essaie de modifier un planning qui n'appartien pas a une enseignant
            return redirect()->route('home');
        }

        return $next($request);
    }
}
