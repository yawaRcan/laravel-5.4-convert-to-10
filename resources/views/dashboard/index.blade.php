@extends('layouts.main')

@section('title', 'Dashboard')

@section('scripts')
    <script src="{{ asset('js/search.js') }}"></script>
    <script src="{{ asset('js/facturenzoeken.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
@endsection

@section('content')

    <script>
        $(function () {
            $('#klant_id').filterByText($('#zoekklant'));
        });
    </script>

    @include('search.searchKlantenFactuur')


    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4">
                    <h4>Facturen opzoeken</h4>
                </div>
            </div>
        </div>
    </div>

    @include('search.zoekenForm')

    <div id="search-results">
        Zoek resultaten verschijnen hier...
    </div>
@endsection