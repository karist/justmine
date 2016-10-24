@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">   
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pull-right">
                    <a href="dda/create" type="button" class="btn btn-primary btn-block" data-toggle="tooltip" data-placement="top" title="Tambah project DDA baru">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </div> 
                <h1>{{$lvl}} {{ $daerah }} Dalam Angka</h1>
                Pendistribusian publikasi DDA baik <i>softcopy</i> maupun <i>hardcopy</i> sudah harus diterima pusat cq. Subdit Publikasi dan Kompilasi Statistik selambat-lambatnya pada <b>17 Agustus</b> pada tahun berjalan</p>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
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
                            <td>
                                {{ $dda->status === 0 ? "Pending" : "Published" }}
                            </td>
                            <td>
                                {!! Form::model($dda, ['method' => 'delete', 'route' => ['dda.destroy', $dda->id], 'class' =>'form-inline form-delete']) !!}
                                    {!! Form::hidden('dda', $dda->id) !!}
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', array('type' => 'submit', 'class' => 'pull-right btn btn-sm btn-danger delete', 'name' => 'delete_modal', 'data-toggle'=>'tooltip', 'data-placement'=> 'top', 'title'=>'Hapus project DDA' )) !!}
                                {!! Form::close() !!}
                                <a class="btn btn-info btn-sm pull-right" href="{{ URL::route('result',array('download'=>'pdf', 'id'=>$dda->id)) }}" data-toggle="tooltip" data-placement="top" title="Unduh file PDF"><span class="glyphicon glyphicon-download"></span></a>
                                <a class="btn btn-default btn-sm pull-right" href="{{ url('dda/'.$dda->id) }}" data-toggle="tooltip" data-placement="top" title="Buka project DDA"><span class="glyphicon glyphicon-folder-open"></span></a>
                                <a class="btn btn-default btn-sm pull-right" href="{{ url('dda/'.$dda->id.'/edit') }}" data-toggle="tooltip" data-placement="top" title="Ubah daftar tabel DDA"><span class="glyphicon glyphicon-edit"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('postJquery')
    @parent
@endsection