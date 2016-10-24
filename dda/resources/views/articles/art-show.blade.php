@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">					
                    <h1><b>{{ $article->title }}</b></h1>
                    <br>
                    <h6>{{ $article->created_at }}</h6>
                    <p>{!! $article->text !!}</p>
                    <hr>
                    @if(Auth::user()->isAdmin)
                        <!-- <a class="btn btn-default pull-right" href="{{ route('articles.edit', $article->id) }}"><span class="glyphicon glyphicon-edit"></span></a> -->
                        {!! Form::model($article, ['method' => 'delete', 'route' => ['articles.destroy', $article->id], 'class' =>'form-inline form-delete']) !!}
                            {!! Form::hidden('id', $article->id) !!}
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', array('type' => 'submit', 'class' => 'pull-right btn btn-danger delete', 'name' => 'delete_modal' )) !!}
                        {!! Form::close() !!}
                    @endif
				</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">     
                    @if (Auth::user())
                        <a class="btn btn-primary pull-right" href="{{ url('articles/create') }}" role="button">Buat Artikel</a>
                    @endif
                    <br><br>
                    <h2><b>Artikel Lainnya</b></h2>               
                    <div class="list-group">
                        @foreach($articles as $art)
                            <hr>
                            <a href="{{ route('articles.show', array($art->id)) }}">{{ $art->title }}</a>
                            <h6 class="pull-right">{{ $art->created_at }}</h6>
                        @endforeach
                    </div>
                    <div class="pagination pull-right"> {{ $articles->links() }} </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('postJquery')
    @parent
@endsection