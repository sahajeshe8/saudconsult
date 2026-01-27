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
get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
 

	<?php 
	$page_tabs_data = array(
		'tabs' => array(
			array( 'id' => 'My Jobs', 'title' => 'My Jobs', 'link' => esc_url( home_url( '/my-job' ) ) ),
			array( 'id' => 'My Profile', 'title' => 'My Profile', 'link' => esc_url( home_url( '/my-profile' ) ) ),
			array( 'id' => 'Password Management', 'title' => 'Password Management', 'link' => esc_url( home_url( '/password-management' ) ) )  
		),
		'active_tab' => 'My Jobs',
		'nav_class' => 'profile-tabs-nav',
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>

	<section class="my_jobs_section pt_80 pb_80">
		<div class="wrap">
			<div class="my_jobs_container">
				<div class="my_jobs_content">
					<div class="profile-title-block text-center-title">
						<h3 class="h3_title_50 pb_10 text_center mb_20">My Jobs</h3>
					</div>

					<div class="my_jobs_table_wrapper">
						<table class="my_jobs_table">
							<thead>
								<tr>
									<th>Job Title</th>
									<th>Job ID</th>
									<th>Job Type</th>
									<th>Applied Date</th>
									<th>Country</th>
									<th>City</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Project Manager</td>
									<td>#54294</td>
									<td>Corporate</td>
									<td>12/04/2025</td>
									<td>Saudi Arabia</td>
									<td>Riyadh</td>
									<td><span class="job_status_badge job_status_badge--active">Active</span></td>
								</tr>
								<tr>
									<td>Project Manager</td>
									<td>#54294</td>
									<td>Corporate</td>
									<td>12/04/2025</td>
									<td>Saudi Arabia</td>
									<td>Riyadh</td>
									<td><span class="job_status_badge job_status_badge--active">Active</span></td>
								</tr>
								<tr>
									<td>Project Manager</td>
									<td>#54294</td>
									<td>Corporate</td>
									<td>12/04/2025</td>
									<td>Saudi Arabia</td>
									<td>Riyadh</td>
									<td><span class="job_status_badge job_status_badge--active">Active</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();
 