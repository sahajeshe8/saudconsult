<?php
/**
 * Template Name: My Jobs
 *
 * The template for displaying the My Jobs page
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';

// Require login: redirect to home so user can use the site login popup; preserve intended URL for after login.
if ( ! is_user_logged_in() ) {
	$intended = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : home_url( '/my-job/' );
	$redirect = add_query_arg( array( 'redirect_to' => rawurlencode( $intended ), 'open_login' => '1' ), home_url( '/' ) );
	wp_safe_redirect( $redirect );
	exit;
}

get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
 

	<?php
	$current_page   = get_queried_object();
	$active_tab     = ( $current_page && isset( $current_page->post_name ) ) ? $current_page->post_name : 'my-job';
	$page_tabs_data = function_exists( 'tasheel_get_profile_tabs' ) ? tasheel_get_profile_tabs( $active_tab, get_queried_object_id() ) : array(
		'tabs'       => array(
			array( 'id' => 'my-job', 'title' => __( 'My Jobs', 'tasheel' ), 'link' => esc_url( home_url( '/my-job/' ) ) ),
			array( 'id' => 'my-profile', 'title' => __( 'My Profile', 'tasheel' ), 'link' => esc_url( home_url( '/my-profile/' ) ) ),
			array( 'id' => 'password-management', 'title' => __( 'Password Management', 'tasheel' ), 'link' => esc_url( home_url( '/password-management/' ) ) ),
		),
		'active_tab'  => $active_tab,
		'nav_class'   => 'profile-tabs-nav',
		'logout_url'  => is_user_logged_in() ? wp_logout_url( home_url( '/' ) ) : '',
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
	?>

	<section class="my_jobs_section pt_80 pb_80">
		<div class="wrap">
			<div class="my_jobs_container">
				<div class="my_jobs_content">
					<div class="profile-title-block text-center-title">
						<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'My Jobs', 'tasheel' ); ?></h3>
					</div>

					<?php
					$user_id     = get_current_user_id();
					$applications = function_exists( 'tasheel_hr_get_user_applications' ) ? tasheel_hr_get_user_applications( $user_id ) : array();
					?>

					<?php if ( empty( $applications ) ) : ?>
						<?php $view_careers_url = function_exists( 'tasheel_get_view_careers_url' ) ? tasheel_get_view_careers_url() : home_url( '/careers/' ); ?>
						<div class="my_jobs_empty_state">
							<p class="my_jobs_empty_message"><?php esc_html_e( 'You have not applied to any positions yet.', 'tasheel' ); ?></p>
							<p class="my_jobs_empty_sub"><?php esc_html_e( 'Browse our career opportunities and apply when you find a role that fits.', 'tasheel' ); ?></p>
							<a href="<?php echo esc_url( $view_careers_url ); ?>" class="btn_style but_black"><?php esc_html_e( 'View Careers', 'tasheel' ); ?></a>
						</div>
					<?php else : ?>
						<div class="my_jobs_table_wrapper">
							<table class="my_jobs_table">
								<thead>
									<tr>
										<th><?php esc_html_e( 'Job Title', 'tasheel' ); ?></th>
										<th><?php esc_html_e( 'Job ID', 'tasheel' ); ?></th>
										<th><?php esc_html_e( 'Job Type', 'tasheel' ); ?></th>
										<th><?php esc_html_e( 'Applied Date', 'tasheel' ); ?></th>
										<th><?php esc_html_e( 'Country', 'tasheel' ); ?></th>
										<th><?php esc_html_e( 'City', 'tasheel' ); ?></th>
										<th><?php esc_html_e( 'Status', 'tasheel' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $applications as $app ) : ?>
										<tr>
											<td><?php echo esc_html( $app['job_title'] ); ?></td>
											<td>#<?php echo esc_html( (string) $app['job_id'] ); ?></td>
											<td><?php echo esc_html( $app['job_type_label'] ); ?></td>
											<td><?php echo esc_html( $app['applied_date'] ); ?></td>
											<td><?php echo esc_html( $app['country'] ); ?></td>
											<td><?php echo esc_html( $app['city'] ); ?></td>
											<td>
												<?php
												$status_class = 'job_status_badge--submitted';
												if ( ! empty( $app['status_slug'] ) ) {
													$status_class = 'job_status_badge--' . sanitize_html_class( $app['status_slug'] );
												}
												?>
												<span class="job_status_badge <?php echo esc_attr( $status_class ); ?>"><?php echo esc_html( $app['status'] ); ?></span>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();
 