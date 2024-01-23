@extends('layouts.main')

@section('title', 'Nieuwe actie aanmaken')

@section('content')
    <div class="page-header">
        <h1>Maak een nieuwe actie aan</h1>
    </div>

    {!! Form::open(['route'=>'acties.store', 'method'=>'post']) !!}
        @include('acties.form', ['btnText'=>'Nieuwe actie toevoegen'])
    {!! Form::close() !!}
@endsection