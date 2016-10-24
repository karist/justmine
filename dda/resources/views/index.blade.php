<html ng-app="JSONedit">
    @extends('layouts.app')
    @section('content')

        <div id="mainView" ng-controller="MainViewCtrl">
            <h2>JSONedit</h2>

            <div class="jsonView">
                <json child="jsonData" default-collapsed="false" type="array"></json>
            </div>
            <hr>
            <form name="columnform" method="post" role="form">
                <div class="form-group">
                    <textarea id="jsonTextarea" ng-model="jsonString"></textarea>
                    <span class="red" ng-if="!wellFormed">JSON not well-formed!</span>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" name="sendjson" id="sendjson"class="btn btn-primary" alt="Send JSON" value="Send JSON"/>
            </form>
        </div>

    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('js/angular.min.js') }}"></script>
    <script src="{{ URL::asset('js/sortable.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles.css') }}">
    <script src="{{ URL::asset('js/directives.js') }}"></script>
    <script src="{{ URL::asset('js/JSONedit.js') }}"></script>
@endsection
</html>