<?php 

function inn_wrong_login() {
  return 'Wrong username or password.';
}
function wpt_remove_version() {  
  return '';  
}  
// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
  $post_types = get_post_types();
  foreach ($post_types as $post_type) {
    if(post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
}

// Close comments on the front-end
function df_disable_comments_status() {
  return false;
}

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
  $comments = array();
  return $comments;
}

// Remove comments page in menu
function df_disable_comments_admin_menu() {
  remove_menu_page('edit-comments.php');
}

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
  global $pagenow;
  if ($pagenow === 'edit-comments.php') {
    wp_redirect(admin_url()); exit;
  }
}

// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}

// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
}

function isMobile() 
{
    return preg_match("/(android|iphone|\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  //return  preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function nfi_remove_version() {
  return '';
}

// ACF General Settings admin menu
if( function_exists('acf_add_options_page') ) {

  $option_page = acf_add_options_page(array(
  'page_title'  => 'General Settings',
  'menu_title'  => 'General Settings',
  'menu_slug'  => 'general-settings',
  'capability'  => 'edit_posts',
  'redirect'  => false
  ));
}


function any_hour_external_link($link = null, $target = null)
{
   if(empty($link))
    {
        return;
    }

    $href_link = null;
    
    if(!empty($link) && $link != null)
    {
        if($link == '#' )
        {
            $href_link = $link;
            $target = '';
        } 
        else
        {
            $url =  trim($link);
            if (!preg_match("~^(?:f|ht)tps?://~i", $url))
            {
                $href_link= "http://" . $url;
            }
            else
            {
                $href_link = trim($link);
            }
        }
    }
    
    if ($target == true)
    {
        return 'href="'.$href_link.'" target="_blank"';
    }
    else
    {
        return 'href="'.$href_link.'"';
    }
}

function alpha_inc_link_fillter($link = null, $target = null)
{
  if(empty($link)){
    return;
  }
  $href_link = null;
  if(!empty($link) && $link != null){
    if($link == '#' ){
      $href_link = $link;
      $target = '';
    } else {
      $url =  trim($link);
      if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $href_link= "http://" . $url;
      } else {
        $href_link = trim($link);
      }
    }
  }
  if ($target == true){
    return 'href="'.$href_link.'" target="_blank"';
  }else{
    return 'href="'.$href_link.'"';
  }
}

//remove draft archive links
function remove_draft_archive_link($options, $field, $the_post) {

   $options['post_status'] = array('publish');
   return $options;
}
add_filter('acf/fields/relationship/query', 'remove_draft_archive_link', 10, 3);
add_filter('acf/fields/page_link/query', 'remove_draft_archive_link', 10, 3);

// ===================================
// Button Group For Clone
// ===================================
function button_group($field_name) {
  if(!empty($field_name) && is_array($field_name)) {
    $button_link = '';
    $button_link_type = $field_name['button_link'];
    $internal_link = $field_name['button_internal_link'];
    $external_link = $field_name['button_external_link'];
    if(($button_link_type == 'button_internal_link') && !empty($internal_link)) {
      $button_link = any_hour_external_link($internal_link,false);
    } elseif(($button_link_type == 'button_external_link') && !empty($external_link)) {
      $button_link = any_hour_external_link($external_link,true);
    }
    if(!empty($button_link)) {
      return $button_link;
    } else {
      return '';
    }
  } else {
    return;
  }
}

// ===================================
// Get Template Part
// ===================================
function any_hour_get_template_part($slug = null, $name = null, array $params = array()) {
  global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;
  do_action("get_template_part_{$slug}", $slug, $name);
  $templates = array();
  if (isset($name))
    $templates[] = "{$slug}-{$name}.php";
    $templates[] = "{$slug}.php";
    $_template_file = locate_template($templates, false, false);
  if (is_array($wp_query->query_vars)) {
    extract($wp_query->query_vars, EXTR_SKIP);
  }
  extract($params, EXTR_SKIP);
  require($_template_file);
}

// ===================================
//  Get Template part for ajax 
// ===================================
function any_hour_return_get_template_part($slug = null, $name = null, array $params = array()) {
    $slug=str_replace("//","/",$slug);
    global $wp_query;
    do_action("get_template_part_{$slug}", $slug, $name);
    $templates = array();
    if (isset($name))
        $templates[] = "{$slug}-{$name}.php";
        $templates[] = "{$slug}.php";
        $_template_file = locate_template($templates, false, false);
    if (is_array($wp_query->query_vars)) {
        extract($wp_query->query_vars, EXTR_SKIP);
    }
    extract($params, EXTR_SKIP);
    if(!empty($_template_file)){
        ob_start();
        include($_template_file);
        $var=ob_get_contents();
        ob_end_clean();
        return $var;
    }
}

