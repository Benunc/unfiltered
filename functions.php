<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'unfiltered_enqueue_scripts_styles' );
function unfiltered_enqueue_scripts_styles() {

	// Enqueue header menu script
	wp_enqueue_script( 'header-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/menu.js', array( 'jquery' ), '1.0.0' );

	// Enqueue dashicons style
	wp_enqueue_style( 'dashicons' );

}

//* Dequeue scripts
add_action( 'wp_enqueue_scripts', 'unfiltered_dequeue_devicepx', 20 );
function unfiltered_dequeue_devicepx() {

	wp_dequeue_script( 'devicepx' );

}

//* Filter open graph tags to use Genesis doctitle and meta description instead
add_filter( 'jetpack_open_graph_tags', 'unfiltered_jetpack_open_graph_tags_filter' );
function unfiltered_jetpack_open_graph_tags_filter( $tags ) {

	// Do nothing if not a single post
	if ( ! is_singular() )
		return $tags;

	// Pull from custom fields
	$title = genesis_get_custom_field( '_genesis_title' );
	$description = genesis_get_custom_field( '_genesis_description' );

	// Set new values for title and description
	$tags['og:title'] = $title ? $title : $tags['og:title'];
	$tags['og:description']	= $description ? $description : $tags['og:description'];

	return $tags;

}

//* Unregister navigation menus
remove_theme_support( 'genesis-menus' );

//* Force full-width-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister sidebars
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Remove site title & description
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Add support for post formats
add_theme_support( 'post-formats', array(
	'aside',
	'image',
	'link',
	'quote'
) );

// Add post format dashicons
add_action( 'genesis_entry_content', 'unfiltered_post_format', 9 );
function unfiltered_post_format() {

	// Display dashicon for aside post formats
	if ( get_post_format() == 'aside' ) {
		echo '<a class="dashicons dashicons-welcome-write-blog" href="http://unfiltered.me/type/posts/"></a>';
	}

	// Display dashicon for image post formats
	elseif ( get_post_format() == 'image' ) {
		echo '<a class="dashicons dashicons-camera" href="http://unfiltered.me/type/images/"></a>';
	}

	// Display dashicon for link post formats
	elseif ( get_post_format() == 'link' ) {
		echo '<a class="dashicons dashicons-admin-links" href="http://unfiltered.me/type/links/"></a>';
	}

	// Display dashicon for quote post formats
	elseif ( get_post_format() == 'quote' ) {
		echo '<a class="dashicons dashicons-format-quote" href="http://unfiltered.me/type/quotes/"></a>';
	}

}

//* Remove the entry header markup
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//* Modify the WordPress read more link
add_filter( 'the_content_more_link', 'unfiltered_read_more' );
function unfiltered_read_more() {

	return '<a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';

}

//* Customize the entry meta in the entry footer
add_filter( 'genesis_post_meta', 'unfiltered_post_meta_filter' );
function unfiltered_post_meta_filter($post_meta) {

	$post_meta = 'Published on [post_date] by [post_author_posts_link] in [post_categories before=""] [post_edit]';
	return $post_meta;

}

//* Add subscribe text after entry
add_action( 'genesis_entry_footer', 'unfiltered_subscribe_text', 12 );
function unfiltered_subscribe_text() {

	// Only display on singular posts with aside post format
	if ( is_singular( 'post' ) && get_post_format() == 'aside' ) {
	
	echo '<p class="subscribe">Like what you read on my blog? <a href="http://unfiltered.me/subscribe/">Subscribe now</a> and get it delivered to your inbox.<ahref="http://unfiltered.me/subscribe/"></a></p>';
	}

}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'unfiltered_remove_comment_form_allowed_tags' );
function unfiltered_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'unfiltered_author_box_gravatar' );
function unfiltered_author_box_gravatar( $size ) {

	return '160';

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'unfiltered_comments_gravatar' );
function unfiltered_comments_gravatar( $args ) {

	$args['avatar_size'] = 120;
	return $args;

}

//* Create a custom Gravatar
add_filter( 'avatar_defaults', 'unfiltered_custom_gravatar' );
function unfiltered_custom_gravatar ($avatar) {

	$custom_avatar = get_stylesheet_directory_uri() . '/images/gravatar.png';
	$avatar[$custom_avatar] = "Custom Gravatar";
	return $avatar;

}

//* Customize the site footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_footer', 'bg_footer' );
	function bg_footer() { ?>

	<div class="site-footer"><div class="wrap"><p>Powered by <a href="http://www.starbucks.com/">Starbucks lattes</a>, <a href="http://www.sarahmclachlan.com/">really good music</a> and the <a href="http://www.studiopress.com/">Genesis Framework</a>.</p><p>Follow me on <a href="http://www.facebook.com/bgardner">Facebook</a>, <a href="http://plus.google.com/109450535379570250650?rel=author">Google+</a>, <a href="http://instagram.com/bgardner">Instagram</a> or <a href="http://twitter.com/bgardner" rel="me">Twitter</a>.</p></div></div>

	<?php
}