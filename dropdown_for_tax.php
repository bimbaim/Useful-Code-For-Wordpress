<?php
//Method 1
function miq_custom_taxonomy_dropdown( $taxonomy ) {
	$terms = get_terms( $taxonomy );
	if ( $terms ) {
		printf( '<select name="%s" class="postform">', esc_attr( $taxonomy ) );
		foreach ( $terms as $term ) {
			printf( '<option value="%s">%s</option>', esc_attr( $term->slug ), esc_html( $term->name ) );
		}
		print( '</select>' );
	}
}


//Put this in template
miq_custom_taxonomy_dropdown( 'my_custom_taxonomy' );


//Method 2
function miq_custom_taxonomy_dropdown( $taxonomy, $orderby = 'date', $order = 'DESC', $limit = '-1', $name, $show_option_all = null, $show_option_none = null ) {
	$args = array(
		'orderby' => $orderby,
		'order' => $order,
		'number' => $limit,
	);
	$terms = get_terms( $taxonomy, $args );
	$name = ( $name ) ? $name : $taxonomy;
	if ( $terms ) {
		printf( '<select name="%s" class="postform">', esc_attr( $name ) );
		if ( $show_option_all ) {
			printf( '<option value="0">%s</option>', esc_html( $show_option_all ) );
		}
		if ( $show_option_none ) {
			printf( '<option value="-1">%s</option>', esc_html( $show_option_none ) );
		}
		foreach ( $terms as $term ) {
			printf( '<option value="%s">%s</option>', esc_attr( $term->slug ), esc_html( $term->name ) );
		}
		print( '</select>' );
	}
}
//Put this on template
miq_custom_taxonomy_dropdown( 'my_custom_taxonomy', 'date', 'DESC', '5', 'my_custom_taxonomy', 'Select All', 'Select None' ); ?>
