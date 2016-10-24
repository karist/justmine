@extends('layouts.app')
@section('content')
<style>
label{
	display: block;
}
#myForm {
	border-width:5px;	
	border-color: gray;
    border-style: dashed;
    border-radius: 5px;
    padding: 20px;
    min-height: 250px;
}
.element {
    border-radius: 5px;
    padding: 20px;
    width: 100%;
    height: auto;
    position: relative;
}
.removeElement{
     margin-top: 1px;
     margin-right: 1px;
     position:absolute;
     top:0;
     right:0;
}
.highlighted{
	background-color: LightSkyBlue;
}
:disabled{
	background: none;
	/*border: none;*/
}
}
</style>
	<div class="container">
	    <div class="row">
	        <div class="col-md-9">
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                	Preview
	                </div>
	                <div class="panel-body">
	                	<div class ="main_content">
	                		<form role="form" method="post" class="form-inline" action="{{ url('text')}}">
	                			<div class="form-group">
		                			<input type="text" id="pagename" name="pagename" placeholder="Insert Page Name">
		                		</div><br>
		                		<div class="form-group">
									<label for="footers">Footer</label><input type="checkbox" id="footers" name="footers">
								</div>
								<div class="form-group">
									<label for="headers">Header</label><input type="checkbox" id="headers" name="headers">
								</div>
								<div class="form-group">
									<input type="text" id="displaytext" name="displaytext" class="form-control">
								</div>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<button id = "saveText" type="submit" class="btn btn-default">Submit</button>
							</form>
					        <div class="col-md-12">
	                			<h4>Text Templates Elements</h4>
								<!-- <button class="btn btn-default" id="footer">Footer</button> -->
								<!-- <button class="btn btn-default" id="header">Header</button> -->
								<button class="btn btn-default" id="img">Image</button>
								<button class="btn btn-default" id="labels">Label</button>
								<button class="btn btn-default" id="list">List</button>
								<button class="btn btn-default" id="sig">Signature</button>
								<button class="btn btn-default" id="tab">Table</button>
								<button class="btn btn-default" id="text">Text</button>
								<button class="btn btn-default" id="field">Text Field</button>
								<button class="btn btn-danger" id="reset">Reset</button>
	                		</div>
							<div id = "properties" class="col-md-3">	
							</div>

							<!-- This div is meant to display final form. -->
							<div id="myForm" class="col-md-9">
							</div>
						</div>
                	</div>
            	</div>
            </div>
	        <div class="col-md-3">
	            <div class="panel panel-default">
	                <div class="panel-heading">Existing Text Template</div>
	                <div class="panel-body">
	                	<ul class="list-group">
	                        <li class="list-group-item">Cras justo odio</li>
	                        <li class="list-group-item">Dapibus ac facilisis in</li>
	                        <li class="list-group-item">Morbi leo risus</li>
	                        <li class="list-group-item">Porta ac consectetur ac</li>
	                        <li class="list-group-item">Vestibulum at eros</li>
	                        <li class="list-group-item">Cras justo odio</li>
	                        <li class="list-group-item">Dapibus ac facilisis in</li>
	                        <li class="list-group-item">Morbi leo risus</li>
	                        <li class="list-group-item">Porta ac consectetur ac</li>
	                        <li class="list-group-item">Vestibulum at eros</li>
                    	</ul>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
<!-- <script src="{{ URL::asset('js/form.js') }}"></script> -->
<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script src="{{ URL::asset('js/myform.js') }}"></script>
<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/form.css') }}"> -->
@endsection

@section('postJquery')
    @parent
@endsection