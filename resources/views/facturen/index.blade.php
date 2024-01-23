@extends('layouts.main')

@section('title', 'Facturen')

@section('scripts')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/facturenselectie.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/pdf.css')}}">
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-11 selectie">
                    <input type="radio" name="factuur_selectie" id="factuur_selectie" value="1" checked> Alle facturen&nbsp;
                    <input type="radio" name="factuur_selectie" id="factuur_selectie" value="2"> Betaalde facturen&nbsp;
                    <input type="radio" name="factuur_selectie" id="factuur_selectie" value="3"> Onbetaalde facturen
                </div>

                <div class="col-lg-1">
                    <a href="print-facturen?optionID=1" class="btn btn-default printbtn" target="_blank">Print</a>
                </div>
            </div>
        </div>
    </div>

    <div id="search-results">

        @if ($facturen->IsEmpty())
            <p>Er zijn nog geen facturen aanwezig !</p>
        @else
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th>Nr</th>
                    <th>Datum</th>
                    <th>Klant</th>
                    <th class="text-right">Bedrag</th>
                    <th class="text-right">Betaald bedrag</th>
                    <th class="text-right">Te betalen</th>
                    <th>Vervaldag</th>
                    <th>Contact</th>
                </tr>
                </thead>
                <tbody>

                @foreach($facturen as $factuur)
                    <tr>
                        <td><a href="{{ route('facturen.edit', $factuur->id) }}">{{ $factuur->factuurnummer }}</a></td>
                        <td>{{ \Carbon\Carbon::parse($factuur->datum)->format('d/m/Y') }}</td>
                        <td>{{ $factuur->klant->naam}}</td>
                        <td class="text-right">{{ number_format($factuur->bedrag,2,",",".") }} EUR</td>
                        <td class="text-right">
                            {{ $factuur->betaald == null ? '0 ' : number_format($factuur->betaald,2,",",".") }} EUR
                        </td>

                        @if ($factuur->voldaan == 1)
                            <td class="text-right">-</td>
                        @else
                            <td class="text-right">{{ number_format(($factuur->bedrag - $factuur->betaald) ,2, ",",".") }} EUR</td>
                        @endif

                        @if ($factuur->voldaan == 1)
                            <td>&nbsp;</td>
                        @else
                            @if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($factuur->vervaldag)))
                                <td style="color:red">
                            @else
                                <td>
                            @endif
                                {{ \Carbon\Carbon::parse($factuur->vervaldag)->format('d/m/Y') }}</td>
                        @endif
  
                        @if ($factuur->voldaan != 1) 
                            <td>
                                @if ($factuur->klant->telefoon != "") 
                                    tel: {{ $factuur->klant->telefoon }} <br>
                                @endif

                                @if ($factuur->klant->gsm != "")
                                    gsm: {{ $factuur->klant->gsm}} <br>
                                @endif 

                                @if ($factuur->klant->fax != "")
                                    fax: {{ $factuur->klant->fax}}
                                @endif
                            </td>
                        @else
                            <td>&nbsp;</td>
                        @endif
                    </tr>
                @endforeach

                {{ $facturen->links() }}
                </tbody>
            </table>
        @endif
    </div>
@endsection