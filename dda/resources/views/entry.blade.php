<!-- halaman entri tabel dari template yang sudah ada -->
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<!-- <script src="{{ URL::asset('js/entry.js') }}"></script> -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('js/amcharts_3.20.12.free/samples/style.css') }}">
<script src="{{ URL::asset('js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<!-- <link rel="stylesheet" href="style.css" type="text/css"> -->
<script src="{{ URL::asset('js/amcharts_3.20.12.free/amcharts/amcharts.js') }}"></script>
<script src="{{ URL::asset('js/amcharts_3.20.12.free/amcharts/serial.js') }}"></script>
<script src="{{ URL::asset('js/amcharts_3.20.12.free/amcharts/pie.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.table2excel.min.js') }}"></script>
<style type="text/css">
  .editable{
    width: 100%;
    min-height: 100px;
    border-style: solid;
    border-width: 1px;
  }

  table{
    width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #ddd;
  }
</style>

@extends('layouts.app')
@section('content')
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
  <ul class="nav nav-pills nav-stacked" id="EntryTab">
    <li><a data-toggle="tab" href="#narration">Narasi</a></li>
    <li><a data-toggle="tab" href="#table">Tabel dan Analisis Deskriptif</a></li>
    <!-- <li><a data-toggle="tab" href="#analysis">Descriptive Analysis</a></li> -->
  </ul>
