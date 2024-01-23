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
            <td>{{ $factuur->klant->naam }}</td>
            <td class="text-right">{{ number_format($factuur->bedrag,2,",",".") }} EUR</td>
            <td class="text-right">
                {{ $factuur->betaald == null ? '0 EUR' : number_format($factuur->betaald,2,",",".") . ' EUR' }}
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

                <tr>
                    <td colspan="2"></td>
                    <td>TOTALEN: </td>
                    <td class="text-right blauw vet"> {{ number_format($facturen->sum('bedrag') , 2, ",", ".")}} EUR</td>
                    <td class="text-right groen vet"> {{ number_format($facturen->sum('betaald') , 2, ",", ".")}} EUR</td>
                    <td class="text-right rood vet"> {{ number_format(($facturen->sum('bedrag') -  $facturen->sum('betaald'))  , 2, ",", ".")}} EUR</td>
                    <td></td>
                </tr>

            </tbody>

        </table>