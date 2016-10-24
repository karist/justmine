$(document).ready(function(){
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

  function update(source){
    // dataFromDB();
    stub = source.table.stubname;
    column = source.table.column;
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
        } else {
          $('#editModal .modal-body form').append('<div><label>'+value+'</label><input type='+type+' name="data_modal[]" value="'+all_data[index_data][value]+'" class="form-control" data-index-content="' + all_data[index_data][value] + '" disabled/>');
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
      update();
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
              alert(JSON.stringify(data2));
              if (data[0] != null) {
                src.data = JSON.parse(data2);
              }
              source = src;
              $('#table_id').val(id);
              // console.log(source);
              update(source);
              init();
              $('#display').show();
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
    update();
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
      var input_text = tinyMCE.activeEditor.getContent({format : 'text'});
      if(input_text != ''){
          $.get('/ajax-translate?input_text='+ input_text, function(data){
              alert(JSON.stringify(data));
          });
      }
  });
  $("#EntryTab li:eq(1) a").tab('show');
});