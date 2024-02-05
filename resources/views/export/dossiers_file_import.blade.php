@extends('layouts.main')

@section('title', 'Dossiers Import')

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#uploadbutton").click(function () {
                if( document.getElementById("dossier_file").files.length == 0 ){
                    alert("Je moet eerst een bestand kiezen !");
                    return false;
                }
                else {
                    $('#loading').css('display', 'block');
                    return true;
                }
            });
        });
    </script>

@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <h1>Dossiers Import Testing</h1>
        </div>
    </div>

    {!! Form::open(['route'=>'dossiers.import', 'method'=>'post', 'class'=>'form-horizontal', 'files'=>'true']) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                {!! Form::label('dossier_file','Kies bestand om te importeren:',['class'=>'col-md-3']) !!}
                <div class="col-md-9">
                    {!! Form::file('dossier_file', array('class' => 'form-control')) !!}
                    {!! $errors->first('dossier_file', '<p class="alert alert-danger">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            {!! Form::submit('Upload',['class'=>'btn btn-primary', 'id'=>'uploadbutton']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    <div id="loading" style="display: none" >
        <div>
            <img src="images/loading_spinner.gif" alt="" />
        </div>
    </div>

    <div id="search-results">
    </div>

@endsection