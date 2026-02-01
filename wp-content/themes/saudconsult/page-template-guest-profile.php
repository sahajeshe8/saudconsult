<?php
/**
 * Template Name: Guest Profile
 *
 * The template for displaying the Guest Profile page
 *
 * @package tasheel
 */

// Set global variable for header class
global $header_custom_class;
$header_custom_class = 'black-header';

get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
 
 

	<section class="my_profile_section pt_80 pb_80">
		<div class="wrap">
			<div class="my_profile_container">
				<div class="my_profile_content">
                    <div class="profile-title-block text-center-title">
						<h3 class="h3_title_50 pb_5 text_center mb_20">Apply as a Guest</h3>
                     </div>

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5>Contact Information</h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6>Full Name</h6>
										<p>Mohammed Shafin Jilani</p>
									</li>
									<li>
										<h6>Email</h6>
										<p>shafin@mail.com</p>
									</li>
									<li>
										<h6>Phone</h6>
										<p>+92342 1234 678</p>
									</li>
								</ul>
							</div>
 
						</div>
					</div>

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5>Diversity Information</h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6>Gender</h6>
										<p>Male</p>
									</li>
									 
									<li>
										<h6>Nationality</h6>
										<p>Saudi</p>
									</li>
								</ul>
							</div>
						</div>
					</div>





					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5>Training Program Enrollment</h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6>Start Date</h6>
										<p>12/12/2025</p>
									</li>
									<li>
										<h6>Duration Time</h6>
										<p>3 months</p>
									</li>
								</ul>
							</div>
						</div>
					</div>






					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5>Supporting Documents and URLs</h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6>LinkedIn Profile</h6>
										<p>https://www.linkedin.com/share?profile</p>
									</li>
									<li>
										<h6>Resume</h6>
										<p>shafin.pdf</p>
									</li>
								</ul>
							</div>
						</div>
					</div>

				 

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01 w_100">
								<h5>Education</h5>
								<div class="education-list">
									<div class="education-item">
										<div class="education-header">
											<h6 class="education-institution">Karachi School of Arts</h6>
											<span class="education-duration">August 2015 - July 2017</span>
										</div>
										<p class="education-degree">Bachelors: Communication Design</p>
										<p class="education-location">Karachi, Pakistan</p>
									</div>
									<div class="education-divider"></div>
									<div class="education-item">
										<div class="education-header">
											<h6 class="education-institution">Karachi School of Arts</h6>
											<span class="education-duration">August 2015 - July 2017</span>
										</div>
										<p class="education-degree">Bachelors: Communication Design</p>
										<p class="education-location">Karachi, Pakistan</p>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <div class="form-buttion-row flex-align-right">
                    <a   href="<?php echo esc_url( home_url( '/application-received' ) ); ?>" class="btn_style but_black   ">Submit Application</a>
</div>

			 

			 
 

				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();


