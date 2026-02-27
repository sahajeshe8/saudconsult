<?php
/**
 * Template Name: Reset Password
 *
 * Displays the custom password reset form (shortcode). Uses ACF flexible content
 * (about_page_sections) for the banner when set; otherwise falls back to inner banner.
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
	// 1. Banner first (only inner_banner from flexible content, or default).
	$has_banner = false;
	if ( ! empty( $sections ) && function_exists( 'tasheel_render_contact_flexible_section' ) ) {
		foreach ( $sections as $section ) {
			if ( ! empty( $section['acf_fc_layout'] ) && $section['acf_fc_layout'] === 'inner_banner' ) {
				tasheel_render_contact_flexible_section( $section );
				$has_banner = true;
			}
		}
	}
	if ( ! $has_banner ) {
		$inner_banner_data = array(
			'background_image'        => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
			'background_image_mobile' => '',
			'title'                   => get_the_title( $page_id ),
		);
		get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
	}

	// 2. Page content (editor) – add [tasheel_reset_password_form] here; shortcode is called and shown. Fallback if empty.
	?>
	<section class="terms_conditions_section pt_80 pb_80">
		<div class="wrap">
			<div class="terms_conditions_container">
				<div class="terms_content entry-content">
					<?php
					$content = get_post_field( 'post_content', $page_id );
					$content = $content ? apply_filters( 'the_content', $content ) : '';
					if ( trim( strip_tags( $content ) ) === '' ) {
						$content = do_shortcode( '[tasheel_reset_password_form]' );
					}
					echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode/form output
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
	// 3. Rest of flexible content (everything except banner).
	if ( ! empty( $sections ) && function_exists( 'tasheel_render_contact_flexible_section' ) ) {
		foreach ( $sections as $section ) {
			if ( empty( $section['acf_fc_layout'] ) || $section['acf_fc_layout'] === 'inner_banner' ) {
				continue;
			}
			tasheel_render_contact_flexible_section( $section );
		}
	}
	?>
</main><!-- #main -->

<?php
get_footer();
