@extends('layouts.app')
@section('content')
<script src="{{ URL::asset('js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<style type="text/css">
	.editable{
		width: 100%;
		min-height: 100px;
		border-style: solid;
		border-width: 1px;
	}
</style>
<div class="container">
    <div class="row">
    	<div class="col-md-4">
            <div class="panel panel-default">
            	<div class="panel-heading">Existing Narration</div>
            	<div class="panel-body">
            		<table class="table table-bordered table-striped table-hover category-table" data-toggle="dataTable" data-form="deleteForm">
                        <tbody>
                            @foreach($narasis as $narasi)
                                <tr>
                                    <td>{{ $narasi->bab }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            	</div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
            	<div class="panel-heading">Template</div>
            	<div class="panel-body">
            		<form action="{{ url('narasi')}}" method="POST" role="form">
						<legend>Entry Narration</legend>

						<div class="form-group">
							<label for="">Bab</label>
							<select name="dd_bab" id="dd_bab" class="form-control" required="required">
								<option>Choose here</option>
		                        @foreach($babs as $bab)
		                            <option value="{{ $bab->id }}">{{ $bab->nama_bab }}</option>
		                        @endforeach
							</select>
						</div>

						<div class="col-md-6">
						<label for="narr_in">Narration in Bahasa</label>
						<input type="hidden" id="narr_in" name="narr_in"/>
							<div class = "editable">
							</div>
						</div>
						<div class="col-md-6">
						<label for="narr_eng">Narration in English</label>
						<input type="hidden" id="narr_eng" name="narr_eng"/>
							<div class = "editable">
							</div>
						</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<button type="submit" id="showtext" class="btn btn-primary pull-right">Submit</button>
						<button type="button" id="translate_btn" class="btn btn-default pull-right">Translate</button>
					</form>
            	</div>
            </div>
        </div>
    </div>
</div>
<script>
    tinymce.init({
		selector: 'div.editable',
	  	inline: true,

	  	plugins: [
	    "image lists",
		],
		toolbar1: 'bold italic underline strikethrough | subscript superscript',
		toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ',
		toolbar3: ' undo redo image',
		menubar: false
		});
    $('#showtext').on('click', function(e){
    	for (i=0; i < tinyMCE.editors.length; i++){
		    var content = tinyMCE.editors[i].getContent();
		    i==0 ? $('#narr_in').val(content) : $('#narr_eng').val(content);
		}
    });
 //    $('#dd_bab').change(function(e){
	//     var id = e.target.value;
	//     $('#dd_sub').empty();
	//     //ajax
	//     $.get('/ajax-subbab?id='+ id, function(data){
	//         $.each(data, function(index, subbab){
	//             $('#dd_sub').append('<option value='+subbab.id_sub+'>'+subbab.nama_sub+'</option>');
	//         });
	//     });
	// });
	$('#translate_btn').on('click', function(){
        var input_text = tinyMCE.activeEditor.getContent({format : 'text'});
        if(input_text != ''){
            $.get('/ajax-translate?input_text='+ input_text, function(data){
                alert(JSON.stringify(data));
            });
        }
    });
</script>
@endsection