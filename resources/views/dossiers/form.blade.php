@include('shared.errors')

<div class="row">
    <div class="form-group">
        {!! Form::label('dossiernummer', 'Dossier nummer: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-2">{{ $dossier->dossiernummer }}</div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('datum', 'Datum: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">{{ \Carbon\Carbon::parse($dossier->datum)->format('d/m/Y')}}</div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('bedrag', 'Bedrag: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-3">{{ number_format ( $dossier->resultaat, 2, ",", "." ) }} EUR</div>
    </div>
</div>

<hr>

<div class="row">
    <div class="form-group">
        {!! Form::label('Merk', 'Merk: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-2">{{ $dossier->merk }}</p></div>

        {!! Form::label('Model', 'Model: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-2">{{ $dossier->model}}</div>

        {!! Form::label('Nummerplaat', 'Nummerplaat: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-2">{{ $dossier->nummerplaat}}</div>
    </div>
</div>


<div class="row">
    <div class="form-group">
        {!! Form::label('makelaar', 'Makelaar: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-10">
            @if ($dossier->makelaar == "")
                Onbekend
            @else
                {{ $dossier->makelaar }}
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('maatschappii', 'Maatschappij: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-10">
            @if ($dossier->maatschappij == "")
                Onbekend
            @else
                {{ $dossier->maatschappij }}
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('opmerkingen', 'Opmerkingen: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-10">{{ $dossier->opmerkingen }}</div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('facturen', 'Facturen: ', ['class'=>'control-label col-lg-2']) !!}
        <div class="col-lg-10">
            @if ($dossier->facturen())
                @foreach($dossier->facturen()->get() as $fact)
                    <a href="{{ route('facturen.edit', $fact->id) }}">Factuur {{ $fact->factuurnummer }}</a><br>
                @endforeach
            @endif
        </div>
    </div>
</div>