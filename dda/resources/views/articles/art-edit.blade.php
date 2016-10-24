@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Sunting Artikel</div>
                <div class="panel-body">
                    @if(Session::has('success'))
                        {!! Session::get('success') !!}
                    @endif

                    <div class="alert-warning">
                        @foreach( $errors->all() as $error )
                           <br> {{ $error }}
                        @endforeach
                    </div>

                    {!! Form::open(['action'=>'ArticlesController@update']) !!}

                    <div class="form-group">
                        {!! Form::label('title', 'Judul:') !!}
                        {!! Form::text('title', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Isi:') !!}
                        {!! Form::textarea('description', null, ['class'=>'form-control', 'rows'=>5] ) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Save', array( 'class'=>'btn btn-primary form-control' )) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection