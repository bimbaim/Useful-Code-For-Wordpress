<?php
add_shortcode('courses-banner-content', function(){
	ob_start();
	extract( shortcode_atts(
		array(
			'extra_class'	=> ''
		),
		$atts
	));
	
	return ob_get_clean();
});
