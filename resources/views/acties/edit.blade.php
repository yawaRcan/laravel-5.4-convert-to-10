@extends('layouts.main')

@section('title', 'Actie ' . $actie->actie . ' aanpassen')

@section('content')
    <div class="page-header">
        <h1>Actie aanpassen</h1>
    </div>

    {!! Form::model($actie, ['route'=>['actie.update', $actie->id], 'method'=>'post']) !!}

    @include('acties.form', ['btnText'=>'Actie opslaan'])

    {!! Form::close() !!}
@endsection