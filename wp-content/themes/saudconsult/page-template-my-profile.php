<?php
/**
 * Template Name: My Profile
 *
 * The template for displaying the My Profile page
 *
 * @package tasheel
 */

// Set global variable for header class
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
		'active_tab' => 'My Profile', // Set which tab should be active
		'nav_class' => 'profile-tabs-nav' // Custom class for ul element
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>







	<section class="my_profile_section pt_80 pb_80">
		<div class="wrap">
			<div class="my_profile_container">
				<div class="my_profile_content">
                    <div class="profile-title-block text-center-title">
					<h3 class="h3_title_50 pb_5 text_center mb_20">Review Profile</h3>

                    <a href="<?php echo esc_url( home_url( '/create-profile' ) ); ?>#" class="btn_style but_black but-position">Edit Profile</a>
                    </div>
					<div class="form-group">
						<div class="profile-view-block-01 colm-rev-mobile related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5>Contact Information</h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6>Full Name</h6>
										<p>Mohammed Shafin Jilani</p>
									</li>
									<li>
										<h6>Email</h6>
										<p><a href="mailto:shafin@mail.com">shafin@mail.com</a></p>
									</li>
									<li>
										<h6>Phone</h6>
										<p><a href="tel:+923421234678">+92342 1234 678</a></p>
									</li>
								</ul>
							</div>

							<div class="profile-photo-block">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile-img.jpg" alt="Profile Photo">
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
										<h6>Marital Status</h6>
										<p>Married</p>
									</li>
									<li>
										<h6>Date of Birth</h6>
										<p>12/04/1980</p>
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
								<h5>Address</h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6>Country</h6>
										<p>Saudi Arabia</p>
									</li>
									<li>
										<h6>City</h6>
										<p>Riyadh</p>
									</li>
									<li>
										<h6>Address</h6>
										<p>House no. 21, street xyz, postal no. 342198</p>
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
										<p><a href="https://www.linkedin.com/share?profile" target="_blank" rel="noopener noreferrer">https://www.linkedin.com/share?profile</a></p>
									</li>
									<li>
										<h6>Resume</h6>
										<p><a href="#" class="resume-download-link">shafin.pdf</a></p>
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

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content related_jobs_section_content">
							<div class="profile-view-block-01-item-01 w_100">
								<h5>Experience</h5>
								<div class="experience-list">
									<div class="experience-item">
										<div class="experience-header">
											<h6 class="experience-position">Project Manager</h6>
											<span class="experience-duration">August 2015 - July 2017</span>
										</div>
										<p class="experience-company">Saud Consult | Saudi Arabia</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group  related_jobs_section_content ">
                    <h5>Licenses and Certificates</h5>
						<div class="profile-view-block-01 related_jobs_section_content license-block">
							<div class="license-image">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/license-01.jpg" alt="License Certificate">
							</div>
							<div class="license-content">
								
								<h6 class="license-title">School of Arts</h6>
								<p class="license-desc">Certification: Communication</p>
							</div>
							<div class="license-duration">
								<span>August 2015 - July 2017</span>
							</div>
						</div>
					</div>

					<div class="form-group  related_jobs_section_content">
                    <h5>Saudi Council Classification</h5>
						<div class="profile-view-block-01 related_jobs_section_content license-block">
                       
							<div class="license-image">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/license-02.jpg" alt="Saudi Council Classification">
							</div>
							<div class="license-content">
								
								<h6 class="license-title">Saudi Council Classification</h6>
							</div>
							<div class="license-duration">
								<span>August 2015 - July 2017</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5>Additional Information</h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6>Years of Experience</h6>
										<p>7 Years</p>
									</li>
									<li>
										<h6>Notice Period</h6>
										<p>90 Days</p>
									</li>
									<li>
										<h6>Current Salary</h6>
										<p>10,000 SAR</p>
									</li>
									<li>
										<h6>Expected Salary</h6>
										<p>15,000 SAR</p>
									</li>
									<li>
										<h6>Visa Status</h6>
										<p>Visit Visa</p>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="form-buttion-row flex-align-right">
						<a href="#login-popup-training-submit" class="btn_style but_black"  data-fancybox-initialized="true">Submit Application</a>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();

