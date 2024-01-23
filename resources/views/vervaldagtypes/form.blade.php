@include('shared.errors')

<div class="row">
    <div class="form-group">
        {!! Form::label('type', 'Type: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">
            {!! Form::text('type',null, ['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('dagen', 'Dagen voor betaling: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">
            {!! Form::number('dagen', null, ['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-lg-4 col-lg-offset-2">
        {!! Form::submit($btnText, ['class'=>'btn btn-primary']) !!}
        <a href="{{ route('vervaldagtypes.home') }}" class="btn btn-link">Annuleren</a>
    </div>
</div>