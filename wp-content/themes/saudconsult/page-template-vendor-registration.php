<?php
/**
 * Template Name: Vendor Registration
 *
 * The template for displaying the Vendor Registration page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main" style="background: #EDF3E4;">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/vendor-banner.jpg',
		'title' => 'Vendor Registration',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<section class="vendor_registration_section pt_80 pb_80">
		<div class="wrap">
			<div class="vendor_registration_container">
				<div class="vendor_registration_title">
					<h3  > <span>Vendor Apply</span> </h3>
				</div>

				<form class="vendor_registration_form" method="post" action="">

                <div class="vendor_registration_form_group">
					<ul class="career-form-list-ul form-col-2">
							<li>
								<label class="vendor_form_label">Legal Entity Name *</label>
								<div class="select-wrapper">
									<select class="input select-input" name="legal_entity_name" required>
										<option value="">Select</option>
										<option value="entity1">Entity 1</option>
										<option value="entity2">Entity 2</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label">Entity Type *</label>
								<div class="select-wrapper">
									<select class="input select-input" name="entity_type" required>
										<option value="">Select</option>
										<option value="llc">Limited Liability Company</option>
										<option value="joint-stock">Joint Stock Company</option>
										<option value="partnership">Partnership</option>
										<option value="establishment-sole-proprietorship">Establishment / Sole Proprietorship</option>
										<option value="joint-venture">Joint Venture</option>
										<option value="freelancer">Freelancer</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label">Years of experience in doing the business *</label>
								<div class="select-wrapper">
									<select class="input select-input" name="years_experience" required>
										<option value="">Select</option>
										<option value="0-5">0-5 years</option>
										<option value="5-10">5-10 years</option>
										<option value="10-15">10-15 years</option>
										<option value="15+">15+ years</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li class="vendor_radio_group_li">
								<div class="vendor_radio_group">
									<label class="vendor_radio_label">Registration Type *</label>
									<div class="vendor_radio_options">
										<label class="vendor_radio_option">
											<input type="radio" name="registration_type" value="gcc" checked required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text">GCC</span>
										</label>
										<label class="vendor_radio_option">
											<input type="radio" name="registration_type" value="international" required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text">International</span>
										</label>
										<label class="vendor_radio_option">
											<input type="radio" name="registration_type" value="ksa" required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text">KSA</span>
										</label>
									</div>
								</div>
							</li>
							<li>
								<label class="vendor_form_label">CR Number *  (Please attach a valid copy) </label>
								<div class="vendor_input_with_button">
									<input class="input" type="text" id="cr-number-input" required>
									<input type="file" id="cr-number-upload" name="cr_number_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden">
									<label for="cr-number-upload" class="btn_style btn_green_02 vendor-attach-btn">Attach Copy</label>
								</div>
							</li>
							<li class="vendor_radio_group_li">
								<div class="vendor_radio_group">
									<label class="vendor_radio_label">Supplying Type *</label>
									<div class="vendor_radio_options">
										<label class="vendor_radio_option">
											<input type="radio" name="supplying_type" value="service" checked required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text">Service</span>
										</label>
										<label class="vendor_radio_option">
											<input type="radio" name="supplying_type" value="material" required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text">Material</span>
										</label>
									</div>
								</div>
							</li>
							<li>
								<label class="vendor_form_label">Does the company Saudi VAT registered? *</label>
								<div class="select-wrapper">
									<select class="input select-input" name="vat_registered" required>
										<option value="">Select</option>
										<option value="yes">Yes</option>
										<option value="no">No</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label">Write down the VAT registration number ( Please attach a valid copy)</label>
								<div class="vendor_input_with_button">
									<input class="input" type="text" id="vat-number-input" required>
									<input type="file" id="vat-number-upload" name="vat_number_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden">
									<label for="vat-number-upload" class="btn_style btn_green_02 vendor-attach-btn">Attach Copy</label>
								</div>
							</li>
							<li>
								<label class="vendor_form_label">Area of expertise for your company (Select all that applied) *</label>
								<div class="select-wrapper">
									<select class="input select-input" name="area_expertise" required>
										<option value="">(Select all that applied) *</option>
										<option value="legal-and-law">Legal and Law</option>
										<option value="engineering-design">Engineering – Design</option>
										<option value="engineering-supervision">Engineering – Supervision</option>
										<option value="engineering-project-management">Engineering – Project Management</option>
										<option value="engineering-studies">Engineering – Studies</option>
										<option value="engineering-assessments">Engineering – Assessments</option>
										<option value="engineering-pmo">Engineering – PMO</option>
										<option value="engineering-pmcm">Engineering – PMCM</option>
										<option value="contracting-construction-work">Contracting / Construction work</option>
										<option value="hr-recruitment-agencies">HR recruitment Agencies</option>
										<option value="marketing">Marketing</option>
										<option value="events-and-conferences">Events and Conferences</option>
										<option value="it-and-networking">IT and Networking</option>
										<option value="food-and-beverages">Food &amp; Beverages</option>
										<option value="retail">Retail</option>
										<option value="real-estate">Real Estate</option>
										<option value="media-and-journalism">Media &amp; Journalism</option>
										<option value="innovation-and-technology">Innovation and Technology</option>
										<option value="facility-and-maintenance">Facility and Maintenance</option>
										<option value="travelling-and-ticketing">Travelling &amp; Ticketing</option>
										<option value="arts-and-sculptural">Arts and Sculptural</option>
										<option value="office-and-furniture">Office and Furniture</option>
										<option value="bim-solutions">BIM Solutions</option>
										<option value="surveying-and-3d-scanning">Surveying &amp; 3D Scanning</option>
										<option value="strategic-and-management-solutions">Strategic and management solutions</option>
										<option value="financial-and-insurance">Financial and insurance</option>
										<option value="other">Other</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label">In Which sectors the company contribute in (Select all that applied) *</label>
								<div class="select-wrapper">
									<select class="input select-input" name="sectors" required>
										<option value="">(Select all that applied) *</option>
										<option value="defense-and-aviation">Defense and Aviation</option>
										<option value="heritage-and-culture">Heritage and Culture</option>
										<option value="landscaping-public-realm">Landscaping/Public realm</option>
										<option value="leisure-and-entertainment">Leisure and Entertainment</option>
										<option value="infrastructure">Infrastructure</option>
										<option value="transportation-rail">Transportation – Rail</option>
										<option value="transportation-roads">Transportation – Roads</option>
										<option value="hospitality">Hospitality</option>
										<option value="health-and-education">Health and Education</option>
										<option value="mixed-use">Mixed use</option>
										<option value="residential">Residential</option>
										<option value="technology">Technology</option>
										<option value="other">Other</option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label">Full Address of Headquarter *</label>
								<input class="input" type="text" required>
							</li>
							<li>
								<label class="vendor_form_label">Other branches if any</label>
								<input class="input" type="text">
							</li>
						</ul>

					<!-- Contact Information Group -->
</div>

                    <div class="vendor_registration_title">
					<h3  > <span>Primary Contact Person</span> </h3>
				</div>



					<div class="vendor_registration_form_group">
						<ul class="career-form-list-ul form-col-2">
								<li>
									<label class="vendor_form_label">Name *</label>
									<div class="select-wrapper">
										<select class="input select-input" name="contact_name" required>
											<option value="">Select</option>
											<option value="name1">Name 1</option>
											<option value="name2">Name 2</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
								<li>
									<label class="vendor_form_label">Position *</label>
									<div class="select-wrapper">
										<select class="input select-input" name="contact_position" required>
											<option value="">Select</option>
											<option value="position1">Position 1</option>
											<option value="position2">Position 2</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
								<li>
									<label class="vendor_form_label">Phone *</label>
									<div class="select-wrapper">
										<select class="input select-input" name="contact_phone" required>
											<option value="">Select</option>
											<option value="phone1">Phone 1</option>
											<option value="phone2">Phone 2</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
								<li>
									<label class="vendor_form_label">Email *</label>
									<div class="select-wrapper">
										<select class="input select-input" name="contact_email" required>
											<option value="">Select</option>
											<option value="email1">Email 1</option>
											<option value="email2">Email 2</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
							</ul>
					</div>

					<div class="vendor_registration_title">
						<h3  > <span>Secondary Contact Person</span> </h3>
					</div>

					<div class="vendor_registration_form_group">
						<ul class="career-form-list-ul form-col-2">
								<li>
									<label class="vendor_form_label">Name *</label>
									<input class="input" type="text">
								</li>
								<li>
									<label class="vendor_form_label">Position *</label>
									<input class="input" type="text">
								</li>
								<li>
									<label class="vendor_form_label">Phone *</label>
									<input class="input" type="text">
								</li>
								<li>
									<label class="vendor_form_label">Email *</label>
									<input class="input" type="text">
								</li>
							</ul>
					</div>


					<div class="vendor_registration_title">
						<h3><span>Local Content Certificate</span></h3>
					</div>

						<div class="vendor_registration_form_wrapper">
							<!-- Left Column -->
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li class="vendor_radio_group_li vendor_radio_group_li_2">
										<div class="vendor_radio_group">
											<label class="vendor_radio_label">Do you have valid local content certificate? *</label>
											<div class="vendor_radio_options">
												<label class="vendor_radio_option">
													<input type="radio" name="local_content_certificate" value="yes" checked required>
													<span class="vendor_radio_custom"></span>
													<span class="vendor_radio_text">Yes</span>
												</label>
												<label class="vendor_radio_option">
													<input type="radio" name="local_content_certificate" value="no" required>
													<span class="vendor_radio_custom"></span>
													<span class="vendor_radio_text">No</span>
												</label>
											</div>
										</div>
									</li>
								</ul>
							</div>

							<!-- Right Column -->
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label">*Specify the percentage ( Please attach a valid copy)</label>
										<div class="vendor_input_with_button">
											<input class="input" type="text" id="company-profile-02-input" name="company_profile_02_file_name">
											<input type="file" id="company-profile-02-upload" name="company_profile_02_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden" data-fill-target="#company-profile-02-input">
											<label for="company-profile-02-upload" class="btn_style btn_green_02 vendor-attach-btn">Attach Copy</label>
										</div>
									</li>
								</ul>
							</div>
						</div>
					<!-- Additional Information Group -->
					<div class="vendor_registration_title">
						<h3  > <span>Company Information and experience </span> </h3>
					</div>

					<div class="vendor_registration_form_group">
						<ul class="career-form-list-ul form-col-2">
								<li>
									<label class="vendor_form_label">Number of Company Employees *</label>
									<div class="select-wrapper">
										<select class="input select-input" name="number_of_employees">
											<option value="">Select</option>
											<option value="1-10">1-10</option>
											<option value="11-50">11-50</option>
											<option value="51-200">51-200</option>
											<option value="201-500">201-500</option>
											<option value="500+">500+</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
								<li>
									<label class="vendor_form_label">Company website *</label>
									<div class="select-wrapper">
										<select class="input select-input" name="number_of_employees">
											<option value="">Select</option>
											<option value="1-10">1-10</option>
											<option value="11-50">11-50</option>
											<option value="51-200">51-200</option>
											<option value="201-500">201-500</option>
											<option value="500+">500+</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
								<li class="vendor_radio_group_li vendor_radio_group_li_2">
									<div class="vendor_radio_group">
										<label class="vendor_radio_label">Have you worked before with <br>SAUDCONSULT? *</label>
										<div class="vendor_radio_options">
											<label class="vendor_radio_option">
												<input type="radio" name="registration_type" value="gcc" checked required>
												<span class="vendor_radio_custom"></span>
												<span class="vendor_radio_text">Yes</span>
											</label>
											<label class="vendor_radio_option">
												<input type="radio" name="registration_type" value="international" required>
												<span class="vendor_radio_custom"></span>
												<span class="vendor_radio_text"> No</span>
											</label>
										</div>
									</div>
								</li>
								<li>
									<label class="vendor_form_label">Project Name *</label>
									<div class="select-wrapper">
										<select class="input select-input" name="annual_revenue">
											<option value="">Select</option>
											<option value="0-1M">0 - 1M SAR</option>
											<option value="1M-5M">1M - 5M SAR</option>
											<option value="5M-10M">5M - 10M SAR</option>
											<option value="10M-50M">10M - 50M SAR</option>
											<option value="50M+">50M+ SAR</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
								<li>
									<label class="vendor_form_label">Role at that Project *</label>
									<div class="select-wrapper">
										<select class="input select-input" name="annual_revenue">
											<option value="">Select</option>
											<option value="0-1M">0 - 1M SAR</option>
											<option value="1M-5M">1M - 5M SAR</option>
											<option value="5M-10M">5M - 10M SAR</option>
											<option value="10M-50M">10M - 50M SAR</option>
											<option value="50M+">50M+ SAR</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
								<li>
									<label class="vendor_form_label">Year of Completion *</label>
									<div class="select-wrapper">
										<select class="input select-input" name="annual_revenue">
											<option value="">Select</option>
											<option value="0-1M">0 - 1M SAR</option>
											<option value="1M-5M">1M - 5M SAR</option>
											<option value="5M-10M">5M - 10M SAR</option>
											<option value="10M-50M">10M - 50M SAR</option>
											<option value="50M+">50M+ SAR</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</li>
							</ul>
					</div>

					<!-- Project Details Group -->
					<div class="vendor_registration_title">
						<h3  > <span> Total revenue for the past three years in (SAR) Currency</span> </h3>
					</div>

					<div class="vendor_registration_form_group">
						<div class="vendor_registration_form_wrapper vendor_registration_form_wrapper_3col">
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label">2024</label>
										<input class="input" type="text" name="cert_year_2024" />
									</li>
								</ul>
							</div>
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label">2023</label>
										<input class="input" type="text" name="cert_year_2023" />
									</li>
								</ul>
							</div>
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label">2022</label>
										<input class="input" type="text" name="cert_year_2022" />
									</li>
								</ul>
							</div>
						</div>
                       
						<div class="vendor_registration_form_wrapper">
                            
							<!-- Left Column -->
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label">Do you have valid ISO Certificates?</label>
										<div class="vendor_input_with_button">
											<input class="input" type="text" id="iso-cert-input" name="iso_cert_file_name" required>
											<input type="file" id="iso-cert-upload" name="iso_cert_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden" data-fill-target="#iso-cert-input">
											<label for="iso-cert-upload" class="btn_style btn_green_02 vendor-attach-btn">Attach Copy</label>
										</div>
									</li>
								</ul>
							</div>

							<!-- Right Column -->
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label">Please attach company profile</label>
										<div class="vendor_input_with_button">
											<input class="input" type="text" id="company-profile-01-input" name="company_profile_01_file_name">
											<input type="file" id="company-profile-01-upload" name="company_profile_01_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden" data-fill-target="#company-profile-01-input">
											<label for="company-profile-01-upload" class="btn_style btn_green_02 vendor-attach-btn">Attach Copy</label>
										</div>
									</li>
								</ul>
							</div>
						</div>

				
					</div>

					<div class="vendor_registration_form_actions">
						<button type="submit" class="btn_style but_black">Submit <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="Submit"></span></button>
					</div>
				</form>
			</div>
		</div>
	</section>
	 
</main><!-- #main -->

<?php
get_footer();

