(function ( $ ) {
	var arr = [];
	var additional = '<button class="add-child">Add</button><button class="delete">Delete</button>';
	$("#pilihan").change(function(e){
		$('#display').empty();
        var input = e.target.value;
        if(input == 'text'){
            $('#display').append('<input type="text"><button class="oke">Oke</button>');
        } else if(input == 'object') {
            $('#display').append('<input type="text"><div><input type="text"><input type="text"><button class="add-child">Add</button></div><button class="oke">Oke</button>');
        }
        $('.oke').on('click',function(){
			$('#show').text(JSON.stringify(arr));
		});
    });
	$('.add').on('click',function(){
		$('#display').append('<div><input type="text">'+additional+'</div>');
	});
	$('#display').on('click', '.delete', function(e){
		e.preventDefault();
		$(this).parent('div').remove();
	});
	$('#display').on('click', '.add-child', function(e){
		$(this).parent('div').append('<div><input type="text">'+additional+'</div>');
		
	});
}( jQuery ));