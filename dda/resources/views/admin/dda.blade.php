@extends('admin.admin')

@section('contentAdmin')
<div class="panel-heading">DDA yang sudah dipublikasikan</div>
<div class="panel-body">

<table class="table table-striped">
    <thead>
      <tr>
        <th>Nama DDA</th>
        <th>Tahun</th>
        <th>Status</th>
        <th>Ubah</th>
      </tr>
    </thead>
    <tbody>
        @foreach($ddas as $dda)
        <tr>
            <td>{{ $dda->id }}</td>
            <td>{{ $dda->tahun }}</td>
            <td>{{ $dda->status }}</td>
            <td>
                <a class="btn btn-info btn-sm pull-right" href="{{ URL::route('result',array('download'=>'pdf', 'id'=>$dda->id)) }}"><span class="glyphicon glyphicon-download"></span>Unduh</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection