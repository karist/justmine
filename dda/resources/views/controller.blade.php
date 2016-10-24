<div id="con">
    <div id="con1">
        <form class="form-horizontal" role="form">
            <div class="form-group form-group-sm">
                <label for="bab_prop" class="up control-label col-sm-3">Bab: </label>
                <div class="col-sm-8">
                    <select class="form-control input-sm" name="bab" id="bab">
                        <option>Choose here</option>
                        @foreach($babs as $bab)
                            <option value="{{ $bab->id}}">{{ $bab->nama_bab }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="subbab_prop" class="up control-label col-sm-3">Sub Bab: </label>
                <div class="col-sm-8">
                    <select class="form-control input-sm" name="subbab" id="subbab">
                    <option>Choose subbab</option>
                    </select>
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="tabno_prop" class="up control-label col-sm-3">Table Number: </label>
                <div class="col-sm-8">
                    <input class="up form-control input-sm" type=text id="tabno_prop" placeholder="Table Number">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="tabname_prop" class="up control-label col-sm-3">Judul Tabel: </label>
                <div class="col-sm-8">
                    <input class="up form-control input-sm" type="text" id="tabname_prop" placeholder="Judul Tabel">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="tabtitle_prop" class="up control-label col-sm-3">Table Title: </label>
                <div class="col-sm-8">
                    <input class="up form-control input-sm" type="text" id="tabtitle_prop" placeholder="Table Title">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <div class="col-sm-10 col-sm-offset-4">
                    <input class="up btn btn-primary" type="button" id="saveup" value="Save">
                </div>
            </div>
        </form>
    </div>

    <div id="con2">
        <form class="form-horizontal" role="form">
            <div class="form-group form-group-sm">
                <label for="sumber_prop" class="control-label col-sm-3">Sumber: </label>
                <div class="col-sm-8">
                    <input class="form-control input-sm" type="text" id="sumber_prop" placeholder="Sumber Tabel">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="source_prop" class="control-label col-sm-3">Source: </label>
                <div class="col-sm-8">
                    <input class="form-control input-sm" type="text" id="source_prop" placeholder="Table Source">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label for="catatan_prop" class="control-label col-sm-3">Catatan: </label>
                <div class="col-sm-8">
                    <input class="form-control input-sm" type="text" id="catatan_prop" placeholder="Catatan (optional)">
                </div>
            </div>         
            <div class="form-group form-group-sm">
                <div class="col-sm-10 col-sm-offset-4">
                    <button type="button" class="btn btn-primary" id="savedown" value="Save Down">Save</button>
                </div>
            </div>
        </form>
    </div>

    <div id="con3">
        <input class="addColumn" type="button" title="Add column" value="Add Column">
        <div class="scrollbar">
            <div class="force-overflow">
                <div class="column_wrapper">
                    <div>
                        <input type="text" name="kolom[]" value=""/><button type="button" class="add_sub btn btn-default btn-sm" title="Add sub column">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <input class="mid" type="button" id="savemid" value="Save Mid">
    </div>
</div>
<div id = "con4">
    <div id="mainView" ng-controller="MainViewCtrl">
        <h4>Pengaturan Kolom</h4>

        <div class="jsonView custom_scrollbar">
            <json child="jsonData" default-collapsed="false" type="array"></json>
        </div>
        <hr>
        <div class="pull-left">
            <textarea id="jsonTextarea" ng-model="jsonString"></textarea>
            <span class="red" ng-if="!wellFormed">JSON not well-formed!</span>
            <input type="submit" name="sendjson" id="sendjson" class="btn btn-primary" alt="Save" value="Save"/>
        </div>
    </div>
</div>