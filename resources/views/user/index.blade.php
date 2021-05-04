@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p>List des utilisateurs</p>
                        <a class="btn btn-success" href="{{route('users_create_show')}}">Ajouter un utilisateur</a>
                    </div>
                    <hr/>
                    <div>
                        <form class="d-flex justify-content-between" action="{{route('users_index')}}" method="GET">
                            <select placeholder="choisir une categorie" name="type" class="form-select col-3" aria-label="Default select example">
                                <option value="">Please select</option>
                                <option value="etudiant">Etudiant</option>
                                <option value="enseignant">Enseignant</option>
                            </select>
                            <input class="col-3" type="text" name="mots" placeholder="mots clé"/>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Prenom</th>
                                <th scope="col">Login</th>
                                <th scope="col">Type</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if ($user!= Auth::user())
                                    <tr>
                                        <th scope="row">{{$user->id}}</th>
                                        <td>{{$user->nom}}</td>
                                        <td>{{$user->prenom}}</td>
                                        <td>{{$user->login}}</td>
                                        <td>{{$user->type}}</td>
                                        <td class="d-flex">

                                            <a class="btn btn-info mx-2" href="{{route('edit_profil_show', ['id'=>$user->id])}}">Edit</a>
                                            <form action="{{route('users_delete')}}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$user->id}}" name="userId"/>
                                                <button type="submit" class="btn btn-danger" onclick="if(confirm('Are you sure?') ===false){event.preventDefault();}">Delete</button>
                                            </form>
                                            @if ($user->type==="etudiant" || $user->type==="enseignant")
                                                <a class="btn btn-light mx-2" href="{{route('planning_index', ['userId'=>$user->id])}}">
                                                    Planning
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16">
                                                        <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                                    </svg>
                                                </a>
                                             @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
