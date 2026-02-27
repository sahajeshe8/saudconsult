<?php
/**
 * Template Name: Guest Profile
 *
 * Review step for Apply as a Guest: shows saved profile from transient; only Start Date, Duration and Submit Application.
 *
 * @package tasheel
 */

global $header_custom_class;
$header_custom_class = 'black-header';

$review_token  = isset( $_GET['review_token'] ) ? sanitize_text_field( wp_unslash( $_GET['review_token'] ) ) : '';
$apply_to      = isset( $_GET['apply_to'] ) ? max( 0, (int) $_GET['apply_to'] ) : 0;
$guest_error   = isset( $_GET['guest_error'] ) ? sanitize_text_field( wp_unslash( $_GET['guest_error'] ) ) : '';
$stored      = array();
$snapshot    = array();
$guest_email = '';

$stored_start_date = '';
$stored_duration   = '';
if ( $review_token && $apply_to ) {
	$stored = get_transient( 'tasheel_guest_review_' . $review_token );
	if ( is_array( $stored ) && (int) ( isset( $stored['job_id'] ) ? $stored['job_id'] : 0 ) === $apply_to ) {
		$snapshot         = isset( $stored['snapshot'] ) ? $stored['snapshot'] : array();
		$guest_email      = isset( $stored['guest_email'] ) ? $stored['guest_email'] : '';
		$stored_start_date = isset( $stored['start_date'] ) ? $stored['start_date'] : '';
		$stored_duration   = isset( $stored['duration'] ) ? $stored['duration'] : '';
	}
}

// Invalid or expired: redirect back to apply-as-a-guest.
if ( empty( $stored ) || empty( $snapshot ) ) {
	if ( $apply_to ) {
		wp_safe_redirect( add_query_arg( array( 'guest_error' => 'expired', 'apply_to' => $apply_to ), home_url( '/apply-as-a-guest/' ) ) );
	} else {
		wp_safe_redirect( add_query_arg( 'guest_error', 'expired', home_url( '/apply-as-a-guest/' ) ) );
	}
	exit;
}

$job = get_post( $apply_to );
$job_title = $job ? get_the_title( $apply_to ) : '';

