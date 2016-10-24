@extends('admin.admin')

@section('contentAdmin')
<div class="panel-heading">Bab</div>

<div class="panel-body">
    <a class="btn btn-info pull-right" action = "route('admin.bab.store')" method="post" data-toggle="modal" href='#modal-id'>Tambah Bab</a>
    <div class="modal fade" id="modal-id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Tambah Bab</h4>
                </div>
                <div class="modal-body">
                    <form name="codexworld_frm" method="post" class="form-horizontal" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="stub_nama">Nama Bab:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="stub_nama" id="stub_nama">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="stub_label">Terjemahan Nama Bab:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="stub_label" id="stub_label">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="stub_detail">Subbab:</label>
                        <div class="col-sm-10">
                            <a class="add_button" title="Add field" id="add">Tambah Isian:</a>
                            <div class="scrollbar">
                                <div class="force-overflow">
                                    <div class="field_wrapper">
                                        <div>
                                            <div class="col-sm-5">
                                                <input placeholder="Istiah dalam Bahasa" type="text" class="form-control" name="field_indo[]"/>
                                            </div>
                                            <div class="col-sm-5">
                                                <input placeholder="English Term" type="text" class="form-control" name="field_eng[]"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Bab</button>
                </div>
            </div>
        </div>
    </div>
</div>
<table class="table table-striped">
    <thead>
      <tr>
        <th>Nomor</th>
        <th>Nama Bab</th>
        <th>Subject</th>
        <th>Subbab</th>
        <th>Ubah</th>
      </tr>
    </thead>
    <tbody>
    	@foreach($babs as $bab)
			<tr>
				<td>{{ $bab->nomorbab }}</td>
                <td>{{ $bab->nama_bab }}</td>
                <td>{{ $bab->nama_eng }}</td>
				<td><select>
					@foreach($subbabs as $sub)
						@if($sub->bab == $bab->id)
					    <option value="{{ $sub->id }}">{{ $sub->nama_sub }}</option>
					    @endif
					@endforeach
				</select></td>
				<td>
				<a class="btn btn-default btn-sm pull-right" href="{{ url('admin/babs/'.$bab->id.'/edit') }}"><span class="glyphicon glyphicon-edit"></span></a>
				<button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#mod-delete-stub"><span class="glyphicon glyphicon-trash"></span></button>
				</td>
			</tr>
		@endforeach
    </tbody>
</table>
</div>

<!-- Modal -->
<div class="modal fade" id="mod-delete-stub" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapusnya?</p>
            </div>
            <div class="modal-footer">
                {{ Form::open(['method' => 'DELETE', 'route' => ['admin.bab.destroy', $bab->id]]) }}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{ Form::close() }}
            </div>
      </div>      
</div>
    
<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script src="{{ URL::asset('js/addremovefield.js') }}"></script>
@endsection
