@extends('layouts.main')

@section('title', 'Nieuw factuur aanmaken')

@section('scripts')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/facturenselectie.js') }}"></script>
@endsection

@section('content')

    <script>
        $(function () {
            $('#klant_id').filterByText($('#zoekklant'));
        });
    </script>

    @include('search.searchKlantenFactuur')

    <div class="page-header">
        <h1>Nieuw factuur</h1>
    </div>

    {!! Form::open(['route'=>'facturen.store', 'method'=>'post', 'class'=>'form-horizontal']) !!}
    @include('facturen.form', ['btnText'=>'Bewaren'])
    {!! Form::close() !!}
@endsection

