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
    <h1>Table Properties</h1>
    @include('controllerFormat')
</div>

<div id="section">
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
    <form name="tableform" method="POST" role="form" action="{{ url('templates')}}">
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
        <input type="submit" class="btn btn-primary pull-right" name="savetemplate" alt="Save Template" value="Save Template"/>
        <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('templates') }}">Back</a>
    </form>
</div>
<div id="mainView" ng-controller="MainViewCtrl">
    <h4>Pengaturan Kolom</h4>

    <div class="jsonView custom_scrollbar">
        <json child="jsonData" default-collapsed="false" type="array"></json>
    </div>
    <hr>
    <div class="pull-left">
        <textarea id="jsonTextarea" ng-model="jsonString"></textarea>
        <span class="red" ng-if="!wellFormed">JSON not well-formed!</span>
        <input type="submit" name="sendjson" id="sendjson" class="btn btn-primary" alt="Save" value="Save"/>
    </div>
</div>
</html>
@endsection

<script type="text/javascript">
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
</script>