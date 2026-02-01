<?php
/**
 * Template Name: Apply as a Guest
 *
 * The template for displaying the Create Profile page
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';
get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
 

	<section class="create_profile_section pt_80 pb_80">
		<div class="wrap">
			<div class="create_profile_container">
				<div class="create_profile_content">
					<h3 class="h3_title_50 pb_5 text_center mb_20">Apply as a Guest</h3>

					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5>Contact Information</h5>
						</div>

						<ul class="career-form-list-ul form-col-2">
							<li><input class="input" type="text" placeholder="First Name *"></li>
							<li><input class="input" type="text" placeholder="Last Name *"></li>
							<li><input class="input" type="email" placeholder="name@mail.com"></li>
							<li><input class="input" type="email" placeholder="Retype Email Address *"></li>
						</ul>
					</div>

			 

					
					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5>Diversity Information</h5>
						</div>

						<ul class="career-form-list-ul form-col-2">
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="gender" required>
										<option value="">Gender *</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="other">Other</option>
										<option value="prefer-not-to-say">Prefer not to say</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="nationality" required>
										<option value="">Nationality *</option>
										<option value="saudi">Saudi</option>
										<option value="other">Other</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
						</ul>
					</div>

					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5>Training Program Enrollment</h5>
						</div>

						<ul class="career-form-list-ul form-col-2">
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="training_start_date" required>
										<option value="">Start Date *</option>
										<option value="2026-01">January 2026</option>
										<option value="2026-02">February 2026</option>
										<option value="2026-03">March 2026</option>
										<option value="2026-04">April 2026</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="training_duration" required>
										<option value="">Duration Time *</option>
										<option value="1-month">1 Month</option>
										<option value="3-months">3 Months</option>
										<option value="6-months">6 Months</option>
										<option value="12-months">12 Months</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
						</ul>
					</div>

					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5>Supporting Documents and URLs</h5>
						</div>

						<div class="resume-upload-wrapper">
							<div class="resume-upload-area">
								<input type="file" id="resume-upload" name="resume" accept=".pdf,.doc,.docx" class="file-input-hidden">
								<label for="resume-upload" class="resume-upload-button">
									Upload resume here
								</label>
								<div class="resume-file-name" style="display: none;"></div>
							</div>
						</div>
                        <div class="resume-upload-wrapper">
							<div class="resume-upload-area">
								<input type="file" id="resume-upload" name="resume" accept=".pdf,.doc,.docx" class="file-input-hidden">
								<label for="resume-upload" class="resume-upload-button">
								Upload portfolio here
								</label>
								<div class="resume-file-name" style="display: none;"></div>
							</div>
						</div>
						<ul class="career-form-list-ul">
							<li>
								<input class="input" type="url" placeholder="LinkedIn Profile Link">
							</li>
						</ul>
					</div>

					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5>Education</h5>
							<p>Please provide details about your education.</p>
						</div>

						<ul class="career-form-list-ul form-col-2">
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="degree" required>
										<option value="">Degree *</option>
										<option value="bachelor">Bachelor's Degree</option>
										<option value="master">Master's Degree</option>
										<option value="phd">PhD</option>
										<option value="diploma">Diploma</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="institute" required>
										<option value="">Institute *</option>
										<option value="institute1">Institute 1</option>
										<option value="institute2">Institute 2</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="major" required>
										<option value="">Major *</option>
										<option value="engineering">Engineering</option>
										<option value="business">Business</option>
										<option value="science">Science</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<div class="select-wrapper date-input-wrapper">
									<input class="input date-input" type="date" placeholder="End Date *" required>
								</div>
							</li>
							<li>
								<div class="select-wrapper date-input-wrapper">
									<input class="input date-input" type="date" placeholder="Start Date *" required>
								</div>
							</li>
							<li>
								<input class="input" type="text" placeholder="City">
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="country" required>
										<option value="">Country *</option>
										<option value="saudi">Saudi Arabia</option>
										<option value="usa">United States</option>
										<option value="uk">United Kingdom</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<input class="input" type="text" placeholder="GPA">
							</li>
							<li>
								<input class="input" type="text" placeholder="Average Grade">
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="mode_of_study">
										<option value="">What was the mode of study?</option>
										<option value="full-time">Full-time</option>
										<option value="part-time">Part-time</option>
										<option value="online">Online</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
						</ul>

						<div class="education-checkbox-wrapper">
							<label class="education-checkbox-label">
								<input type="checkbox" name="under_process" class="education-checkbox" checked>
								<span class="checkbox-text">Under Process</span>
							</label>
						</div>

						<div class="education-buttons-wrapper">
							<button type="button" class=" max-w-but  btn_style btn_save_education">Save Education</button>
							<button type="button" class="max-w-but btn_style btn_add_more_education">Add More Education</button>
						</div>
					</div>

				  
 
 
 

					 <div class="form-buttion-row flex-align-right">
                        <a href="<?php echo esc_url( home_url( '/guest-profile' ) ); ?>" type="button" class="btn_style btn_transparent but_black">Review</a>
                     </div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();

