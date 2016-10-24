<style type="text/css">
	#all-templates-div{
		width: 100%;
    	height: 300px;
    	overflow: scroll;
	}
</style>
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Create A New DDA Project</div>
            <div class="panel-body">
            	@if(Session::has('success'))
			        <div class="alert alert-success">
			        {!! Session::get('success') !!}
			        </div>
			    @endif
            	@if (count($errors) > 0)
		        	<div class="alert alert-danger">
		            	<ul>
		              	@foreach ($errors->all() as $error)
		                	<li>{{ $error }}</li>
		              	@endforeach
		            	</ul>
		          	</div>
		        @endif					
            	<form name="tableform" method="POST" role="form" action="{{ url('dda')}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
		            <div class="form-group">
		                <label class="control-label col-sm-2" for="tingkat">Tingkat</label>
		                    <div class="col-sm-10">
		                        <select class="form-control" id="tingkat" name="tingkat">
		                            <option value="">Pilih tingkatan DDA</option>
		                            @foreach($levels as $level)
		                                <option value="{{ $level->id }}">{{ $level->keterangan }}</option>
		                            @endforeach
		                        </select>
		                    </div>
		            </div>

		            <div class="form-group">
		                <label class="control-label col-sm-2" for="daerah">Daerah</label>
		                <div class="col-sm-3">    
		                    <select class="form-control" id="select_prov" name="select_prov">
		                        <option>Pilih Provinsi</option>
		                        @foreach($provinsis as $provinsi)
		                            <option value="{{ $provinsi->kode_prov }}">{{ $provinsi->nama_prov }}</option>
		                        @endforeach
		                    </select>
		                </div>
		                <div class="col-sm-3">
		                    <select class="form-control" id="select_kab" name="select_kab" disabled>
		                        <option>Pilih Kabupaten/Kota</option>
		                    </select>
		                </div>
		                <div class="col-sm-3">
		                    <select class="form-control" id="select_kec" name="select_kec" disabled>
		                        <option>Pilih Kecamatan</option>
		                    </select>
		                </div>
		            </div>

<!-- 					<div class="form-group">
					  	<label class="control-label col-sm-2" for="level">Level</label>
					  	<div class="col-sm-10">
            				<input class="form-control" type="text" name="level" id="level" value="{{ $lvl }}" />
            			</div>
					</div> -->
					<!-- <div class="form-group">
					  	<label class="control-label col-sm-2" for="level">Region</label>
					  	<div class="col-sm-10">
            				<input class="form-control" type="text" name="level" id="level" value="{{ $daerah }}" />
            			</div>
					</div> -->
					<div class="form-group">
					  	<label class="control-label col-sm-2" for="tahun">Tahun</label>
					  	<div class="col-sm-10">
					    	<input type="number" class="form-control" name="tahun" id="tahun"  min="2016" max="9999" placeholder="year" />
					  	</div>
					</div>
					<div class="form-group">
					  	<label class="control-label col-sm-2" for="pilih">Pilih Templat:</label>
					  	<div class="col-sm-10">
					    	<div class="checkbox">
					    		<label>
					    			<input id="cbx-all" name="cbx-all" type="checkbox" value="all">Pilih semua
					    		</label>
					    	</div>
					    <div id="all-templates-div">
					    	@foreach($templates as $template)
						    <div class="checkbox col-sm-12">
						    	<label>
						    		<input type="checkbox" value="{{ $template->id }}">{{ $template->tabno }} {!! $template->tabtitle !!}
						    	</label>
						    </div>
						    @endforeach
					    </div>
					  </div>
					</div>
					<input type="hidden" name="selected_templates" id="selected_templates"/>
					<button type="submit" class="btn btn-primary pull-right" id="dda_create" value="Create DDA">Create DDA</button>
        			<a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('home') }}">Back</a>
				</form>
			</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#tingkat').on('change', function(e){
        var id = e.target.value;
        if(id != "1"){
            $("#select_kab").prop('disabled', false);
            if(id == "4"){
                $("#select_kec").prop('disabled', false);
            } else {
                $("#select_kec").prop('disabled', true);
            }
        } else {
            $("#select_kab").prop('disabled', true);
            $("#select_kec").prop('disabled', true);
        }
    });

    $('#select_prov').on('change', function(e){
        if(!$("#select_kab").prop( "disabled" )){
            var id = e.target.value;
            $("#select_kab").empty();
            var l = $("#tingkat").val();
            if(l == 2){
                $.get('/ajax-kab?id='+ id, function(datas){
                    $.each(datas, function(i, data){
                        $("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
                    });
                });
            } else if (l == 3){
                $.get('/ajax-kota?id='+ id, function(datas){
                    $.each(datas, function(i, data){
                        $("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
                    });
                });
            } else {
                $.get('/ajax-kabkot?id='+ id, function(datas){
                    $.each(datas, function(i, data){
                        $("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
                    });
                });
            }
        }
    });

    $('#select_kab').on('change', function(e){
        if(!$("#select_kec").prop( "disabled" )){
            var id = e.target.value;
            $("#select_kec").empty();
            //ajax
            $.get('/ajax-kec?id='+ id, function(datas){
                $.each(datas, function(i, data){
                    $("#select_kec").append('<option value="'+data.id+'">'+data.nama_kec+'</option>');
                });
            });
        }
    });
</script>
@endsection

@section('postJquery')
    @parent
    $('#level').on('change', function(e){
    	var id = e.target.value;
    	if(id != "1"){
    		$("#select_kab").prop('disabled', false);
    		if(id == "4"){
    			$("#select_kec").prop('disabled', false);
    		} else {
    			$("#select_kec").prop('disabled', true);
    		}
    	} else {
    		$("#select_kab").prop('disabled', true);
    		$("#select_kec").prop('disabled', true);
    	}
    });

    $('#select_prov').on('change', function(e){
    	if(!$("#select_kab").prop( "disabled" )){
    		var id = e.target.value;
	    	$("#select_kab").empty();
	    	var l = $("#level").val();
	    	if(l == 2){
		    	$.get('/ajax-kab?id='+ id, function(datas){
			    	$.each(datas, function(i, data){
			    		$("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
			    	});
			    });
	    	} else if (l == 3){
	    		$.get('/ajax-kota?id='+ id, function(datas){
			    	$.each(datas, function(i, data){
			    		$("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
			    	});
			    });
	    	} else {
	    		$.get('/ajax-kabkot?id='+ id, function(datas){
			    	$.each(datas, function(i, data){
			    		$("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
			    	});
			    });
	    	}
    	}
    });

    $('#select_kab').on('change', function(e){
    	if(!$("#select_kec").prop( "disabled" )){
    		var id = e.target.value;
	    	$("#select_kec").empty();
		   	//ajax
		    $.get('/ajax-kec?id='+ id, function(datas){
		    	$.each(datas, function(i, data){
		    		$("#select_kec").append('<option value="'+data.id+'">'+data.nama_kec+'</option>');
		    	});
		    });
    	}
    });

    $('#cbx-all').on('change', function(e){
    	if(this.checked) {
 			$('#all-templates-div').find('input[type="checkbox"]').each(function(){
 				$(this).prop('checked', true);
 			});
		} else {
			$('#all-templates-div').find('input[type="checkbox"]').each(function(){
 				$(this).prop('checked', false);
 			});
		}
    });

	$('#dda_create').on('click', function(){
		var selected = [];
		$('#all-templates-div input:checked').each(function(){
			selected.push($(this).val());
		});
		$('#selected_templates').val(selected);
	});
@endsection