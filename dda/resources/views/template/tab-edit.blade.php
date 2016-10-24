<html ng-app="JSONedit">
@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dialog.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery-ui.css') }}">

<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery-ui.js') }}"></script>
<script src="{{ URL::asset('js/angular.min.js') }}"></script>
<script src="{{ URL::asset('js/sortable.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles.css') }}">
<script src="{{ URL::asset('js/directives.js') }}"></script>
<script src="{{ URL::asset('js/JSONedit.js') }}"></script>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Pengaturan Tabel</div>
                <div class="panel-body">@include('controller')</div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Ubah Templat Tabel</div>
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
                	<p id="jsonp" hidden>{{ $template->tabtemplate }}</p>
            	    <form name="tableform" method="post" role="form" action="{{ url('templates/'.$template->id) }}">
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
				        <div id="display">
				            <div id="up">
				                <table id="tabhead" border="0">
				                    <tr>
				                        <td class="garis"><b>Tabel</b></td>
				                        <td rowspan="2"><input type="text" class="up" id="tabno" name="tabno"readonly value="{{ $template->tabno}}"> : </td>
				                        <td><input type="text" class="up" id="tabname" name="tabname" readonly value="{{ $template->tabtitle }}"></td>
				                    </tr>
				                    <tr>
				                        <td><b><i>Table</i></b></td>
				                        <td><input type="text" class="up" id="tabtitle" name="tabtitle" readonly></td>
				                    </tr>
				                </table>
				            </div>
				            <div id="container" class="tablePreview">
				            </div>
				            <div id="tabfooter">
				              <label class="down" id="sumberlbl">Sumber</label><i><label class="down" id="sourcelbl"></label></i>: <input type="text" class="up" id="sumber" readonly><p id="slash"></p><i><input type="text" class="up" id="source" readonly></i><br>
				              <p class="down" id="cat"></p>
				            </div>
				        </div>
				        <input type="hidden" id="tabtemplate" name="tabtemplate" value="{{ $template->tabtemplate }}"/>                        
				        <input type="hidden" id="stubname" name="stubname" value="{{ $template->stubname }}"/>
                        <input type="hidden" id="idbab" name="idbab" value="{{ $template->idbab }}"/>
                        <input type="hidden" id="idsubbab" name="idsubbab" value="{{ $template->idsubbab }}"/>
                        <button type="submit" class="btn btn-primary pull-right" id="stub_save" value="Save Template">Simpan</button>
                        <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('templates') }}">Kembali</a>
				    </form>
                </div>
            </div>
        </div>
    </div>
</div>            
@endsection

