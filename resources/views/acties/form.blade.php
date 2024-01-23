@include('shared.errors')

<div class="form-group">
    {!! Form::label('Actie') !!}
    {!! Form::text('actie', null, ['class'=>'form_control']) !!}
</div>

{!! Form::submit($btnText, ['class'=>'btn btn-primary']) !!}

<a href="{{ route('acties.home') }}" class="btn btn-link">Annuleren</a>