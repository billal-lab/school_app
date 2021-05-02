@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p>List des cours</p>
                        <a class="btn btn-success" href="{{Route('cours_create_show')}}">Ajouter un cour</a>
                    </div>
                    <hr/>
                    <div>
                        <form class="d-flex justify-content-between" action="{{Route('cours_index')}}" method="GET">
                            <input class="col-3" type="text" name="intitule" placeholder="recherche par intitulé"/>
                            <select placeholder="choisir un enseignant" name="enseignant" class="form-select col-3" aria-label="Default select example">
                                <option value="">Selectionner un Enseignant</option>
                                @foreach ($enseignants as $enseignant)
                                    <option value="{{$enseignant->id}}">{{$enseignant->nom}} {{$enseignant->prenom}} ({{$enseignant->login}})</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Intitule</th>
                                <th scope="col">Formation</th>
                                <th scope="col">Enseignant</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cours as $cour)
                                <tr>
                                    <th scope="row">{{$cour->id}}</th>
                                    <td>{{$cour->intitule}}</td>
                                    <td>{{$cour->formation->intitule}}</td>
                                    <td>{{$cour->enseignant->nom}} {{$cour->enseignant->prenom}} ({{$cour->enseignant->login}})</td>
                                    <td>{{$cour->created_at}}</td>
                                    <td class="d-flex">
                                        <a class="btn btn-info mx-2" href="{{Route('cours_edit',['id'=>$cour->id])}}">Edit</a>
                                        <form action="{{Route('cours_delete')}}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$cour->id}}" name="courId"/>
                                            <button type="submit" class="btn btn-danger" onclick="if(confirm('Are you sure?') ===false){event.preventDefault();}">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
