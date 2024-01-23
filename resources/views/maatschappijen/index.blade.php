@extends('layouts.main')

@section('title', 'Maatschappijen')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('maatschappijen.create') }}" class="btn btn-primary">Maak nieuwe maatschappij aan</a>
        </div>
    </div>

    @if ($maatschappijen->IsEmpty())
        <p>Er zijn nog geen maatschappijen aanwezig !</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Maatschappij</th>
                <th>Telefoon</th>
                <th>Website</th>
            </tr>
            </thead>
            <tbody>
            @foreach($maatschappijen as $maatschappij)
                <tr>
                    <td><a href="{{ route('maatschappijen.edit', $maatschappij->id) }}">{{ $maatschappij->naam }}</a></td>
                    <td>{{ $maatschappij->telefoon }}</td>
                    <td>{{ $maatschappij->website }}</td>
                </tr>
            @endforeach

            {{ $maatschappijen->links() }}
            </tbody>
        </table>
    @endif
@endsection