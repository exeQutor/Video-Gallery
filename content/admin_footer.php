<div id="bsvg_thickbox" style="display:none;">
    <div class="wrap">
    	<p>
	    	Video Group: 
	        <select class="bsvg-video-group">
	        	<?php foreach ($video_galleries as $video_gallery): ?>
	        	<option value="<?php echo $video_gallery->ID ?>"><?php echo $video_gallery->post_title ?></option>
	        	<?php endforeach ?>
	        </select>
	    </p>
        
        <p>
	        Shortcode: <input type="text" class="bsvg-shortcode" value='[bsvg id="<?php echo $video_galleries[0]->ID ?>"]' readonly>
	    </p>
        
        <p><input type="button" id="bsvg_send_to_editor" class="button-primary" value="Insert Shortcode" /></p>
    </div>
</div>