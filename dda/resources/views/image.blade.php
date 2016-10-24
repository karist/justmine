<!-- halaman entri tabel dari template yang sudah ada -->

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Daftar Gambar</div>
                <div class="panel-body">
                	@foreach( $images as $image )
    					<img src="{!! '/images/'.$image->filePath !!}" height="250" width="250">
					@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection