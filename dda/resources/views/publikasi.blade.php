<!-- halaman entri tabel dari template yang sudah ada -->

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Daftar Publikasi</div>
                <div class="panel-body">
                	@foreach( $publikasi as $p )
                        <p>{{$p->title}}</p>
					@endforeach
                    @foreach( $ddas as $d )
                        <p>{{$d->id}}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection