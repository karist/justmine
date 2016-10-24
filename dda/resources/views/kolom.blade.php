<style>
div{
	border-color: black;
}
</style>

<button class="btn btn-default col-sm-8 add">Add</button><br/>
<label for="pilihan">Add Column</label>
<select id = "pilihan">
	<option>text</option>
	<option>object</option>
</select>
<div id="displaypilihan"></div>

<div id="display"></div>
<p id = "show"></p>

<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script src="{{ URL::asset('js/kolom.js') }}"></script>