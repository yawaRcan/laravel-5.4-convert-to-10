@extends('layouts.main')

@section('title', 'Dossier')

@section('content')

    <div class="page-header">
        <h1>Dossier {{ $dossier->dossiernummer }}</h1>
    </div>

    @include('dossiers.form')

@endsection