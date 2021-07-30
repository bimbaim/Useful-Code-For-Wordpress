<?php
//Validate cf7 form 
function custom_textarea_validation_filter($result, $tag) {  
$type = $tag['type'];
$name = $tag['name'];
if($name == 'your-message') {
$value = $_POST[$name];
		$nourl_pattern = '(http|https|href)';
    	$latin = "/^[a-zA-ZàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ\s\d.('\"£$%!&*()}{@#~><>|=_+^?\/\\;:,,.)]+$/";
if(preg_match($nourl_pattern,$value)){

    $result->invalidate( $tag, "Message cannot contain website addresses." );
                }
                
else if(!preg_match($latin,$value)){

    $result->invalidate( $tag, "Message cannot contain non-latin word." );
                }
}
return $result;
}
add_filter('wpcf7_validate_textarea','custom_textarea_validation_filter', 10, 2);
add_filter('wpcf7_validate_textarea*', 'custom_textarea_validation_filter', 10, 2);

function custom_text_validation_filter($result, $tag) {  
$type = $tag['type'];
$name = $tag['name'];
if($name == 'your-subject') {
$value = $_POST[$name];
		$nourl_pattern = '(http|https|href)';
    	$latin = "/^[a-zA-ZàèìòùÀÈÌÒÙáéíóúýÁÉÍÓÚÝâêîôûÂÊÎÔÛãñõÃÑÕäëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ\s\d.('\"£$%!&*()}{@#~><>|=_+^?\/\\;:,,.)]+$/";
if(preg_match($nourl_pattern,$value)){

    $result->invalidate( $tag, "Subject cannot contain website addresses." );
                }
                
else if(!preg_match($latin,$value)){

    $result->invalidate( $tag, "Subject cannot contain non-latin word." );
                }
}
return $result;
}
add_filter('wpcf7_validate_text','custom_text_validation_filter', 10, 2);
add_filter('wpcf7_validate_text*', 'custom_text_validation_filter', 10, 2);