// ===================================
//  Text Limit 
// ===================================
function any_hour_limitText($string,$limit)
{
  if(!empty($string))
  {
    $string = strip_tags($string);
    if (strlen($string) > $limit)
    {
      $stringCut = substr($string, 0, $limit);
      $string = substr($stringCut, 0, strrpos($stringCut, ' ')) ; 
    }
    return $string;
  }
  else
  {
    return false; 
  }
}

function any_hour_get_option($name) {
    $options = get_option('any_hour_options');
    if (isset($options[$name]))
        return $options[$name];
}
function any_hour_update_option($name, $value) {
    $options = get_option('any_hour_options');
    $options[$name] = $value;
    return update_option('any_hour_options', $options);
}
function any_hour_delete_option($name) {
    $options = get_option('any_hour_options');
    unset($options[$name]);
    return update_option('any_hour_options', $options);
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since any_hour 1.0
 *
 * @global int $paged WordPress archive pagination page count.
 * @global int $page  WordPress paginated post page count.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function any_hour_wp_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo('name', 'display');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() )) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if (( $paged >= 2 || $page >= 2 ) && !is_404()) {
        $title = "$title $sep " . sprintf(__('Page %s', 'any_hour'), max($paged, $page));
    }

    return $title;
}

function any_hour_migrate_option() {
    if (get_option('any_hour_options') && !get_option('any_hour_option_migrate')) {
        $theme_option = array('any_hour_logo', 'any_hour_favicon', 'any_hour_slideimage1', 'any_hour_slideimage2', 'any_hour_fimg1', 'any_hour_fimg2', 'any_hour_fimg3');
        $wp_upload_dir = wp_upload_dir();
        require ( ABSPATH . 'wp-admin/includes/image.php' );
        foreach ($theme_option as $option) {
            $option_value = any_hour_get_option($option);
            if ($option_value && $option_value != '') {
                $filetype = wp_check_filetype(basename($option_value), null);
                $image_name = preg_replace('/\.[^.]+$/', '', basename($option_value));
                $new_image_url = $wp_upload_dir['path'] . '/' . $image_name . '.' . $filetype['ext'];
                any_hour_import_file($new_image_url);
            }
        }
        update_option('any_hour_option_migrate', true);
    }
}
function any_hour_import_file($file, $post_id = 0, $import_date = 'file') {
    set_time_limit(120);
    // Initially, Base it on the -current- time.
    $time = current_time('mysql', 1);
//     Next, If it's post to base the upload off:
    $time = gmdate('Y-m-d H:i:s', @filemtime($file));
//     A writable uploads dir will pass this test. Again, there's no point overriding this one.
    if (!( ( $uploads = wp_upload_dir($time) ) && false === $uploads['error'] )) {
        return new WP_Error('upload_error', $uploads['error']);
    }
    $wp_filetype = wp_check_filetype($file, null);
    extract($wp_filetype);
    if ((!$type || !$ext ) && !current_user_can('unfiltered_upload')) {
        return new WP_Error('wrong_file_type', __('Sorry, this file type is not permitted for security reasons.', 'any_hour')); //A WP-core string..
    }
    $file_name = str_replace('\\', '/', $file);
    if (preg_match('|^' . preg_quote(str_replace('\\', '/', $uploads['basedir'])) . '(.*)$|i', $file_name, $mat)) {
        $filename = basename($file);
        $new_file = $file;
        $url = $uploads['baseurl'] . $mat[1];
        $attachment = get_posts(array('post_type' => 'attachment', 'meta_key' => '_wp_attached_file', 'meta_value' => ltrim($mat[1], '/')));
        if (!empty($attachment)) {
            return new WP_Error('file_exists', __('Sorry, That file already exists in the WordPress media library.', 'any_hour'));
        }
        //Ok, Its in the uploads folder, But NOT in WordPress's media library.
        if ('file' == $import_date) {
            $time = @filemtime($file);
            if (preg_match("|(\d+)/(\d+)|", $mat[1], $datemat)) { //So lets set the date of the import to the date folder its in, IF its in a date folder.
                $hour = $min = $sec = 0;
                $day = 1;
                $year = $datemat[1];
                $month = $datemat[2];
                // If the files datetime is set, and it's in the same region of upload directory, set the minute details to that too, else, override it.
                if ($time && date('Y-m', $time) == "$year-$month") {
                    list($hour, $min, $sec, $day) = explode(';', date('H;i;s;j', $time));
                }
                $time = mktime($hour, $min, $sec, $month, $day, $year);
            }
            $time = gmdate('Y-m-d H:i:s', $time);
            // A new time has been found! Get the new uploads folder:
            // A writable uploads dir will pass this test. Again, there's no point overriding this one.
            if (!( ( $uploads = wp_upload_dir($time) ) && false === $uploads['error'] ))
                return new WP_Error('upload_error', $uploads['error']);
            $url = $uploads['baseurl'] . $mat[1];
        }
    } else {
        $filename = wp_unique_filename($uploads['path'], basename($file));
        // copy the file to the uploads dir
        $new_file = $uploads['path'] . '/' . $filename;
        if (false === @copy($file, $new_file))
            return new WP_Error('upload_error', sprintf(__('The selected file could not be copied to %s.', 'any_hour'), $uploads['path']));
        // Set correct file permissions
        $stat = stat(dirname($new_file));
        $perms = $stat['mode'] & 0000666;
        @ chmod($new_file, $perms);
        // Compute the URL
        $url = $uploads['url'] . '/' . $filename;
        if ('file' == $import_date)
            $time = gmdate('Y-m-d H:i:s', @filemtime($file));
    }
    //Apply upload filters
    $return = apply_filters('wp_handle_upload', array('file' => $new_file, 'url' => $url, 'type' => $type));
    $new_file = $return['file'];
    $url = $return['url'];
    $type = $return['type'];
    $title = preg_replace('!\.[^.]+$!', '', basename($file));
    $content = '';

    if ($time) {
        $post_date_gmt = $time;
        $post_date = $time;
    } else {
        $post_date = current_time('mysql');
        $post_date_gmt = current_time('mysql', 1);
    }

    // Construct the attachment array
    $attachment = array(
        'post_mime_type' => $type,
        'guid' => $url,
        'post_parent' => $post_id,
        'post_title' => $title,
        'post_name' => $title,
        'post_content' => $content,
        'post_date' => $post_date,
        'post_date_gmt' => $post_date_gmt
    );
    $attachment = apply_filters('afs-import_details', $attachment, $file, $post_id, $import_date);
    //Win32 fix:
    $new_file = str_replace(strtolower(str_replace('\\', '/', $uploads['basedir'])), $uploads['basedir'], $new_file);
    // Save the data
    $id = wp_insert_attachment($attachment, $new_file, $post_id);
    if (!is_wp_error($id)) {
        $data = wp_generate_attachment_metadata($id, $new_file);
        wp_update_attachment_metadata($id, $data);
    }
    //update_post_meta( $id, '_wp_attached_file', $uploads['subdir'] . '/' . $filename );

    return $id;
}
function any_hour_tracking_admin_notice() {
    global $current_user;
    $user_id = $current_user->ID;
    /* Check that the user hasn't already clicked to ignore the message */
    if (!get_user_meta($user_id, 'wp_email_tracking_ignore_notice')) {
        ?>
        <div class="updated um-admin-notice"><p><?php _e('Allow any_hour theme to send you setup guide? Opt-in to our newsletter and we will immediately e-mail you a setup guide along with 20% discount which you can use to purchase any theme.', 'any_hour'); ?></p><p><a href="<?php echo get_template_directory_uri() . '/functions/smtp.php?wp_email_tracking=email_smtp_allow_tracking'; ?>" class="button button-primary"><?php _e('Allow Sending', 'any_hour'); ?></a>&nbsp;<a href="<?php echo get_template_directory_uri() . '/functions/smtp.php?wp_email_tracking=email_smtp_hide_tracking'; ?>" class="button-secondary"><?php _e('Do not allow', 'any_hour'); ?></a></p></div>
        <?php
    }
}

//allow svg  to upload in media
function cc_mime_types($mimes) {
 $mimes['svg'] = 'image/svg+xml';
 return $mimes;
}

//Feature  image instruction
function add_featured_image_instruction($content) {
    global $post;
    $post_type = get_post_type();
    if($post_type == 'page' ){
      $content .= '<p><b>Recommended 1920 , 700 pixels</b></p>';
    }
    return $content;

    // if(get_page_template_slug()=='tp-products.php'){  
    //   $content .= '<p><b>Recommended 565 * 320 pixels</b></p>';
    // }
    // return $content;
}

