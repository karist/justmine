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