@extends('layouts.main')

@section('title', 'Statistieken')

@section('scripts')
    <script src="{{ asset('js/facturenzoeken.js') }}"></script>
    <script src="{{ asset('js/Chart.js') }}"></script>
@endsection

@section('content')

    @include('dashboard.statistiekenForm')

    <div id="search-results">
    </div>

@endsection