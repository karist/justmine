<form action="{{ url('narasi')}}" method="POST" role="form">
	<legend>Entry Narration</legend>

	<div class="form-group">
		<label for="">Bab</label>
		<select name="dd_bab" id="dd_bab" class="form-control" required="required">
			<option>Choose here</option>
            @foreach($babs as $bab)
                <option value="{{ $bab->id }}">{{ $bab->nama_bab }}</option>
            @endforeach
		</select>
	</div>

	<div class="col-md-6">
	<label for="narr_in">Narration in Bahasa</label>
	<input type="hidden" id="narr_in" name="narr_in"/>
		<div class = "editable">
		</div>
	</div>
	<div class="col-md-6">
	<label for="narr_eng">Narration in English</label>
	<input type="hidden" id="narr_eng" name="narr_eng"/>
		<div class = "editable">
		</div>
	</div>
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<button type="submit" id="showtext" class="btn btn-primary pull-right">Submit</button>
	<button type="button" id="translate_btn" class="btn btn-default pull-right">Translate</button>
</form>