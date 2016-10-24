<style type="text/css">
	.scrollbar{
		width: 100%;
	    height: 250px;
	    overflow: scroll;
	}
</style>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal">&times;</button>
	        	<h4 class="modal-title">Tambah Stub</h4>
	    	</div>
	    	<div class="modal-body">
	        @if (count($errors) > 0)
	        	<div class="alert alert-danger">
	            	<ul>
	              	@foreach ($errors->all() as $error)
	                	<li>{{ $error }}</li>
	              	@endforeach
	            	</ul>
	          	</div>
	        @endif
	        	<form name="codexworld_frm" method="post" class="form-horizontal" role="form">
	          		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	          		<div class="form-group">
	              		<label class="control-label col-sm-2" for="stub_nama">Nama Stub:</label>
	              		<div class="col-sm-10">
	                		<input type="text" class="form-control" name="stub_nama" id="stub_nama" required>
	              		</div>
	          		</div>	
	          		<div class="form-group">
	              		<label class="control-label col-sm-2" for="stub_label">Label Stub:</label>
	              		<div class="col-sm-10">
	                		<input type="text" class="form-control" name="stub_label" id="stub_label" required>
	              		</div>
	          		</div>
	          		<div class="form-group">
	              		<label class="control-label col-sm-2" for="stub_english"><i>Label Stub (English):</i></label>
	              		<div class="col-sm-10">
	                		<input type="text" class="form-control" name="stub_english" id="stub_english">
	              		</div>
	          		</div>
	          		<div class="form-group">
	              		<label class="control-label col-sm-2" for="tipe">Tipe:</label>
	              		<div class="col-sm-10">
	                		<select class="form-control" name="tipe" id="tipe" required>
	                			<option>Static</option>
	                			<option>Dynamic</option>
	                		</select>
	              		</div>
	          		</div>
	          		<div class="form-group">
	              		<label class="control-label col-sm-2" for="stub_detail">Detil Stub:</label>
	              		<div class="col-sm-10">
	                		<a class="add_button" title="Add field" id="add">Tambah Isian</a>
	                		<div class="scrollbar">
	                    		<div class="force-overflow">
	                        		<div class="field_wrapper">
	                            		<div>
	                              			<div class="col-sm-5">
	                                			<input placeholder="Istiah dalam Bahasa" type="text" class="form-control" name="field_indo[]"/>
	                              			</div>
	                              			<div class="col-sm-5">
	                                			<input placeholder="English Term" type="text" class="form-control" name="field_eng[]"/>
	                              			</div>
	                            		</div>
	                        		</div>
	                    		</div>
	                		</div>
	              		</div>
	          		</div>
	      	</div>
	      	<div class="modal-footer">
	      		<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
	        	<button type="submit" class="btn btn-primary" id="stub_save" value="Save Stub">Simpan</button></form>
	      	</div>
	    </div>
	</div>
</div>