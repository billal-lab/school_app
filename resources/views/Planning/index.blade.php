@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p>Planning</p>
                        <a class="btn btn-success" href="{{route('planning_create_show', ['userId'=>Auth::user()->id])}}">Ajouter une séance</a>
                    </div>
                    <hr/>
                    <div>
                        <form class="d-flex justify-content-between" action="#" method="GET">
                            <select placeholder="choisir une categorie" name="type" class="form-select col-3" aria-label="Default select example">
                                <option value="">Please select</option>
                                <option value="semaine">Par Semaine</option>
                                <option value="cours">Par cours</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">cours</th>
                                <th scope="col">debut</th>
                                <th scope="col">fin</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plannings as $planning)
                                <tr>
                                    <td>{{$planning->intitule}}</td>
                                    <td>{{$planning->date_debut}}</td>
                                    <td>{{$planning->date_fin}}</td>
                                    <td class="d-flex">
                                        <a class="btn btn-info mx-2" href="#">Edit</a>
                                        <form action="#" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$planning->id}}" name="planningId"/>
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
