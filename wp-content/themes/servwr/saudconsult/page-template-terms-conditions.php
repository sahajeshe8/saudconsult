<?php
/**
 * Template Name: Terms and Conditions
 *
 * The template for displaying the Terms and Conditions page.
 * Uses ACF flexible content (about_page_sections) for banner (desktop + mobile)
 * and WordPress page content (the_content) for the main terms text.
 *
 * @package tasheel
 */

get_header();

$page_id = get_queried_object_id();
$sections = array();
if ( function_exists( 'get_field' ) ) {
	$sections = get_field( 'about_page_sections', $page_id );
}
$sections = is_array( $sections ) ? $sections : array();
?>

<main id="primary" class="site-main">
	<?php
	if ( ! empty( $sections ) && function_exists( 'tasheel_render_contact_flexible_section' ) ) {
		foreach ( $sections as $section ) {
			tasheel_render_contact_flexible_section( $section );
		}
	} else {
		// Default banner when no flexible content is set – use the page title
		$inner_banner_data = array(
			'background_image'        => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
			'background_image_mobile' => '',
			'title'                   => get_the_title( $page_id ),
		);
		get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
	}
	?>

	<section class="terms_conditions_section pt_80 pb_80">
		<div class="wrap">
			<div class="terms_conditions_container">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="terms_content entry-content">
						<?php the_content(); ?>
					</div>
					<?php
				endwhile;
				?>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();
