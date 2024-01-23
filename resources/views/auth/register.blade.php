@extends('layouts.main')

@section('content')
    <div id="new-account">
        <h1>Nieuwe gebruiker</h1>

        @include('shared.errors')

        {!! Form::open(['route'=> 'register']) !!}

        <p>
            {!! Form::label('name', 'Naam') !!}
            {!! Form::text('name') !!}
        </p>

        <p>
            {!! Form::label('email') !!}
            {!! Form::email('email') !!}
        </p>

        <p>
            {!! Form::label('password') !!}
            {!! Form::password('password') !!}
        </p>

        <p>
            {!! Form::label('password_confirmation', 'Herhaal uw paswoord') !!}
            {!! Form::password('password_confirmation') !!}
        </p>

        {!! Form::submit('Nieuwe gebruiker aanmaken', ['class'=>'secondary-cart-btn']) !!}

        {!! Form::close() !!}
    </div>
@endsection