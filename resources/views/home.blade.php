@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard type : <strong>{{ Auth::user()->type }}</strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="d-flex row">
                        @switch(Auth::user()->type)
                            @case("etudiant")
                                @include('layouts._etudiant')
                                @break
                            @case("admin")
                                @include('layouts._admin')
                                @break
                            @case("enseignant")
                                @include('layouts._enseignant')
                                @break
                            @default
                                <h1>Vous n'avez pas encore le droit de naviguer sur le site</h1>
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
