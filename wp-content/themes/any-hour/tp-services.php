<?php
/*
Template Name: Services Page
*/

get_header();

//Banner Section
$page_id = get_the_id();  //Page ID

$image = wp_get_attachment_image_src(get_post_thumbnail_id($page_id), 'service_image_size');
if(!empty($image)){
    $banner_image = $image[0];
}
else{
    $default_banner_image = get_field("default_service_banner_image","option");
    $banner_image = $default_banner_image['sizes']['service_image_size'];
}

$title = get_the_title($page_id); //Page Title                   
$content = get_the_content($page_id); //Page Content                   
  
//Service section
$service_contents = get_field('service_contents');
$service_image = get_field('service_image');
$service_mobile_image = get_field('service_mobile_image');
$service_data = get_field('service_data');

?>

<?php if(!empty($banner_image)): ?>
<section class="banner-section bg-cover inner-banner" style="background-image: url(<?php echo $banner_image; ?>);">
    <!-- <img class="img-fluid"  src="images/banner.jpg"> -->
	
    <div class="mobile-img"><img class="img-fluid" src="<?php echo $banner_image; ?>"></div>
   
    <?php if(!empty($title)): ?>
    <div class="content-part-b">
        <h1><?php echo $title; ?></h1>
    </div>
    <?php endif; ?>
</section>
<?php endif; ?>

<!-- service section -->
<?php if(!empty($service_contents)): ?>
<section class="service-section main-service">
        <div class="wrapper">
            <div class="main-service-content">
        	   <?php echo $service_contents; ?>
            </div>
        </div>
</section>
<?php endif; ?>
<!-- END-service section -->

<!-- service-bg section -->
<?php if(wp_is_mobile()): ?>
        <?php if(!empty($service_mobile_image) || !empty( $service_image) ): ?>    
        <section class="mobile-img-service" >
            <img class="img-fluid" id="service_image_src" 
            data-mobile-img="<?php echo $service_mobile_image['sizes']['service_mobile_image_size']; ?>" data-desktop-img="<?php echo $service_image['sizes']['service_image_size']; ?>" />
        </section>
        <?php endif; ?>

<?php else: ?>
    <?php if(!empty( $service_image)): ?>
    <section class="service-bg service-inner-bg bg-cover" style="background-image: url(<?php echo $service_image['sizes']['service_image_size']; ?>); ">
        <img class="img-fluid" src="<?php echo $service_image['sizes']['service_image_size']; ?>" />
    </section> 
    <?php endif; ?>

<?php endif; ?>
<!-- END service bg section -->

<!-- credit service section -->
<?php if(!empty($service_data)): ?>
<section class="creadit-service service-stap ">
    <div class="wrapper">

        <div class="content-service-stap">
        	<?php echo $service_data; ?>        
        </div> 

    </div>
</section>
<?php endif; ?>
<!--End credit service section -->

<?php get_footer(); ?>