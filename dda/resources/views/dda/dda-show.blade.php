<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
@extends('layouts.app')
@section('content')
<style type="text/css">
table td{
    border: solid;
}
#tempfld{
    width: 100%;
    height: 300px;
    overflow: scroll;
}
</style>
<script type="text/javascript">

$(function() {
    var arr_object = JSON.parse('{"tables":[]}');
    showTable();
    function update(source, id){
    // dataFromDB();
    stub = source.table.stubname;
    column = source.table.column;
    kolom = stub.concat(column);
    $('#table_column').val(colnames(kolom));
    $('#table_data').val(JSON.stringify(source.data));
    $('#table_stub').val(source.table.stubname[0]);

    var options = {
        source: source.data,
        rowClass: "classy",
        callback: function(){}
    };
    var testTable = $("<table></table>");
    var keys = kolom;
    testTable.jsonTable({
        head : kolom,
        json : keys // The '*' identity will be incremented at each line
    });
    testTable.jsonTableUpdate(options);
    $('#'+id).empty();
    $('#'+id).append(testTable);
  }

  function colnames(subMenuItems) {
    if (subMenuItems) {
      var arr = [];
      for (var i = 0; i < subMenuItems.length; i++) {
        if (typeof subMenuItems[i] != null && typeof subMenuItems[i] === 'object') {
          var found = colnames(subMenuItems[i].subcol);
          arr = arr.concat(found);
        } else {
          arr.push(subMenuItems[i]);
        }   
      }
      return arr;
    }
  };
  $('#lihat_pdf').click(function(){
    var dda_id = "<?php echo $id; ?>"; 
    var url = "{{ URL::route('result',array('id'=>$dda->id, 'tab'=>tabel)) }}";
    url = url.replace('dda_id', dda_id);
    url = url.replace('tabel', JSON.stringify(arr_object));
    window.location.href = url;
  });
  $('#unduh_pdf').click(function(){
    var dda_id = "<?php echo $id; ?>"; 
    var url = "{{ URL::route('result',array('download'=>'pdf', 'id'=>$dda->id, 'tab'=>tabel)) }}";
    url = url.replace('dda_id', dda_id);
    url = url.replace('tabel', $('#arr_object').val());
    window.location.href = url;
  });
  function showTable(){
    $('.tablePreview').each(function(){
    // $(this).append('hereeeeee '+$(this).attr('id'));
    var dda_id = "<?php echo $id; ?>";
    var id = $(this).attr('id');
    var source = JSON.parse($('#text'+id).val());
    //ajax
      $.ajax({
        type: 'get',
        url: '/aj',
        data: {id:dda_id, table:id},
        success: function(data2){
          source.data = JSON.parse(data2);
          update(source,id);
          var obj = {};
          obj['id'] = id;
          obj['html'] = $('#'+id).html();
          arr_object.tables.push(obj);
          $('#arr_object').val(JSON.stringify(arr_object));
        },
        error: function(){
        }
      });
    });  
  }
});
</script>
<div class="container">
@foreach($templates as $t)
      <div class="tablePreview" id="{{ $t->id }}" style="display: none;">{{ $t->id }}</div>
      <input type="hidden" id="text{{$t->id}}" value="{{$t->tabtemplate}}">
@endforeach

    <div class="row">
        <div id="contents">
        </div>
        <div id="editor"></div>
        <!-- <button id="cmd">generate PDF</button> -->
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Project Pane</div>
            <div class="panel-body">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                    {!! Session::get('success') !!}
                    </div>
                @endif
	            <form method="POST" class="form-horizontal" role="form" action="{{ url('dda/'.$dda->id.'/generate')}}">
            		<div class="form-group">
            			<label class="control-label col-sm-2" for="tingkatfld">Tingkat:</label>
            			<div class="col-sm-10">
            				<input class="form-control" type="text" name="tingkatfld" id="tingkatfld" value="{{ $lvl }}" disabled/>
            			</div>
            		</div>
            		<div class="form-group">
            			<label class="control-label col-sm-2" for="tahunfld">Tahun:</label>
            			<div class="col-sm-10">
            				<input class="form-control" type="text" name="tahunfld" id="tahunfld" value="{{ $dda->tahun }}" disabled/>
            			</div>
            		</div>
            		<div class="form-group">
            			<label class="control-label col-sm-2" for="daerahfld">Daerah:</label>
            			<div class="col-sm-10">
      						<input class="form-control" type="text" name="daerahfld" id="daerahfld" value="{{ $daerah }}" disabled/>
      					</div>
            		</div>

					<div class="form-group">
            			<label class="control-label col-sm-2" for="tempfld">Templates:</label>
            			<div id="all-templates-div" class="col-sm-10">
      						<ul class="list-group" id="tempfld" name="tempfld">
                                @foreach($templates as $template)
                                    <li class="col-sm-12 list-group-item" id="{{ $template->id }}">{{ $template->tabno }} {{ str_replace(['$level','$daerah','$tahun'], [$lvl, $daerah,$tahun], $template->tabtitle) }}</li>
                                @endforeach
      						</ul>
      					</div>
            		</div>
                    <input type="hidden" name="tabel" id="tabel"/>
                    <input type="hidden" name="arr_object" id="arr_object"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
            		<div class="form-group">
            			<div class="col-sm-10 col-sm-offset-2">
                            <a id="lihat_pdf">Lihat PDF</a>
                            <a id="unduh_pdf">Unduh PDF</a>
                            <!-- <a href="{{ URL::route('publish',array('id'=>$dda->id)) }}">Simpan PDF</a> -->
            				<button type="submit" id="generate" class="btn btn-primary pull-right">Ekspor</button>
            				<!-- <a type="button" class="btn btn-default pull-right" id="layout" value="Layout" href="{{ url('dda/'.$dda->id.'/layout') }}">Tata Letak</a> -->
                            <a class="btn btn-default btn-default pull-right entry" href="{{ url('dda/'.$dda->id.'/entry') }}">Entri DDA</a>
            				<a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('home') }}">Kembali</a>
            			</div>
            		</div>
                    <form method="POST" class="form-horizontal" role="form" action="{{ url('dda/'.$dda->id.'/generate')}}">
                        <!-- <button type="submit" id="generate" class="btn btn-primary pull-right">Buat Ms. Word</button> -->
                    </form>
	            </form>
            </div>
        </div>
    </div>

