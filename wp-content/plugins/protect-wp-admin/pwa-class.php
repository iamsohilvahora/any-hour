<?php
/*
 * Protect WP-Admin (C)
 * @register_install_hook()
 * @register_uninstall_hook()
 * */
?>
<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $getPwaOptions;
/** Get all options value */
if(!function_exists('get_pwa_setting_options')):
function get_pwa_setting_options() {
		global $wpdb;
		$pwaOptions = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'pwa_%'");
								
		foreach ($pwaOptions as $option) {
			$pwaOptions[$option->option_name] =  $option->option_value;
		}
		return $pwaOptions;	
	}
endif;	

GLOBAL  $getPwaOptions;
$getPwaOptions = get_pwa_setting_options();
if(isset($getPwaOptions['pwa_active']) && '1'==$getPwaOptions['pwa_active'])
{
add_action('login_enqueue_scripts','pwa_load_jquery');
add_action('init', 'init_pwa_admin_rewrite_rules' );
add_action('init', 'pwa_admin_url_redirect_conditions' );
add_action('login_head', 'pwa_update_login_page_logo');
add_action('login_footer','pwa_custom_script',5);
add_action('login_enqueue_scripts','check_login_status',20);

	if(isset($getPwaOptions['pwa_logout']))
	{
	add_action('admin_init', 'pwa_logout_user_after_settings_save');
	add_action('admin_init', 'pwa_logout_user_after_settings_save');
	}
}
if(!function_exists('check_login_status')):
	function check_login_status()
	{
		$getPwaOptions = get_pwa_setting_options();
		$current_uri = pwa_get_current_page_url($_SERVER);
		$newadminurl = site_url($getPwaOptions['pwa_rewrite_text']);
		 if ( is_user_logged_in() && $current_uri==$newadminurl) 
		 {
				wp_redirect(admin_url()); die();
			} else {
				//echo 'slient';
			}
		
		
		}
endif;

if(!function_exists('pwa_logout_user_after_settings_save')):
function pwa_logout_user_after_settings_save()
{
	$getPwaOptions=get_pwa_setting_options();
    if(isset($_GET['settings-updated']) && $_GET['settings-updated'] && isset($_GET['page']) && $_GET['page']=='pwa-settings')
    {
    flush_rewrite_rules();
	}
	
  if(isset($_GET['settings-updated']) && $_GET['settings-updated'] && isset($_GET['page']) && $_GET['page']=='pwa-settings' && isset($getPwaOptions['pwa_logout']) && $getPwaOptions['pwa_logout']==1)
   {
     $URL=str_replace('&amp;','&',wp_logout_url());
      if(isset($getPwaOptions['pwa_rewrite_text']) && isset($getPwaOptions['pwa_logout']) && $getPwaOptions['pwa_logout']==1 && $getPwaOptions['pwa_rewrite_text']!=''){
      wp_redirect(site_url('/'.$getPwaOptions['pwa_rewrite_text']));
     }else
     {
		 //silent
		 }
     //wp_redirect($URL);
   }
}
endif;
/** Create a new rewrite rule for change to wp-admin url */
if(!function_exists('init_pwa_admin_rewrite_rules')):
function init_pwa_admin_rewrite_rules() {
	$getPwaOptions=get_pwa_setting_options();
    if(isset($getPwaOptions['pwa_active']) && (isset($getPwaOptions['pwa_rewrite_text']) && $getPwaOptions['pwa_rewrite_text']!='')){
	$newurl=strip_tags($getPwaOptions['pwa_rewrite_text']);
    add_rewrite_rule( $newurl.'/?$', 'wp-login.php', 'top' );
    add_rewrite_rule( $newurl.'/register/?$', 'wp-login.php?action=register', 'top' );
    add_rewrite_rule( $newurl.'/lostpassword/?$', 'wp-login.php?action=lostpassword', 'top' );
    
    }
}
endif;
/** 
 * Update Login, Register & Forgot password link as per new admin url
 * */
if(!function_exists('pwa_load_jquery')):
function pwa_load_jquery()
{
wp_enqueue_script("jquery"); 
}
endif;