get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">

	<section class="my_profile_section pt_80 pb_80">
		<div class="wrap">
			<div class="my_profile_container">
				<div class="my_profile_content">
					<div class="profile-title-block text-center-title">
						<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'Apply as a Guest', 'tasheel' ); ?></h3>
						<?php if ( $guest_error === 'training' ) : ?>
							<p class="guest-apply-error text_center mb_20" style="color: #842029;"><?php esc_html_e( 'Please select Start Date and Duration.', 'tasheel' ); ?></p>
						<?php endif; ?>
						<?php
						// POST to apply-as-a-guest so the request is never served from GET cache; server runs template and loads transient.
						?>
						<div class="mb_20">
						<form method="post" action="<?php echo esc_url( home_url( '/apply-as-a-guest/' ) ); ?>" class="guest-edit-profile-form" style="display: inline;">
							<?php wp_nonce_field( 'tasheel_guest_edit_profile_' . $apply_to, 'tasheel_guest_edit_nonce' ); ?>
							<input type="hidden" name="tasheel_guest_edit_profile" value="1" />
							<input type="hidden" name="apply_to" value="<?php echo (int) $apply_to; ?>" />
							<input type="hidden" name="review_token" value="<?php echo esc_attr( $review_token ); ?>" />
							<button type="submit" class="btn_style btn_transparent but_black"><?php esc_html_e( 'Edit profile', 'tasheel' ); ?></button>
						</form>
						</div>
					</div>

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'Contact Information', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6><?php esc_html_e( 'Title', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( function_exists( 'tasheel_hr_title_display_label' ) ? tasheel_hr_title_display_label( isset( $snapshot['profile_title'] ) ? $snapshot['profile_title'] : '' ) : ( isset( $snapshot['profile_title'] ) && $snapshot['profile_title'] !== '' ? $snapshot['profile_title'] : '—' ) ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Full Name', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( trim( ( isset( $snapshot['profile_first_name'] ) ? $snapshot['profile_first_name'] : '' ) . ' ' . ( isset( $snapshot['profile_last_name'] ) ? $snapshot['profile_last_name'] : '' ) ) ?: '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Email', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( $guest_email ?: '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Phone', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( isset( $snapshot['profile_phone'] ) ? $snapshot['profile_phone'] : '—' ); ?></p>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'General Informations', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6><?php esc_html_e( 'Gender', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( function_exists( 'tasheel_hr_gender_display_label' ) ? tasheel_hr_gender_display_label( isset( $snapshot['profile_gender'] ) ? $snapshot['profile_gender'] : '' ) : ( isset( $snapshot['profile_gender'] ) ? $snapshot['profile_gender'] : '—' ) ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Marital Status', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( function_exists( 'tasheel_hr_marital_status_label' ) ? tasheel_hr_marital_status_label( isset( $snapshot['profile_marital_status'] ) ? $snapshot['profile_marital_status'] : '' ) : ( isset( $snapshot['profile_marital_status'] ) ? $snapshot['profile_marital_status'] : '—' ) ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Date of Birth', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( isset( $snapshot['profile_dob'] ) ? $snapshot['profile_dob'] : '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'National Status', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( isset( $snapshot['profile_national_status'] ) && $snapshot['profile_national_status'] ? ucfirst( $snapshot['profile_national_status'] ) : '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Nationality', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( isset( $snapshot['profile_nationality'] ) && $snapshot['profile_nationality'] ? ( function_exists( 'tasheel_hr_get_country_name' ) ? tasheel_hr_get_country_name( $snapshot['profile_nationality'] ) : $snapshot['profile_nationality'] ) : '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Location', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( isset( $snapshot['profile_location'] ) ? $snapshot['profile_location'] : '—' ); ?></p>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'Supporting Documents and URLs', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6><?php esc_html_e( 'LinkedIn Profile', 'tasheel' ); ?></h6>
										<p>
											<?php
											$linkedin = isset( $snapshot['profile_linkedin'] ) ? $snapshot['profile_linkedin'] : '';
											if ( $linkedin ) {
												echo '<a href="' . esc_url( $linkedin ) . '" target="_blank" rel="noopener">' . esc_html( $linkedin ) . '</a>';
											} else {
												echo '—';
											}
											?>
										</p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Resume', 'tasheel' ); ?></h6>
										<p>
											<?php
											$resume = isset( $snapshot['profile_resume'] ) ? $snapshot['profile_resume'] : '';
											if ( is_array( $resume ) && ! empty( $resume['url'] ) ) {
												echo '<a href="' . esc_url( $resume['url'] ) . '" target="_blank" rel="noopener">' . esc_html( basename( $resume['url'] ) ) . '</a>';
											} elseif ( is_string( $resume ) && $resume !== '' ) {
												echo esc_html( $resume );
											} else {
												echo '—';
											}
											?>
										</p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Portfolio', 'tasheel' ); ?></h6>
										<p>
											<?php
											$portfolio = isset( $snapshot['profile_portfolio'] ) ? $snapshot['profile_portfolio'] : '';
											if ( is_array( $portfolio ) && ! empty( $portfolio['url'] ) ) {
												echo '<a href="' . esc_url( $portfolio['url'] ) . '" target="_blank" rel="noopener">' . esc_html( basename( $portfolio['url'] ) ) . '</a>';
											} elseif ( is_string( $portfolio ) && $portfolio !== '' ) {
												echo '<a href="' . esc_url( $portfolio ) . '" target="_blank" rel="noopener">' . esc_html( basename( wp_parse_url( $portfolio, PHP_URL_PATH ) ) ?: $portfolio ) . '</a>';
											} else {
												echo '—';
											}
											?>
										</p>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01 w_100">
								<h5><?php esc_html_e( 'Education', 'tasheel' ); ?></h5>
								<div class="education-list">
									<?php
									$education = isset( $snapshot['profile_education'] ) && is_array( $snapshot['profile_education'] ) ? $snapshot['profile_education'] : array();
									if ( ! empty( $education ) ) :
										foreach ( $education as $i => $item ) :
											$item = is_array( $item ) ? $item : array();
											$institute_display = isset( $item['institute'] ) ? $item['institute'] : ( isset( $item['institution'] ) ? $item['institution'] : ( isset( $item['degree'] ) ? $item['degree'] : '' ) );
											$country_display = ( isset( $item['country'] ) && function_exists( 'tasheel_hr_get_country_name' ) ) ? tasheel_hr_get_country_name( $item['country'] ) : ( isset( $item['country'] ) ? $item['country'] : '' );
											?>
										<div class="education-item">
											<div class="education-header">
												<h6 class="education-institution"><?php echo esc_html( $institute_display ?: '—' ); ?></h6>
												<?php if ( ! empty( $item['start_date'] ) || ! empty( $item['end_date'] ) ) : ?><span class="education-duration"><?php echo esc_html( ( isset( $item['start_date'] ) ? $item['start_date'] : '' ) . ( ! empty( $item['start_date'] ) && ! empty( $item['end_date'] ) ? ' - ' : '' ) . ( isset( $item['end_date'] ) ? $item['end_date'] : '' ) ); ?></span><?php endif; ?>
												<?php if ( ! empty( $item['under_process'] ) ) : ?><span class="education-under-process">(<?php esc_html_e( 'Under Process', 'tasheel' ); ?>)</span><?php endif; ?>
											</div>
											<?php if ( ! empty( $item['degree'] ) || ! empty( $item['major'] ) ) : ?><p class="education-degree"><?php
												$deg_val = isset( $item['degree'] ) ? $item['degree'] : '';
												$major_val = isset( $item['major'] ) ? $item['major'] : '';
												$deg_label = function_exists( 'tasheel_hr_education_degree_label' ) ? tasheel_hr_education_degree_label( $deg_val ) : $deg_val;
												$major_label = function_exists( 'tasheel_hr_education_major_label' ) ? tasheel_hr_education_major_label( $major_val ) : $major_val;
												echo esc_html( $deg_label . ( $deg_label && $major_label ? ': ' : '' ) . $major_label );
											?></p><?php endif; ?>
											<?php if ( ! empty( $item['city'] ) || ! empty( $item['country'] ) ) : ?><p class="education-location"><?php echo esc_html( ( isset( $item['city'] ) ? $item['city'] : '' ) . ( ! empty( $item['city'] ) && ! empty( $country_display ) ? ', ' : '' ) . $country_display ); ?></p><?php endif; ?>
											<?php if ( ! empty( $item['gpa'] ) || ! empty( $item['avg_grade'] ) || ! empty( $item['mode'] ) ) : ?>
											<p class="education-details"><?php
												$parts = array();
												if ( ! empty( $item['gpa'] ) ) { $parts[] = esc_html__( 'GPA:', 'tasheel' ) . ' ' . esc_html( $item['gpa'] ); }
												if ( ! empty( $item['avg_grade'] ) ) { $parts[] = esc_html__( 'Avg Grade:', 'tasheel' ) . ' ' . esc_html( $item['avg_grade'] ); }
												if ( ! empty( $item['mode'] ) ) {
													$mode_label = function_exists( 'tasheel_hr_education_mode_label' ) ? tasheel_hr_education_mode_label( $item['mode'] ) : $item['mode'];
													$parts[] = esc_html__( 'Mode:', 'tasheel' ) . ' ' . esc_html( $mode_label );
												}
												echo implode( ' | ', $parts );
											?></p>
											<?php endif; ?>
										</div>
										<?php if ( $i < count( $education ) - 1 ) : ?><div class="education-divider"></div><?php endif; ?>
									<?php endforeach; else : ?>
										<p>—</p>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>

					<?php
					$start_date_labels = array( '2026-01' => __( 'January 2026', 'tasheel' ), '2026-02' => __( 'February 2026', 'tasheel' ), '2026-03' => __( 'March 2026', 'tasheel' ), '2026-04' => __( 'April 2026', 'tasheel' ) );
					$duration_labels   = array( '1-month' => __( '1 Month', 'tasheel' ), '3-months' => __( '3 Months', 'tasheel' ), '6-months' => __( '6 Months', 'tasheel' ), '12-months' => __( '12 Months', 'tasheel' ) );
					$display_start = isset( $start_date_labels[ $stored_start_date ] ) ? $start_date_labels[ $stored_start_date ] : $stored_start_date;
					$display_duration = isset( $duration_labels[ $stored_duration ] ) ? $duration_labels[ $stored_duration ] : $stored_duration;
					if ( $stored_start_date || $stored_duration ) :
						?>
					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'Training Program Enrollment', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6><?php esc_html_e( 'Start Date', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( $display_start ?: '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Duration Time', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( $display_duration ?: '—' ); ?></p>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<form method="post" action="<?php echo esc_url( home_url( '/apply-as-a-guest/' ) ); ?>" class="guest-profile-submit-form" id="guest-profile-submit-form">
						<?php wp_nonce_field( 'tasheel_hr_guest_apply_' . $apply_to, '_wpnonce' ); ?>
						<input type="hidden" name="tasheel_hr_guest_apply" value="1" />
						<input type="hidden" name="apply_to" value="<?php echo (int) $apply_to; ?>" />
						<input type="hidden" name="step" value="submit" />
						<input type="hidden" name="review_token" value="<?php echo esc_attr( $review_token ); ?>" />
						<input type="hidden" name="start_date" value="<?php echo esc_attr( $stored_start_date ); ?>" />
						<input type="hidden" name="duration" value="<?php echo esc_attr( $stored_duration ); ?>" />

						<div class="form-buttion-row flex-align-right">
							<button type="submit" class="btn_style but_black"><?php esc_html_e( 'Submit Application', 'tasheel' ); ?></button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();
