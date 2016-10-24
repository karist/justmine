@extends('layouts.app')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
<style type="text/css">
    textarea {
        resize: none;
    }
    
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            Daftar semua templat tabel Anda. <a href="{{ url('templates/create') }}">Tambah templat tabel?</a>
            <div class="panel panel-default">
                <div class="panel-heading">Templat</div>

                <table class="table table-bordered table-hover tableList category-table" data-toggle="dataTable" data-form="deleteForm">
                    <tbody>
                        @foreach($templates as $template)
                            <tr id = "{{ $template->id }}">
                                <td>{{ $template->tabno }}  {{ strtr($template->tabtitle, $vars) }}</td>
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
            </div>
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
var kd = "<?php echo $kd ?>";
$('tr').click(function(){
   var id = $(this).attr('id');
   //ajax
    $.get('/ajax-temp?id='+ id, function(data){
        source = JSON.parse(data.tabtemplate);
        var stubname = source.table.stubname[0];
        //ajax
        if(stubname == "kabkot"){
            //ajax
            $.get('/ajax-kabkot?id='+ kd, function(data2){
                var arr = [];
                $.each(data2, function(index, kk){
                    arr.push(kk.nama_kabkot[0] + kk.nama_kabkot.slice(1).toLowerCase());
                });
                source.table.stub = arr;
                source.data = getData(source);    
                update(source);
                $('#display').show();
            });
            source.table.stubname[0] = stubname;
            update();
        } else {
            $.get('/ajax-stub?stubname='+ stubname, function(data2){
                var arr = [];
                $.each(data2, function(index, stub){
                    arr.push(stub.rincian);
                });
                source.table.stub = arr;
                source.data = getData(source);    
                update(source);
                $('#display').show();
            });
        }
    });
});

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