if(!function_exists('pwa_custom_script')):
function pwa_custom_script()
{	
$getPwaOptions=get_pwa_setting_options();
if(isset($getPwaOptions['pwa_active']) && ''!=$getPwaOptions['pwa_rewrite_text']){

echo '<script>jQuery(document).ready(function(){
	jQuery("#login #login_error a").attr("href","'.site_url($getPwaOptions["pwa_rewrite_text"].'/lostpassword').'");
	jQuery("body.login-action-resetpass p.reset-pass a").attr("href","'.site_url($getPwaOptions["pwa_rewrite_text"].'/').'");
	var formId= jQuery("#login form").attr("id");
if(formId=="loginform"){
	jQuery("#"+formId).attr("action","'.site_url($getPwaOptions["pwa_rewrite_text"]).'");
	}else if("lostpasswordform"==formId){
			jQuery("#"+formId).attr("action","'.site_url($getPwaOptions["pwa_rewrite_text"].'/lostpassword').'");
			jQuery("#"+formId+" input:hidden[name=redirect_to]").val("'.site_url($getPwaOptions["pwa_rewrite_text"].'/?checkemail=confirm').'");
		}else if("registerform"==formId){
			jQuery("#"+formId).attr("action","'.site_url($getPwaOptions["pwa_rewrite_text"].'/register').'");
			}
		else
			{
				//silent
				}
				//alert(jQuery("#nav a").slice(0).attr("href"));
				';
		$currentUrl = pwa_get_current_page_url($_SERVER);			
          echo 'jQuery("#nav a").each(function(){
           /* var linkText=jQuery(this).attr("href");
            
            if(linkText.indexOf("?action=register") >= 0)
            {
                //jQuery(this).attr("href","'.site_url($getPwaOptions["pwa_rewrite_text"].'/register').'");
            }
            
            if(linkText.indexOf("?action=lostpassword") >= 0)
            {
               // jQuery(this).attr("href","'.site_url($getPwaOptions["pwa_rewrite_text"].'/lostpassword').'");
            }
            */
            var linkText = jQuery(this).attr("href").match(/[^/]*(?=(\/)?$)/)[0];
            if(linkText=="wp-login.php"){jQuery(this).attr("href","'.site_url($getPwaOptions["pwa_rewrite_text"]).'");}
			else if(linkText=="wp-login.php?action=register"){jQuery(this).attr("href","'.site_url($getPwaOptions["pwa_rewrite_text"].'/register').'");}else if(linkText=="wp-login.php?action=lostpassword"){jQuery(this).attr("href","'.site_url($getPwaOptions["pwa_rewrite_text"].'/lostpassword').'");}else { 
				//silent
				}	
        });});</script>';
}

}
endif;

