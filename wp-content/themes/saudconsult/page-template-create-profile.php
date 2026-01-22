<?php
/**
 * Template Name: Create Profile
 *
 * The template for displaying the Create Profile page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
		'title' => 'Create Profile',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<section class="create_profile_section pt_80 pb_80">
		<div class="wrap">
			<div class="create_profile_container">
				<div class="create_profile_content">
					<h3 class="h3_title_50 pb_10 text_center mb_20">Sign Up</h3>
					<div class="related_jobs_section_content">
						<h5>Create an account</h5>
						<p>Create your account in a seconds</p>
					</div>

					<ul class="career-form-list-ul">
						<li><input class="input" type="text" placeholder="Email Address *"></li>
						<li><input class="input" type="email" placeholder="Retype Email Address *"></li>
						<li><input class="input" type="text" placeholder="First Name *"></li>
						<li><input class="input" type="text" placeholder="Last Name *"></li>
						<li><input class="input" type="password" placeholder="Choose Password *"> <span class="form-icon"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icn.svg" alt="Eye"></span></li>
						<li><input class="input" type="password" placeholder="Retype Password *"> <span class="form-icon"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/eye-icn.svg" alt="Eye"></span></li>
						<li><input class="input-buttion" type="submit" value="Create Account"> </li>
					</ul>

					<div class="form-bottom-txt">
						<p>Already a registered user? <a href="#" class="text_black"> Please sign in</a></p>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();

