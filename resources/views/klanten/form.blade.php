@include('shared.errors')

<div class="row">
    <div class="form-group">
        {!! Form::label('naam', 'Naam: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            <p class="waarde">{{ $klant->naam }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('straat', 'Straat: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            <p class="waarde">{{ $klant->straat }}</p>
        </div>
    </div>

</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('postcode', 'Postcode: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-1">
            <p class="waarde">{{ $klant->postcode }}</p>
        </div>
        {!! Form::label('gemeente', 'Gemeente: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            <p class="waarde">{{ $klant->gemeente }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('telefoon', 'Telefoon: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-2">
            <p class="waarde">{{ $klant->telefoon }}</p>
        </div>
        {!! Form::label('gsm', 'GSM: ', ['class'=>'control-label col-lg-1']) !!}
        <div class="col-lg-2">
            <p class="waarde">{{ $klant->gsm }}</p>
        </div>
        {!! Form::label('fax', 'FAX: ', ['class'=>'control-label col-lg-1']) !!}
        <div class="col-lg-2">
            <p class="waarde">{{ $klant->fax }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('email', 'Email adres: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            <p class="waarde">{{ $klant->email }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('btw', 'BTW? ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-2">
            @if ($klant->btw)
                <p class="waarde">BTW plichtig</p>
            @else
                <p class="waarde">niet BTW plichtig</p>
            @endif
        </div>

        @if ($klant->btw)
            {!! Form::label('btwnr', 'BTW nr: ', ['class'=>'control-label col-lg-1']) !!}
            <div class="col-lg-5">
                <p class="waarde">{{ $klant->btwnr }}</p>
            </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('opmerkingen', 'Opmerkingen: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            <p class="waarde">{{ $klant->opmerking }}</p>
        </div>
    </div>
</div>