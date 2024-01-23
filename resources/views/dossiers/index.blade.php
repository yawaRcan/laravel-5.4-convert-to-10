@extends('layouts.main')

@section('title', 'Dossiers')

@section('scripts')
    <script src="{{ asset('js/search.js') }}"></script>
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <h1>Zoek dossiers</h1>
            @include('search.searchDossiers')
        </div>
    </div>

     @if ($dossiers->IsEmpty())
            <p>Er zijn nog geen dossiers aanwezig !</p>
        @else
            <table class="table table-sm table-striped">
                <thead>
                <tr>
                    <th>Nr</th>
                    <th>Datum</th>
                    <th>Nummerplaat</th>
                    <th>Makelaar</th>
                    <th>Maatschappij</th>
                    <th class="text-right">Bedrag</th>
                </tr>
                </thead>
                <tbody>

                @foreach($dossiers as $dossier)
                    <tr>
                        <td><a href="{{ route('dossiers.show', $dossier->id) }}">{{ $dossier->dossiernummer }}</a></td>
                        <td>{{ \Carbon\Carbon::parse($dossier->datum)->format('d/m/Y') }}</td>
                        <td>{{ $dossier->nummerplaat}}</td>
                        <td>{{ $dossier->makelaar }}</td>
                        <td>{{ $dossier->maatschappij }}</td>
                        <td class="text-right">{{ number_format($dossier->resultaat,2,",",".") }} EUR</td>
                    </tr>
                @endforeach

                {{ $dossiers->links() }}
                </tbody>
            </table>
        @endif
@endsection