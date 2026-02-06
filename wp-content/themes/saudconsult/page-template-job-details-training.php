<?php
/**
 * Template Name: Job Details training
 *
 * The template for displaying the Job Details page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
		'title' => 'Career',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<section class="job_details_section pt_80 pb_80">
		<div class="wrap">
			<div class="job_details_container">
				<div class="job_details_header">
					<div class="job_posted_date">Posted 18 hours ago</div>
					<h3 class="h3_title_50 pb_10  ">Chief Financial <span>Officer</span></h3>
					<div class="job_location">Riyadh, Saudi Arabia</div>
				</div>
<h4 class="job_main_title">Job Information</h4>
				<div class="job_details_info">
					<ul class="job_info_list">
						<li><span>Job ID:</span> 54294</li>
						<li><span>Job Category:</span> Corporate</li>
						<li><span>Posting Date:</span> 12/04/2025</li>
						<li><span>Apply Before:</span> 12/09/2025</li>
						<li><span>Job Schedule:</span> Full time</li>
						<li><span>Location:</span> Riyadh, Riyadh, SA</li>
					</ul>
				</div>

				<div class="job_details_content">
					<div class="job_company_description">
                    <h4 class="job_main_title">Overview</h4>
						<p>We have grown into a multidisciplinary firm with over 2,000 professionals of various disciplines, securing all project requirements single-handedly—a comprehensive approach that ensures seamless delivery and unwavering quality from concept to commissioning. We don't just design structures; we engineer the future of vital sectors like transportation, energy, and urban planning, ensuring sustainability and longevity for the next generation.</p>
						<h4 class="job_main_title">Role Overview</h4>
                        <p>We have grown into a multidisciplinary firm with over 2,000 professionals of various disciplines, securing all project requirements single-handedly—a comprehensive approach that ensures seamless delivery and unwavering quality from concept to commissioning. We don't just design structures; we engineer the future of vital sectors like transportation, energy, and urban planning, ensuring sustainability and longevity for the next generation.</p>
					</div>

					<div class="job_requirements">
                    <h4 class="job_main_title">Requirements</h4>
						<ul class="job_info_list">
							<li>Bachelor's degree in law, Legal Studies, or a related field.</li>
							<li>Professional certification in Legal or equivalent is preferred.</li>
							<li>Additional certifications in Legal, Compliance, or Investigations considered an asset.</li>
							<li>1-3 years of professional experience in legal, compliance, or investigative roles.</li>
							<li>Demonstrated experience conducting investigations or legal assessments in a fast-paced environment, with verifiable references.</li>
							<li>Solid understanding of risk management, internal controls, and compliance principles.</li>
							<li>Ability to assist with legal investigations, review business processes, and support documentation and reporting.</li>
							<li>Strong organizational, analytical, and time-management skills.</li>
							<li>Familiarity with fraud investigation concepts and regulatory/legal requirements.</li>
							<li>Basic proficiency in data analysis tools and techniques to support investigations and reporting.</li>
							
						</ul>

                        <h4 class="job_main_title">Key Responsibilities</h4>
                        <ul class="job_info_list">
                        <li>Archive and control revisions of design drawings, shop drawings, and as-builts.</li>
							<li>Must have a experience in CAD drafting/design experience in civil infrastructure projects (roads, bridges, utilities, manholes, landscaping, etc.</li>
							<li>Must be fluent in English with an excellent understanding of technical terminology.</li>
							<li>Civil AutoCAD drafters have to draw diagrams and maps for projects and structures in construction.</li>

                        </ul>


					</div>

					<div class="job_apply_action">
						<a href="#login-popup-training" class="btn_style btn_transparent but_black"  >
							Apply Now <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="Apply"></span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>





</main><!-- #main -->

<?php
get_footer();

