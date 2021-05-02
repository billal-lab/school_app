@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>Edit Informations : <strong>{{$user->login}}</strong></p>
                    <a href="{{route('edit_password_show', ['id'=>$user->id])}}">Changer le mot de pass</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('edit_profil') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nom</label>
                            <input type="hidden" value="{{$user->id}}" name="userId"/>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{$user->nom }}" required autocomplete="nom" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="prenom" class="col-md-4 col-form-label text-md-right">Prenom</label>

                            <div class="col-md-6">
                                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{$user->prenom }}" required autocomplete="prenom" autofocus>

                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if (Auth::user()->type=="admin" && $user->type!="admin")
                            <div class="form-group row">
                                <label for="role_register" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                                <div class="col-md-6">
                                    <select id="role_register" name="type" class="form-select form-control" aria-label="Default select example">
                                        <option value="">Choisissez un role</option>
                                        <option value="admin" {{$user->type == 'admin' ? 'selected' : '' }}>ADMIN</option>
                                        <option value="enseignant" {{$user->type == 'enseignant' ? 'selected' : '' }}>ENSEIGNANT</option>
                                        <option value="etudiant" {{$user->type == 'etudiant' ? 'selected' : '' }}>ETUDIANT</option>
                                    </select>
                                </div>
                            </div>
                            <div id="formation_register_row" class="form-group row {{$user->type!='etudiant' ? 'd-none' : ''}}">
                                <label for="formation_register" class="col-md-4 col-form-label text-md-right">{{ __('Formation') }}</label>
                                <div class="col-md-6">
                                    <select id="formation_register" placeholder="choisir ue formation" name="formation_id" class="form-select form-control" aria-label="Default select example">
                                        @foreach ($formations as $formation)
                                            <option value="{{$formation->id}}" {{$formation->id == $user->formation_id ? 'selected' : '' }}>{{$formation->intitule}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('SAVE') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
