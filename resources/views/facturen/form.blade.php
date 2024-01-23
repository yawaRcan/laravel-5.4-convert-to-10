@include('shared.errors')

<div class="row">
    <div class="form-group">

        {!! Form::label('factuurnummer', 'Factuurnummer: ', ['class'=>'control-label col-lg-2']) !!}

        <div class="col-lg-3">
            @if (isset ($factuur))
                {!! Form::hidden('factuurnummer') !!}
                <p class="waarde">{{ $factuur->factuurnummer }}</p>
            @else
                {!! Form::hidden('factuurnummer', $fn) !!}
                {{ $fn }}
            @endif
        </div>

        {!! Form::label('datum', 'Factuur Datum: ', ['class'=>'control-label col-lg-2']) !!}

        <div class="col-lg-3">
            @if (isset ($factuur))
                {!! Form::hidden('datum') !!}
                <p class="waarde">{{ \Carbon\Carbon::parse($factuur->datum)->format('d/m/Y')}}</p>
            @else
                {!! Form::date('datum', null , ['class'=>'form-control']) !!}
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('bedrag', 'Factuur Bedrag: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">
            @if (isset ($factuur))
                {!! Form::hidden('bedrag') !!}
                <p class="waarde">{{ number_format ( $factuur->bedrag, 2, ",", "." ) }} EUR</p>
            @else
                {!! Form::number('bedrag', null, ['class'=>'form-control bedrag', 'step'=>'any',])!!}
            @endif
        </div>

        {!! Form::label('dossier', 'Dossier: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">
            <p class="waarde"><a href="{{ route('dossiers.show', $dossier->id) }}">{{ $dossier->dossiernummer }}</a></p>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('betaald','Betaald: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">
            @if($factuur->bedrag - $factuur->betaald > 0)
                <p class="waarde redback">
            @else
                <p class="waarde">
            @endif
            {{ number_format($factuur->betaald, 2, ",", "." ) }} EUR
                </p>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="form-group">
        {!! Form::label('Klant', 'Klant naam: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">
            @if (isset ($factuur))
                {!! Form::hidden('klant_id') !!}
                <p class="waarde"><a href="{{ route('klanten.edit', $klantid) }}">{{ ucwords(strtolower($klantnaam), " ") }}</a></p>
            @else
                {!! Form::select('klant_id', $klanten, null, ['id'=>'klant_id','class'=>'form-control']) !!}
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('merk_id', 'Merk: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">
            <p class="waarde"> {{ $dossier->merk }}</p>
        </div>

        {!! Form::label('makelaar_id', 'Makelaar: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            <p class="waarde">{{ $dossier->makelaar }}</p>
        </div>

    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('model', 'Model: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">
            <p class="waarde">{{ $dossier->model }}</p>
        </div>

        {!! Form::label('maatschappij_id', 'Maatschappij: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            <p class="waarde">{{ $dossier->maatschappij }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {{ Form::label('code', 'Nummerplaat: ', ['class'=>'control-label col-lg-2']) }}
        <div class="col-lg-3">
            <p class="waarde">{{ $dossier->nummerplaat }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('opmerkingen', 'Opmerkingen: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-5">
            <p class="waarde">{{ $factuur->opmerkingen }}</p>
        </div>
    </div>
</div>