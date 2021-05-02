@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Créer un nouveau cours</div>

                <div class="card-body">
                    <form method="POST" action="{{Route('cours_create')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="intitule" class="col-md-4 col-form-label text-md-right">Intitule</label>

                            <div class="col-md-6">
                                <input id="intitule" type="text" class="form-control @error('intitule') is-invalid @enderror" name="intitule" value="{{ old('intitule') }}" required autocomplete="intitule" autofocus>

                                @error('intitule')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label for="enseignant" class="col-md-4 col-form-label text-md-right">{{ __('Enseignant') }}</label>
                            <div class="col-md-6">
                                <select placeholder="choisir un enseignant" name="user_id" class="form-select form-control" aria-label="Default select example">
                                    @foreach ($enseignants as $enseignant)
                                        <option value="{{$enseignant->id}}">{{$enseignant->nom}} {{$enseignant->prenom}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="formation" class="col-md-4 col-form-label text-md-right">{{ __('Formation') }}</label>
                            <div class="col-md-6">
                                <select placeholder="choisir ue formation" name="formation_id" class="form-select form-control" aria-label="Default select example">
                                    @foreach ($formations as $formation)
                                        <option value="{{$formation->id}}">{{$formation->intitule}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
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
