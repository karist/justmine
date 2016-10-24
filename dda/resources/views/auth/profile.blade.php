@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<img src = "{{ URL::asset('avatar/'.$user->avatar) }}" style="width:150px;height:150px; float:left; border-radius:50%; margin-right:25px;">
			<h2>{{ $user->name }}'s Profile</h2>
			<hr/>
			<a class="btn btn-primary" data-toggle="modal" href='#modal-id'>Ubah Password</a>
			<hr/>
			<form enctype="multipart/form-data" action="/profile" method="POST" class="form-inline" role="form">
				<div class="form-group">
					<label for="avatar">Ubah Foto Profil</label>
					<input type="file" name="avatar" id="avatar">
				</div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="submit" class="btn btn-sm btn-default" value="Ubah Foto Profil">
			</form>
		</div>
	</div>
</div>
@endsection
<div class="modal fade" id="modal-id">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Ubah Password</h4>
			</div>
			<div class="modal-body">
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/password') }}">
        		{{ csrf_field() }}
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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
				</div>
			</form>
		</div>
	</div>
</div>