@extends('layouts.main')

@section('title', 'Nieuwe klant aanmaken')

@section('content')
    <div class="page-header">
        <h1>Nieuwe klant</h1>
    </div>

    {!! Form::open(['route'=>'klanten.store', 'method'=>'post', 'class'=>'form-horizontal']) !!}
        @include('klanten.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection