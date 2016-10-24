@extends('admin.admin')

@section('contentAdmin')
<div class="panel-heading">Ubah Data Pengguna</div>
<div class="panel-body">
    @if(Session::has('success'))
      <div class="alert alert-success">
      {!! Session::get('success') !!}
      </div>
    @endif
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/'.$user->id) }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
            <label for="nama" class="col-md-4 control-label">Nama</label>

            <div class="col-md-6">
                <input id="nama" type="text" class="form-control" name="nama" value="{{ $user->name }}">

                @if ($errors->has('nama'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nama') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('surel') ? ' has-error' : '' }}">
            <label for="surel" class="col-md-4 control-label">Alamat Surat Elektronik</label>

            <div class="col-md-6">
                <input id="surel" type="surel" class="form-control" name="surel" value="{{ $user->email }}">

                @if ($errors->has('surel'))
                    <span class="help-block">
                        <strong>{{ $errors->first('surel') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('sandi') ? ' has-error' : '' }}">
            <label for="sandi" class="col-md-4 control-label">Kata sandi</label>

            <div class="col-md-6">
                <input id="sandi" type="password" class="form-control" name="sandi">

                @if ($errors->has('sandi'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sandi') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('konfirmasi_sandi') ? ' has-error' : '' }}">
            <label for="konfirmasi_sandi" class="col-md-4 control-label">Konfirmasi Kata Sandi</label>

            <div class="col-md-6">
                <input id="konfirmasi_sandi" type="password" class="form-control" name="konfirmasi_sandi">

                @if ($errors->has('konfirmasi_sandi'))
                    <span class="help-block">
                        <strong>{{ $errors->first('konfirmasi_sandi') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('tingkat') ? ' has-error' : '' }}">
            <div class="form-group">
                <label class="control-label col-md-4" for="tingkat">Tingkat</label>
                    <div class="col-md-6">
                        <select class="form-control" id="tingkat" name="tingkat">
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ (Input::old("tingkat") == $level->id ? "selected":"") }}>{{ $level->keterangan }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('daerah') ? ' has-error' : '' }}">
            <div class="form-group">
                <label class="control-label col-md-4" for="daerah">Daerah</label>
                <div class="col-md-2">    
                    <select class="form-control" id="select_prov" name="select_prov">
                        <option>Pilih Provinsi</option>
                        @foreach($provinsis as $provinsi)
                            <option value="{{ $provinsi->kode_prov }}">{{ $provinsi->nama_prov }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" id="select_kab" name="select_kab" disabled>
                        <option>Pilih Kabupaten/Kota</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" id="select_kec" name="select_kec" disabled>
                        <option>Pilih Kecamatan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('admin') ? ' has-error' : '' }}">
            <div class="form-group">
                <label class="control-label col-md-4" for="admin">Admin</label>
                    <div class="col-md-6">
                        <select class="form-control" id="admin" name="admin">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-user"></i> Perbarui
                </button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $('#tingkat').on('change', function(e){
        var id = e.target.value;
        if(id != "1"){
            $("#select_kab").prop('disabled', false);
            if(id == "4"){
                $("#select_kec").prop('disabled', false);
            } else {
                $("#select_kec").prop('disabled', true);
            }
        } else {
            $("#select_kab").prop('disabled', true);
            $("#select_kec").prop('disabled', true);
        }
    });

    $('#select_prov').on('change', function(e){
        if(!$("#select_kab").prop( "disabled" )){
            var id = e.target.value;
            $("#select_kab").empty();
            var l = $("#tingkat").val();
            if(l == 2){
                $.get('/ajax-kab?id='+ id, function(datas){
                    $.each(datas, function(i, data){
                        $("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
                    });
                });
            } else if (l == 3){
                $.get('/ajax-kota?id='+ id, function(datas){
                    $.each(datas, function(i, data){
                        $("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
                    });
                });
            } else {
                $.get('/ajax-kabkot?id='+ id, function(datas){
                    $.each(datas, function(i, data){
                        $("#select_kab").append('<option value="'+data.id+'">'+data.nama_kabkot+'</option>');
                    });
                });
            }
        }
    });

    $('#select_kab').on('change', function(e){
        if(!$("#select_kec").prop( "disabled" )){
            var id = e.target.value;
            $("#select_kec").empty();
            //ajax
            $.get('/ajax-kec?id='+ id, function(datas){
                $.each(datas, function(i, data){
                    $("#select_kec").append('<option value="'+data.id+'">'+data.nama_kec+'</option>');
                });
            });
        }
    });
</script>
@endsection
