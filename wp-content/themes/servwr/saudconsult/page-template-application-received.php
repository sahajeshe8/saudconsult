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

$application_id = isset( $_GET['application_id'] ) ? max( 0, (int) $_GET['application_id'] ) : 0;
$is_guest_application = false;
if ( $application_id ) {
	$guest_email = get_post_meta( $application_id, 'guest_email', true );
	$is_guest_application = ( is_string( $guest_email ) && trim( $guest_email ) !== '' );
}

get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
 

	<section class="application_received_section pt_80 pb_80">
		<div class="wrap">
			<div class="application_received_container">
				<div class="application_received_content">
					<h2 class="application_received_title"><?php esc_html_e( 'Application Received!', 'tasheel' ); ?></h2>
					
					<p class="application_received_message">
						<?php esc_html_e( 'Your application has been submitted successfully.', 'tasheel' ); ?>
					</p>

					<?php if ( ! $is_guest_application ) : ?>
					<div class="application_received_actions">
						<a href="<?php echo esc_url( home_url( '/my-job' ) ); ?>" class="btn_style but_black"><?php esc_html_e( 'My Jobs', 'tasheel' ); ?></a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();

