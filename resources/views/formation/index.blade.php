@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p>List des formations</p>
                        <a class="btn btn-success" href="{{Route('formations_create_show')}}">Ajouter une formation</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">intitule</th>
                                <th scope="col">created at</th>
                                <th scope="col">updated at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formations as $formation)
                                <tr>
                                    <th scope="row">{{$formation->id}}</th>
                                    <td>{{$formation->intitule}}</td>
                                    <td>{{$formation->created_at}}</td>
                                    <td>{{$formation->updated_at}}</td>
                                    <td class="d-flex">
                                            <a class="btn btn-info mx-2" href="{{Route('formations_edit_show',['id' => $formation->id])}}">Edit</a>
                                            <form action="{{Route('formations_delete')}}" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$formation->id}}" name="formationId"/>
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
