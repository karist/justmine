@extends('admin.admin')

@section('contentAdmin')

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
<style type="text/css">
    textarea {
        resize: none;
    }
</style>

<div class="panel-heading">Tabel Baku</div>
<div class="panel-body">
    <div class="col-md-6">
        Berikut ini daftar tabel baku Anda. <a href="{{ url('admin/baku/create') }}">Tambahkan tabel baku baru?</a>
        <table class="table table-bordered tableList table-hover category-table" data-toggle="dataTable" data-form="deleteForm">
            <tbody>
                @foreach($bakus as $baku)
                    <tr id = "{{ $baku->id }}">
                        <td>{{ $baku->name }}</td>
                        <td>
                        <a class="btn btn-default btn-sm pull-right" href="{{ url('admin/baku/'.$baku->id.'/edit') }}"><span class="glyphicon glyphicon-edit"></span></a>
                        {!! Form::model($baku, ['method' => 'delete', 'route' => ['admin.baku.destroy', $baku->id], 'class' =>'form-inline form-delete']) !!}
                            {!! Form::hidden('baku', $baku->id) !!}
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', array('type' => 'submit', 'class' => 'pull-right btn btn-sm btn-danger delete', 'name' => 'delete_modal' )) !!}
                        {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination pull-right"> {{ $bakus->links() }} </div>
    </div>
    <div class="col-md-6">
        <div id="display" style="display:none">
            <div id="container" class="tablePreview">
            </div>
            <div id="showField"></div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.table2excel.min.js') }}"></script>
<script src="{{ URL::asset('js/addremovefield.js') }}"></script>
@endsection

@section('postJquery')
var source = {"tableheader":{"tabno":"","tabname":"","tabtitle":""},"table":{"stubname":[],"column":[],"stub":[]},"data":[],"tablefooter":{}};

function update(source){
    var stub = source.table.stubname;
    var column = source.table.column;
    var kolom = stub.concat(column);
    
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
    $("#container").empty();
    $("#container").append(testTable);
}

$('tr').click(function(){
   var id = $(this).attr('id');
   //ajax
    $.get('/ajax-baku?id='+ id, function(data){
        source = JSON.parse(data.tabel_baku);
        update(JSON.parse(data.tabel_baku));
        $('#display').show();
        stub = source.table.stubname;
	    column = source.table.column;
	    kolom = colnamesAll(stub.concat(column));
	    $('#showField').empty();
	    $.each(kolom, function(key, value){
	    	$('#showField').append('<label>'+value+'</label><input class="form-control" type="text">');
	    });
    });
});

function colnamesAll(subMenuItems) {
    if (subMenuItems) {
      var arr = [];
      for (var i = 0; i < subMenuItems.length; i++) {
        if (typeof subMenuItems[i] != null && typeof subMenuItems[i] === 'object') {
          var found = colnames(subMenuItems[i].subcol);
          arr.push(subMenuItems[i].name);
          arr = arr.concat(found);
        } else {
          arr.push(subMenuItems[i]);
        }   
      }
      return arr;
    }
  }; 
@endsection