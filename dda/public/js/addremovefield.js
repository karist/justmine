$(document).ready(function(){
	var maxField = 40; //Input fields increment limitation
	// var addButton = $('.add_button'); //Add button selector
	// var wrapper = $('.field_wrapper'); //Input field wrapper
	var x = 1; //Initial field counter is 1
	// var col = 1;
	// var y = 1;
	$('.add_button').click(function(){ //Once add button is clicked
		if(x < maxField){ //Check maximum number of input fields
			x++; //Increment field counter
			var fieldHTML = '<div><div class="col-sm-5"><input placeholder="Istilah dalam Bahasa" type="text" class="form-control" name="field_indo[]"/></div><div class="col-sm-5"><input placeholder="English Term" type="text" class="form-control" name="field_eng[]"/></div><div class="col-sm-2"><button type="button" class="remove_button btn btn-default btn-sm" id="remove_button"><span class="glyphicon glyphicon-trash"></span></button></div></div>'; 
			$('.field_wrapper').append(fieldHTML); // Add field html
		}
	});
	$('.field_wrapper').on('click', '.remove_button', function(e){ //Once remove button is clicked
		// var x = $(this).parent('div').size();
		e.preventDefault();
		$(this).parent('div').parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
	$('.addColumn').click(function(){ //Once add button is clicked
		var fieldHTML = '<div><input type="text" name="kolom[]" value=""/><a href="javascript:void(0);" class="add_sub" title="Add sub column"><img src="images/sub-column.png"/></a><a href="javascript:void(0);" class="remove_column" title="Remove field"><img src="images/delete-sub.png"/></a></div>';
		var col = $(this).parent('div').size();
		if(col < maxField){ //Check maximum number of input fields
			// col++; //Increment field counter
			$('.column_wrapper').append(fieldHTML); // Add field html
		}
	});
	$('.column_wrapper').on('click', '.remove_column', function(e){ //Once remove button is clicked
		var col = $(this).parent('div').size();
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		// col--; //Decrement field counter
	});
	$('.column_wrapper').on('click', '.add_sub', function(e){
		var fieldHTML = '<div><input class = "sub" type="text" name="kolom2[]" value=""/><a href="javascript:void(0);" class="add_sub2" title="Add sub sub column"><img src="images/sub-column.png"/></a><a href="javascript:void(0);" class="del_sub" title="Remove sub column"><img src="images/delete-sub.png"/></a></div>';
		var y = $(this).parent('div').size();
		if(y < maxField){
			// y++;
			$(this).parent('div').append(fieldHTML);
		}
	});
	$('.column_wrapper').on('click', '.del_sub', function(e){ //Once remove button is clicked
		var y = $(this).parent('div').size();
		e.preventDefault();
		// alert(y+" "+ $(this).parent('div').parent().children().size());
		$(this).parent('div').remove(); //Remove field html
		// y--; //Decrement field counter
	});
	$('.column_wrapper').on('click', '.add_sub2', function(e){
		var fieldHTML = '<div><input class = "sub2" type="text" name="kolom3[]" value=""/><a href="javascript:void(0);" class="add_sub3" title="Add sub sub column"><img src="images/sub-column.png"/></a><a href="javascript:void(0);" class="del_sub2" title="Remove sub column"><img src="images/delete-sub.png"/></a></div>';
		var y = $(this).parent('div').size();
		if(y < maxField){
			// y++;
			$(this).parent('div').append(fieldHTML);
		}
	});
	$('.column_wrapper').on('click', '.del_sub2', function(e){ //Once remove button is clicked
		var z = $(this).parent('div').size();
		e.preventDefault();
		// alert(y+" "+ $(this).parent('div').parent().children().size());
		$(this).parent('div').remove(); //Remove field html
		// z--; //Decrement field counter
	});
	$('.column_wrapper').on('click', '.add_sub3', function(e){
		var fieldHTML = '<div><input class = "sub3" type="text" name="kolom4[]" value=""/><a href="javascript:void(0);" class="add_sub4" title="Add sub sub column"><img src="images/sub-column.png"/></a><a href="javascript:void(0);" class="del_sub3" title="Remove sub column"><img src="images/delete-sub.png"/></a></div>';
		var z = $(this).parent('div').size();
		if(z < maxField){
			// z++;
			$(this).parent('div').append(fieldHTML);
		}
	});
	$('.column_wrapper').on('click', '.del_sub3', function(e){ //Once remove button is clicked
		e.preventDefault();
		// alert(y+" "+ $(this).parent('div').parent().children().size());
		// var w = $(this).parent('div').size();
		$(this).parent('div').remove(); //Remove field html
		// w--; //Decrement field counter
	});
	$('.column_wrapper').on('click', '.add_sub4', function(e){
		var fieldHTML = '<div><input class = "sub4" type="text" name="kolom5[]" value=""/><a href="javascript:void(0);" class="del_sub4" title="Remove sub column"><img src="images/delete-sub.png"/></a></div>';
		var y = $(this).parent('div').size();
		if(y < maxField){
			$(this).parent('div').append(fieldHTML);
		}
	});
	$('.column_wrapper').on('click', '.del_sub4', function(e){ //Once remove button is clicked
		e.preventDefault();
		// alert(y+" "+ $(this).parent('div').parent().children().size());
		// var w = $(this).parent('div').size();
		$(this).parent('div').remove(); //Remove field html
		// w--; //Decrement field counter
	});
});