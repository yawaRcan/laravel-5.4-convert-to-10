@extends('layouts.main')

@section('title', 'Klant ' . $klant->naam . ' aanpassen')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-lg-11">
                <h1>Klant</h1>
            </div>
            <div class ="col-lg-1">
                <a href="{{ route('klanten.home') }}" class="btn btn-primary">Terug</a>
            </div>
        </div>
    </div>

    {!! Form::model($klant, ['route'=>['klanten.update', $klant->id], 'method'=>'post', 'class'=>'form-horizontal']) !!}
    @include('klanten.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection