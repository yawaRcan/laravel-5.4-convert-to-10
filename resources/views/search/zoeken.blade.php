@extends('layouts.main')

@section('title', 'Facturen zoeken')

@section('scripts')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/facturenZoeken.js') }}"></script>
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4">
                    <a href="{{ route('facturen.create') }}" class="btn btn-primary">Maak nieuw factuur aan</a>
                </div>

                <div class="col-lg-8 selectie">
                    <input type="radio" name="factuur_selectie" id="factuur_selectie" value="1" checked> Alle facturen&nbsp;
                    <input type="radio" name="factuur_selectie" id="factuur_selectie" value="2"> Betaalde facturen&nbsp;
                    <input type="radio" name="factuur_selectie" id="factuur_selectie" value="3"> Onbetaalde facturen
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
                </tr>
                </thead>
                <tbody>

                @foreach($facturen as $factuur)
                    <tr>
                        <td><a href="{{ route('facturen.edit', $factuur->id) }}">{{ $factuur->factuurnummer }}</a></td>
                        <td>{{ \Carbon\Carbon::parse($factuur->datum)->format('d/m/Y') }}</td>
                        <td>{{ $factuur->klant->naam }}</td>
                        <td class="text-right">{{ $factuur->bedrag }} EUR</td>
                        <td class="text-right">
                            {{ $factuur->betaald == null ? '0 EUR' : $factuur->betaald.' EUR' }}
                        </td>

                        <td class="text-right">{{ $factuur->bedrag - $factuur->betaald }} EUR</td>

                        @if ($factuur->voldaan == 1)
                            <td>Voldaan</td>
                        @else
                            @if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($factuur->vervaldag)))
                                <td style="color:red">
                            @else
                                <td>
                                    @endif
                                    {{ \Carbon\Carbon::parse($factuur->vervaldag)->format('d/m/Y') }}</td>
                            @endif
                    </tr>
                @endforeach

                {{ $facturen->links() }}
                </tbody>
            </table>
        @endif
    </div>
@endsection