<div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Daftar Tabel</div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($templates as $template)
                            <li class="list-group-item" id="{{ $template->id }}">{{ $template->tabno }}  : {{ $template->tabtitle }}</li>
                        @endforeach
                    </ul>            
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                            {!! Session::get('success') !!}
                            </div>
                        @endif
                    <p id="jsonp" hidden>{{ $template->tabtemplate }}</p>
                    <form name="tableform" method="POST" role="form" action="{{ url('dda/'.$id.'/entry')}}">
                        <div id="display">
                            <div id="up">
                                <table id="tabhead" border="0">
                                    <tr>
                                        <td class="garis"><b>Tabel</b></td>
                                        <td rowspan="2"><input type="text" class="up" id="tabno" name="tabno"readonly> : </td>
                                        <td><input type="text" class="up" id="tabname" name="tabname" readonly></td>
                                    </tr>
                                    <tr>
                                        <td><b><i>Table</i></b></td>
                                        <td><input type="text" class="up" id="tabtitle" name="tabtitle" readonly></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="container" class="tablePreview">
                            </div>
                            <div id="tabfooter">
                              <label class="down" id="sumberlbl">Sumber</label><i><label class="down" id="sourcelbl"></label></i>: <input type="text" class="up" id="sumber" readonly><p id="slash"></p><i><input type="text" class="up" id="source" readonly></i><br>
                              <p class="down" id="cat"></p>
                            </div>
                        </div>
                        <input type="hidden" id="table_id" name="table_id"/>
                        <input type="hidden" id="table_data" name="table_data"/>
                        <input type="hidden" id="table_column" name="table_column"/>
                        <input type="hidden" id="table_stub" name="table_stub"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a type="button" class="btn btn-default pull-right" id="back" value="Back" href="{{ url('templates') }}">Back</a>
                        <button type="button" class="btn btn-info btn-lg paste" data-toggle="modal" data-target="#pasteModal">
                            <span class="glyphicon glyphicon-paste"></span>
                        </button>
                        <input type="submit" class="btn btn-primary pull-right" name="savedata" alt="Save Data" value="Save Data"/>
                    </form>
                </div>
            </div>
        </div>