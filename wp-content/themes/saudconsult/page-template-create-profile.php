<?php
/**
 * Template Name: Create Profile
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
					<h3 class="h3_title_50 pb_5 text_center mb_20">Create Profile</h3>


                    <div class="form-group">


					<div class="related_jobs_section_content">
						<h5>Contact Information</h5>

						<div class="file-upload-section-wrapper">
							<div class="file-upload-section">
								<input type="file" id="profile-photo-upload" name="profile_photo" accept="image/*" class="file-input-hidden">
								<label for="profile-photo-upload" class="file-upload-label">
									<span class="file-upload-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/file-upload.svg" alt="Upload"></span>
									<p class="file-upload-text">Upload a photo</p>
								</label>
								<div class="file-preview-container" style="display: none;">
									<img id="file-preview-image" src="" alt="Preview" class="file-preview-image">
									<button type="button" class="file-remove-btn" aria-label="Remove image">×</button>
								</div>
							</div>
						</div>
 </div>

					<ul class="career-form-list-ul form-col-2">
						<li><input class="input" type="text" placeholder="Title *"></li>
						<li><input class="input" type="text" placeholder="Last Name *"></li>
						<li><input class="input" type="text" placeholder="Middle Name"></li>
						<li><input class="input" type="text" placeholder="Last Name *"></li>
						<li><input class="input" type="email" placeholder="Email Address *"></li>
						<li><input class="input" type="tel" placeholder="Phone Number *"></li>
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
									<select class="input select-input" name="marital_status" required>
										<option value="">Marital Status *</option>
										<option value="single">Single</option>
										<option value="married">Married</option>
										<option value="divorced">Divorced</option>
										<option value="widowed">Widowed</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<div class="select-wrapper date-input-wrapper">
									<input class="input date-input" type="date" placeholder="Date of Birth *" required>
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
									<select class="input select-input" name="training_country" required>
										<option value="">Country *</option>
										<option value="saudi">Saudi Arabia</option>
										<option value="usa">United States</option>
										<option value="uk">United Kingdom</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<input class="input" type="text" placeholder="City *" required>
							</li>
							<li>
								<input class="input" type="text" placeholder="Address Line 1">
							</li>
							<li>
								<input class="input" type="text" placeholder="Address Line 2">
							</li>
							<li>
								<input class="input" type="text" placeholder="PO Box">
							</li>
							<li>
								<input class="input" type="text" placeholder="Postal Code">
							</li>
						</ul>
					</div>

					<div class="form-group supporting-documents-section">
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

					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5>Experience *</h5>
							<p>Please provide details about your work experience.</p>
						</div>

						<ul class="career-form-list-ul form-col-2">
							<li>
								<input class="input" type="text" placeholder="Employer Name *" required>
							</li>
							<li>
								<input class="input" type="text" placeholder="Job Title *" required>
							</li>
							<li>
								<div class="select-wrapper date-input-wrapper">
									<input class="input date-input" type="date" placeholder="Start Date *" required>
								</div>
							</li>
							<li>
								<div class="select-wrapper date-input-wrapper">
									<input class="input date-input" type="date" placeholder="End Date *" required>
								</div>
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
								<input class="input" type="text" placeholder="Years of Experience *" required>
							</li>
							<li>
								<input class="input" type="text" placeholder="Salary *" required>
							</li>
							<li>
								<input class="input" type="text" placeholder="Benefits">
							</li>
						</ul>

						<div class="career-form-list-ul">
							<li>
								<textarea class="input textarea-input" placeholder="Reason for Leaving" rows="4"></textarea>
							</li>
						</div>

						<div class="education-checkbox-wrapper">
							<label class="education-checkbox-label">
								<input type="checkbox" name="current_job" class="education-checkbox" checked>
								<span class="checkbox-text">Current Job</span>
							</label>
						</div>

						<div class="education-buttons-wrapper">
							<button type="button" class="max-w-but btn_style btn_save_education">Save Experience</button>
							<button type="button" class="max-w-but btn_style btn_add_more_education">Add More Experience</button>
						</div>
					</div>

					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5>Licenses and Certificates</h5>
							<p>Please provide details about your licenses and certificates. In the 'Expiration Date' field, please enter '12/31/9999' to indicate an unlimited expiration date.</p>
						</div>

						<ul class="career-form-list-ul form-col-2">
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="license_certificate" required>
										<option value="">License or Certificate *</option>
										<option value="license1">License 1</option>
										<option value="license2">License 2</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<input class="input" type="text" placeholder="Job Title *" required>
							</li>
							<li>
								<div class="select-wrapper date-input-wrapper">
									<input class="input date-input" type="date" placeholder="Issue Date *" required>
								</div>
							</li>
							<li>
								<div class="select-wrapper date-input-wrapper">
									<input class="input date-input" type="date" placeholder="Expiration Date">
								</div>
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="status">
										<option value="">Status</option>
										<option value="active">Active</option>
										<option value="expired">Expired</option>
										<option value="pending">Pending</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="title">
										<option value="">Title</option>
										<option value="title1">Title 1</option>
										<option value="title2">Title 2</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
						</ul>

						<div class="certificate-upload-section">
							<p class="certificate-upload-instruction">Please upload the certificate or license, if applicable</p>
							<div class="certificate-upload-area">
								<input type="file" id="certificate-upload" name="certificate" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden">
								<label for="certificate-upload" class="certificate-upload-button">
									Drop attachment here
								</label>
								<div class="certificate-file-name" style="display: none;"></div>
							</div>
						</div>

						<div class="education-buttons-wrapper">
							<button type="button" class="max-w-but btn_style btn_save_education">Add License</button>
							<button type="button" class="max-w-but btn_style btn_add_more_education">Add More License</button>
						</div>
					</div>

					<div class="form-group">
						<div class="saudi-council-section">
							<h5 class="saudi-council-title">Saudi Council Classification</h5>
							<div class="saudi-council-upload-wrapper">
								<div class="mob_Show placeholder_mob_show">
								<p class="m_0  " >
								Saudi Council Classification Certificate (شهادة هيئة المهندسين السعوديين)
</p>
</div>
								<div class="saudi-council-input-wrapper mobile_hide">
									<input type="text" class="input saudi-council-input" placeholder="Saudi Council Classification Certificate (شهادة هيئة المهندسين السعوديين)" readonly>
								</div>
								<div class="saudi-council-button-wrapper">
									<input type="file" id="saudi-council-upload" name="saudi_council_certificate" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden">
									<label for="saudi-council-upload" class="saudi-council-attach-btn">
										Attach Copy
									</label>
									<!-- <div class="saudi-council-file-name" style="display: none;"></div> -->
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5>Additional Information</h5>
						</div>

						<ul class="career-form-list-ul form-col-2">
							<li>
								<input class="input" type="text" placeholder="Years of Experience *" required>
							</li>
							<li>
								<input class="input" type="text" placeholder="Notice Period *" required>
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="current_salary" required>
										<option value="">Current Salary *</option>
										<option value="0-5000">0 - 5,000 SAR</option>
										<option value="5000-10000">5,000 - 10,000 SAR</option>
										<option value="10000-15000">10,000 - 15,000 SAR</option>
										<option value="15000+">15,000+ SAR</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="expected_salary" required>
										<option value="">Expected Salary *</option>
										<option value="0-5000">0 - 5,000 SAR</option>
										<option value="5000-10000">5,000 - 10,000 SAR</option>
										<option value="10000-15000">10,000 - 15,000 SAR</option>
										<option value="15000+">15,000+ SAR</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<div class="select-wrapper">
									<select class="input select-input" name="po_box">
										<option value="">PO Box</option>
										<option value="box1">PO Box 1</option>
										<option value="box2">PO Box 2</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
						</ul>
					</div>

					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5>Employment History at Saud Consult</h5>
						</div>

						<!-- Section 1: Currently employed -->
						<div class="employment-section mt_20">
							<div class="career-form-list-ul form-col-2">
								<li>
									<div class="employment-question">
										<label class="employment-question-label">Currently employed at Saud Consult?</label>
										<div class="yes-no-checkboxes">
											<label class="yes-no-checkbox-label">
												<input type="checkbox" name="currently_employed" value="yes" class="yes-no-checkbox" checked>
												<span class="checkbox-text">Yes</span>
											</label>
											<label class="yes-no-checkbox-label">
												<input type="checkbox" name="currently_employed" value="no" class="yes-no-checkbox">
												<span class="checkbox-text">No</span>
											</label>
										</div>
									</div>
								</li>
							</div>
							<ul class="career-form-list-ul form-col-2">
								<li>
									<input class="input" type="text" placeholder="Employee ID *" required>
								</li>
								<li>
									<input class="input" type="text" placeholder="Current Project *" required>
								</li>
								<li>
									<div class="select-wrapper">
										<select class="input select-input" name="current_department" required>
											<option value="">Department *</option>
											<option value="engineering">Engineering</option>
											<option value="design">Design</option>
											<option value="management">Management</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
							</ul>
						</div>

						<!-- Section 2: Previously worked -->
						<div class="employment-section">
							<div class="career-form-list-ul form-col-2">
								<li>
									<div class="employment-question">
										<label class="employment-question-label">Previously worked at Saud Consult?</label>
										<div class="yes-no-checkboxes">
											<label class="yes-no-checkbox-label">
												<input type="checkbox" name="previously_worked" value="yes" class="yes-no-checkbox" checked>
												<span class="checkbox-text">Yes</span>
											</label>
											<label class="yes-no-checkbox-label">
												<input type="checkbox" name="previously_worked" value="no" class="yes-no-checkbox">
												<span class="checkbox-text">No</span>
											</label>
										</div>
									</div>
								</li>
							</div>
							<ul class="career-form-list-ul form-col-2">
								<li>
									<input class="input" type="text" placeholder="Duration *" required>
								</li>
								<li>
									<input class="input" type="text" placeholder="Last Project *" required>
								</li>
								<li>
									<div class="select-wrapper">
										<select class="input select-input" name="previous_department" required>
											<option value="">Department *</option>
											<option value="engineering">Engineering</option>
											<option value="design">Design</option>
											<option value="management">Management</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
							</ul>
						</div>

						<!-- Section 3: Recent Projects experience -->
						<div class="employment-section">
							<div class="career-form-list-ul form-col-2">
								<li>
									<div class="employment-question">
										<label class="employment-question-label">Recent Projects experience</label>
										<div class="yes-no-checkboxes">
											<label class="yes-no-checkbox-label">
												<input type="checkbox" name="recent_projects" value="yes" class="yes-no-checkbox" checked>
												<span class="checkbox-text">Yes</span>
											</label>
											<label class="yes-no-checkbox-label">
												<input type="checkbox" name="recent_projects" value="no" class="yes-no-checkbox">
												<span class="checkbox-text">No</span>
											</label>
										</div>
									</div>
								</li>
							</div>
							<ul class="career-form-list-ul form-col-2">
								<li>
									<input class="input" type="text" placeholder="Company Name *" required>
								</li>
								<li>
									<input class="input" type="text" placeholder="Client Name *" required>
								</li>
								<li>
									<div class="select-wrapper">
										<select class="input select-input" name="employment_period" required>
											<option value="">Employment Period *</option>
											<option value="0-1">0-1 years</option>
											<option value="1-3">1-3 years</option>
											<option value="3-5">3-5 years</option>
											<option value="5+">5+ years</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
								<li>
									<div class="select-wrapper">
										<select class="input select-input" name="position" required>
											<option value="">Position *</option>
											<option value="engineer">Engineer</option>
											<option value="senior-engineer">Senior Engineer</option>
											<option value="manager">Manager</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
							</ul>
							<div class="career-form-list-ul">
								<li>
									<textarea class="input textarea-input" placeholder="Duties & Responsibilities" rows="4"></textarea>
								</li>
							</div>
							<div class="add-more-projects-link">
								<a href="#" class="add-more-link">Add more projects</a>
							</div>
						</div>
					</div>

					 <div class="form-buttion-row flex-align-right">
                        <a href="<?php echo esc_url( home_url( '/my-profile' ) ); ?>" type="button" class="btn_style btn_transparent but_black">Save Profile</a>
                     </div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();

