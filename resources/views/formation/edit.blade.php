@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create new formation</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('formations_edit', ['id'=> $formation->id]) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="intitule" class="col-md-4 col-form-label text-md-right">Intitule</label>

                            <div class="col-md-6">
                                <input id="intitule" type="text" class="form-control @error('intitule') is-invalid @enderror" name="intitule" value="{{ $formation->intitule }}" required autocomplete="intitule" autofocus>

                                @error('intitule')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Sauvegarder') }}
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