<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/entry.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
<!-- <script src="https://code.jquery.com/jquery.min.js"></script> -->
<!-- <script src="{{ URL::asset('js/jspdf.js')}}"></script> -->

@endsection

@section('postJquery')
    @parent
    $('[data-toggle="tooltip"]').tooltip();   
    var id = <?php echo($dda->id) ?>;
    // var sel = <?php echo json_encode($dda->isi) ?>;
    var temps = <?php echo json_encode($templates) ?>;
    // var arr = sel.split(',');

    // $.each(temps, function(index, temp){
        // var trash_btn = '<button class="btn btn-default btn-sm pull-right entry" id="edit'+temp.id+'" name="edit'+temp.id+'"><span class="glyphicon glyphicon-trash"></span></button>';
    	// var attrib = temp.id;
        // console.log(temps);
		// for(var x = 0 ; x < arr.length ; x++){
   		//	if(arr[x] == attrib){
   		//		$('#tempfld').append('<li class="col-sm-3 list-group-item" id = "'+temp.id+'">'+temp.tabno+'<a class="btn btn-default btn-sm pull-right entry" href="<?php echo url('dda/'.$dda->id.'/entry') ?>"><span class="glyphicon glyphicon-edit"></span></a>');
   		//	}
   	//	}    	
    //});

    $('a .entry').on('click', function(e){
        e.preventDefault();
        string 
        window.location.href = "<?php echo url('dda/$id/entry'); ?>";
    });

    var doc = new jsPDF('p','pt','a5');
    var margins = {
        top: 25,
        bottom: 60,
        left: 20,
        width: 522
    };
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

    var source = {"tableheader":{"tabno":"","tabname":"","tabtitle":""},"table":{"stubname":[],"column":[],"stub":[]},"data":[],"tablefooter":{}};
    var stub = source.table.stubname;
    var column = source.table.column;
    var kolom = stub.concat(column);
    var table_array = [];

    $('#cmd').click(function () {
        $.each(temps, function(index, temp){
            var attrib = temp.id;
            for(var x = 0 ; x < arr.length ; x++){
                if(arr[x] == attrib){                    
                    var source = JSON.parse(temp.tabtemplate);
                    update(source);
                    table_array.push($('#contents').html());
                    doc.fromHTML($('#contents').html(), 15, 15, {
                        'elementHandlers': specialElementHandlers
                    });
                    if(x != arr.length - 1){
                        doc.addPage();
                    }
                }
            }       
        });
        doc.save('sample-file.pdf');
        // $('#contents').empty();
    });

function update(source){
    stub = source.table.stubname;
    column = source.table.column;
    kolom = stub.concat(column);
    $('#table_column').val(colnames(kolom));
    $('#table_data').val(JSON.stringify(source.data));
    $('#table_stub').val(source.table.stubname[0]);

    var options = {
        source: source.data,
        rowClass: "classy",
        callback: function(){}
    };
    var testTable = $("<table></table>");
    var keys = kolom;
    testTable.jsonTable({
        head : kolom,
        json : keys // The '*' identity will be incremented at each line
    });
    testTable.jsonTableUpdate(options);
    $("#contents").append(testTable);
}

function colnames(subMenuItems) {
if (subMenuItems) {
  var arr = [];
  for (var i = 0; i < subMenuItems.length; i++) {
    if (typeof subMenuItems[i] != null && typeof subMenuItems[i] === 'object') {
      var found = colnames(subMenuItems[i].subcol);
      arr = arr.concat(found);
    } else {
      arr.push(subMenuItems[i]);
    }   
  }
  return arr;
}
};

$('#generate').on('click', function(e){
    $.each(temps, function(index, temp){
        var attrib = temp.id;
        for(var x = 0 ; x < arr.length ; x++){
            if(arr[x] == attrib){                    
                var source = JSON.parse(temp.tabtemplate);
                $('#contents').append('<table id="tabhead" border="0"><tr><td class="garis"><b>Tabel</b></td><td rowspan="2">'+source.tableheader.tabno+' : </td><td>'+source.tableheader.tabname+'</td></tr><tr><td><b><i>Table</i></b></td><td><i>'+source.tableheader.tabtitle+'</i></td></tr></table>');
                update(source);
                table_array.push($('#contents').html());
            }
        }       
    });
    $('#tabel').val(table_array);
    $('#contents').empty();
});
@endsection