<?php
/**
 * Job detail content (used by single-hr_job). Matches design: Job Information, main content from post editor, Apply.
 * Main content (Overview, Role Overview, Requirements, Key Responsibilities) comes from the default post editor.
 * WPML-ready.
 *
 * @package tasheel
 */

$job_id    = get_the_ID();
// Display ID: same number for EN and AR (canonical/original post ID).
$display_job_id = function_exists( 'tasheel_hr_canonical_job_id' ) ? tasheel_hr_canonical_job_id( $job_id ) : $job_id;
$job_type_slug = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : '';
$job_type_normalized = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $job_type_slug ) : ( $job_type_slug ?: 'career' );
$loc_parts = function_exists( 'tasheel_hr_job_location_parts' ) ? tasheel_hr_job_location_parts( $job_id ) : array( 'display' => '' );
$location  = isset( $loc_parts['display'] ) ? $loc_parts['display'] : '';
$employment_type = function_exists( 'get_field' ) ? get_field( 'employment_type', $job_id ) : '';
$closing_date = function_exists( 'get_field' ) ? get_field( 'closing_date', $job_id ) : '';

// Date format to match design: m/d/Y (e.g. 12/04/2025).
$date_format_job = 'm/d/Y';
// Use original job's post date for "Posted X ago" when this is a WPML translation (so both EN and AR show correct relative time).
$date_source_id = $job_id;
if ( function_exists( 'apply_filters' ) && has_filter( 'wpml_original_element_id' ) ) {
	$post_type = get_post_type( $job_id );
	$original_id = apply_filters( 'wpml_original_element_id', null, $job_id, 'post_' . ( $post_type ?: 'hr_job' ) );
	if ( $original_id && (int) $original_id !== (int) $job_id ) {
		$date_source_id = (int) $original_id;
	}
}
$posted_date = get_the_date( $date_format_job, $date_source_id );
$posted_timestamp = get_post_time( 'U', false, $date_source_id );
$posted_human = human_time_diff( $posted_timestamp, current_time( 'timestamp' ) );
// Build "Posted X ago" so the time always shows. Use format with %s; if translation omits %s, fallback keeps the time visible.
$posted_format = __( 'Posted %s ago', 'tasheel' );
$posted_label = ( strpos( $posted_format, '%s' ) !== false )
	? sprintf( $posted_format, $posted_human )
	: ( $posted_format . ' ' . $posted_human );
// Arabic: show numbers in Arabic-Indic numerals (٠-٩).
if ( function_exists( 'tasheel_arabic_numerals' ) ) {
	$posted_label = tasheel_arabic_numerals( $posted_label );
}

$employment_label = ( $employment_type === 'part_time' ) ? __( 'Part-time', 'tasheel' ) : __( 'Full-time', 'tasheel' );

// Job Category label from taxonomy (Career / Corporate Training / Academic Program). WPML: use term name in current language.
$job_category_label = '';
$terms = get_the_terms( $job_id, 'job_type' );
if ( $terms && ! is_wp_error( $terms ) ) {
	$t = reset( $terms );
	if ( $t ) {
		$job_category_label = $t->name;
		// If WPML is active, get the translated term name for the current language (fixes Arabic showing English "Career").
		if ( function_exists( 'apply_filters' ) && has_filter( 'wpml_object_id' ) ) {
			$current_lang = apply_filters( 'wpml_current_language', null );
			if ( is_string( $current_lang ) && $current_lang !== '' ) {
				$translated_term_id = apply_filters( 'wpml_object_id', (int) $t->term_id, 'job_type', true, $current_lang );
				if ( $translated_term_id && $translated_term_id !== (int) $t->term_id ) {
					$translated_term = get_term( $translated_term_id, 'job_type' );
					if ( $translated_term && ! is_wp_error( $translated_term ) && ! empty( $translated_term->name ) ) {
						$job_category_label = $translated_term->name;
					}
				}
			}
		}
	}
}

// Title: optional split so last word can be in <span> (e.g. "Chief Financial <span>Officer</span>").
$title_full = get_the_title( $job_id );
$title_parts = preg_split( '/\s+/', trim( $title_full ), -1, PREG_SPLIT_NO_EMPTY );
if ( count( $title_parts ) > 1 ) {
	$title_last = array_pop( $title_parts );
	$title_first = implode( ' ', $title_parts );
} else {
	$title_first = $title_full;
	$title_last = '';
}

$apply_url = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url( $job_id ) : add_query_arg( 'apply_to', $job_id, home_url( '/my-profile/' ) );
?>

<section class="job_details_section pt_80 pb_80">
	<div class="wrap">
		<div class="job_details_container">
			<div class="job_details_header">
				<div class="job_posted_date"><?php echo esc_html( $posted_label ); ?></div>
				<h3 class="h3_title_50 pb_10">
					<?php echo esc_html( $title_first ); ?>
					<?php if ( $title_last ) : ?> <span><?php echo esc_html( $title_last ); ?></span><?php endif; ?>
				</h3>
				<?php if ( $location ) : ?>
					<div class="job_location"><?php echo esc_html( $location ); ?></div>
				<?php endif; ?>
			</div>

			<h4 class="job_main_title"><?php echo esc_html__( 'Job Information', 'tasheel' ); ?></h4>
			<div class="job_details_info">
				<ul class="job_info_list">
					<li><span><?php echo esc_html__( 'Job ID:', 'tasheel' ); ?></span> <?php echo esc_html( (string) $display_job_id ); ?></li>
					<?php if ( $job_category_label ) : ?>
						<li><span><?php echo esc_html__( 'Job Category:', 'tasheel' ); ?></span> <?php echo esc_html( $job_category_label ); ?></li>
					<?php endif; ?>
					<li><span><?php echo esc_html__( 'Posting Date:', 'tasheel' ); ?></span> <?php echo esc_html( $posted_date ); ?></li>
					<?php if ( $closing_date ) : ?>
						<li><span><?php echo esc_html__( 'Apply Before:', 'tasheel' ); ?></span> <?php echo esc_html( date_i18n( $date_format_job, strtotime( $closing_date ) ) ); ?></li>
					<?php endif; ?>
					<li><span><?php echo esc_html__( 'Job Schedule:', 'tasheel' ); ?></span> <?php echo esc_html( $employment_label ); ?></li>
					<?php if ( $location ) : ?>
						<li><span><?php echo esc_html__( 'Location:', 'tasheel' ); ?></span> <?php echo esc_html( $location ); ?></li>
					<?php endif; ?>
				</ul>
			</div>

			<div class="job_details_content">
				<?php
				// Main content only from post editor. Job Summary (listing card) is not shown here.
				$content = get_post_field( 'post_content', $job_id );
				if ( $content ) :
					?>
					<div class="job_company_description">
						<?php echo apply_filters( 'the_content', $content ); ?>
					</div>
				<?php endif; ?>

				<div class="job_apply_action">
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( $apply_url ); ?>" class="btn_style btn_transparent but_black">
							<?php echo esc_html__( 'Apply Now', 'tasheel' ); ?> <span><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr__( 'Apply', 'tasheel' ); ?>"></span>
						</a>
					<?php else : ?>
						<a href="#login-popup" class="btn_style btn_transparent but_black" data-fancybox="login-popup">
							<?php echo esc_html__( 'Apply Now', 'tasheel' ); ?> <span><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr__( 'Apply', 'tasheel' ); ?>"></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
