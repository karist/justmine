(function ( $ ) {
	var delete_btn = '<a class="removeElement btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>';
	var form = [];
	var num = 0;
	/* 
	 ----------------------------------------------------------------------------
	 functions that will be called upon, when user click on a button
	 ---------------------------------------------------------------------------
	 */
	$('button').on('click', function(){
		var type = $(this).attr('id');
		var input = "";
		var obj = {};
		switch(type){
			// case 'footer': input += '<label>Footer</label>'; // text [left,right,center] , enable/disable , page number, text style, margin, line, odd/even/all
			// 	obj["id"]=num;
			// 	obj["type"] = "footer";
			// 	obj["left"] = "";
			// 	obj["right"] = "";
			// 	obj["center"] = "";
			// 	obj["pagenumber"] = true;
			// 	form[num] = obj;
			// 	break;
			case 'field' : input += '<label>Field:</label><input type="text" disabled >'; // label, alignment, placeholder, input type, text style
				obj["id"]=num;
				obj["type"] = "field";
				obj["inputype"] = "";
				obj["label"] = "";
				obj["placeholder"] = "";
				form[num] = obj;
				break;
			// case 'header': input += '<label>Header</label>'; // text [left,right,center] , enable/disable , page number, text style, margin, line, odd/even/all
			// 	obj["id"]=num;
			// 	obj["type"] = "header";
			// 	obj["alignment"] = "";
			// 	obj["pagenumber"] = true;
			// 	form[num] = obj;
			// 	break;
			case 'img' : input += ' <img border="1" alt="Smiley face" height="42" width="42">'; // location, upload, height, width, 
				obj["id"]=num;
				obj["type"] = "image";
				obj["height"] = "";
				obj["width"] = "";
				form[num] = obj;
				break;
			case 'labels' : input += '<label>Label Text</label>'; // label, alignment, h1/h2/h3/h4, bold/italic/underline
				obj["id"]=num;
				obj["type"] = "label";
				obj["labeltext"] = "";
				obj["size"] = "";
				obj["bold"] = "";
				obj["italic"] = "";
				obj["underline"] = "";
				form[num] = obj;
				break;
			case 'list' : input += '<ol><li>List 1</li><li>List 2</li><li>List 3</li></ol>'; // ol/ul, alignment
				obj["id"]=num;
				obj["type"] = "list";
				obj["listype"] = ""; // ordered or unordered
				form[num] = obj;
				break;
			case 'sig' : input += '<label>Place, Date Month Year</label><br><label id="position"></label><br><br><br><input type="text" id="name" disabled>'; // salutatation, date, space, name
				obj["id"]=num;
				obj["type"] = "signature";
				obj["alignment"] = "left";
				obj["position"] = "Statistics of Indonesia";
				obj["name"] = "Full Name";
				form[num] = obj;
				break;
			case 'tab' : input += '<table border="1"><thead><tr><th>Header 01</th><th>Header 02</th><th>Header 03</th><th>Header 04</th></tr></thead><tbody><tr><td>Cell 11</td><td>Cell 12</td><td>Cell 13</td><td>Cell 14</td></tr><tr><td>Cell 21</td><td>Cell 22</td><td>Cell 23</td><td>Cell 24</td></tr><tr><td>Cell 31</td><td>Cell 32</td><td>Cell 33</td><td>Cell 34</td></tr></tbody></table>';
				obj["id"]=num;
				obj["type"] = "table";
				form[num] = obj;
				break;
			case 'text' : input += '<textarea rows="6" style="width:100%; overflow:hidden; resize:none;" disabled>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</textarea>'; // jml kolom, garis tengah, ul/ol/none, alignment, size
				obj["id"]=num;
				obj["type"] = "text";
				obj["alignment"] = "";
				form[num] = obj;
				break;
		}
		$('#myForm').append('<div class="element '+ type + ' ' + num + '">' + input + delete_btn +'</div>');
		num++;
		$('#displaytext').val(JSON.stringify(form));
	});

	$('#reset').on('click',function(){
		form = [];
		$('#myForm').empty();
	});

	$('#myForm').on('click', '.removeElement', function(e){
		e.preventDefault();
		var data = $(this).parent('.element').attr('class');
		$(this).parent('.element').remove();
		form[data.split(" ").splice(-1)] = null;
		$('#displaytext').val(JSON.stringify(form));
	});

	$('#myForm').on('click', '.element', function(e){
		e.preventDefault();
		$('.highlighted').removeClass('highlighted');
    	$(this).addClass('highlighted');
    	var idx = $(this).attr('class').split(" ")[2];
		var type = $(this).attr('class').split(" ")[1];
		showprop(type, idx);
	});

	function showprop(type, index){
		var input = "";
		switch(type){ // inputype, label
			case 'field' : input += '<label>Input Type:</label><select id="inputype"><option value="text">Text</option><option value="number">Number</option></select>'
				+ '<label>Label:</label><input type="text" id="labeltext">'
				+ '<input type="button" value="Save" id="fieldbtn">';
				break;
			case 'img' : input += '<label>Height (pixels):</label><input type="number" id="width" min="1"><br>'
				+ '<label>Width (pixels):</label><input type="number" id="width" min="1">'
				+ '<input type="button" value="Save" id="imgbtn">';
				break;
			case 'labels' : input += '<label>Label:</label><input type="text" id="labeltext">'
				+ '<input type="checkbox" id="bold" value="bold"><b>B</b>'
				+ '<input type="checkbox" id="italic" value="italic"><i>I</i>'
				+ '<input type="checkbox" id="underline" value="underline"><u>U</u>'
				+ '<br><label>Size (pixels):</label><input type="number" id="labelsize" min="9" max="32">'
				+ '<label>Alignment:</label><select id="labelalgn"><option value="left">Left</option><option value="right">Right</option><option value="center">Center</option></select>'
				+ '<input type="button" value="Save" id="labelbtn">';
				break;
			case 'list' : input += '<label>List Type:</label><select id="listype"><option value="ol">Ordered</option><option value="ul">Unordered</option></select>'
				+ '';
				break;
			case 'sig' : input += '<label>Name:</label><input type="text" id="signame">'
				+ '<label>Position:</label><input type="text" id="sigpos">'
				+ '<label>Alignment:</label><select id="sigal"><option value="left">Left</option><option value="right">Right</option></select>'
				+ '<input type="button" value="Save" id="sigbtn">';
				break;
			case 'tab' : input += '';
				break;
			case 'text' : input += '<label>Input Type:</label><select id="altype"><option value="left">Left</option><option value="right">Right</option><option value="justify">Justify</option></select>'
				+ '';
				break;
		}
		$('#properties').empty();
		$('#properties').append('<div class="' + index + '">' + input + '</div>');
		btnonclick();
	}

	function btnonclick(){
		$('#fieldbtn').on('click',function(){
			// New value
			var inputype = $('#inputype').val();
			var label = $('#labeltext').val();
			
			// Change preview pane
			var idx = $(this).parent('div').attr('class');
			$('div .highlighted').find('label').text(label+'	:');
			$('div .highlighted').find('input').attr('type', 'date');

			// Change json
			form[idx].inputype = inputype;
			form[idx].placeholder = inputype;
			form[idx].label = label;
			$('#displaytext').val(JSON.stringify(form));
		});

		$('#imgbtn').on('click',function(){

		});
		
		$('#labelbtn').on('click',function(){
			var texts = $('#labeltext').val();
			var sizes = $('#labelsize').val();
			$('.highlighted').find('label').text(texts);
			$('.highlighted').find('label').css('font-size', sizes+'px');

			var idx = $(this).parent('div').attr('class');
			form[idx].labeltext = texts;
			form[idx].size = sizes+'px';
			$('#displaytext').val(JSON.stringify(form));
		});
		
		$('#listype').on('change', function(){
			var idx = $(this).parent('div').attr('class');
			var type = $('#listype').val();
			$($('.highlighted').find('ul').add('ol').get().reverse()).each(function(){
				$(this).replaceWith($('<'+type+'>'+$(this).html()+'</'+type+'>'))
			});
			form[idx].listype = $('#listype').val();
			$('#displaytext').val(JSON.stringify(form));
		});
		
		$('#sigbtn').on('click',function(){
			// New value
			var name = $('#signame').val();
			var position = $('#sigpos').val();
			var alignment = $('#sigal').val();

			// Change preview pane
			var idx = $(this).parent('div').attr('class');
			$('#name').val(name);
			$('#position').text(position);

			// Change json
			form[idx].position = position;
			form[idx].name = name;
			form[idx].alignment = alignment;
			$('#displaytext').val(JSON.stringify(form));
		});
		
		$('#altype').on('change',function(){
			$('textarea').css('text-align', $('#altype').val());
			var idx = $(this).parent('div').attr('class');
			form[idx].alignment = $('#altype').val();
			$('#displaytext').val(JSON.stringify(form));
		});

		$('#labelalgn').on('change',function(){
			$('.highlighted').find('label').css('text-align', $('#labelalgn').val());
			var idx = $(this).parent('div').attr('class');
			form[idx].alignment = $('#labelalgn').val();
			$('#displaytext').val(JSON.stringify(form));
		});

		$('#bold').on('change', function(){
			var b = this.checked ? 'bold' : 'normal';
    		$('.highlighted').find('label').css('font-weight', b);
    		var idx = $(this).parent('div').attr('class');
    		form[idx].bold = this.checked;
    		$('#displaytext').val(JSON.stringify(form));
		});

		$('#italic').on('change', function(){
			var i = this.checked ? 'italic' : 'normal';
    		$('.highlighted').find('label').css('font-style', i);
    		var idx = $(this).parent('div').attr('class');
    		form[idx].italic = this.checked;
    		$('#displaytext').val(JSON.stringify(form));
		});

		$('#underline').on('change', function(){
			var u = this.checked ? 'underline' : 'none';
    		$('.highlighted').find('label').css('text-decoration', u);
    		var idx = $(this).parent('div').attr('class');
    		form[idx].underline = this.checked;
    		$('#displaytext').val(JSON.stringify(form));
		});
	}
}( jQuery ));