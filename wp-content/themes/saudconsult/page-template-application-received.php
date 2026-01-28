<?php
/**
 * Template Name: Application Received!
 *
 * The template for displaying the Application Received success page
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';
get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
 

	<section class="application_received_section pt_80 pb_80">
		<div class="wrap">
			<div class="application_received_container">
				<div class="application_received_content">
					<h2 class="application_received_title">Application Received!</h2>
					
					<p class="application_received_message">
						Your application has been submitted successfully.
					</p>

					<div class="application_received_actions">
						<a href="<?php echo esc_url( home_url( '/my-job' ) ); ?>" class="btn_style but_black">My Jobs</a>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();

