@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">					
                @foreach($articles as $article)
                	<h2><a href="{{ route('articles.show', array($article->id)) }}">{{ $article->title }}</a></h2>
                	<h6>{{ $article->created_at }}</h6>
                	<p> {!! substr(html_entity_decode($article->text),0,500) !!}
                    <br><a href="{{ url('articles/'.$article->id) }}">Read More...</a></p>
                	<hr>
                @endforeach
                <div class="pagination pull-right"> {!! $articles->links() !!} </div>
				</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (Auth::user())
                        <a class="btn btn-primary pull-right" href="{{ url('articles/create') }}" role="button">Buat Artikel</a>
                    @endif<br><br>
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