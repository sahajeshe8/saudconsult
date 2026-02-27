<?php
/**
 * Template Name: Vendor Registration
 *
 * When you add any sections in the editor (Page Sections flexible content), those are rendered:
 * Inner Banner, Vendor Form (Contact Form 7 shortcode), etc. If no sections are added, fallback
 * is default banner + static HTML form. Ensure this page uses template "Vendor Registration" and
 * save after adding blocks. All visible strings use esc_html_e / esc_html__ for WPML.
 *
 * @package tasheel
 */

get_header();

$page_id  = get_queried_object_id();
$sections = array();
if ( function_exists( 'get_field' ) ) {
	$raw = get_field( 'about_page_sections', $page_id );
	$sections = ( is_array( $raw ) && ! empty( $raw ) ) ? $raw : array();
}
$use_flexible = ! empty( $sections );
?>

<main id="primary" class="site-main" style="background: #EDF3E4;">
	<?php
	if ( $use_flexible ) {
		// Dynamic: render each ACF section. Vendor Form block is rendered directly so it always shows on this page.
		foreach ( $sections as $section ) {
			$layout = isset( $section['acf_fc_layout'] ) ? $section['acf_fc_layout'] : '';
			$is_vendor_form = ( $layout === 'vendor_form' || $layout === 'layout_vendor_form' );
			if ( ! $is_vendor_form && function_exists( 'tasheel_vendor_get_form_shortcode' ) && tasheel_vendor_get_form_shortcode( $section ) !== '' ) {
				$is_vendor_form = true; // Section has CF7 shortcode → treat as vendor form even if layout name differs.
			}
			if ( $is_vendor_form && function_exists( 'tasheel_render_vendor_flexible_section' ) ) {
				tasheel_render_vendor_flexible_section( $section );
			} elseif ( function_exists( 'tasheel_render_contact_flexible_section' ) ) {
				tasheel_render_contact_flexible_section( $section );
			}
		}
	} else {
		// Fallback: default banner + static form.
		$inner_banner_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/vendor-banner.jpg',
			'title'            => esc_html__( 'Vendor Registration', 'tasheel' ),
		);
		get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
	?>
	<section class="vendor_registration_section pt_80 pb_80">
		<div class="wrap">
			<div class="vendor_registration_container">
				<div class="vendor_registration_title">
					<h3><span><?php esc_html_e( 'Vendor Application Form', 'tasheel' ); ?></span></h3>
				</div>

				<form class="vendor_registration_form" method="post" action="">

					<div class="vendor_registration_form_group">
						<ul class="career-form-list-ul form-col-2">
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Legal Entity Name *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="legal_entity_name" required>
										<option value=""><?php esc_html_e( 'Select', 'tasheel' ); ?></option>
										<option value="entity1"><?php esc_html_e( 'Entity 1', 'tasheel' ); ?></option>
										<option value="entity2"><?php esc_html_e( 'Entity 2', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Entity Type *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="entity_type" required>
										<option value=""><?php esc_html_e( 'Select', 'tasheel' ); ?></option>
										<option value="llc"><?php esc_html_e( 'Limited Liability Company', 'tasheel' ); ?></option>
										<option value="joint-stock"><?php esc_html_e( 'Joint Stock Company', 'tasheel' ); ?></option>
										<option value="partnership"><?php esc_html_e( 'Partnership', 'tasheel' ); ?></option>
										<option value="establishment-sole-proprietorship"><?php esc_html_e( 'Establishment / Sole Proprietorship', 'tasheel' ); ?></option>
										<option value="joint-venture"><?php esc_html_e( 'Joint Venture', 'tasheel' ); ?></option>
										<option value="freelancer"><?php esc_html_e( 'Freelancer', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Years of experience in doing the business *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="years_experience" required>
										<option value=""><?php esc_html_e( 'Select', 'tasheel' ); ?></option>
										<option value="0-5"><?php esc_html_e( '0-5 years', 'tasheel' ); ?></option>
										<option value="5-10"><?php esc_html_e( '5-10 years', 'tasheel' ); ?></option>
										<option value="10-15"><?php esc_html_e( '10-15 years', 'tasheel' ); ?></option>
										<option value="15+"><?php esc_html_e( '15+ years', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li class="vendor_radio_group_li">
								<div class="vendor_radio_group">
									<label class="vendor_radio_label"><?php esc_html_e( 'Registration Type *', 'tasheel' ); ?></label>
									<div class="vendor_radio_options">
										<label class="vendor_radio_option">
											<input type="radio" name="registration_type" value="gcc" checked required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text"><?php esc_html_e( 'GCC', 'tasheel' ); ?></span>
										</label>
										<label class="vendor_radio_option">
											<input type="radio" name="registration_type" value="international" required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text"><?php esc_html_e( 'International', 'tasheel' ); ?></span>
										</label>
										<label class="vendor_radio_option">
											<input type="radio" name="registration_type" value="ksa" required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text"><?php esc_html_e( 'KSA', 'tasheel' ); ?></span>
										</label>
									</div>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'CR Number * (Please attach a valid copy)', 'tasheel' ); ?></label>
								<div class="vendor_input_with_button">
									<input class="input" type="text" id="cr-number-input" name="cr_number" required>
									<input type="file" id="cr-number-upload" name="cr_number_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden">
									<label for="cr-number-upload" class="btn_style btn_green_02 vendor-attach-btn"><?php esc_html_e( 'Attach Copy', 'tasheel' ); ?></label>
								</div>
							</li>
							<li class="vendor_radio_group_li">
								<div class="vendor_radio_group">
									<label class="vendor_radio_label"><?php esc_html_e( 'Supplying Type *', 'tasheel' ); ?></label>
									<div class="vendor_radio_options">
										<label class="vendor_radio_option">
											<input type="radio" name="supplying_type" value="service" checked required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text"><?php esc_html_e( 'Service', 'tasheel' ); ?></span>
										</label>
										<label class="vendor_radio_option">
											<input type="radio" name="supplying_type" value="material" required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text"><?php esc_html_e( 'Material', 'tasheel' ); ?></span>
										</label>
									</div>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Does the company Saudi VAT registered? *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="vat_registered" required>
										<option value=""><?php esc_html_e( 'Select', 'tasheel' ); ?></option>
										<option value="yes"><?php esc_html_e( 'Yes', 'tasheel' ); ?></option>
										<option value="no"><?php esc_html_e( 'No', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Write down the VAT registration number (Please attach a valid copy)', 'tasheel' ); ?></label>
								<div class="vendor_input_with_button">
									<input class="input" type="text" id="vat-number-input" name="vat_number">
									<input type="file" id="vat-number-upload" name="vat_number_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden">
									<label for="vat-number-upload" class="btn_style btn_green_02 vendor-attach-btn"><?php esc_html_e( 'Attach Copy', 'tasheel' ); ?></label>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Area of expertise for your company (Select all that applied) *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="area_expertise" required>
										<option value=""><?php esc_html_e( '(Select all that applied) *', 'tasheel' ); ?></option>
										<option value="legal-and-law"><?php esc_html_e( 'Legal and Law', 'tasheel' ); ?></option>
										<option value="engineering-design"><?php esc_html_e( 'Engineering – Design', 'tasheel' ); ?></option>
										<option value="engineering-supervision"><?php esc_html_e( 'Engineering – Supervision', 'tasheel' ); ?></option>
										<option value="engineering-project-management"><?php esc_html_e( 'Engineering – Project Management', 'tasheel' ); ?></option>
										<option value="engineering-studies"><?php esc_html_e( 'Engineering – Studies', 'tasheel' ); ?></option>
										<option value="engineering-assessments"><?php esc_html_e( 'Engineering – Assessments', 'tasheel' ); ?></option>
										<option value="engineering-pmo"><?php esc_html_e( 'Engineering – PMO', 'tasheel' ); ?></option>
										<option value="engineering-pmcm"><?php esc_html_e( 'Engineering – PMCM', 'tasheel' ); ?></option>
										<option value="contracting-construction-work"><?php esc_html_e( 'Contracting / Construction work', 'tasheel' ); ?></option>
										<option value="hr-recruitment-agencies"><?php esc_html_e( 'HR recruitment Agencies', 'tasheel' ); ?></option>
										<option value="marketing"><?php esc_html_e( 'Marketing', 'tasheel' ); ?></option>
										<option value="events-and-conferences"><?php esc_html_e( 'Events and Conferences', 'tasheel' ); ?></option>
										<option value="it-and-networking"><?php esc_html_e( 'IT and Networking', 'tasheel' ); ?></option>
										<option value="food-and-beverages"><?php esc_html_e( 'Food & Beverages', 'tasheel' ); ?></option>
										<option value="retail"><?php esc_html_e( 'Retail', 'tasheel' ); ?></option>
										<option value="real-estate"><?php esc_html_e( 'Real Estate', 'tasheel' ); ?></option>
										<option value="media-and-journalism"><?php esc_html_e( 'Media & Journalism', 'tasheel' ); ?></option>
										<option value="innovation-and-technology"><?php esc_html_e( 'Innovation and Technology', 'tasheel' ); ?></option>
										<option value="facility-and-maintenance"><?php esc_html_e( 'Facility and Maintenance', 'tasheel' ); ?></option>
										<option value="travelling-and-ticketing"><?php esc_html_e( 'Travelling & Ticketing', 'tasheel' ); ?></option>
										<option value="arts-and-sculptural"><?php esc_html_e( 'Arts and Sculptural', 'tasheel' ); ?></option>
										<option value="office-and-furniture"><?php esc_html_e( 'Office and Furniture', 'tasheel' ); ?></option>
										<option value="bim-solutions"><?php esc_html_e( 'BIM Solutions', 'tasheel' ); ?></option>
										<option value="surveying-and-3d-scanning"><?php esc_html_e( 'Surveying & 3D Scanning', 'tasheel' ); ?></option>
										<option value="strategic-and-management-solutions"><?php esc_html_e( 'Strategic and management solutions', 'tasheel' ); ?></option>
										<option value="financial-and-insurance"><?php esc_html_e( 'Financial and insurance', 'tasheel' ); ?></option>
										<option value="other"><?php esc_html_e( 'Other', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'In Which sectors the company contribute in (Select all that applied) *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="sectors" required>
										<option value=""><?php esc_html_e( '(Select all that applied) *', 'tasheel' ); ?></option>
										<option value="defense-and-aviation"><?php esc_html_e( 'Defense and Aviation', 'tasheel' ); ?></option>
										<option value="heritage-and-culture"><?php esc_html_e( 'Heritage and Culture', 'tasheel' ); ?></option>
										<option value="landscaping-public-realm"><?php esc_html_e( 'Landscaping/Public realm', 'tasheel' ); ?></option>
										<option value="leisure-and-entertainment"><?php esc_html_e( 'Leisure and Entertainment', 'tasheel' ); ?></option>
										<option value="infrastructure"><?php esc_html_e( 'Infrastructure', 'tasheel' ); ?></option>
										<option value="transportation-rail"><?php esc_html_e( 'Transportation – Rail', 'tasheel' ); ?></option>
										<option value="transportation-roads"><?php esc_html_e( 'Transportation – Roads', 'tasheel' ); ?></option>
										<option value="hospitality"><?php esc_html_e( 'Hospitality', 'tasheel' ); ?></option>
										<option value="health-and-education"><?php esc_html_e( 'Health and Education', 'tasheel' ); ?></option>
										<option value="mixed-use"><?php esc_html_e( 'Mixed use', 'tasheel' ); ?></option>
										<option value="residential"><?php esc_html_e( 'Residential', 'tasheel' ); ?></option>
										<option value="technology"><?php esc_html_e( 'Technology', 'tasheel' ); ?></option>
										<option value="other"><?php esc_html_e( 'Other', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Full Address of Headquarter *', 'tasheel' ); ?></label>
								<input class="input" type="text" name="headquarter_address" required>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Other branches if any', 'tasheel' ); ?></label>
								<input class="input" type="text" name="other_branches">
							</li>
						</ul>
					</div>

					<div class="vendor_registration_title">
						<h3><span><?php esc_html_e( 'Primary Contact Person', 'tasheel' ); ?></span></h3>
					</div>

					<div class="vendor_registration_form_group">
						<ul class="career-form-list-ul form-col-2">
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Name *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="contact_name" required>
										<option value=""><?php esc_html_e( 'Select', 'tasheel' ); ?></option>
										<option value="name1"><?php esc_html_e( 'Name 1', 'tasheel' ); ?></option>
										<option value="name2"><?php esc_html_e( 'Name 2', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Position *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="contact_position" required>
										<option value=""><?php esc_html_e( 'Select', 'tasheel' ); ?></option>
										<option value="position1"><?php esc_html_e( 'Position 1', 'tasheel' ); ?></option>
										<option value="position2"><?php esc_html_e( 'Position 2', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Phone *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="contact_phone" required>
										<option value=""><?php esc_html_e( 'Select', 'tasheel' ); ?></option>
										<option value="phone1"><?php esc_html_e( 'Phone 1', 'tasheel' ); ?></option>
										<option value="phone2"><?php esc_html_e( 'Phone 2', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Email *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="contact_email" required>
										<option value=""><?php esc_html_e( 'Select', 'tasheel' ); ?></option>
										<option value="email1"><?php esc_html_e( 'Email 1', 'tasheel' ); ?></option>
										<option value="email2"><?php esc_html_e( 'Email 2', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
							</li>
						</ul>
					</div>

					<div class="vendor_registration_title">
						<h3><span><?php esc_html_e( 'Secondary Contact Person', 'tasheel' ); ?></span></h3>
					</div>

					<div class="vendor_registration_form_group">
						<ul class="career-form-list-ul form-col-2">
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Name *', 'tasheel' ); ?></label>
								<input class="input" type="text" name="secondary_contact_name">
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Position *', 'tasheel' ); ?></label>
								<input class="input" type="text" name="secondary_contact_position">
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Phone *', 'tasheel' ); ?></label>
								<input class="input" type="text" name="secondary_contact_phone">
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Email *', 'tasheel' ); ?></label>
								<input class="input" type="text" name="secondary_contact_email">
							</li>
						</ul>
					</div>

					<div class="vendor_registration_title">
						<h3><span><?php esc_html_e( 'Local Content Certificate', 'tasheel' ); ?></span></h3>
					</div>

					<div class="vendor_registration_form_wrapper">
						<div class="vendor_registration_form_col">
							<ul class="career-form-list-ul">
								<li class="vendor_radio_group_li vendor_radio_group_li_2">
									<div class="vendor_radio_group">
										<label class="vendor_radio_label"><?php esc_html_e( 'Do you have valid local content certificate? *', 'tasheel' ); ?></label>
										<div class="vendor_radio_options">
											<label class="vendor_radio_option">
												<input type="radio" name="local_content_certificate" value="yes" checked required>
												<span class="vendor_radio_custom"></span>
												<span class="vendor_radio_text"><?php esc_html_e( 'Yes', 'tasheel' ); ?></span>
											</label>
											<label class="vendor_radio_option">
												<input type="radio" name="local_content_certificate" value="no" required>
												<span class="vendor_radio_custom"></span>
												<span class="vendor_radio_text"><?php esc_html_e( 'No', 'tasheel' ); ?></span>
											</label>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="vendor_registration_form_col">
							<ul class="career-form-list-ul">
								<li>
									<label class="vendor_form_label"><?php esc_html_e( '*Specify the percentage (Please attach a valid copy)', 'tasheel' ); ?></label>
									<div class="vendor_input_with_button">
										<input class="input" type="text" id="company-profile-02-input" name="company_profile_02_file_name">
										<input type="file" id="company-profile-02-upload" name="company_profile_02_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden" data-fill-target="#company-profile-02-input">
										<label for="company-profile-02-upload" class="btn_style btn_green_02 vendor-attach-btn"><?php esc_html_e( 'Attach Copy', 'tasheel' ); ?></label>
									</div>
								</li>
							</ul>
						</div>
					</div>

					<div class="vendor_registration_title">
						<h3><span><?php esc_html_e( 'Company Information and experience', 'tasheel' ); ?></span></h3>
					</div>

					<div class="vendor_registration_form_group">
						<ul class="career-form-list-ul form-col-2">
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Number of Company Employees *', 'tasheel' ); ?></label>
								<div class="select-wrapper">
									<select class="input select-input" name="number_of_employees">
										<option value=""><?php esc_html_e( 'Select', 'tasheel' ); ?></option>
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
								<label class="vendor_form_label"><?php esc_html_e( 'Company website *', 'tasheel' ); ?></label>
								<input class="input" type="url" name="company_website" placeholder="https://">
							</li>
							<li class="vendor_radio_group_li vendor_radio_group_li_2">
								<div class="vendor_radio_group">
									<label class="vendor_radio_label"><?php esc_html_e( 'Have you worked before with SAUDCONSULT? *', 'tasheel' ); ?></label>
									<div class="vendor_radio_options">
										<label class="vendor_radio_option">
											<input type="radio" name="worked_with_saudconsult" value="yes" checked required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text"><?php esc_html_e( 'Yes', 'tasheel' ); ?></span>
										</label>
										<label class="vendor_radio_option">
											<input type="radio" name="worked_with_saudconsult" value="no" required>
											<span class="vendor_radio_custom"></span>
											<span class="vendor_radio_text"><?php esc_html_e( 'No', 'tasheel' ); ?></span>
										</label>
									</div>
								</div>
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Project Name *', 'tasheel' ); ?></label>
								<input class="input" type="text" name="project_name">
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Role at that Project *', 'tasheel' ); ?></label>
								<input class="input" type="text" name="role_at_project">
							</li>
							<li>
								<label class="vendor_form_label"><?php esc_html_e( 'Year of Completion *', 'tasheel' ); ?></label>
								<input class="input" type="text" name="year_of_completion" placeholder="e.g. 2023">
							</li>
						</ul>
					</div>

					<div class="vendor_registration_title">
						<h3><span><?php esc_html_e( 'Total revenue for the past three years in (SAR) Currency', 'tasheel' ); ?></span></h3>
					</div>

					<div class="vendor_registration_form_group">
						<div class="vendor_registration_form_wrapper vendor_registration_form_wrapper_3col">
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label">2024</label>
										<input class="input" type="text" name="cert_year_2024">
									</li>
								</ul>
							</div>
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label">2023</label>
										<input class="input" type="text" name="cert_year_2023">
									</li>
								</ul>
							</div>
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label">2022</label>
										<input class="input" type="text" name="cert_year_2022">
									</li>
								</ul>
							</div>
						</div>

						<div class="vendor_registration_form_wrapper">
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li class="vendor_radio_group_li vendor_radio_group_li_2">
										<div class="vendor_radio_group">
											<label class="vendor_radio_label"><?php esc_html_e( 'Do you have valid ISO Certificates?', 'tasheel' ); ?></label>
											<div class="vendor_radio_options">
												<label class="vendor_radio_option">
													<input type="radio" name="has_iso_cert" value="yes" checked required>
													<span class="vendor_radio_custom"></span>
													<span class="vendor_radio_text"><?php esc_html_e( 'Yes', 'tasheel' ); ?></span>
												</label>
												<label class="vendor_radio_option">
													<input type="radio" name="has_iso_cert" value="no" required>
													<span class="vendor_radio_custom"></span>
													<span class="vendor_radio_text"><?php esc_html_e( 'No', 'tasheel' ); ?></span>
												</label>
											</div>
										</div>
									</li>
									<li>
										<label class="vendor_form_label"><?php esc_html_e( 'Please attach company profile', 'tasheel' ); ?></label>
										<div class="vendor_input_with_button">
											<input class="input" type="text" id="company-profile-01-input" name="company_profile_01_file_name">
											<input type="file" id="company-profile-01-upload" name="company_profile_01_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden" data-fill-target="#company-profile-01-input">
											<label for="company-profile-01-upload" class="btn_style btn_green_02 vendor-attach-btn"><?php esc_html_e( 'Attach Copy', 'tasheel' ); ?></label>
										</div>
									</li>
								</ul>
							</div>
							<div class="vendor_registration_form_col">
								<ul class="career-form-list-ul">
									<li>
										<label class="vendor_form_label"><?php esc_html_e( 'If yes, please attach a valid copy', 'tasheel' ); ?></label>
										<div class="vendor_input_with_button">
											<input class="input" type="text" id="iso-cert-input" name="iso_cert_file_name">
											<input type="file" id="iso-cert-upload" name="iso_cert_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden" data-fill-target="#iso-cert-input">
											<label for="iso-cert-upload" class="btn_style btn_green_02 vendor-attach-btn"><?php esc_html_e( 'Attach Copy', 'tasheel' ); ?></label>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="vendor_registration_form_actions">
						<button type="submit" class="btn_style but_black"><?php esc_html_e( 'Submit', 'tasheel' ); ?> <span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'Submit', 'tasheel' ); ?>"></span></button>
					</div>
				</form>
			</div>
		</div>
	</section>
	<?php } ?>

</main><!-- #main -->

<?php
get_footer();
