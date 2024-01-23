@extends('layouts.main')

@section('title', 'Logs')

@section('content')

        <h2>Logs</h2>
        <table class="table table-striped log">

        @foreach($logs as $la)
            <tr>
                <td>
                    {{ $la->created_at }}
                </td>
                <td>
                    {{ $la->description }}
                </td>
            </tr>
        @endforeach
        </table>

{{ $logs->links() }}
@endsection