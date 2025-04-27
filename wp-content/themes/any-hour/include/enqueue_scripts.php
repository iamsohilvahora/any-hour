<?php
/**
 * Enqueue scripts and styles.
 */
function any_hour_scripts() {
	wp_enqueue_style( 'any-hour-style', get_stylesheet_uri(), array(), '02-11-2020' );
	wp_enqueue_style( 'any-hour-responsive-style', get_template_directory_uri() . '/css/responsive.css', array(), '02-11-2020' );
	wp_style_add_data( 'any-hour-style', 'rtl', 'replace' );

	wp_enqueue_script( 'any-hour-custom', get_template_directory_uri() . '/js/custom.js', array(), '02-11-2020', true );
	wp_enqueue_script( 'any-hour-customizer', get_template_directory_uri() . '/js/customizer.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'any-hour-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	 /**************** For jQuery-AJAX *****************/
	// wp_enqueue_script( 'mr-brown-assets-custom', get_template_directory_uri() . '/js/custom.js', array(), '20151215', true);
	// wp_localize_script( 'mr-brown-assets-custom', "post_list_admin_URL_NAME",  post_list_admin_URL());
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function any_hour_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'any_hour_content_width', 640 );
}