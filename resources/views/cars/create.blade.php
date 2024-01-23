@extends('layouts.main')

@section('title', 'Nieuw automerk')

@section('content')
    <div class="page-header">
        <h1>Nieuw automerk</h1>
    </div>

    {!! Form::open(['route'=>'cars.store', 'method'=>'post']) !!}
    @include('cars.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection