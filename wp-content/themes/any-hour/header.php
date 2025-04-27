<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package any-hour
 */

$site_logo = get_field('site_logo','options');
$phone_number = get_field('phone_number','options');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png"/>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://use.typekit.net/irh6sac.css">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<main class="site-main">
	<!-- header with banner -->
	<header class="header-banner">	
			<div class="header-top">
				<?php if(!empty($site_logo)): ?>
				<div class="logo"><a href="<?php echo home_url('/'); ?>"><img class="img-fluid" src="<?php echo $site_logo['sizes']['logo_image_size'];?>"></a></div>
				<?php endif; ?>

				<nav class="site-navigation">							
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
						)
					);
					?>

					<?php if(!empty($phone_number)): ?>
					<div class="schedule"><a href="tel:<?php echo $phone_number; ?>" class="schedule-btn"> Schedule a Call</a></div>
					<?php endif; ?>
					
				</nav>
			</div>	
	</header>
