@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p>Planning</p>
                        @if ($user->type=="enseignant")
                            <a class="btn btn-success" href="{{route('planning_create_show', ['userId'=>$user->id])}}">Ajouter une séance</a>
                        @endif
                    </div>
                    <hr/>
                    <div>
                        <form class="d-flex justify-content-between" action="{{route('planning_index')}}" method="GET">
                            <input type="hidden" name="userId" value="{{$user->id}}"/>
                            <select placeholder="choisir une categorie" name="coursId" class="form-select col-3" aria-label="Default select example">
                                <option value="">Selectionner par cours</option>
                                @foreach ($cours as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <div>
                                <div class="d-flex">
                                    <label for="example-datetime-local-input" class="mx-2">une semaine a partir de</label>
                                    <input id class="form-control col-6"  name="date_debut" type="date" value="{{old('date_debut')}}"  id="example-datetime-local-input">
                                </div>
                            </div>
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
                                @if ($user->type=="enseignant")
                                    <th scope="col">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plannings as $planning)
                                <tr>
                                    <td>{{$planning->intitule}}</td>
                                    <td>{{$planning->date_debut}}</td>
                                    <td>{{$planning->date_fin}}</td>
                                    @if ($user->type=="enseignant")
                                        <td class="d-flex">
                                            <a class="btn btn-info mx-2" href="{{Route('planning_edit_show', ['userId'=>$user->id,'planningId'=>$planning->id])}}">Edit</a>
                                            <form action="{{Route('planning_delete')}}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$planning->id}}" name="planningId"/>
                                                <input type="hidden" value="{{$user->id}}" name="userId"/>
                                                <button type="submit" class="btn btn-danger" onclick="if(confirm('Are you sure?') ===false){event.preventDefault();}">Delete</button>
                                            </form>
                                        </td>
                                    @endif
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
