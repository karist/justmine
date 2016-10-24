@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Unggah Gambar</div>
                <div class="panel-body">
                    @if(Session::has('success'))
                        {!! Session::get('success') !!}
                    @endif

                    <div class="alert-warning">
                        @foreach( $errors->all() as $error )
                           <br> {{ $error }}
                        @endforeach
                    </div>

                    {!! Form::open(['action'=>'ImageController@store', 'files'=>true]) !!}

                    <div class="form-group">
                        {!! Form::label('title', 'Title:') !!}
                        {!! Form::text('title', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Description:') !!}
                        {!! Form::textarea('description', null, ['class'=>'form-control', 'rows'=>5] ) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('image', 'Choose an image') !!}
                        {!! Form::file('image') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Save', array( 'class'=>'btn btn-danger form-control' )) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection