<html>

    <head>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/mycss.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
    </head>

    <body>
        <div class="container">

            <table>
                <tr>
                    <td colspan="4">
                        <img src="{{ asset("images/pclogo.png") }}" style="width: 65px; height: 59px;" alt="">
                        <img src="{{ asset("images/Porsche.png") }}" style="width: 100px; height: 59px;" alt="">
                    </td>
                    <td colspan="4">
                        <h1>Selectie facturen</h1>
                    </td>
                </tr>
                <tr>
                    <td><strong>Lijst van </strong></td>
                    <td>{{ $datum }}</td>
                    <td><strong>Munteenheid: </strong></td>
                    <td>EUR</td>
                    <td><strong>Keuze: </strong></td>
                    <td>{{ $title }}</td>
                    <td><strong>Sorteervolgorde: </strong></td>
                    <td>Factuur nummer</td>
                </tr>
            </table>

            <br><br>
            <table class="facturen-print">
                <tr>
                    <th>Factuurnr&nbsp;&nbsp;</th>
                    <th>Datum</th>
                    <th>Vervaldag</th>
                    <th width="110px">Telefoon</th>
                    <th colspan="2">Naam Klant</th>
                    <th class="rechts">Bedrag</th>
                    <th class="rechts">Betaald</th>
                    <th class="rechts">Nog te betalen</th>
                    <th colspan="2">Opmerking</th>
                </tr>

                @foreach ($facturen as $key => $factuur)
                    <tr>
                        <td rowspan="3">
                            @if(($factuur->bedrag - $factuur->betaald) > 0)
                                @if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($factuur->vervaldag)))
                                    @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($factuur->vervaldag)->addDays(45)))
                                        <img src="{{ asset("images/bol-rood.png") }}" style="width: 16px; height: 16px; text-align: center" alt="">
                                    @elseif(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($factuur->vervaldag)->addDays(30)))
                                        <img src="{{ asset("images/bol-oranje.png") }}" style="width: 16px; height: 16px; text-align: center" alt="">
                                    @else
                                        <img src="{{ asset("images/bol-groen.png") }}" style="width: 16px; height: 16px; text-align: center" alt="">
                                    @endif
                                @endif
                            @else
                                <img src="{{ asset("images/bol-blauw.png") }}" style="width: 16px; height: 16px; text-align: center" alt="">
                            @endif


                            &nbsp;{{ $factuur->factuurnummer }}
                        </td>
                        <td>{{ $factuur->datum }}</td>
                        <td>{{ $factuur->vervaldag }}</td>
                        <td>
                            @if ($factuur->klant->telefoon != "") 
                                T: {{ $factuur->klant->telefoon }} <br>
                            @endif

                            @if ($factuur->klant->gsm != "")
                                G: {{ $factuur->klant->gsm}} <br>
                            @endif 

                            @if ($factuur->klant->fax != "")
                                F: {{ $factuur->klant->fax}}
                            @endif
                        </td>

                        <td colspan="2" class="vet">{{ $factuur->klant->naam }}</td>
                        <td class="rechts blauw">{{ number_format($factuur->bedrag, 2, ",", ".") }}</td>
                        <td class="rechts groen">{{ $factuur->betaald == null ? 0 : number_format($factuur->betaald, 2, ",", ".") }}</td>
                        <td class="rechts rood">{{ number_format($factuur->bedrag - $factuur->betaald, 2, ",", ".") }}</td>
                        <td colspan="2">{{ $factuur->opmerkingen }}</td>
                    </tr>
                    <tr>
                        <td>Nummerplaat</td>
                        <td class="vet">{{ $factuur->code }}</td>
                        <td>Type: </td>

                        @if ($factuur->dossiers()->first())
                            <td colspan="7" class="vet">{{ $factuur->dossiers()->first()->merk }} {{ $factuur->dossiers()->first()->model }}</td>
                        @else
                            <td colspan="7" class="vet">-</td>
                        @endif
                    </tr>
                    <tr>
                        <td>Maatschappij: </td>
                        @if($factuur->dossiers()->first())
                            <td class="vet">{{ $factuur->dossiers()->first()->maatschappij }}</td>
                        @else
                            <td class="vet">-</td>
                        @endif
                        <td>Makelaar: </td>
                        @if($factuur->dossiers()->first())
                            <td colspan="7" class="vet">{{ $factuur->dossiers()->first()->makelaar }}</td>
                        @else
                            <td colspan="7" class="vet">-</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>