@extends('layouts.main')

@section('title', 'Merk ' . $car->brand . ' aanpassen')

@section('content')
    <div class="page-header">
        <h1>Automerk aanpassen</h1>
    </div>

    {!! Form::model($car, ['route'=>['cars.update', $car->id], 'method'=>'post']) !!}
    @include('cars.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection