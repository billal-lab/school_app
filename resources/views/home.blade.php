@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul>
                        @switch(Auth::user()->type)
                            @case("etudiant")
                                <li>
                                    <a href="{{Route('cours_users_index')}}">Voir tout les cours de ma formations</a>
                                </li>
                                <li>
                                    <a href="{{route('cours_users_index_registred')}}">Voir les cours auquels je me suis insrcit de ma formations</a>
                                </li>
                                <li>
                                    <a href="{{Route('planning_index',['userId'=> Auth::user()->id])}}">Voir mon planning</a>
                                </li>    
                                @break
                            @case("admin")
                                <li>
                                    <a href="{{route('users_index')}}">Gestion des utilisateurs</a>
                                </li>
                                <li>
                                    <a href="{{route('formations_index')}}">Gestion des formations</a>
                                </li>
                                <li>
                                    <a href="{{route('cours_index')}}">Gestion des cours</a>
                                </li>
                                @break
                            @case("enseignant")
                                <li>
                                    <a href="{{route('cours_enseignant_index')}}">Afficher les cours dont je suis reponsable</a>
                                </li>
                                <li>
                                    <a href="{{Route('planning_index', ['userId'=> Auth::user()->id])}}">Voir mon planning</a>
                                </li>  
                                @break
                            @default
                                <h1>Vous n'avez pas encore le droit de naviguer sur le site</h1>
                        @endswitch
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
