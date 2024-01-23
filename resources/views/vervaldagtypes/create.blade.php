@extends('layouts.main')

@section('title', 'Nieuw vervaldagtype aanmaken')

@section('content')
    <div class="page-header">
        <h1>Nieuw vervaldagtype</h1>
    </div>

    {!! Form::open(['route'=>'vervaldagtypes.store', 'method'=>'post', 'class'=>'form-horizontal']) !!}
        @include('vervaldagtypes.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection