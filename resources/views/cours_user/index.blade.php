@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p>List des cours de la formation</p>
                        <a class="btn btn-success" href="{{route('cours_users_index_registred')}}">Voir mes cours</a>
                    </div>
                    <hr/>
                    <div>
                        <form class="d-flex justify-content-between" action="{{route('cours_users_index')}}" method="GET">
                            <input class="col-3" type="text" name="mots" placeholder="chercher un cours"/>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">intitule</th>
                                <th scope="col">crée le</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cours as $cour)
                                <tr>
                                    <th scope="row">{{$cour->id}}</th>
                                    <td>{{$cour->intitule}}</td>
                                    <td>{{$cour->created_at}}</td>
                                    @php
                                        $registred=false;
                                        foreach (Auth::user()->cours_users as $tuple){
                                            if ($tuple->cours_id== $cour->id){
                                                $registred = true;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <td class="d-flex">
                                        <form action="{{$registred ? Route('cours_users_unregister') : Route('cours_users_register')}}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$cour->id}}" name="courId"/>
                                            <button type="submit" class="btn btn-{{$registred ? "danger" : "success"}}">
                                                {{$registred ? "Se désinscrire" : "S'inscrire"}}
                                            </button>
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
