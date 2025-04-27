<?php
/*
Template Name: Home Page
*/

//Banner Section
$banner_image = get_field('banner_image');
$banner_heading = get_field('banner_heading');
$banner_description = get_field('banner_description');
  
//Service section
$service_heading = get_field('service_heading');
$service_description = get_field('service_description');
$buttons =  get_field('about_us_button');
$button_label = $buttons['button_label'];
$button_link = button_group($buttons);
$service_image = get_field('service_image');
$service_mobile_image = get_field('service_mobile_image');

//Page Link Section
$page_contents = get_field('page_contents');

//News Post Section
$post_image = get_field('post_image');
$post_heading = get_field('post_heading');
$post_download_link = get_field('post_download_link');
$post_button = get_field('post_button');
$post_button_label = $post_button['button_label'];
$post_button_link = button_group($post_button);

$args = array(  
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post_status' => 'publish', 
        'orderby' => 'publish_date', 
        'order' => 'DESC', 
    );

$loop = new WP_Query( $args );

wp_reset_postdata(); 

get_header(); 
?>
<?php if(!empty($banner_image)): ?>
<section class="banner-section bg-cover" style="background-image: url(<?php echo $banner_image['sizes']['home_banner_image_size']; ?>);">
<!-- <img class="img-fluid"  src="images/banner.jpg"> -->
    
    <div class="mobile-img"><img class="img-fluid" src="<?php echo $banner_image['sizes']['home_banner_image_size'];?>"></div>
    
    <div class="content-part-b">
    	<?php if(!empty($banner_heading )): ?>
        <h1><?php echo $banner_heading; ?></h1>
    	<?php endif; ?>
    	<?php if(!empty($banner_description )): ?>
        <div class="semi-content-b">
            <?php echo $banner_description; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- service section -->
<section class="service-section">
        <div class="wrapper">
            <div class="service-content">
            	<?php if(!empty( $service_heading )): ?>
                <h3><?php echo $service_heading ; ?></h3>
                <?php endif;
                if(!empty($service_description)): ?>
                <p><?php echo $service_description ; ?></p>
				<?php endif;
				if(!empty($button_label) && !empty($button_link)): ?>
                <a class="btn-blue" <?php echo $button_link; ?>> <?php echo $button_label; ?></a>
                <?php endif; ?>
            </div>
        </div>
</section>
<!-- END service section -->

<!-- service-bg section -->
<?php if(wp_is_mobile()): ?>
        <?php if(!empty($service_mobile_image) || !empty( $service_image) ): ?>    
        <section class="mobile-view-set">
            <img class="img-fluid" id="service_image_src" 
            data-mobile-img="<?php echo $service_mobile_image['sizes']['home_service_mobile_image_size']; ?>" data-desktop-img="<?php echo $service_image['sizes']['service_image_size']; ?>" />
        </section>
        <?php endif; ?>

<?php else: ?>
    <?php if(!empty( $service_image)): ?>
    <section class="service-bg bg-cover" style="background-image: url(<?php echo $service_image['sizes']['service_image_size']; ?>); ">
        <img class="img-fluid" src="<?php echo $service_image['sizes']['service_image_size']; ?>" />
    </section> 
    <?php endif; ?>

<?php endif; ?>
<!-- END service bg section -->

<!-- credit service section -->
<?php if(!empty($page_contents)): ?>
<section class="credit-service">
    <div class="wrapper">
    	<?php 
    		foreach($page_contents as $content):
				$page_image = $content['page_image']['sizes']['page_icon_image_size'];
				$page_heading = $content['page_heading'];
				$page_description = $content['page_description'];
				$page_button = $content['page_link_button'];
				$page_button_label = $page_button['button_label'];
				$page_button_link = button_group($page_button); ?>
        <div class="credit-service-main ">
        	<?php if(!empty($page_image)): ?>
            <div class="icon-service">
                <img class="img-fluid" src="<?php echo $page_image; ?>">
            </div>
            <?php endif; ?>
            <div class="content-service">
            	<?php if(!empty($page_heading)): ?>
                <h3><?php echo $page_heading; ?></h3>
                <?php endif;
                if(!empty($page_description)): ?>
                <p><?php echo $page_description; ?></p>
            	<?php endif; 
				if(!empty( $page_button_link ) && !empty($page_button_label)): ?>
                <a class="btn-blue btn" <?php echo $page_button_link; ?>><?php echo $page_button_label; ?></a>
        		<?php endif; ?>
            </div>
        </div>
        <?php endforeach;  ?>
    </div>
</section>
<?php endif; ?>
<!-- END credit service section -->

<!-- recent news bg section -->
<section class="recent-news-bg bg-cover" style="background-image: url(<?php echo $post_image['sizes']['news_post_image_size']; ?>);">
	<div class="wrapper">
	    <div class="news-content">
	    	<?php if(!empty($post_heading)): ?>
	        <h3><?php echo $post_heading; ?></h3>
	        <?php endif;

	        if($loop->posts):  
                foreach($loop->posts as $post):
                     $id = $post->ID; 
                     $title = $post->post_title;
                     $post_date = $post->post_date;
                     $date = date('F j, Y', strtotime($post_date)); 
                     $content = substr($content, 0, 70); 
                     $content = get_the_excerpt();
                     $post_download_link = get_field('post_download_link');
                     ?>

                    <div class="credit-union">
                        <?php if(!empty($title)): ?>
                        <h4><a href="<?php echo get_permalink($id); ?>"><?php echo $title; ?></a></h4>
                        <?php endif;
                        if(!empty($content)): ?>
                        <p><?php echo $date; ?> - <?php echo $content; ?></p>
                        <?php endif; ?>
                       
                        <span><a href="<?php echo $post_download_link ? $post_download_link : '#'; ?>" target="_blank">Click here </a>to download this press release</span>
                        
                    </div>

                <?php endforeach; 
            endif; 

	        if(!empty($post_button_link ) && !empty($post_button_label)): ?>
	        <a <?php echo $post_button_link; ?>><button class="btn-blue"><?php echo $post_button_label; ?> </button> </a>
	    	<?php endif; ?>
	    </div>
	</div>
</section>
<!-- END recent news bg section -->

<?php get_footer(); ?>