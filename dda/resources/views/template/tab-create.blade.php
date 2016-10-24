<html ng-app="JSONedit">
<style>
#temp_list{
    /*position: absolute;*/
    top: 0;
    bottom: 0;
    right: 0;
    overflow-y: scroll;
    /*width: 25%;*/
  }
</style>
@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery-ui.css') }}">

    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('js/angular.min.js') }}"></script>
    <script src="{{ URL::asset('js/sortable.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles.css') }}">
    <script src="{{ URL::asset('js/directives.js') }}"></script>
    <script src="{{ URL::asset('js/JSONedit.js') }}"></script>

<div id="tabController">
    <h1>Pengaturan Tabel</h1>
    @include('controller')
</div>

<div id="section">
    {{ Form::open(array('url'=>'', 'files'=>true)) }}
        <div class="form-group">
            <label for="stublist"><h4>Pilih stub yang akan Anda gunakan</h4></label>
            <select class="form-control input-sm" name="stublist" id="stublist">
                <option>Choose here</option>
                <!-- <option value="empty">Empty Stub</option> -->
            @foreach($stubattrs as $stubattr)
                <option value="{{ $stubattr->stubname}}">{{ $stubattr->stubindo }}</option>
            @endforeach
            </select>
        </div>
    {{ Form::close() }}
    <div id="optionalFld"></div>
    @include('modals/mod-stub-cr')

<!--     You cannot find your stub in the list? 
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Create New Stub</button> -->

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
    <div><form name="tableform" method="POST" role="form" action="{{ url('templates')}}">
        <div id="display">
            <div id="up">
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
            </div>
            <div id="container" class="tablePreview">
            </div>
            <div id="tabfooter">
              <label class="down" id="sumberlbl">Sumber</label><i><label class="down" id="sourcelbl"></label></i>: <input type="text" class="up" id="sumber" readonly><p id="slash"></p><i><input type="text" class="up" id="source" readonly></i><br>
              <p class="down" id="cat"></p>
            </div>
        </div>
        <input type="hidden" id="tabtemplate" name="tabtemplate"/>
        <input type="hidden" id="stubname" name="stubname"/>
        <input type="hidden" id="idbab" name="idbab"/>
        <input type="hidden" id="idsubbab" name="idsubbab"/>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-primary pull-right" name="savetemplate" alt="Save Template" value="Simpan Templat"/>
        <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('templates') }}">Kembali</a>
    </form>
    </div>
    <br><br>
    <div class="panel panel-info">
      <div class="panel-heading">Petunjuk</div>
      <div class="panel-body">
          <ul>
              <li>Pilih salah satu stub sesuai dengan tabel yang dibuat.</li>
              <li>Klik pada bagian keterangan tabel, tabel, atau sumber tabel untuk menampilkan pengaturan tabel.</li>
              <li>Pada penulisan judul tabel, tuliskan $tahun sebagai penanda tahun, $daerah sebagai penanda daerah, dan $level sebagai penanda tingkatan DDA yang dibuat</li>
              <li>Contoh: Tabel Curah Hujan berdasarkan bulan di $level $daerah, $tahun</li>
              <li>Setelah melakukan semua pengaturan, simpan templat</li>
          </ul>
      </div>
    </div>
</div>


<div id="templatelist">
    <p id="here"></p>
    <h3>Daftar Templat Tabel</h3>
    <table class="table table-bordered table-striped table-hover category-table" data-toggle="dataTable" data-form="deleteForm">
        <tbody>
            @foreach($templates as $template)
                <tr id = "{{ $template->id }}">
                    <td>{{ $template->tabno }}  {{ $template->tabtitle }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
<!--     <div id="temp_list">
      <ul>
        @if(count($templates))
          @foreach($templates as $template)
            <li>{{ $template->tabno }} : {{ $template->tabtitle }}</li>
          @endforeach
        @endif
      </ul>
    </div> -->
    <div class="pagination pull-right"> {{ $templates->links() }} </div>
</div>
@endsection

@section('postJquery')
@parent
var kd = "<?php echo $kd ?>";
var source = {
    "tableheader":{
        "tabno":"No",
        "tabname":"Name",
        "tabtitle":"Title"
    },
    "table":{
        "stubname":["stub"],
        "column":["Column1","Column2"],
        "stub":["Stub01", "Stub02", "Stub03", "Stub04", "Stub05"]
    },
    "data":[],
    "tablefooter":{}
};
// $('#tabno_prop').val(source.tableheader.tabno);
// $('#tabname_prop').val(source.tableheader.tabname);
// $('#tabtitle_prop').val(source.tableheader.tabtitle);

$('#tabno').val(source.tableheader.tabno);
$('#tabname').val(source.tableheader.tabname);
$('#tabtitle').val(source.tableheader.tabtitle);

//show table
update();

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
        source.tablefooter.sumber = $('#sumber_prop').val();
        if($('#source_prop').val() != ''){
            $('#sumberlbl').append('/');
            $('#sourcelbl').text('Source');
            $('#slash').text('/');
            $('#source').val($('#source_prop').val());
            source.tablefooter.source = $('#source_prop').val();
        }
    }
    if($('#catatan_prop').val() != ''){
        $('#cat').text('Catatan: '+$('#catatan_prop').val());
        source.tablefooter.catatan = $('#catatan_prop').val();
    }
    // update JSON 
    $('#tabtemplate').val(JSON.stringify(source));
});
$('#savemid').click(function(){ 
    var arr = [];
    $('.column_wrapper').find('input[type="text"]').each(function(i){
      arr.push($(this).val());
    });
    source.table.column = arr;
    update();
  });
$("#stublist").change(function(e){
    var stubname = e.target.value;
    $('#optionalFld').empty();
    if(stubname=='empty'){
        $("#optionalFld").append("<input type='text' name='naofstub' id='naofstub' min='1' max='99' placeholder='stub name'/><input type='number' name='nofstub' id='nofstub' min='1' max='99' placeholder='number of stub'/><input type='button' id='nofstubbtn' value='Update table' />");
        $('#nofstubbtn').click(function(){
            var len = $('#nofstub').val();
            <!-- console.log(len); -->
            source.table.stub = [];
            var stbnme = $('#naofstub').val();
            source.table.stubname = stbnme;
            $('#stubname').val(stbnme);
            for(var i = 0; i < len; i++){
                source.table.stub.push("");
            }
            update();
        });
    } else {
        source.table.stub = [];
        if(stubname == "kabkot"){
            //ajax
            $.get('/ajax-kabkot?id='+ kd, function(data){
                $.each(data, function(index, kk){
                    // $('#rincilist').append('<li class="list-group-item">'+kk.nama_kabkot+'</li>');
                    source.table.stub.push(kk.nama_kabkot[0] + kk.nama_kabkot.slice(1).toLowerCase());
                });
            });
            source.table.stubname[0] = stubname;
            update();
        } else {
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
    <!-- console.log(data2); -->
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
$('#bab').change(function(e){
    var id = e.target.value;
    $('#subbab').empty();
    $('#idbab').val(id);
    //ajax
    $.get('/ajax-subbab?id='+ id, function(data){
        $.each(data, function(index, subbab){
            $('#subbab').append('<option value='+subbab.id+'>'+subbab.nama_sub+'</option>');
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