if(!function_exists('pwa_admin_url_redirect_conditions')):
function pwa_admin_url_redirect_conditions()
{
	$getPwaOptions=get_pwa_setting_options();
	$pwaActualURLAry =array
	                       (
                           site_url('/wp-login.php'),
                           site_url('/wp-login.php/'),
                           site_url('/wp-login'),
                           site_url('/wp-login/'),
                           site_url('/wp-admin'),
                           site_url('/wp-admin/'),
                           );
    $request_url = pwa_get_current_page_url($_SERVER);
    $newUrl = explode('?',$request_url);
	//print_r($pwaActualURLAry); echo $newUrl[0];exit;
if(! is_user_logged_in() && in_array($newUrl[0],$pwaActualURLAry) ) 
	{
 if(wp_doing_ajax() && $newUrl[0]==site_url('/wp-admin/admin-ajax.php'))
   return true;
/** is forgot password link */
if( isset($_GET['login']) && isset($_GET['action']) && $_GET['action']=='rp' && $_GET['login']!='')
{
$username = $_GET['login'];
if(username_exists($username))
{
//silent
}else{ wp_redirect(home_url('/'),301); //exit;
}
}elseif(isset($_GET['action']) && $_GET['action']=='rp')
{
	//silent
	}
elseif(isset($_GET['action']) && isset($_GET['error']) && $_GET['action']=='lostpassword' && $_GET['error']=='invalidkey')
{
	$redirectUrl=site_url($getPwaOptions["pwa_rewrite_text"].'/?action=lostpassword&error=invalidkey');
	wp_redirect($redirectUrl,301);//exit;
	}
elseif(isset($_GET['action']) && $_GET['action']=='resetpass')
{
// silent 
	}
	else{

	wp_redirect(home_url('/'),301);//exit;
	   }


		//exit;
		}
		else if(isset($getPwaOptions['pwa_restrict']) && $getPwaOptions['pwa_restrict']==1 && is_user_logged_in())
		{
			global $current_user;
	        $user_roles = $current_user->roles;
	        $user_ID = $current_user->ID;
	        $user_role = array_shift($user_roles);
	        
	        if(isset($getPwaOptions['pwa_allow_custom_users']) && $getPwaOptions['pwa_allow_custom_users']!='')
	        {
				$userids=explode(',' ,$getPwaOptions['pwa_allow_custom_users']);
				
				if(is_array($userids))
				{
					$userids=explode(',' ,$getPwaOptions['pwa_allow_custom_users']);
					}else
					{
						$userids[]=$getPwaOptions['pwa_allow_custom_users'];
						}
				}else
				{
					$userids=array();
					}
	        
			if($user_role=='administrator' || in_array($user_ID,$userids))
			{
				//silent is gold
				}else
				{
					
					show_admin_bar(false); // disble admin_bar for guest user
					 
					wp_redirect(home_url('/'));//exit;
					}
			}else
			{
				//silent is gold
				}
	
}
endif;
/** Get the current url*/
if(!function_exists('pwa_current_path_protocol')):
function pwa_current_path_protocol($s, $use_forwarded_host=false)
{
    $pwahttp = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $pwasprotocal = strtolower($s['SERVER_PROTOCOL']);
    $pwa_protocol = substr($pwasprotocal, 0, strpos($pwasprotocal, '/')) . (($pwahttp) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$pwahttp && $port=='80') || ($pwahttp && $port=='443')) ? '' : ':'.$port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $pwa_protocol . '://' . $host;
}
endif;
if(!function_exists('pwa_get_current_page_url')):
function pwa_get_current_page_url($s, $use_forwarded_host=false)
{
    return pwa_current_path_protocol($s, $use_forwarded_host) . $s['REQUEST_URI'];
}
endif;
/* Change Wordpress Default Logo */
if(!function_exists('pwa_update_login_page_logo')):
	function pwa_update_login_page_logo() 
	{
	  
	  $getPwaOptions=get_pwa_setting_options();
	   // get logo height and width
	   $imagelogo = $getPwaOptions['pwa_logo_path'];
	   echo '<style type="text/css"> /* Protect WP-Admin Style*/';
	   if(!empty($imagelogo))
	   {
		ob_start();
		$data = getimagesize($imagelogo);
		$resize_warning = ob_get_clean();
		if(!empty($resize_warning)) {
		   $logwigdth = '100px !important;';
		   $logheight = '100px !important;';
		   $logbgsize = '100px !important';
		} else {
			   $logwigdth =$data[0].'px !important;'; 
			   $logheight = $data[1].'px !important;';
			   $logbgsize ='inherit !important;';
		}

		if(isset($getPwaOptions['pwa_logo_path']) && $getPwaOptions['pwa_logo_path']!=''){
		  echo ' h1 a { background-image:url('.$getPwaOptions['pwa_logo_path'].') !important; width:'.$logwigdth.'height:'.$logheight.'background-size:'.$logbgsize.'}';
	  }
	 }  
		if(isset($getPwaOptions['pwa_login_page_bg_color']) && $getPwaOptions['pwa_login_page_bg_color']!='')
		echo ' body.login-action-login,html{ background:'.$getPwaOptions['pwa_login_page_bg_color'].' !important; height: 100% !important;}.login .button-primary{background:'.$getPwaOptions['pwa_login_page_bg_color'].' !important;}.login #backtoblog a, .login #nav a { color: '.$getPwaOptions['pwa_login_page_color'].'; }';
		echo '</style>';
	
	   
	}
endif;
/*************************************************************
  Hooks to overide option value before save it into database 
* ************************************************************/
function pwa_update_field_rewrite_text( $new_value, $old_value ) {
$new_value =  str_replace('/','-',trim(stripslashes(strip_tags($new_value))));
return $new_value;
}
add_filter( 'pre_update_option_pwa_rewrite_text', 'pwa_update_field_rewrite_text', 10, 2 );
/*************************************************************
  Hooks to overide login page url
*************************************************************/
remove_filter( 'login_url', 'pwa_hooks_login_page', 10, 2 );
function pwa_hooks_login_page( $login_url, $redirect ) {
  $enable = get_option('pwa_active');
  $newurl = get_option('pwa_rewrite_text');
  if($enable && $newurl!='')
  {
    $login_url = str_replace("wp-login.php",$newurl,$login_url);
   }
   return $login_url;
}

remove_action( 'login_form', 'pwa_hooks_replace_login_submit_form',1); 
function pwa_hooks_replace_login_submit_form() {
  $enable = get_option('pwa_active');
  $newurl = get_option('pwa_rewrite_text');
  if($enable && $newurl!='')
  {
  $your_content = ob_get_contents();
  $your_content = str_replace("wp-login.php",$newurl,$your_content);  
  ob_get_clean();
  echo $your_content;
  }
}
