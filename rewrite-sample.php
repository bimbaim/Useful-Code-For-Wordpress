<?php
//Sample 1
function newwhello_rewriteRules( $rules ) {
	$new_rules = array(

        'online-marketing-specialist/(.+?)/([^/]+)(?:/([0-9]+))?/?$' => 'post_type=specialist&cat_specialist=$matches[1]&specialist=$matches[2]&page=$matches[3]',


        '(marketing-tips)/page/?([0-9]{1,})/?$'         => 'pagename=$matches[1]&paged=$matches[2]',
        'marketing-tips/(.+?)/page/?([0-9]{1,})/?$'     => 'post_type=post&category_name=$matches[1]&paged=$matches[2]',
        'marketing-tips/(.+?)/([^/]+)(?:/([0-9]+))?/?$' => 'post_type=post&category_name=$matches[1]&name=$matches[2]&page=$matches[3]',
        
	);
	return $new_rules + $rules;
}
add_action( 'rewrite_rules_array', 'newwhello_rewriteRules' );


//Sample 2 using class
class WhelloRewriteRules {
	
	function __construct() {
		add_action('generate_rewrite_rules', array( $this, 'rewrite_rules'), 99 );
		//add_filter( 'query_vars', array( $this, 'prefix_register_query_var') );
		
	}

	public function rewrite_rules($wp_rewrite){
		global $wp_rewrite;    
	    $rules = array();

	    $base 	= "marketing-voorbeelden";
	    $lokasi 	= get_terms( array( 'taxonomy' => 'cases', 'hide_empty' => false ));
	   	$rules[$base . '/page/?([0-9]{1,})/?$'] = 'index.php?pagename='.$base.'&paged=$matches[1]';
	   	$rules[$base . '/?$'] = 'index.php?pagename='.$base;
	   	
	    foreach($lokasi as $term) {
            $rules[$base . '/' . $term->slug . '/page/?([0-9]{1,})/?$'] = 'index.php?pagename='.$base.'&cases='.$term->slug.'&paged=$matches[1]';
            $rules[$base . '/' . $term->slug . '/([^/]+)(?:/([0-9]+))?/?$'] = 'index.php?cases=$matches[1]';
	        $rules[$base . '/' . $term->slug . '/?$'] = 'index.php?pagename='.$base.'&cases='.$term->slug;
		}

		$wp_rewrite->rules = $rules + $wp_rewrite->rules;
    
    	return $wp_rewrite->rules;
	}
	
}


new WhelloRewriteRules;

//remove spesific string in url
function __custom_messagetypes_link( $link, $term, $taxonomy )
{
    if ( $taxonomy !== 'cases' )
        return $link;

    return str_replace( 'marketing-tips/', '', $link );
}
add_filter( 'term_link', '__custom_messagetypes_link', 10, 3 );
