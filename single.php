<?php

//* Custom entry navigation
add_action( 'genesis_after_entry', 'unfiltered_entry_nav', 9 );
function unfiltered_entry_nav() {

	echo '<div class="entry-nav">';
	next_post_link( '%link', '') ;
	previous_post_link( '%link', '' );
	echo '</div>';

}

//* Filter next post entry navigation
add_filter( 'next_post_link', 'post_link_attributes' );
function post_link_attributes($output) {

	$code = 'class="dashicons dashicons-arrow-left-alt2"';
	return str_replace('<a href=', '<a '.$code.' href=', $output);

}

//* Filter previous post entry navigation
add_filter( 'previous_post_link', 'post_link_attributes_previous' );
function post_link_attributes_previous($output) {

	$code = 'class="dashicons dashicons-arrow-right-alt2"';
	return str_replace('<a href=', '<a '.$code.' href=', $output);

}

//* Run the Genesis loop
genesis();
