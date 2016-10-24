<!DOCTYPE html>
<html>
<head>
<title>To PDF</title>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/result.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/jsonTable.js') }}"></script>
<script src="{{ URL::asset('js/jspdf.min.js') }}"></script>
<script src="{{ URL::asset('js/html2canvas.min.js') }}"></script>
<script type="text/javascript">

$(function() {
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
        },
        error: function(){
        }
      });
    });
  }

});
</script>
</head>
<body>
<!-- <button type="button" class="btn btn-default" id="btn-print">print</button>
<htmlpagefooter name="page-footer">
    {PAGENO}
</htmlpagefooter> -->
<div id="print">
<!-- <div class="body"> -->
@foreach($babs as $key=>$b)
  <div class="body">
    <div id="chapNo">{{ ($key+1) }}</div>
    <h1><p class="page-header">{{ $b->nama_bab }}</p><i>{{ $b->nama_eng }}</i></h1>
  </div>
  @foreach($narasis as $n)
		@if($n->bab == $b->id)
    <div class="body">
			<div class="nar">
				<div class="col1">
					<center><b>PENJELASAN TEKNIS</b></center>
					{!! $n->teks !!}
				</div>
				<div class="col2">
					<center><b><i>TECHNICAL NOTES</i></b></center>
					{!! $n->text !!}
				</div>
			</div>
    </div>
    @endif
  @endforeach
  <div class="body">
	<div class="sub">
		@foreach($subbabs as $sub)
			@if($b->id == $sub->bab)	
				@foreach($anades as $a)
					@if($a->subbab == $sub->id)
						<div class="col1">
			    			<h3>{{ $sub->nama_sub }}</h3>
			    			<p>{!! $a->teks !!}</p>
			    		</div>
						<div class="col2">
							<h3><i>{{ $sub->sub_name }}</i></h3>
							<p>{!! $a->text !!}</p>
						</div>		
					@endif
        @endforeach
			@endif
		@endforeach
	</div>
  </div>
  <div class="body">
  <div>
  @foreach($templates as $t)
    @if($b->id == $t->idbab)
      <table class = "caption">
        <tr>
            <td class="garis"><b>Tabel</b></td>
            <td rowspan="2">{{$t->tabno}} :</td>
            <td><b>{{ str_replace(['$level','$daerah','$tahun'], [$lvl, $daerah,$tahun], $t->tabtitle) }}</b></td>
        </tr>
        <tr>
            <td><b><i>Table</i></b></td>
            <td><i></i></td>
        </tr>
      </table>
      <br>
      <input type="hidden" id="text{{$t->id}}" value="{{$t->tabtemplate}}">
      <div class="tablePreview" id="{{ $t->id }}"></div>
    @endif
  @endforeach
  </div>
  </div>
@endforeach
<!-- </div> -->
</div>
<script type="text/javascript">
$('#btn-print').on('click', function(){
var pdf = new jsPDF('p', 'mm', 'a5'); //portrait, mm, a5
var source = $('#print')[0];
var margins = {
        top: 15,
        bottom: 15,
        left: 15,
        width: 600
    };
pdf.fromHTML(source, margins.left, margins.top, {'width': margins.width,
      'background': '#fff','pagesplit': true, 'margin':15
    }, function() {
      pdf.save('sample-file.pdf');
    });
});
</script>
</body>
</html>
