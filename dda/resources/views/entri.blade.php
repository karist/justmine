@extends('layouts.app')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default pull-right">
                <a class="btn btn-primary" href="{{ url('templates/create') }}">Create New</a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Template</div>
                 <ul class="list-group table table-striped">
                 	@foreach($templates as $template)
						<li class="list-group-item">{{ $template->tabno }}	{{ $template->tabtitle }}
							<div class="pull-right">
		                		<a class="btn btn-default btn-sm" href="{{ url('template/edit'.'/'.$template->id) }}"><span class="glyphicon glyphicon-edit"></span></a>
		                		<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#mod-delete-temp"><span class="glyphicon glyphicon-trash"></span></button>
		    				</div>
	    				</li>
					@endforeach
				</ul>
                <div class="pagination pull-right"> {{ $templates->links() }} </div>
            </div>
        </div>
        <div class="col-md-6">
        	<table id="tabhead" border="0">
                <tr>
                    <td class="garis"><b>Tabel</b></td>
                    <td rowspan="2"><input type="text" class="up" id="tabno" name="tabno"readonly> : </td>
                    <td><input type="text" class="up" id="tabname" name="tabname" readonly></td>
                </tr>
                <tr>
                    <td><b><i>Table</i></b></td>
                    <td><input type="text" class="up" id="tabtitle" name="tabtitle" readonly></td>
                </tr>
            </table>
            <div id="container" class="tablePreview">
            </div>
            <div id="tabfooter">
              <label class="down" id="sumberlbl">Sumber</label><i><label class="down" id="sourcelbl"></label></i>: <input type="text" class="up" id="sumber" readonly><p id="slash"></p><i><input type="text" class="up" id="source" readonly></i><br>
              <p class="down" id="cat"></p>
            </div>
        </div>
        <!-- Modal -->
	    <div class="modal fade" id="mod-delete-temp" role="dialog">
	        <div class="modal-dialog">

	          	<!-- Modal content-->
	          	<div class="modal-content">
	            <div class="modal-header">
	              <button type="button" class="close" data-dismiss="modal">&times;</button>
	              <h4 class="modal-title">Delete Confirmation</h4>
	            </div>
	            <div class="modal-body">
	              <p>Are you sure want to delete this table template?</p>
	            </div>
	            <div class="modal-footer">
                	<a class="btn btn-primary" href={{ url('template/delete').'/'.$template->id }}>Yes</a>
                	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	</div>
          	</div>      
    	</div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script src="{{ URL::asset('js/addremovefield.js') }}"></script>
@endsection

@section('postJquery')
$('li').click(function(){
   $id = $(this).val();
});
@endsection