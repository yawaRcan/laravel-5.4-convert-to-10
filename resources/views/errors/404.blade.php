@extends('layouts.main')

@section('title', 'Data niet gevonden')

@section('content')
    <div class="page-header">
        <h1>404 <small>... niet gevonden</small></h1>
    </div>
    
    <p class="lead">
        Sorry... deze pagina werd niet gevonden !
    </p>

    <a href="{{ route('site.home') }}" class="btn btn-primary">Terug naar de site</a>
@endsection