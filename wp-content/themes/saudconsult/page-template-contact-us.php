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

	 

	<section class="contact_us_section pt_120 pb_80">
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
								<svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
<path d="M2.88895 1.4452C2.88876 1.8283 2.73639 2.19563 2.46536 2.46638C2.19434 2.73714 1.82685 2.88914 1.44375 2.88895C1.06065 2.88876 0.693323 2.73639 0.422566 2.46536C0.15181 2.19434 -0.000191369 1.82685 1.80821e-07 1.44375C0.00019173 1.06065 0.152561 0.693323 0.423588 0.422566C0.694615 0.15181 1.0621 -0.000191369 1.4452 1.8082e-07C1.8283 0.00019173 2.19563 0.152561 2.46638 0.423588C2.73714 0.694615 2.88914 1.0621 2.88895 1.4452ZM2.93229 3.95858H0.0433344V13.001H2.93229V3.95858ZM7.49683 3.95858H4.62232V13.001H7.46794V8.2559C7.46794 5.61251 10.913 5.36695 10.913 8.2559V13.001H13.7658V7.27366C13.7658 2.81745 8.66685 2.98356 7.46794 5.17194L7.49683 3.95858Z" fill="#136B37"/>
</svg>
								</a>
								<a href="#" class="contact_social_link">
								<svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
<path d="M6.54614 5.08114L10.6409 0H9.67039L6.11587 4.41171L3.27549 0H0L4.29454 6.672L0 12H0.970517L4.7248 7.34057L7.72451 12H11L6.54614 5.08114ZM1.3199 0.78H2.81046L9.6712 11.256H8.18065L1.3199 0.78Z" fill="#136B37"/>
</svg>
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

