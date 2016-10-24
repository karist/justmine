@extends('admin.admin')

@section('contentAdmin')

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
<style type="text/css">
    textarea {
        resize: none;
    }
    table {
        overflow-x: scroll;
    }
    tbody {
        display:block;
        height:200px;
        overflow:auto;
    }
    thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
    thead {
        width: calc( 100% - 1em );
    }
</style>

<div class="panel-heading">Membuat Templat Tabel</div>
<div class="panel-body">
    <div class="col-md-6">
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
        <form action="{{url('admin/templates')}}" method="POST" class="form-horizontal" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4" for="baku">Tabel Baku</label>
                <div class="col-md-8 col-sm-8">
                    <select name="baku" id="inputTemplat" class="form-control" >
                        @foreach($bakus as $baku)
                            <option value="{{ $baku->id }}" selected="selected">{{ $baku->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4" for="bab">Bab</label>
                <div class="col-md-8 col-sm-8">
                    <select name="bab" id="bab" class="form-control" >
                        @foreach($babs as $bab)
                            <option value="{{ $bab->id }}">{{ $bab->nama_bab }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4" for="subbab">Subbab</label>
                <div class="col-md-8 col-sm-8">
                    <select name="subbab" id="subbab" class="form-control" >
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4" for="judul_id">Nama Tabel</label>
                <div class="col-md-8 col-sm-8">
                    <input type="text" name="judul_id" id="judul_id" class="form-control" placeholder="Masukkan nama templat tabel" ><br>
                    <input type="text" name="judul_en" id="inputJudul_id" class="form-control" placeholder="Masukkan nama templat tabel (English)" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4" for="sumber_id">Sumber Tabel</label>
                <div class="col-md-8 col-sm-8">
                    <input type="text" name="sumber_id" id="sumber_id" class="form-control" placeholder="Masukkan sumber data" ><br>
                    <input type="text" name="sumber_en" id="inputJudul_id" class="form-control" placeholder="Masukkan sumber data (English)" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4" for="judul_stub">Judul Stub</label>
                <div class="col-md-8 col-sm-8">
                    <select name="judul_stub" id="judul_stub" class="form-control">
                        @foreach($stubs as $stub)
                            <option value="{{ $stub->stubname }}">{{ $stub->stubindo }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="showField" class="scrollbar">
                
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <div id="display" style="display:none">
            <div id="container" class="tablePreview">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.table2excel.min.js') }}"></script>
<script src="{{ URL::asset('js/addremovefield.js') }}"></script>
@endsection

@section('postJquery')
$('#inputTemplat').change(function(e){
   var id = e.target.value;
   //ajax
    $.get('/ajax-baku?id='+ id, function(data){
        source = JSON.parse(data.tabel_baku);
        update(JSON.parse(data.tabel_baku), 'container'); // fungsi dari file tableManager.js dipanggil di app.blade.php
        $('#display').show();
        stub = source.table.stubname;
        column = source.table.column;
        kolom = colnamesAll(stub.concat(column)); // fungsi dari file tableManager.js dipanggil di app.blade.php
        $('#showField').empty();
        $.each(kolom, function(key, value){
            if(key > 0){
                $('#showField').append('<label class="control-label col-md-4 col-sm-4" for="sumber_id">'+value+'</label><div class="col-md-8 col-sm-8"><input type="text" name="kolom[]" id="kolom[]" class="form-control" ><br>');
            }
        });
    });
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

$('button').click(function(){
   alert($('#judul_stub').val());
});
@endsection