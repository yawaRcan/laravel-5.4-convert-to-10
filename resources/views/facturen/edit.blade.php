@extends('layouts.main')

@section('title', 'Factuur ' . $factuur->factuurnummer)

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
        <div class="row">
            <div class="col-lg-10"><h1>Factuur</h1></div>
            <div class="col-lg-2"><a href="{{ route('facturen.home') }}" class="btn btn-primary">Terug</a></div>
        </div>
    </div>

    {!! Form::model($factuur, ['route'=>['facturen.update', $factuur->id], 'method'=>'post', 'class'=>'form-horizontal']) !!}

    @include('facturen.form', ['btnText'=>'Bewaren'])

    {!! Form::close() !!}
@endsection