<?php
/**
 * Template Name: Contact Us
 *
 * The template for displaying the Contact Us page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/contact-banner.jpg',
		'title' => 'Contact Us',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	 

	<section class="contact_us_section pt_80 pb_80">
		<div class="wrap">
			<div class="contact_us_container">
				<div class="contact_us_content">
					<div class="contact_us_info">
                    <h3 class="h3_title_50">Get in touch <span>with us</span></h3>
						<p class="contact_us_description">Questions, comments, or suggestions? Simply fill in the form and we'll be in touch shortly.</p>
						
						<div class="contact_info_section">
							<div class="contact_info_item">
								<div class="contact_info_icon">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/contact-icn-01.svg' ); ?>" alt="Location">
								</div>
								<div class="contact_info_text">
									<p>P.O. Box 2341 RIYADH 11451, Kingdom of Saudi Arabia.</p>
								</div>
							</div>
							
							<div class="contact_info_item">
								<div class="contact_info_icon">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/contact-icn-02.svg' ); ?>" alt="Location">

								</div>
								<div class="contact_info_text">
									<a href="tel:+966114659975">+966 (0)11 465-9975.</a>
								</div>
							</div>
							
							<div class="contact_info_item">
								<div class="contact_info_icon">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/contact-icn-03.svg' ); ?>" alt="Location">

								</div>
								<div class="contact_info_text">
									<a href="mailto:scc@saudconsult.com">scc@saudconsult.com</a>
								</div>
							</div>
							
							<div class="contact_social_links">
								<a href="#" class="contact_social_link">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/in-f.svg' ); ?>" alt="LinkedIn">
								</a>
								<a href="#" class="contact_social_link">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/x-f.svg' ); ?>" alt="X">
								</a>
							</div>
						</div>
					</div>

					<div class="contact_us_form_wrapper">
						<form class="contact_form" id="contactForm" method="post" action="">
							<ul class="contact_form_list">
								<li class="form_row_item">
									<ul class="form_row">
										<li class="form_group">
											<input type="text" id="contact_first_name" name="contact_first_name" class="form_input" placeholder="First Name*" required>
										</li>
										
										<li class="form_group">
											<input type="text" id="contact_last_name" name="contact_last_name" class="form_input" placeholder="Last Name*" required>
										</li>
									</ul>
								</li>

								<li class="form_group">
									<input type="email" id="contact_email" name="contact_email" class="form_input" placeholder="Email*" required>
								</li>

								<li class="form_group">
									<input type="tel" id="contact_phone" name="contact_phone" class="form_input" placeholder="Phone Number*" required>
								</li>

								<li class="form_group">
									<textarea id="contact_message" name="contact_message" class="form_textarea" placeholder="Message" rows="6"></textarea>
								</li>

								<li class="form_submit_wrapper">
									<button type="submit" class="btn_style but_black">
										<span>Submit</span>
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="Arrow">
									</button>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php 
	$contact_map_data = array(
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	get_template_part( 'template-parts/Contact-Map', null, $contact_map_data ); 
	?>

	<?php 
	$faq_data = array(
		'section_wrapper_class' => array( 'pt_80', 'pb_80' ),
		'section_class' => '',
		'faq_items' => array(
			array(
				'question' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,',
				'answer' => 'Engineering Design is the cornerstone of project success. We transform ambitious visions into detailed, optimized, and buildable plans. Our multidisciplinary team ensures every element—architectural, structural, mechanical, electrical, and utility—is integrated flawlessly, adhering to local regulations and international standards.',
				'is_open' => true
			),
			array(
				'question' => 'Lorem ipsum dolor sit amet,',
				'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
				'is_open' => false
			),
			array(
				'question' => 'Lorem ipsum dolor sit amet, consectetur adipiscing',
				'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
				'is_open' => false
			),
			array(
				'question' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,',
				'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
				'is_open' => false
			),
		)
	);
	get_template_part( 'template-parts/FAQ', null, $faq_data ); 
	?>

</main><!-- #main -->

<?php
get_footer();

