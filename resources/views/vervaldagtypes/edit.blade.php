@extends('layouts.main')

@section('title', 'Vervaldagtype ' . $vervaldagtype->type . ' aanpassen')

@section('content')
    <div class="page-header">
        <h1>Vervaldagtype aanpassen</h1>
    </div>

    {!! Form::model($vervaldagtype, ['route'=>['vervaldagtypes.update', $vervaldagtype->id], 'method'=>'post', 'class'=>'form-horizontal']) !!}
    @include('vervaldagtypes.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection