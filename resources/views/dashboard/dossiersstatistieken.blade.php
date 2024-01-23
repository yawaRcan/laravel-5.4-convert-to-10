@extends('layouts.main')

@section('title', 'Dossiers statistieken')

@section('scripts')
    <script src="{{ asset('js/dossierszoeken.js') }}"></script>
    <script src="{{ asset('js/Chart.js') }}"></script>
@endsection

@section('content')

    @include('dashboard.dossiersStatistiekenForm')

    <div id="search-results">
    </div>

@endsection