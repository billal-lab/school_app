@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Changer l'horaire du <strong>{{$cours->intitule}}</strong></div>

                <div class="card-body">
                    <form method="POST" action="{{Route('planning_edit')}}">
                        @csrf
                        <input type="hidden" name ="planningId" value="{{$planning->id}}"/>
                        <input type="hidden" name ="userId" value="{{$user->id}}"/>
                        <div class="form-group row">
                            <label for="example-datetime-local-input" class="col-md-4 col-form-label text-md-right">Date de début</label>
                            <div class="col-md-6">
                              <input class="form-control"  name="date_debut" type="datetime-local" value="{{old('date_debut')}}"  id="example-datetime-local-input">
                              @error('date_debut')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="example-datetime-local-input" class="col-md-4 col-form-label text-md-right">Date de fin</label>
                            <div class="col-md-6">
                              <input class="form-control"  name="date_fin" type="datetime-local" value="{{old('date_fin')}}" id="example-datetime-local-input">
                              @error('date_fin')
                              <span class="text-danger" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                        </div>
                        
                        @error('date_fin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Créer la séance') }}
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
