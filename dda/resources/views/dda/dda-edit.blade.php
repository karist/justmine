@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Edit DDA Project</div>
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
            	<form name="tableform" method="POST" role="form" action="{{ url('dda/'.$dda->id)}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input name="_method" type="hidden" value="PUT">
					<div class="form-group">
					  	<label class="control-label col-sm-2" for="level">Level:</label>
					  	<div class="col-sm-10">
					  		<input type="text" class="form-control" name="level" id="name" value="{{ $lvl }}" disabled/>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-2" for="tahun">Tahun:</label>
					  <div class="col-sm-10">
					    <input type="number" class="form-control" name="tahun" id="tahun"  min="2016" max="9999" placeholder="year" value="{{ $dda->tahun }}" disabled/>
					  </div>
					</div>
					<div class="form-group">
					  	<label class="control-label col-sm-2" for="daerah">Nama Daerah:</label>
					  	<div class="col-sm-10">
					    	<input type="text" class="form-control" name="daerah" id="daerah" value="{{ $daerah }}" disabled/>
					  	</div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-2" for="pilih">Select Templates:</label>
					  <div class="col-sm-10">
					    <div class="checkbox">
					    	<label>
					    		<input id="cbx-all" name="cbx-all" type="checkbox" value="all">Select All
					    	</label>
					    </div>
					    <div id="all-templates-div">
					    @foreach($templates as $template)
						    <div class="checkbox col-sm-2">
						    	<label>
						    		<input type="checkbox" value="{{ $template->id }}">{{ $template->tabno }}
						    	</label>
						    </div>
						@endforeach
					    </div>
					  </div>
					</div>
					<input type="hidden" name="selected_templates" id="selected_templates" value="$dda->isi"/>
					<button type="submit" class="btn btn-primary pull-right" id="dda_update" value="Update DDA">Update</button>
        			<a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('home') }}">Back</a>
				</form>
			</div>
        </div>
    </div>
</div>
@endsection

@section('postJquery')
    @parent
    var sel = <?php echo json_encode($dda->isi) ?>;
    var arr = sel.split(',');
   	
   	$('#all-templates-div input[type="checkbox"]').each(function(){
   		var attrib = $(this).attr('value');
   		for(var x = 0 ; x < arr.length ; x++){
   			if(arr[x] == attrib){
   				$(this).attr('checked', true);
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

	$('#dda_update').on('click', function(){
		var selected = [];
		$('#all-templates-div input:checked').each(function(){
			selected.push($(this).val());
		});
		$('#selected_templates').val(selected);
	});
@endsection