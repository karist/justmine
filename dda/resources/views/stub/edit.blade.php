@extends('layouts.app')
@section('content')
<style type="text/css">
    .scrollbar{
      width: 100%;
      height: 300px;
      overflow: scroll;
    }
</style>
<div class="container">
    <div class="row">
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
        <form name="codexworld_frm" method="post" class="form-horizontal" role="form" action="{{ url('stubs/'.$stubattr->stubname) }}">
          <input name="_method" type="hidden" value="PUT">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
              <label class="control-label col-sm-2" for="stub_nama">Nama Stub:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="stub_nama" id="stub_nama" value="{{ $stubattr->stubname }}" disabled/>
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-2" for="stub_label">Label Stub:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="stub_label" id="stub_label" value="{{ $stubattr->stubindo }}"/>
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-2" for="stub_english">Label Stub (English):</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="stub_english" id="stub_english" value="{{ $stubattr->stubeng }}">
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-2" for="tipe">Tipe:</label>
              <div class="col-sm-10">
                <select class="form-control" name="tipe" id="tipe">
                  <option>Static</option>
                  <option>Dynamic</option>
                </select>
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-2" for="stub_detail">Detil Stub:</label>
              <div class="col-sm-10">
                <a class="add_button" title="Add field" id="add">Tambah Isian</a>
                <div class="scrollbar">
                    <div class="force-overflow">
                        <div class="field_wrapper">
                            @foreach($stubs as $stub)	
                            	<div>
                            		<div class="col-sm-5">
                                		<input placeholder="Istiah dalam Bahasa" type="text" class="form-control" name="field_indo[]" value="{{ $stub->rincian }}"/>
                              		</div>
                              		<div class="col-sm-5">
                                		<input placeholder="English Term" type="text" class="form-control" name="field_eng[]" value="{{ $stub->details }}" />
                              		</div>
                              		<div class="col-sm-2">
                              			<button type="button" class="remove_button btn btn-default btn-sm" id="remove_button"><span class="glyphicon glyphicon-trash"></span></button>
                              		</div>
                            	</div>
                            @endforeach
                        </div>
                    </div>
                </div>
              </div>
          </div>
        <button type="submit" class="btn btn-primary pull-right" id="stub_save" value="Save Stub">Simpan</button>
        <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('stubs') }}">Kembali</a>
        </form>
  	</div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script src="{{ URL::asset('js/addremovefield.js') }}"></script>
@endsection