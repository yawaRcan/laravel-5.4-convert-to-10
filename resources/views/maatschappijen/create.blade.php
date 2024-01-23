@extends('layouts.main')

@section('title', 'Nieuwe maatschappij aanmaken')

@section('content')
    <div class="page-header">
        <h1>Nieuwe maatschappij</h1>
    </div>

    {!! Form::open(['route'=>'maatschappijen.store', 'method'=>'post', 'class'=>'form-horizontal']) !!}
        @include('maatschappijen.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection