@extends('admin.admin')

@section('contentAdmin')

<style type="text/css">
	#exTab2 h3 {
	  color : white;
	  background-color: #428bca;
	  /*padding : 5px 15px;*/
	}
	.tab-content {
		width: 100%;
	}

	tbody {
	    display:block;
	    height:200px;
	    overflow:auto;
	}
	thead, tbody tr {
	    display:table;
	    width:100%;
	    table-layout:fixed;
	}
	thead {
	    width: calc( 100% - 1em )
	}
</style>
<div class="panel-body"><h2>Master Daerah</h2></div>
	<div id="exTab2" class="panel-body">	
	<ul class="nav nav-tabs">
		<li class="active">
	        <a  href="#1" data-toggle="tab">Provinsi</a>
		</li>
		<li>
			<a href="#2" data-toggle="tab">Kabupaten/Kota</a>
		</li>
		<li>
			<a href="#3" data-toggle="tab">Kecamatan</a>
		</li>
		<li>
			<a href="#4" data-toggle="tab">Desa</a>
		</li>
		<li>
			<a href="#5" data-toggle="tab">Tambah Daerah</a>
		</li>
	</ul>

	<div class="tab-content ">
		<div class="tab-pane active" id="1">
			<div class="form-group">
				<label for="filter" class="col-sm-2 control-label">Filter:</label>
				<div class="col-sm-10">
					<input type="text" name="filter" id="filter" class="form-control" placeholder="Tik di sini...">
				</div>
			</div>
	        <table class="table table-hover">
	        	<thead>
	        		<tr>
	        			<th>Kode Provinsi</th>
	        			<th>Nama Provinsi</th>
	        		</tr>
	        	</thead>
	        	<tbody class="searchable">
	        		@foreach($provinsis as $prov)
	        		<tr>
	        			<td>{{ $prov->kode_prov }}</td>
	        			<td>{{ $prov->nama_prov }}</td>
	        		</tr>
	        		@endforeach
	        	</tbody>
	        </table>
	        
		</div>
		
		<div class="tab-pane" id="2">
			<div class="form-group">
				<label for="filterKab" class="col-sm-2 control-label">Filter:</label>
				<div class="col-sm-10">
					<input type="text" name="filterKab" id="filterKab" class="form-control" placeholder="Tik di sini...">
				</div>
			</div>
	        <table class="table table-hover">
	        	<thead>
	        		<tr>
	        			<th>Kode Kota/Kabupaten</th>
	        			<th>Nama Kota/Kabupaten</th>
	        		</tr>
	        	</thead>
	        	<tbody class="searchable2">
	        		@foreach($kabs as $kab)
	        		<tr>
	        			<td>{{ $kab->id }}</td>
	        			<td>{{ $kab->nama_kabkot }}</td>
	        		</tr>
	        		@endforeach
	        	</tbody>
	        </table>
		</div>

	    <div class="tab-pane" id="3">
	    	<div class="form-group">
				<label for="filterKec" class="col-sm-2 control-label">Filter:</label>
				<div class="col-sm-10">
					<input type="text" name="filterKec" id="filterKec" class="form-control" placeholder="Tik di sini...">
				</div>
			</div>
	        <table class="table table-hover">
	        	<thead>
	        		<tr>
	        			<th>Kode Kecamatan</th>
	        			<th>Nama Kecamatan</th>
	        		</tr>
	        	</thead>
	        	<tbody class="searchable3">
	        		@foreach($kecs as $kec)
	        		<tr>
	        			<td>{{ $kec->id }}</td>
	        			<td>{{ $kec->nama_kec }}</td>
	        		</tr>
	        		@endforeach
	        	</tbody>
	        </table>
		</div>

		<div class="tab-pane" id="4">
			<div class="col-sm-12 col-md-3">
				<select class="form-control" id="select_prov" name="select_prov">
	                <option>Pilih Provinsi</option>
	                @foreach($provinsis as $provinsi)
	                    <option value="{{ $provinsi->kode_prov }}">{{ $provinsi->nama_prov }}</option>
	                @endforeach
	            </select>
            </div>
            <div class="col-sm-12 col-md-3">
	            <select class="form-control" id="select_kab" name="select_kab">
	                <option>Pilih Kabupaten/Kota</option>
	            </select>
	        </div>
	        <div class="col-sm-12 col-md-3">
	            <select class="form-control" id="select_kec" name="select_kec">
	                <option>Pilih Kecamatan</option>
	            </select>
	        </div>
	        <div class="col-sm-12 col-md-3">
            	<button type="button" class="btn btn-default" id="tampil_desa">Tampilkan desa</button>
            </div>
            <hr>
            <div class="form-group">
				<label for="filterDesa" class="col-sm-2 control-label">Filter:</label>
				<div class="col-sm-10">
					<input type="text" name="filterDesa" id="filterDesa" class="form-control" placeholder="Tik di sini...">
				</div>
			</div>
	        <table class="table table-hover" id="tabel_desa">
	        	<thead>
	        		<tr>
	        			<th>Kode Desa</th>
	        			<th>Nama Desa</th>
	        		</tr>
	        	</thead>
	        	<tbody class="searchable4">
	        		
	        	</tbody>
	        </table>
		</div>
		<div class="tab-pane" id="5">
			@if (count($errors) > 0)
	        	<div class="alert alert-danger">
	            	<ul>
	              	@foreach ($errors->all() as $error)
	                	<li>{{ $error }}</li>
	              	@endforeach
	            	</ul>
	          	</div>
	        @endif
	        @if(Session::has('success'))
                <div class="alert alert-success">
                {!! Session::get('success') !!}
                </div>
            @endif
			<form action="{{ url('/admin/daerah/add') }}" method="POST" role="form">
				<select name="tingkat" id="inputTingkat" class="form-control" required="required">
					<option value="1">Provinsi</option>
					<option value="2">Kabupaten/Kota</option>
					<option value="3">Kecamatan</option>
					<option value="4">Desa</option>
				</select>
				<div class="form-group">
					<label for="kode">Kode Daerah</label>
					<input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode daerah">
				</div>
				
				<div class="form-group">
					<label for="nama">Nama Daerah</label>
					<input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama daerah">
				</div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection
