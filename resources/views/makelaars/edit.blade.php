@extends('layouts.main')

@section('title', 'Makelaar ' . $makelaar->naam . ' aanpassen')

@section('content')
    <div class="page-header">
        <h1>Makelaar aanpassen</h1>
    </div>

    {!! Form::model($makelaar, ['route'=>['makelaars.update', $makelaar->id], 'method'=>'post', 'class'=>'form-horizontal']) !!}

    @include('makelaars.form', ['btnText'=>'Bewaren'])

    {!! Form::close() !!}
@endsection