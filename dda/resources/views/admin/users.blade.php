@extends('admin.admin')

@section('contentAdmin')
<div class="panel-heading">Atur Pengguna</div>
<div class="panel-body">

<table class="table table-striped">
    <thead>
      <tr>
        <th>Nomor</th>
        <th>Nama</th>
        <th>Surel</th>
        <th>Daerah</th>
        <th>Administrator</th>
        <th>Ubah</th>
      </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->kode_daerah }}</td>
                <td>{{ Form::checkbox('admin[]', $user->isAdmin, $user->isAdmin, array('disabled')) }}</td>
                <td>
                <a class="btn btn-default btn-sm pull-right" href="{{ url('admin/user/'.$user->id.'/edit') }}"><span class="glyphicon glyphicon-edit"></span></a>
                <button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#mod-delete-stub"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

</div>
@endsection