@section('postJquery')
	$('#filter').keyup(function () {
        var rex = new RegExp($(this).val(), 'i');
        $('.searchable tr').hide();
        $('.searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();

    });
    $('#filterKab').keyup(function () {
        var rex = new RegExp($(this).val(), 'i');
        $('.searchable2 tr').hide();
        $('.searchable2 tr').filter(function () {
            return rex.test($(this).text());
        }).show();

    });
    $('#filterKec').keyup(function () {
        var rex = new RegExp($(this).val(), 'i');
        $('.searchable3 tr').hide();
        $('.searchable3 tr').filter(function () {
            return rex.test($(this).text());
        }).show();

    });
    $('#filterDesa').keyup(function () {
        var rex = new RegExp($(this).val(), 'i');
        $('.searchable4 tr').hide();
        $('.searchable4 tr').filter(function () {
            return rex.test($(this).text());
        }).show();

    });
    $('#select_prov').on('change', function(e){
    	var id = e.target.value;
    	$("#select_kab").empty();
    	$.get('/ajax-kabkot?id='+ id, function(datas){
            $.each(datas, function(i, data){
                $("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
            });
        });
    });

    $('#select_kab').on('change', function(e){
    	var id = e.target.value;
    	$("#select_kec").empty();
       	$.get('/ajax-kec?id='+ id, function(datas){
            $.each(datas, function(i, data){
                $("#select_kec").append('<option value="'+data.id+'">'+data.nama_kec+'</option>');
            });
        });
    });

    $('#tampil_desa').on('click', function(){
    	var kec = $('#select_kec').val();
    	$('#tabel_desa tbody').empty();
    	$.ajax({
         type: 'get',
         url: '/desa',
         data: {kec:kec},
         success: function(datas){
         	$.each(datas, function(i, data){
         		var text = '<tr>';
	         	text += '<td>'+data.id+'</td>';
	         	text += '<td>'+data.nama_kel+'</td>';
	         	text += '</tr>';
	         	$('#tabel_desa tbody').append(text);
            });
        }
      });
    });
@endsection