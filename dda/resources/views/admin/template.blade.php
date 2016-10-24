@extends('admin.admin')

@section('contentAdmin')

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
<style type="text/css">
    textarea {
        resize: none;
    }
</style>

<div class="panel-heading">Templat Tabel</div>
<div class="panel-body">
    <div class="col-md-6">
        <table class="table table-bordered tableList table-hover category-table" data-toggle="dataTable" data-form="deleteForm">
            <tbody>
                @foreach($templates as $template)
                    <tr id = "{{ $template->id }}">
                        <td>{{ $template->judul }}</td>
                        <td>
                        <a class="btn btn-default btn-sm pull-right" href="{{ url('templates/'.$template->id.'/edit') }}"><span class="glyphicon glyphicon-edit"></span></a>
                        <button class="btn btn-default btn-sm pull-right export"><span class="glyphicon glyphicon-print"></span></button>
                        {!! Form::model($templates, ['method' => 'delete', 'route' => ['templates.destroy', $template->id], 'class' =>'form-inline form-delete']) !!}
                            {!! Form::hidden('templates', $template->id) !!}
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', array('type' => 'submit', 'class' => 'pull-right btn btn-sm btn-danger delete', 'name' => 'delete_modal' )) !!}
                        {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination pull-right"> {{ $templates->links() }} </div>
    </div>
    <div class="col-md-6">
        <div id="display" style="display:none">
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
    init(source);
}

function init(source){
    $('#tabno').val(source.tableheader.tabno);
    $('#tabname').val(source.tableheader.tabname);
    $('#tabtitle').val(source.tableheader.tabtitle);
    $('#sumber').val(source.tablefooter.sumber);
}

$('tr').click(function(){
   var id = $(this).attr('id');
   //ajax
    $.get('/ajax-temp?id='+ id, function(data){
        source.data = JSON.parse(data.tabtemplate);
        update(JSON.parse(data.tabtemplate));
        $('#display').show();
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
$('.export').click(function(e){
    e.preventDefault();
    $('#myDiv table').each(function(){ 
        alert(this.id);  
    });
    $('#container').find('table').table2excel({
        name: "New File",
        filename : "newfile",
        fileext: ".xls"
    });
});
@endsection