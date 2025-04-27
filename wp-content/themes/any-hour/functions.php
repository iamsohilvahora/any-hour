<?php
//Theme setup and widgets , custom option pages 
require get_template_directory().'/include/theme_setup.php'; 

//Enqueue Scripts and style , js 
require get_template_directory().'/include/enqueue_scripts.php'; 

//General Hooks , action and function used in theme globally 
require get_template_directory().'/include/general_function.php';

//custom image sizes
require get_template_directory().'/include/custom_image_size.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

//action and filter hooks
add_action( 'after_setup_theme', 'any_hour_setup' );
add_action( 'after_setup_theme', 'any_hour_content_width', 0 );
add_action( 'widgets_init', 'any_hour_widgets_init' );
add_action( 'wp_enqueue_scripts', 'any_hour_scripts' );
add_filter('login_errors', 'inn_wrong_login');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
add_filter('the_generator', 'wpt_remove_version');
remove_action('wp_head', 'wp_generator'); 
add_filter('the_generator', 'nfi_remove_version');
add_action('admin_init', 'df_disable_comments_post_types_support');
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);
add_action('admin_menu', 'df_disable_comments_admin_menu');
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
add_action('admin_init', 'df_disable_comments_dashboard');
add_action('init', 'df_disable_comments_admin_bar');
add_filter('upload_mimes', 'cc_mime_types');
add_filter('admin_post_thumbnail_html', 'add_featured_image_instruction');
