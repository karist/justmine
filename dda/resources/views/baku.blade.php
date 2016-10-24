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
@extends('admin.admin')

@section('contentAdmin')
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


    <div class="panel-heading">Merancang Tabel Baku</div>
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
        <form name="tableform" method="POST" role="form" action="{{ url('admin/baku')}}">
            <div class="form-group form-group-sm">
                <label for="name_baku" class="up control-label col-sm-3">Nama Tabel Baku</label>
                <div class="col-sm-8">
                    <input class="up form-control input-sm" type="text" id="name_baku" name="name_baku" placeholder="Judul Tabel Baku">
                </div>
            </div>
            <div id="mainView" ng-controller="MainViewCtrl">
                <label for="jsonTextarea" class="up control-label col-sm-3">Pengaturan Kolom</label>
                <div class="col-sm-8">
                    <div class="jsonView custom_scrollbar">
                        <json child="jsonData" default-collapsed="false" type="array"></json>
                    </div>
                </div>
                <div class="col-sm-8">
                    <textarea id="jsonTextarea" ng-model="jsonString"></textarea>
                    <span class="red" ng-if="!wellFormed">JSON not well-formed!</span>
                    <input type="button" name="sendjson" id="sendjson" class="btn btn-primary" alt="Save" value="Pratinjau"/>
                </div>
            </div>
            <input type="hidden" id="tabtemplate" name="tabtemplate"/>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="btn btn-primary pull-right" name="savetemplate" alt="Save Template" value="Save Template"/>
            <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('admin/baku') }}">Kembali</a>
        </form>                
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">Pratinjau</div>
        <div class="panel-body">
            <div id="container" class="tablePreview">
            </div>
        </div>
    </div>

    
</div>
@endsection

@section('postJquery')
@parent
var source = {
    "tableheader":{
        "tabno":"No",
        "tabname":"Name",
        "tabtitle":"Title"
    },
    "table":{
        "stubname":["stub"],
        "column":["Column1","Column2"],
        "stub":["", ""]
    },
    "data":[],
    "tablefooter":{}
};
update();

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
$('#sendjson').click(function(){
    source.table.column = JSON.parse($('#jsonTextarea').val());
    update();
});
@endsection
</html>