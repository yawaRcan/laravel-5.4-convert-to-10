@extends('layouts.main')

@section('title', 'Maatschappij ' . $maatschappij->naam . ' aanpassen')

@section('content')
    <div class="page-header">
        <h1>Maatschappij aanpassen</h1>
    </div>

    {!! Form::model($maatschappij, ['route'=>['maatschappijen.update', $maatschappij->id], 'method'=>'post',  'class'=>'form-horizontal']) !!}
    @include('maatschappijen.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection