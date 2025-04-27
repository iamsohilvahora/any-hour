<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package any-hour
 */
$site_logo = get_field('site_logo','options');
$address = get_field('address','options');
$phone_number = get_field('phone_number','options');

$email_address = get_field('email_address','options');

$news_button = get_field('news_signup','options');
$news_button_label = $news_button['button_label'];
$news_button_link = button_group($news_button);
$copyright = get_field('copyright','options');
?>
<footer id="colophon" class="footer-section site-footer">
	<div class="wrapper">
		<div class="footer-top">
 		<div class="content-ft">
 			<?php if(!empty($site_logo)): ?>
 			<a href="<?php echo home_url('/'); ?>"><img  class="img-fluid" src="<?php echo $site_logo['sizes']['logo_image_size']; ?>"></a>
 			<?php endif;
 			if(!empty($address)): ?>
 			<p><?php echo $address; ?></p>
 			<?php endif;
 			if(!empty($phone_number)): ?>
 			<p><span class="phone">Phone: </span><a href="tel:<?php echo $phone_number; ?>"><strong><?php echo $phone_number; ?></strong></a></p>
 			<?php endif; ?>
 		</div>
			<div class="footer-btn">
				<?php if(!empty($email_address)): ?>
				<a href="mailto:<?php echo $email_address; ?>" class="btn-blue send-message">Send a Message</a>
				<?php endif;
				if(!empty($news_button_label) && !empty($news_button_link)): ?>
				<a <?php echo $news_button_link; ?> class="btn-blue news-button"><?php echo $news_button_label; ?></a>
				<?php endif; ?>
			</div>

		</div>
		<?php if(!empty($copyright)): ?>
		<div class="footer-bottom">
			<p><?php echo str_replace('YYYY', date('Y'), $copyright); ?></p>		
		</div>
		<?php endif; ?>
	</div>
</footer>
</div><!-- #page -->
</main>
<?php wp_footer(); ?>
</body>
</html>
