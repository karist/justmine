@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
    	<div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">Page Settings</div>
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
            	<form class="form-horizontal" role="form" method="post">
            	 	<input type="hidden" name="_token" value="{{ csrf_token() }}">
				   	<div class="form-group">
						<label class="control-label col-sm-2" for="paper-sz">Paper Size:</label>
				      	<div class="col-sm-2">
							<select class="form-control" id="paper-sz" name="paper-sz">
						    	<option>A5</option>
						  	</select>
					  	</div>
				  	</div>
				  	<div class="form-group">
					  	<label class="control-label col-sm-2" for="margin-tp">Margin:</label>
				      	<div class="col-sm-2">
					      	<input type="number" class="form-control" id="margin-tp" name="margin-tp" placeholder="Top" min="0"> mm
					    </div>
					    <div class="col-sm-2">
					      	<input type="number" class="form-control" id="margin-btm" name="margin-btm" placeholder="Bottom" min="0"> mm
					    </div>
					    <div class="col-sm-2">
					      	<input type="number" class="form-control" id="margin-insd" name="margin-insd"placeholder="Inside" min="0"> mm
					    </div>
					    <div class="col-sm-2">
					      	<input type="number" class="form-control" id="margin-osd" name="margin-osd"placeholder="Outside" min="0"> mm
					    </div>
					    <div class="col-sm-2">
					      	<div class="checkbox">
  								<label><input type="checkbox" id="mirror" name="mirror">Mirrored Margin</label>
							</div>
				    	</div>
				  	</div>
				  	<hr/>
				  	<div class="col-sm-2"><h4> Header </h4></div>
				  	<div class="col-sm-10">
					  	<div class="form-group">
					  		<label class="control-label col-sm-2" for="header-margin">Header Margin: </label>
					  		<div class="col-sm-3">
					  			<input type="number" class="form-control" id="header-margin" name="header-margin" min="0">
					  		</div>
					  		mm
					  	</div>
					  	<div class="col-sm-6">
						  	<div class="form-group">
								<label for="header-left-select">Left Header:</label>
								<select class="form-control" id="header-left-select">
									<option value="blank">Blank</option>
								    <option value="pagenumber">Page Number</option>
								    <option value="publication">Publication Name</option>
								    <option value="chapter">Chapter Name</option>
								    <option value="other">Other</option>
								</select>
								<div id="hl-other"></div>
								<label for="header2-left-select">Left Header II:</label>
								<select class="form-control " id="header2-left-select" disabled>
									<option value="blank">Blank</option>
								    <option value="pagenumber">Page Number</option>
								    <option value="publication">Publication Name</option>
								    <option value="chapter">Chapter Name</option>
								    <option value="other">Other</option>
								</select>
								<div id="hl2-other"></div>
								<input type="checkbox" id="header-left-bold" value="bold"><span class="glyphicon glyphicon-bold"></span>
							    <input type="checkbox" id="header-left-italic" value="italic"><span class="glyphicon glyphicon-italic"></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="header-right-select">Right Header:</label>
								<select class="form-control" id="header-right-select">
									<option value="blank">Blank</option>
								    <option value="pagenumber">Page Number</option>
								    <option value="publication">Publication Name</option>
								    <option value="chapter">Chapter Name</option>
								    <option value="other">Other</option>
								</select>
								<div id="hr-other"></div>
								<label for="header2-right-select">Right Header II:</label>
								<select class="form-control " id="header2-right-select" disabled>
									<option value="blank">Blank</option>
								    <option value="pagenumber">Page Number</option>
								    <option value="publication">Publication Name</option>
								    <option value="chapter">Chapter Name</option>
								    <option value="other">Other</option>
								</select>
								<div id="hr2-other"></div>
								<input type="checkbox" id="header-right-bold" value="bold"><span class="glyphicon glyphicon-bold"></span>
							    <input type="checkbox" id="header-right-italic" value="italic"><span class="glyphicon glyphicon-italic"></span>
							</div>
						</div>
					</div>
					<hr/>
					<div class="col-sm-2"><h4> Footer </h4></div>
				  	<div class="col-sm-10">
					  	<div class="form-group">
					  		<label class="control-label col-sm-2" for="footer-margin">Footer Margin: </label>
					  		<div class="col-sm-3">
					  			<input type="number" class="form-control" id="footer-margin" name="footer-margin"min="0">
					  		</div>
					  		mm
					  	</div>
					  	<div class="col-sm-6">
						  	<div class="form-group">
								<label for="footer-left-select">Left Footer:</label>
								<select class="form-control" id="footer-left-select">
									<option value="blank">Blank</option>
								    <option value="pagenumber">Page Number</option>
								    <option value="publication">Publication Name</option>
								    <option value="chapter">Chapter Name</option>
								    <option value="other">Other</option>
								</select>
								<label for="footer2-left-select">Left Footer II:</label>
								<select class="form-control " id="footer2-left-select" disabled>
									<option value="blank">Blank</option>
								    <option value="pagenumber">Page Number</option>
								    <option value="publication">Publication Name</option>
								    <option value="chapter">Chapter Name</option>
								    <option value="other">Other</option>
								</select>
								<div id="fl2-other"></div>
								<input type="checkbox" id="footer-left-bold" value="bold"><span class="glyphicon glyphicon-bold"></span>
							    <input type="checkbox" id="footer-left-italic" value="italic"><span class="glyphicon glyphicon-italic"></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="footer-right-select">Right Footer:</label>
								<select class="form-control" id="footer-right-select">
									<option value="blank">Blank</option>
								    <option value="pagenumber">Page Number</option>
								    <option value="publication">Publication Name</option>
								    <option value="chapter">Chapter Name</option>
								    <option value="other">Other</option>
								</select>
								<div id="fr-other"></div>
								<label for="footer2-right-select">Right Footer II:</label>
								<select class="form-control " id="footer2-right-select" disabled>
									<option value="blank">Blank</option>
								    <option value="pagenumber">Page Number</option>
								    <option value="publication">Publication Name</option>
								    <option value="chapter">Chapter Name</option>
								    <option value="other">Other</option>
								</select>
								<div id="fr2-other"></div>
								<input type="checkbox" id="footer-right-bold" value="bold"><span class="glyphicon glyphicon-bold"></span>
							    <input type="checkbox" id="footer-right-italic" value="italic"><span class="glyphicon glyphicon-italic"></span>
							</div>
						</div>
				  	</div>
				  	<button type="submit" class="btn btn-default" style="float: right;">Submit</button>
				</form>					
			</div>
        </div>
    	</div>
    	<div class="col-md-7">
    		<div class="panel panel-default">
    		<div class="panel-heading">Preview</div>
    		<div class="panel-body">
	    		<div class="well" id="show">
	    			<div id="show_body"></div>
	    		</div>
	    	</div>
	    	</div>
    	</div>
    </div>
</div>
@endsection

@section('postJquery')
    @parent
    $('#show').css("width", "148mm");
    $('#show').css("height", "210mm");
    $('#show_body').css("width", "100%");
    $('#show_body').css("height", "100%");
    $('#show_body').css("background-color", "lightblue");
    $('#margin-tp').on('change', function(){
    	var sz = $(this).val();
    	$('#show').css("padding-top", sz+"mm");
    	//$('#show-body').css("margin-top", sz+"mm");
    });
    $('#margin-btm').on('change', function(){
    	var sz = $(this).val();
    	$('#show').css("padding-bottom", sz+"mm");
    });
    $('#margin-insd').on('change', function(){
    	var sz = $(this).val();
    	$('#show').css("padding-left", sz+"mm");
    });
    $('#margin-osd').on('change', function(){
    	var sz = $(this).val();
    	$('#show').css("padding-right", sz+"mm");
    });

    $('#header-left-select').on('change', function(e){
    	var value = e.target.value;
    	$('#hl-other').empty();
    	if(value == "other"){
    		$('#hl-other').append('<input type="text" class="form-control" name="header-left-other" placeholder="Type your custom header" />');
    	}
    });
    $('#header-right-select').on('change', function(e){
    	var value = e.target.value;
    	$('#hr-other').empty();
    	if(value == "other"){
    		$('#hr-other').append('<input type="text" class="form-control" name="header-right-other" placeholder="Type your custom header" />');
    	}
    });
    $('#footer-left-select').on('change', function(e){
    	var value = e.target.value;
    	$('#fl-other').empty();
    	if(value == "other"){
    		$('#fl-other').append('<input type="text" class="form-control" name="footer-left-other" placeholder="Type your custom header" />');
    	}
    });
    $('#footer-right-select').on('change', function(e){
    	var value = e.target.value;
    	$('#fr-other').empty();
    	if(value == "other"){
    		$('#fr-other').append('<input type="text" class="form-control" name="footer-right-other" placeholder="Type your custom header" />');
    	}
    });
    $('#header2-left-select').on('change', function(e){
    	var value = e.target.value;
    	$('#hl2-other').empty();
    	if(value == "other"){
    		$('#hl2-other').append('<input type="text" class="form-control" name="header2-left-other" placeholder="Type your custom header" />');
    	}
    });
    $('#header2-right-select').on('change', function(e){
    	var value = e.target.value;
    	$('#hr2-other').empty();
    	if(value == "other"){
    		$('#hr2-other').append('<input type="text" class="form-control" name="header2-right-other" placeholder="Type your custom header" />');
    	}
    });
    $('#footer2-left-select').on('change', function(e){
    	var value = e.target.value;
    	$('#fl2-other').empty();
    	if(value == "other"){
    		$('#fl2-other').append('<input type="text" class="form-control" name="footer2-left-other" placeholder="Type your custom header" />');
    	}
    });
    $('#footer2-right-select').on('change', function(e){
    	var value = e.target.value;
    	$('#fr2-other').empty();
    	if(value == "other"){
    		$('#fr2-other').append('<input type="text" class="form-control" name="footer2-right-other" placeholder="Type your custom header" />');
    	}
    });
    $('#mirror').change(function(){
    	if(this.checked){
    		console.log('checked');
    		$('#header2-right-select').prop('disabled', false);
    		$('#header2-left-select').prop('disabled', false);
    		$('#footer2-right-select').prop('disabled', false);
    		$('#footer2-left-select').prop('disabled', false);
    	} else {
    		$('#header2-right-select').prop('disabled', true);
    		$('#header2-left-select').prop('disabled', true);
    		$('#footer2-right-select').prop('disabled', true);
    		$('#footer2-left-select').prop('disabled', true);
    	}
	});
@endsection