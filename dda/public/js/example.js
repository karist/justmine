(function ( $ ) {
	$.fn.deletecolumn = function() {
		e.preventDefault();
		this.parent('div').remove();
	}
}( jQuery ));