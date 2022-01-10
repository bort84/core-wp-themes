jQuery(document).ready(function($) {
	if ($('#submitdiv').length) { // check that the element exists before running
	  	/* WP page/post fixed/scroll submit/publish box */
		var wpMenuOffset = $('#side-sortables').offset(); // grab sidebar offset;
		var bottom = $('#side-sortables').height(); // grab side bar height (for Submit box only)

		$('#submitdiv').append('<a class="anchor" href="#wpbody">Back to Top</a>'); // append back top anchor

		$(window).scroll(function(){

			var scrollPoint = $(window).scrollTop(); // grab scoll bar position
			var start = wpMenuOffset.top + bottom; // grab offset top of sidebar and add side bar height to get the bottom value
			
			if ( scrollPoint > start ) {
				$('#side-sortables').addClass('active') // add active class when scroll bar hits start
				// $('#submitdiv a').show();

			} else if ( scrollPoint < start) {
				$('#side-sortables').removeClass('active'); // remove active class when scroll bar hits start point
			}
		});
	}
});