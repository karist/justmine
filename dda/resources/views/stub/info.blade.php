@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Stub</div>
                @if(Session::get('error_code') == 5)
                    <script>
                        $(function() {
                            $('#myModal').modal('show');
                        });
                    </script>
                @endif
                <div class="panel-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                        {!! Session::get('success') !!}
                        </div>
                    @endif
                	@include('modals/mod-stub-cr')
                	<button type="button" class="btn btn-info btn-lg pull-right" data-toggle="modal" data-target="#myModal">Tambah Stub</button>
                </div>
                @include('modals/mod-stub-ed')
                <table class="table table-bordered tableList table-hover category-table" data-toggle="dataTable" data-form="deleteForm">
				    <thead>
				      <tr>
				        <th>Stub</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
				        <th>Detail Rincian</th>
				        <th>Ubah</th>
				      </tr>
				    </thead>
				    <tbody>
				    	@foreach($stubattrs as $stubattr)
                			<tr>
                				<td>{{ $stubattr->stubindo }}</td>
                                <td>{{ $stubattr->type }}</td>
                                <td>
                                    {{ $stubattr->length }}
                                </td>
                				<td><select>
                					@foreach($stubs as $stub)
                						@if($stub->stubname == $stubattr->stubname)
									    <option value="{{ $stub->id }}">{{ $stub->rincian }} / {{ $stub->details }}</option>
									    @endif
									@endforeach
                				</select></td>
                				<td>
                				<a class="btn btn-default btn-sm pull-right" href="{{ url('stubs/'.$stubattr->stubname.'/edit') }}"><span class="glyphicon glyphicon-edit"></span></a>
                                {!! Form::model($stubattr, ['method' => 'delete', 'route' => ['stubs.destroy', $stubattr->stubname], 'class' =>'form-inline form-delete']) !!}
                                    {!! Form::hidden('stubname', $stubattr->stubname) !!}
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', array('type' => 'submit', 'class' => 'pull-right btn btn-sm btn-danger delete', 'name' => 'delete_modal' )) !!}
                                {!! Form::close() !!}
                				</td>
                			</tr>
            			@endforeach
				    </tbody>
				</table>
                <div class="pagination pull-right"> {{ $stubattrs->links() }} </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script src="{{ URL::asset('js/addremovefield.js') }}"></script>
@endsection