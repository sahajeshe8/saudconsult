<?php
/**
 * The template for displaying the footer
 *
 * @package tasheel
 */
?>

<footer id="colophon" class="site-footer footer">

	<div class="wrap">
		 <ul class="footer_list">
			<li class="footer_list_item_01">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logo.png" alt="Footer Logo">
				</a>
			</li>
			<li class="footer_list_item_02">
				<h3>Stay updated with UB Emirates latest insights and service updates.</h3>
				 <div class="subscribe_form">
					 <div class="subscribe_input">
						 <input type="email" placeholder="Email Address">
					 </div>
					 <div class="subscribe_form_button">
					 <button type="submit">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/subscribe-icn.svg" alt="Send">
					 </button>
				 </div>	
				 </div>	
				  				
			</li>
			<li class="footer_list_item_03">
				<h3 class="footer_title_h3">Explore</h3>

				<ul class="footer_list_ul">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
					<li><a href="<?php echo esc_url( home_url( '/projects' ) ); ?>">Projects</a></li>
					<li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">About Us</a></li>
					<li><a href="<?php echo esc_url( home_url( '/careers' ) ); ?>">Careers</a></li>
					<li><a href="<?php echo esc_url( home_url( '/brands' ) ); ?>">Brands</a></li>
					<li><a href="<?php echo esc_url( home_url( '/media-center' ) ); ?>">Media Center</a></li>
					<li><a href="<?php echo esc_url( home_url( '/products' ) ); ?>">Products</a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>">Contact</a></li>
					<li><a href="<?php echo esc_url( home_url( '/industries' ) ); ?>">Industries We Serve</a></li>
				</ul>
			</li>
			<li class="footer_list_item_04">
			<h3 class="footer_title_h3">Social Media</h3>
			<ul class="footer_social_list_ul">
				<li>
					<a href="<?php echo esc_url( get_theme_mod( 'footer_linkedin_url', '#' ) ); ?>" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-in.svg" alt="LinkedIn">
					</a>
				</li>
				<li>
					<a href="<?php echo esc_url( get_theme_mod( 'footer_instagram_url', '#' ) ); ?>" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer_insta.svg" alt="Instagram">
					</a>
				</li>
				<li>
					<a href="<?php echo esc_url( get_theme_mod( 'footer_twitter_url', '#' ) ); ?>" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-x.svg" alt="X (Twitter)">
					</a>
				</li>
			</ul>
			</li>
	 
		 </ul>


		 <div class="footer_bottom">
		 <p>© 2025 UB Emirates LLC. All Rights Reserved</p> 

		 <ul class="footer_bottom_list">
			<li><a href="<?php echo esc_url( home_url( '/terms-conditions' ) ); ?>">Terms & Conditions</a></li>
			<li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>">Privacy Policy</a></li>
 
		 </ul>
	</div>
	</div>



</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
