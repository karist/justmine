@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">	
                <h1>Daerah Dalam Angka</h1>
				<p>Pendistribusian publikasi DDA baik softcopy maupun hardcopy sudah harus diterima pusat cq. Subdit Publikasi dan Kompilasi Statistik selambat-lambatnya pada <b>30 November</b> pada tahun berjalan</p>
				</div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                	<table class="table table-striped">
				    <thead>
				      <tr>
				        <th>Nama DDA</th>
                        <th>Tahun</th>
                        <th>Status</th>
				        <th>Ubah</th>
				      </tr>
				    </thead>
				    <tbody>
				    	<tr>
				    		<td></td>
				    		<td></td>
				    		<td></td>
				    		<td><a class="btn btn-info btn-sm pull-right" href="#"><span class="glyphicon glyphicon-trash"></span></a>
				    			<a class="btn btn-info btn-sm pull-right" href="#"><span class="glyphicon glyphicon-download"></span></a>
                				<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#mod-delete-stub"><span class="glyphicon glyphicon-edit"></span></button>
                			</td>
				    	</tr>
				    </tbody>
				</table>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('postJquery')
    @parent
@endsection