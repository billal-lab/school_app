@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1 class="text-center">Mes cours</h1>
            <div class="row justify-content-center">
                @php
                    $colors = ["success", "info", "danger", "warning", "primary", "white"];
                @endphp
                @foreach ($cours as $cour)
                    @php
                        $choice = array_rand($colors, 1);
                    @endphp
                    <div class="card col-3 mx-2 mb-2 bg-{{$colors[$choice]}}">
                        <div class="card-body text-center">
                            <h2 class="card-text">{{$cour->intitule}}</h2>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
