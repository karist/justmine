@extends('layouts.app')
@section('content')
<style>
#sortable1, #sortable2 {
    border: 1px solid #eee;
    width: 142px;
    min-height: 20px;
    list-style-type: none;
    margin: 0;
    padding: 5px 0 0 0;
    float: left;
    margin-right: 10px;
}
#sortable1 li, #sortable2 li {
    margin: 0 5px 5px 5px;
    padding: 5px;
    font-size: 1.2em;
    width: 120px;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
            	<div class="panel-heading">Tabel DDA</div>
            	<div class="panel-body">
                    <ul id="sortable1" class="connectedSortable list-group">
                    </ul>
            	</div>
            </div>
        </div>
        <div class="col-md-6">
        	<div class="panel panel-default">
        		<div class="panel-heading">Tabel Terurut</div>
        		<div class="panel-body">
                    <ul id="sortable2" class="connectedSortable list-group">
                    </ul>
            	</div>
            </div>
        </div>
        <!-- <form name="tableform" method="POST" role="form" action="{{ url('/dda/'.$dda->id.'/layout')}}"> -->
        <form>
        <input type="hidden" id="orderedArray" name="orderedArray"/>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-primary pull-right" id="dda_update" value="Update DDA">Simpan</button>
        </form>
        <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('dda/'.$dda->id) }}">Kembali</a>
    </div>
</div>
@endsection

@section('postJquery')
$( function() {
    // var sel = <?php echo json_encode($dda->isi) ?>;
    var temps = <?php echo json_encode($templates) ?>;
    // var arr = sel.split(',');

    $.each(temps, function(index, temp){
        var attrib = temp.id;
        //for(var x = 0 ; x < arr.length ; x++){
        //    if(arr[x] == attrib){
        //        $('#sortable1').append('<li class="col-sm-3 list-group-item" id = "'+temp.id+'">'+temp.tabno);
        //    }
        //}       
        $.each(temps, function(key, data){
            $('#sortable1').append('<li class="col-sm-12 list-group-item" id = "'+data.id+'">'+data.tabno+' '+temp.tabtitle);
        });
    });

    $( "#sortable1, #sortable2" ).sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
});
$('#dda_update').on('click', function(e){   
    e.preventDefault();
    $('#sortable2').find('li').each(function(){
        console.log($(this).attr('id'));
    });
});
@endsection