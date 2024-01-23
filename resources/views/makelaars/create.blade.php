@extends('layouts.main')

@section('title', 'Nieuwe makelaar aanmaken')

@section('content')
    <div class="page-header">
        <h1>Nieuwe makelaar</h1>
    </div>

    {!! Form::open(['route'=>'makelaars.store', 'method'=>'post', 'class'=>'form-horizontal']) !!}
        @include('makelaars.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection