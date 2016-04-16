jQuery(document).ready(function($) {

	$('.bsvg-video-group').change(function() {
	
		var id = $(this).val();
		$('.bsvg-shortcode').val('[bsvg id="'+id+'"]');
		
	});
	
	$('#bsvg_send_to_editor').click(function() {
		
		var shortcode = $('.bsvg-shortcode').val();
        window.send_to_editor(shortcode);
        
    });
	
});