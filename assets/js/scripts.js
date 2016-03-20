jQuery(document).ready(function($) {

	$('ul.bsvg-list > li > a').hover(function() {
		$(this).find('.title-overlay').show().addClass('slideInUp');
	}, function() {
		$(this).find('.title-overlay').removeClass('slideInUp').hide();
	});
	
});