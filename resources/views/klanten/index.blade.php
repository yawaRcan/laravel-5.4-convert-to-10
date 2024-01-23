@extends('layouts.main')

@section('title', 'Klanten')

@section('scripts')
    <script src="{{ asset('js/search.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <h1>Zoek klanten</h1>
            @include('search.search')
        </div>
    </div>


    @if ($klanten->IsEmpty())
        <p>Er zijn nog geen klanten aanwezig !</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Naam</th>
                <th>Adres</th>
                <th>Telefoon</th>
                <th>BTW</th>
            </tr>
            </thead>
            <tbody>
            @foreach($klanten as $klant)
                <tr>
                    <td><a href="{{ route('klanten.edit', $klant->id) }}">{{ ucwords(strtolower($klant->naam), " ") }}</a></td>
                    <td>{{ $klant->straat }}, {{ $klant->postcode }} {{ $klant->gemeente }}</td>
                    <td>{{ substr($klant->telefoon, 0, 1) != "0" & ($klant->telefoon <> "") ? "0" . $klant->telefoon : $klant->telefoon }}</td>
                    @if ($klant->btw = true)
                        <td>{{ $klant->btwnr }}</td>
                    @endif
                </tr>
            @endforeach

            {{ $klanten->links() }}
            </tbody>
        </table>

    @endif


@endsection