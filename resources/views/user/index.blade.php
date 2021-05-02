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
