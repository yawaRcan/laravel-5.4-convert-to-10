@extends('layouts.main')

@section('title', 'Export')

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <h1>Export</h1>
        </div>
    </div>

    @if(isset($record_found) && $record_found==0)
        No record found.
    @endif

@endsection