</div>
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 tab-content">
  <div id="analysis" class="tab-pane fade">
  </div>
  <div id="narration" class="tab-pane fade">
    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
      <form action="{{ url('/dda/'.$id.'/narasi')}}" method="POST" role="form">
        <legend>Entri Narasi</legend>
        @if(Session::has('narr_success'))
            <div class="alert alert-success">
            {!! Session::get('narr_success') !!}
            </div>
        @endif

        <div class="form-group">
          <label for="">Bab</label>
          <select name="dd_bab" id="dd_bab" class="form-control" required="required">
            <option>Pilih bab</option>
              @foreach($babs as $bab)
                  <option value="{{ $bab->id }}">{{ $bab->nama_bab }}</option>
              @endforeach
          </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <label for="narr_in">Narasi dalam bahasa Indonesia</label>
            <div class = "editable" id="narr_in" name="narr_in"></div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <label for="narr_eng">Narasi dalam bahasa Inggris</label>
            <div class = "editable" id="narr_eng" name="narr_eng"></div>
        </div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" id="showtext" class="btn btn-primary pull-right">Simpan Narasi</button>
        <button type="button" id="narr_translate_btn" class="btn btn-default pull-right translate">Terjemahkan</button>
        <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('home') }}">Kembali</a>
      </form>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
      <div class="panel panel-default narasi-list">
            <ul class="list-group">
            @foreach($narasis as $narasi)
                      @foreach($babs as $bab)
                        @if($narasi->bab == $bab->id)
                    <li class="list-group-item" id="{{ $bab->id }}">{{ $bab->nama_bab }}</li>
                  @endif
                @endforeach
            @endforeach
            </ul>
      </div>           
    </div>
  </div>
  <div id="table" class="tab-pane fade">    
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 pull-right">
      <div class="panel panel-default">
        <div class="panel-heading">Daftar Tabel</div>
        <div class="panel-body">
          <ul class="list-group">
            @foreach($templates as $template)
              @foreach($subbabs as $subbab)
                @if($template->idsubbab == $subbab->id)
                  <li class="list-group-item" id="{{ $template->id }}" data-toggle="tooltip" data-placement="top" title="{{ $template->tabtitle }}"><b>{{ $subbab->nama_sub }}</b> | {{ $template->tabno }}</li>
                @endif
              @endforeach
            @endforeach
          </ul>            
        </div>
      </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
      <div class="panel panel-default">
          <div class="panel-body">
          <div class="panel panel-info">
            <div class="panel-heading">Petunjuk</div>
            <div class="panel-body">
                <ul>
                    <li>Pilih salah satu tabel pada daftar tabel di sisi kanan halaman untuk mulai mengentri data.</li>
                </ul>
            </div>
          </div>
            @if(Session::has('tab_success'))
                <div class="alert alert-success">
                {!! Session::get('tab_success') !!}
                </div>
            @endif
            <p id="jsonp" hidden>{{ $template->tabtemplate }}</p>
            <form name="tableform" method="POST" role="form" action="{{ url('dda/'.$id.'/entry')}}">
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
          <input type="hidden" id="table_id" name="table_id"/>
          <input type="hidden" id="table_data" name="table_data"/>
          <input type="hidden" id="table_column" name="table_column"/>
          <input type="hidden" id="table_stub" name="table_stub"/>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="button" class="btn btn-info btn-lg paste" data-toggle="modal" data-target="#pasteModal">
              Salin dari Ms. Excel<span class="glyphicon glyphicon-paste"></span>
          </button>
           <button class="btn btn-default pull-right" id="export"><span class="glyphicon glyphicon-print"></span></button>
          <input type="submit" class="btn btn-primary pull-right" name="savedata" alt="Save Data" value="Simpan Data"/>
          <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('dda/'.$id) }}">Kembali</a>
        </form>
      </div>
    </div>
    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
      <form action="{{ url('/dda/'.$id.'/anades')}}" method="POST" role="form">
        <legend>Entri Analisis Deskriptif</legend>
        @if(Session::has('anades_success'))
            <div class="alert alert-success">
            {!! Session::get('anades_success') !!}
            </div>
        @endif
        <div class="form-group">
          <label for="dd_sub">Sub bab</label>
          <select name="dd_sub" id="dd_sub" class="form-control" required="required">
            <option>Pilih sub bab</option>
              @foreach($subbabs as $subbab)
                <option value="{{ $subbab->id }}">{{ $subbab->nama_sub }}</option>
              @endforeach
          </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="anades_id">Teks bahasa Indonesia</label>
          <div class = "editable" id="anades_id" name="anades_id">
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="anades_eng">Teks bahasa Inggris<br></label>
          <div class = "editable" id="anades_eng" name="anades_eng">
          </div>
        </div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" id="showtext" class="btn btn-primary pull-right">Simpan Analisis Deskriptif</button>
        <button type="button" id="an_translate_btn" class="btn btn-default pull-right translate">Terjemahkan</button>
        <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('dda/'.$id) }}">Kembali</a>
      </form>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
      <label for="selectSub"><h3>Analisis deskriptif yang sudah disimpan</h3></label>
      <select name="selectSub" id="selectSub" class="form-control" required="required">
        <option>Pilih sub bab</option>
      @foreach($anades as $a)
          @foreach($subbabs as $sub)
            @if($a->subbab == $sub->id)
              <option value="{{ $sub->id }}">{{ $sub->nama_sub }}</option>
            @endif
          @endforeach
      @endforeach
      </select>
      <hr>
      <div id="chart_dd"></div>
      <div id="chartdiv" style="width: 100%; height: 100%;"></div>
    </div>
    <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
      <div class="panel panel-default anades-list">
          <ul class="list-group">
          @foreach($anades as $a)
              @foreach($subbabs as $sub)
                @if($a->subbab == $sub->id)
                  <li class="list-group-item" id="{{ $sub->id }}">{{ $sub->nama_sub }}</li>
                @endif
              @endforeach
          @endforeach
          </ul>
      </div>            
    </div> -->
  </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edit page details</h4>
            </div>
            <div class="modal-body">
                <form id="" method="get">
                    
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-block btn-success" type="button" id="btn-update">
                    <span class="glyphicon glyphicon-refresh"></span>
                Update
                </button>
                <button class="btn btn-block btn-default" type="button" id="btn-cancel">
                    <span class="glyphicon glyphicon-backward"></span>
                Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pasteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Paste Data</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="comment">Paste Here:</label>
                        <textarea class="form-control" rows="5" id="paste_area"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-block btn-success" type="button" id="paste-update">
                    <span class="glyphicon glyphicon-refresh"></span>
                Update
                </button>
                <button class="btn btn-block btn-default" type="button" id="paste-cancel">
                    <span class="glyphicon glyphicon-backward"></span>
                Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('postJquery')
    var dda_id = "<?php echo $id ?>";
    var source = {
    "tableheader":{
      "tabno":"",
      "tabname":"",
      "tabtitle":""},
    "table":{
      "stubname":[],
      "column":[],
      "stub":[]},
      "data":[],
      "tablefooter":{}};
    var stub = source.table.stubname;
    var column = source.table.column;
    var kolom = stub.concat(column);
    var $tahun = <?php echo $tahun;?>;
    var kd = "<?php echo $kd ?>";

  function update(source){
    // dataFromDB();
    stub = source.table.stubname;
    var column = cek_tahun(source.table.column);
    kolom = stub.concat(column);
    $('#table_column').val(colnames(kolom));
    $('#table_data').val(JSON.stringify(source.data));
    $('#table_stub').val(source.table.stubname[0]);
    init();

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
    var index_edit = 0;
    $('.tablePreview tbody tr').each(function(){
      $(this).append('<td class="edit no-border" data-toggle="modal" data-target="#editModal"></td>');
      $('.edit').html('<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></button>');
      add_events();
      index_edit++;
    });

    var sum = [];
    sum[0] = 'Jumlah';
    for(var i = 0 ; i < source.data.length ; i++){
      for(var j = 1 ; j < kolom.length ; j++){
        sum[j] = isNaN(sum[j]) ? 0 : sum[j];
        var key = kolom[j], num = isNaN(parseInt(source.data[i][key])) ? 0 : parseInt(source.data[i][key]);
        sum[j] = sum[j] + num;
      }
    }
    $('.tablePreview table').append('<tfoot></tfoot>');
    $.each(kolom, function(index, value){
      $('.tablePreview tfoot').append('<td>'+sum[index]+'</td>');
    })
  }

  $('#export').click(function(e){
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

  function add_events(){
    $('#btn-cancel').click(function() {       //cancel data update event
      $('#editModal').modal('hide');
    });

    $('.edit').unbind().click(function() {
      $('#editModal .modal-body form').empty();    //clearing data
      var index_data = $(this).closest('tr').index();
      var column_list = colnames(kolom);
      var all_data = source.data;
      $.each(column_list, function(index, value){
        var type = '"number" step="0.01"';
        if(index == 0) type = '"text"';
        if(all_data[index_data][value] == ''){
          $('#editModal .modal-body form').append('<div><label>'+value+'</label><input type='+type+' name="data_modal[]" value="'+all_data[index_data][value]+'" class="form-control" data-index-content="' + all_data[index_data][value] + '"/>');  
        } else if(index == 0){
          $('#editModal .modal-body form').append('<div><label>'+value+'</label><input type='+type+' name="data_modal[]" value="'+all_data[index_data][value]+'" class="form-control" data-index-content="' + all_data[index_data][value] + '" disabled/>');
        } else {
          $('#editModal .modal-body form').append('<div><label>'+value+'</label><input type='+type+' name="data_modal[]" value="'+all_data[index_data][value]+'" class="form-control" data-index-content="' + all_data[index_data][value] + '"/>');
        }
        $('#editModal .modal-body form').attr('data-index', index_data);
      });
    });

    $('#btn-update').click(function(){
      var ele = $('#editModal .modal-body form');
      var col = parseInt(ele.attr('data-index'));
      var data = source.data[col];
      var temp = [];
      var column_list = colnames(kolom);
      $('#editModal input').each(function(i){
        var key = column_list[i];
        source.data[col][key] = $(this).val();
      });
      update(source);
      $('#editModal').modal('hide');  
    });
  }

  $('.panel-body li').click(function(){
   var id = $(this).attr('id');
   //ajax
   $.get('/ajax-temp?id='+ id, function(data){
      var src = JSON.parse(data.tabtemplate);
          $.ajax({
           type: 'get',
           url: '/aj',
           data: {id:dda_id, table:id},
           success: function(data2){
              var d = JSON.parse(data2);
              if (d.length > 1) {
                src.data = JSON.parse(data2);
                var stub = src.table.stubname[0];
                var kol = src.table.column;
                var kolom = src.table.column[0];
                var slc = "<select id='selectCol' name='selectCol' class='form-control' >";
                $.each(kol, function(k, value){
                  slc += "<option value='"+value+"'>"+value+"</option>";
                });
                slc += "</select>";
                charting(d, stub, kolom);
                $('#chart_dd').empty();
                $('#chart_dd').append(slc);
                $('#selectCol').change(function(e){
                  var x = e.target.value;
                  charting(d, stub, x);
                });
              }
              source = src;
              $('#table_id').val(id);
              update(source);
              init();
              $('#display').show();
          },
          error: function(){
            source = src;
            $('#table_id').val(id);
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
                init();
                $('#display').show();
              });
            } else {
              $.get('/ajax-stub?stubname='+ stubname, function(data2){
                var arr = [];
                $.each(data2, function(index, stub){
                    arr.push(stub.rincian);
                });
                source.table.stub = arr;
                source.data = getData(source);    
                update(source);
                init();
                $('#display').show();
              });
            }
          }
        });
    });
  });

  function init(){
    $('#sumber_source').val(source.tablefooter.sumber);
    $('#sumber_catatan').val(source.tablefooter.sumber);
    $('#tabno').val(source.tableheader.tabno);
    $('#tabname').val(source.tableheader.tabname);
    $('#tabtitle').val(source.tableheader.tabtitle);
    $('#sumber').val(source.tablefooter.sumber);
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

  function cek_tahun(column){
    var x = JSON.stringify(column);
    if(x.indexOf("$tahun") !== -1){ // bernilai -1 saat tidak match
      x = x.replace(/\$tahun/g, $tahun);
      x = JSON.parse(x);
      $.each(x, function(index, value){
        if(value.indexOf($tahun) !== -1){
          x[index] = eval(value);
        } else {
          x[index] = value;
        }
      });
      column = x;
    }
    return column;
  }

  function getData(source) {
    var stub = source.table.stubname;
    var column = cek_tahun(source.table.column);
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

  $('#paste-cancel').click(function() {       //cancel data update event
    $('#pasteModal').modal('hide');
    $('#paste_area').val('');
  }); 

  $('#paste-update').click(function() {       //cancel data update event
    var lines = $('textarea').val().split('\n');
    var column_list = colnames(kolom);
    for(var i = 0;i < lines.length;i++){
        var cells = lines[i].split('\t');
        for(var j = 0; j < cells.length ; j++){
          var key = column_list[j+1];
          source.data[i][key] = cells[j];
        }
    }
    $('#pasteModal').modal('hide'); 
    $('#paste_area').val('');
    $('#table_data').val(JSON.stringify(source.data));
    update(source);
  }); 
  $('#dd_bab').change(function(e){
      var id = e.target.value;
      $('#dd_sub').empty();
      console.log(e);
      //ajax
      $.get('/ajax-subbab?id='+ id, function(data){
          $.each(data, function(index, subbab){
              $('#dd_sub').append('<option value='+subbab.id_sub+'>'+subbab.nama_sub+'</option>');
          });

      });
  });
  $('.translate').on('click', function(){
    var input_text = '';
      <!-- var input_text = tinyMCE.activeEditor.getContent({format : 'text'}); -->
      var id = $(this).attr('id') ;
      if(id==='narr_translate_btn'){
        input_text = tinymce.get('narr_in').getContent({format : 'text'});
      } else if(id === 'an_translate_btn'){
        input_text = tinymce.get('anades_id').getContent({format : 'text'});
      }
      if(input_text != ''){
          $.get('/ajax-translate?input_text='+ input_text, function(data){
              alert(data);
              if(id==='narr_translate_btn'){
                input_text = tinymce.get('narr_in').setContent(data);
              } else if(id === 'an_translate_btn'){
                input_text = tinymce.get('anades_id').setContent(data);
              }
          });
      } else {
          alert('Tidak ditemukan teks untuk diterjemahkan');
      }
  });
  $("#EntryTab li:eq(1) a").tab('show');
  $('.anades-list li').click(function(){
   var id = $(this).attr('id');
   $.ajax({
       type: 'get',
       url: '/anades',
       data: {id:dda_id, sub:id},
       success: function(result){
       $('#dd_sub').val(result.subbab);
        tinyMCE.get('anades_eng').setContent(result.text);
        tinyMCE.get('anades_id').setContent(result.teks);
      }
    });
  });
  $('#selectSub').change(function(e){
    var id = e.target.value;
     $.ajax({
         type: 'get',
         url: '/anades',
         data: {id:dda_id, sub:id},
         success: function(result){
         $('#dd_sub').val(result.subbab);
          tinyMCE.get('anades_eng').setContent(result.text);
          tinyMCE.get('anades_id').setContent(result.teks);
        }
      });
  });
  $('.narasi-list li').click(function(){
   var id = $(this).attr('id');
   $.ajax({
       type: 'get',
       url: '/narasi',
       data: {id:dda_id, bab:id},
       success: function(result){
         $('#dd_bab').val(result.bab);
          tinyMCE.get('narr_eng').setContent(result.text);
          tinyMCE.get('narr_in').setContent(result.teks);
      }
    });
});
@endsection
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

function charting(data, stub, kolom){
var chart = AmCharts.makeChart( "chartdiv", {
  "type": "serial",
  "theme": "light",
  "dataProvider": data,
  "valueAxes": [ {
    "gridColor": "#FFFFFF",
    "gridAlpha": 0.2,
    "dashLength": 0
  } ],
  "gridAboveGraphs": true,
  "startDuration": 1,
  "graphs": [ {
    "balloonText": "[[category]]: <b>[[value]]</b>",
    "fillAlphas": 0.8,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": kolom,
  } ],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": stub,
  "categoryAxis": {
    "gridPosition": "start",
    "gridAlpha": 0,
    "tickPosition": "start",
    "tickLength": 20
  },
  "export": {
    "enabled": true
  }

} );
}
</script>