@extends('layouts.admin')

@section('content')
    <h1>Gelieve in te loggen</h1>
    {!! Form::open(['route'=>'login']) !!}

    <ul>
        <li>
            {!! Form::label('Naam') !!}
            {!! Form::text('name') !!}
            {!! $errors->first('name', '<p class="error">:message</p>') !!}
        </li>
        <li>
            {!! Form::label('password') !!}
            {!! Form::password('password') !!}
            {!! $errors->first('password', '<p class="error">:message</p>') !!}
        </li>
        <li>
            {!! Form::submit('Login') !!}
        </li>
    </ul>
    {!! Form::close() !!}
@endsection