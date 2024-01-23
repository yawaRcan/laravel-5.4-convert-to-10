@include('shared.errors')

<div class="row">
    <div class="form-group">
        {!! Form::label('naam','Makelaar: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            {!! Form::text('naam', null, ['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('telefoon', 'Telefoon: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-2">
            {!! Form::text('telefoon', null, ['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('website','Website: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            {!! Form::text('website', null, ['class'=>'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-lg-offset-2">
        {!! Form::submit($btnText, ['class'=>'btn btn-primary']) !!}
        <a href="{{ route('makelaars.home') }}" class="btn btn-link">Annuleren</a>
    </div>
</div>