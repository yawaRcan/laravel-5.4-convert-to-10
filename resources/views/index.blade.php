@extends('layouts.main')

@section('scripts')

    <script>
        $(document).ready(function() {
            $('.count').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 1500,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        });
    </script>

@endsection

@section('css')
    <link href="https://fonts.googleapis.com/css?family=Krona+One" rel="stylesheet">
@endsection

@section('content')

    <h1>Welkom op de Factuur Manager</h1>

    <br><br><br>
    <div class="row">
        <div class="col-lg-3">
            <img src="images/billboard.png" alt="Billboard">
        </div>

        @if (auth()->check())
            <div class="col-lg-3 countersquare">
                <h1>Klanten</h1>
                <span class="counter-digit">
                    <span class="count">{{ $aantalklanten }}</span>
                </span>
            </div>

            <div class="col-lg-3 countersquare">
                <h1>Dossiers</h1>
                <span class="counter-digit">
                    <span class="count">{{ $aantaldossiers }}</span>
                </span>
            </div>

            <div class="col-lg-3 countersquare">
                <h1>Facturen</h1>
                <span class="counter-digit">
                    <span class="count">{{ $aantalfacturen }}</span>
                </span>
            </div>
        @else
            <p>Welkom op de Plevoets Factuur Manager V1<br>
            Om verder te gaan moet u eerst inloggen. Klik daarvoor op de knop "Inloggen" rechtsboven !</p>
        @endif
    </div>

@endsection
