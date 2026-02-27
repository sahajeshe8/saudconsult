<?php
/**
 * Single Job (hr_job). Job type (Career / Corporate Training / Academic) is from taxonomy job_type.
 *
 * @package tasheel
 */

get_header();

while ( have_posts() ) :
	the_post();
	$job_id = get_the_ID();
	$banner_img = function_exists( 'get_field' ) ? get_field( 'banner_image', $job_id ) : '';
	$banner_mobile = function_exists( 'get_field' ) ? get_field( 'banner_image_mobile', $job_id ) : '';
	if ( empty( $banner_img ) ) {
		$job_type_slug = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : '';
		$banner_img = get_template_directory_uri() . '/assets/images/careers-banner.jpg';
		if ( $job_type_slug === 'corporate_training' ) {
			$banner_img = get_template_directory_uri() . '/assets/images/corporate-banner.jpg';
		}
	}
	if ( is_array( $banner_img ) && isset( $banner_img['url'] ) ) {
		$banner_img = $banner_img['url'];
	}
	if ( is_array( $banner_mobile ) && isset( $banner_mobile['url'] ) ) {
		$banner_mobile = $banner_mobile['url'];
	} elseif ( is_numeric( $banner_mobile ) ) {
		$banner_mobile = wp_get_attachment_url( (int) $banner_mobile ) ?: '';
	}
	$banner_title = function_exists( 'get_field' ) ? get_field( 'banner_title', $job_id ) : '';
	$banner_title = ( $banner_title && trim( (string) $banner_title ) !== '' ) ? trim( $banner_title ) : get_the_title();
	$inner_banner_data = array(
		'background_image'         => $banner_img,
		'background_image_mobile'  => $banner_mobile,
		'title'                     => $banner_title,
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
	get_template_part( 'template-parts/content-job-detail' );
endwhile;

get_footer();
