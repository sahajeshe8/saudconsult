<?php
/**
 * Submit application form (shown on My Profile when apply_to is set). WPML-ready.
 * Submit button always shown; validation runs on click via AJAX, errors shown without page load.
 *
 * @package tasheel
 */

$args = ( isset( $args ) && is_array( $args ) ) ? $args : (array) get_query_var( 'args', array() );
if ( empty( $args ) ) {
	$args = (array) get_query_var( 'args', array() );
}
$job_id = isset( $args['job_id'] ) ? (int) $args['job_id'] : 0;
$already_applied = isset( $args['already_applied'] ) ? (bool) $args['already_applied'] : false;
if ( ! $job_id ) {
	return;
}
$job = get_post( $job_id );
$pt = function_exists( 'tasheel_hr_job_post_type' ) ? tasheel_hr_job_post_type() : 'hr_job';
if ( ! $job || $job->post_type !== $pt ) {
	return;
}
$raw_slug = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : '';
$is_corporate = ( function_exists( 'tasheel_hr_normalize_job_type_slug' ) && tasheel_hr_normalize_job_type_slug( $raw_slug ) === 'corporate_training' );
$rest_url = rest_url( 'tasheel/v1/validate-apply' );
$nonce = wp_create_nonce( 'wp_rest' );
?>

<div class="hr_apply_form_wrap" data-job-id="<?php echo esc_attr( $job_id ); ?>" data-validate-url="<?php echo esc_url( $rest_url ); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>">
	<?php if ( $already_applied ) : ?>
		<p class="hr_apply_already"><?php echo esc_html__( 'You have already applied for this position.', 'tasheel' ); ?></p>
	<?php else : ?>
		<?php if ( $is_corporate ) : ?>
			<div class="form-buttion-row flex-align-right">
				<a href="#login-popup-training-submit" class="btn_style but_black hr_apply_corporate_link" data-fancybox="login-popup-training-submit"><?php echo esc_html__( 'Submit Application', 'tasheel' ); ?></a>
			</div>
		<?php else : ?>
			<form method="post" action="" class="hr_apply_form">
				<?php wp_nonce_field( 'tasheel_hr_apply_' . $job_id, '_wpnonce' ); ?>
				<input type="hidden" name="tasheel_hr_submit_application" value="1" />
				<input type="hidden" name="apply_to" value="<?php echo esc_attr( $job_id ); ?>" />
				<input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>" />
				<input type="hidden" name="job_title" value="<?php echo esc_attr( get_the_title( $job_id ) ); ?>" />
				<p class="form-buttion-row flex-align-right">
					<button type="submit" class="btn_style btn_transparent but_black"><?php echo esc_html__( 'Submit application', 'tasheel' ); ?></button>
				</p>
			</form>
		<?php endif; ?>
	<?php endif; ?>
</div>