@section('postJquery')
    @parent
    	// var source = {"tableheader":{"tabno":"No","tabname":"Name","tabtitle":"Title"},"table":{"stubname":["stub"],"column":["Column1","Column2"],"stub":["Stub01", "Stub02", "Stub03", "Stub04", "Stub05"]},"data":[],"tablefooter":{}};
    	var source = JSON.parse($('#tabtemplate').val());
        init();
        update();

        $('#con1').hide();
        $('#con2').hide();
        $('#con3').hide();
        $('#con4').hide();
        $('#up').click(function(){
            $('div .divclicked').removeClass('divclicked');
            $(this).addClass('divclicked');
            $('#con4').hide();
            $('#con3').hide();
            $('#con2').hide();
            $('#con1').show();
        });
        $('#tabfooter').click(function(){
            $('#con1').hide();
            $('#con3').hide();
            $('#con4').hide();
            $('div .divclicked').removeClass('divclicked');
            $(this).addClass('divclicked'); 
            $('#con2').show();
        });
        $('#container').click(function(){
            $('div .divclicked').removeClass('divclicked');
            $(this).addClass('divclicked'); 
            $('#con1').hide();
            $('#con2').hide();
            $('#con3').hide();
            $('#con4').show();
        });
        $('#saveup').click(function(){
            $('#tabno').text(':');
            $('#tabno').val($('#tabno_prop').val());
            $('#tabname').val($('#tabname_prop').val());
            $('#tabtitle').val($('#tabtitle_prop').val());
            // update JSON
            source.tableheader.tabno = $('#tabno_prop').val();
            source.tableheader.tabname = $('#tabname_prop').val();
            source.tableheader.tabtitle = $('#tabtitle_prop').val();
            $('#tabtemplate').val(JSON.stringify(source));
        });
        $('#savedown').click(function(){
            if($('#sumber_prop').val() == ''){
                alert('"Sumber" cannot be empty');
            } else {
                $('#sumberlbl').text("Sumber");
                $('#sumber').val($('#sumber_prop').val());
                if($('#source_prop').val() != ''){
                    $('#sumberlbl').append('/');
                    $('#sourcelbl').text('Source');
                    $('#slash').text('/');
                    $('#source').val($('#source_prop').val());
                }
            }
            if($('#catatan_prop').val() != ''){
                $('#cat').text('Catatan: '+$('#catatan_prop').val());
            }

            // update JSON 
            source.tablefooter.sumber = $('#sumber_prop').val();
            source.tablefooter.source = $('#source_prop').val();
            source.tablefooter.catatan = $('#catatan_prop').val();
            $('#tabtemplate').val(JSON.stringify(source));
        });
        $('#savemid').click(function(){ 
            var arr = [];
            $('.column_wrapper').find('input[type="text"]').each(function(i){
              arr.push($(this).val());
            });
            source.table.column = arr;
            update();
            $('#tabtemplate').val(JSON.stringify(source));
          });
        $("#stublist").change(function(e){
            var stubname = e.target.value;
            $('#optionalFld').empty();
            if(stubname=='empty'){
                $("#optionalFld").append("<input type='number' name='nofstub' min='1' max='99' placeholder='number of stub'/><input type='button' id='nofstubbtn' value='Update table' />");
            } else {
                source.table.stub = [];
                //ajax
                $.get('/ajax-stub?stubname='+ stubname, function(data){
                    $.each(data, function(index, stub){
                        // $('#rincilist').append('<li class="list-group-item">'+stub.rincian+'</li>');
                        source.table.stub.push(stub.rincian);
                    });
                });
                source.table.stubname[0] = stubname;
                update();
            }
        });
        $('#nofstubbtn').click(function(){
            var len = $('#nofstubbtn').val();
            for(var i = 0; i < len; i++){
                source.table.stub.push("");
            }
        });
        function getData() {
            var stub = source.table.stubname;
            var column = source.table.column;
            var col = stub.concat(column);
            var row = source.table.stub;
            var data2 = [];
            var colname = colnames(col);
            for(i = 0 ; i < row.length ; i++){
                var obj = {};
                for(j = 0; j < colname.length; j++){
                    if(j==0){
                        obj[stub] = row[i];
                    } else {
                        var myVar = colname[j];
                        obj[myVar] = "";
                    }
                }
                data2.push(obj);
            }
            return data2;
        }

        function update(){
            var stub = source.table.stubname;
            var column = source.table.column;
            var kolom = stub.concat(column);
            source.data = getData();
            
            var options = {
                source: source.data,
                rowClass: "classy",
                callback: function(){
                    // alert("Table generated!");
                }
            };
            ///////////////////////////////
            // Test on a table not yet attached to the DOM
            var testTable = $("<table></table>");
            var keys = kolom;
            testTable.jsonTable({
                head : kolom,
                json : keys // The '*' identity will be incremented at each line
            });
            testTable.jsonTableUpdate(options);
            $("#container").empty();
            $("#container").append(testTable);
            $('#tabtemplate').val(JSON.stringify(source));
            $('#stubname').val(source.table.stubname[0]);
        }
        $('#sendjson').click(function(){
            source.table.column = JSON.parse($('#jsonTextarea').val());
            update();
        });
        function init(){
        	$('#tabno_prop').val(source.tableheader.tabno);
	        $('#tabname_prop').val(source.tableheader.tabname);
	        $('#tabtitle_prop').val(source.tableheader.tabtitle);
	        $('#sumber_prop').val(source.tablefooter.sumber);
	        $('#sumber_source').val(source.tablefooter.sumber);
	        $('#sumber_catatan').val(source.tablefooter.sumber);

	        $('#tabno').val(source.tableheader.tabno);
	        $('#tabname').val(source.tableheader.tabname);
	        $('#tabtitle').val(source.tableheader.tabtitle);
	        $('#sumber').val(source.tablefooter.sumber);

            var idb = $('#idbab').val();
            var idsb = $('#idsubbab').val();
            $("#bab option[value="+idb+"]").prop('selected', true);
            $("#subbab option[value="+idsb+"]").prop('selected', true);
        }

        

$('#bab').change(function(e){
    var id = e.target.value;
    $('#subbab').empty();
    $('#idbab').val(id);
    //ajax
    $.get('/ajax-subbab?id='+ id, function(data){
        $.each(data, function(index, subbab){
            $('#subbab').append('<option value='+subbab.id_sub+'>'+subbab.nama_sub+'</option>');
        });
    });
});

$('#subbab').change(function(e){
    var id = e.target.value;
    $('#idsubbab').val(id);
});

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
@endsection
</html>