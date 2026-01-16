<?php
/**
 * Template Name: Infrastructure
 *
 * The template for displaying the Infrastructure service page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/infrastructure-banner.jpg',
		'title' => 'Infrastructure',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$breadcrumb_data = array(
		'breadcrumb_items' => array(
			array(
				'title' => '',
				'url' => esc_url( home_url( '/' ) ),
				'icon' => true
			),
            array(
				'title' => 'Services',
				'url' => esc_url( home_url( '/services' ) )
			),
			array(
				'title' => 'Engineering Design',
				'url' => esc_url( home_url( '/services' ) )
			),
			array(
				'title' => 'Infrastructure',
				'url' => '' // Empty URL makes it active
			)
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data ); 
	?>

	<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/design-precision.jpg',
		'image_alt' => 'ddd',
		'title' => 'Design Precision. <br>',
		'title_span' => 'The Blueprint for National Development',
		'content' => '<p>Engineering Design is the cornerstone of project success. We transform ambitious visions into detailed, optimized, and buildable plans. Our multidisciplinary team ensures every element—architectural, structural, mechanical, electrical, and utility—is integrated flawlessly, adhering to local regulations and international standards.</p><p>Master Planning & Conceptual Design, Detailed Technical Drawings (2D/3D/BIM), Structural Analysis & Calculations, Specifications & Material Schedules, Value Engineering Reports, Tender Documentation Packages.</p>',
		'button_text' => '',
		'button_link' => esc_url( home_url( '' ) ),
		'section_class' => '',
		'bg_style' => '',
		'image_container_class' => '',
		'text_container_class' => ''
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>




	<?php 
	$projects_home_data = array(
		'label_text' => '',
		'label_icon' => get_template_directory_uri() . '/assets/images/dot-02.svg',
		'title' => 'Infrastructure Projects in Focus.',
		'title_span' => '',
		'description' => 'Where Our Expertise Makes an Impact.',
		'button_text' => 'View All Infrastructure Projects',
		'button_link' => esc_url( home_url( '/projects' ) ),
		'section_wrapper_class' => array(),
		'section_class' => '',
		'projects' => array(
			array(
				'background_image' => get_template_directory_uri() . '/assets/images/pro-img.jpg',
				'background_image_alt' => 'Infrastructure Project',
				'title' => 'Rayadah Housing Project',
				'description' => 'Detailed Infrastructure Design, Construction Supervision, Environmental Impact Study, and Value Engineering for the complete mixed-use development.',
				'button_text' => 'Explore More',
				'button_link' => esc_url( home_url( '/contact' ) ),
				'stats' => array(
					array(
						'value' => '2011',
						'label' => 'Completion'
					),
					array(
						'value' => '22,000 M2',
						'label' => 'Area'
					),
					array(
						'value' => '20KM',
						'label' => 'Length of Road'
					),
					array(
						'value' => '(SAR) 1M',
						'label' => 'Cost'
					)
				)
			),
			array(
				'background_image' => get_template_directory_uri() . '/assets/images/service-img-01.jpg',
				'background_image_alt' => 'Infrastructure Project',
				'title' => 'Urban Development Project',
				'description' => 'Master planning and infrastructure development for sustainable urban communities, including utilities, public facilities, and transportation networks.',
				'button_text' => 'Explore More',
				'button_link' => esc_url( home_url( '/contact' ) ),
				'stats' => array(
					array(
						'value' => '2022',
						'label' => 'Completion'
					),
					array(
						'value' => '500,000 M2',
						'label' => 'Development Area'
					),
					array(
						'value' => '10,000',
						'label' => 'Residential Units'
					),
					array(
						'value' => '(SAR) 2.5B',
						'label' => 'Project Value'
					)
				)
			),
			array(
				'background_image' => get_template_directory_uri() . '/assets/images/service-img-02.jpg',
				'background_image_alt' => 'Infrastructure Project',
				'title' => 'Water Infrastructure System',
				'description' => 'Design and implementation of comprehensive water and wastewater infrastructure systems ensuring sustainable water management and distribution.',
				'button_text' => 'Explore More',
				'button_link' => esc_url( home_url( '/contact' ) ),
				'stats' => array(
					array(
						'value' => '2024',
						'label' => 'Completion'
					),
					array(
						'value' => '50 KM',
						'label' => 'Pipeline Network'
					),
					array(
						'value' => '5',
						'label' => 'Treatment Plants'
					),
					array(
						'value' => '(SAR) 800M',
						'label' => 'Project Value'
					)
				)
			)
		)
	);
	get_template_part( 'template-parts/Projects-home', null, $projects_home_data ); 
	?>






<?php 
	$what_to_expect_data = array(
		'title' => 'Our Capabilities',
		'title_span' => '',
		'description' => 'We seamlessly integrate our core service offerings to ensure holistic, end-to-end project success:',
		'section_wrapper_class' => array(),
		'section_class' => '',
		'background_color' => '',
		'items' => array(
			array(
				'icon' => get_template_directory_uri() . '/assets/images/cap-ic-06.svg',
				'icon_alt' => 'Comprehensive Planning',
				'title' => 'Engineering',
				'title_span' => 'Design',
				'content' => 'Detailed engineering for water/sewerage networks, storm drainage systems, pump/treatment plants (STP), utility corridors, and site grading plans.',
				'bg_class' => 'bg_collor_green box-style-01',
				'item_class' => ''
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/cap-ic-05.svg',
				'icon_alt' => 'Expert Design',
				'title' => 'Construction ',
				'title_span' => 'Supervision',
				'content' => 'On-site quality assurance for pipe laying, treatment plant installation, materials testing, and adherence to strict utility authority standards and project timelines.',
				'bg_class' => 'bg_collor_green box-style-01',
				'item_class' => ''
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/cap-ic-04.svg',
				'icon_alt' => 'Quality Assurance',
				'title' => 'Project ',
				'title_span' => 'Management',
				'content' => 'Contract administration, scheduling, cost control, risk management, and stakeholder coordination (e.g., managing interfaces between utility providers and municipal authorities).',
				'bg_class' => '',
				'item_class' => 'bg_collor_green box-style-01'
            ),



            array(
				'icon' => get_template_directory_uri() . '/assets/images/cap-ic-03.svg',
				'icon_alt' => 'Quality Assurance',
				'title' => 'Engineering  ',
				'title_span' => 'Design',
				'content' => 'Detailed engineering for water/sewerage networks, storm drainage systems, pump/treatment plants (STP), utility corridors, and site grading plans.',
				'bg_class' => '',
				'item_class' => 'bg_collor_green box-style-01'
			),



            array(
				'icon' => get_template_directory_uri() . '/assets/images/cap-ic-02.svg',
				'icon_alt' => 'Quality Assurance',
				'title' => 'Construction  ',
				'title_span' => 'Supervision',
				'content' => 'On-site quality assurance for pipe laying, treatment plant installation, materials testing, and adherence to strict utility authority standards and project timelines.',
				'bg_class' => '',
				'item_class' => 'bg_collor_green box-style-01'
			),



            array(
				'icon' => get_template_directory_uri() . '/assets/images/cap-ic-01.svg',
				'icon_alt' => 'Quality Assurance',
				'title' => 'Project  ',
				'title_span' => 'Management',
				'content' => 'Contract administration, scheduling, cost control, risk management, and stakeholder coordination (e.g., managing interfaces between utility providers and municipal authorities).',
				'bg_class' => '',
				'item_class' => 'bg_collor_green box-style-01'
			)











		)
	);
	get_template_part( 'template-parts/What-to-Expect', null, $what_to_expect_data ); 
	?>




<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/integrated-img.jpg',
		'image_alt' => 'ddd',
		'title' => 'Integrated Design for <br>',
		'title_span' => 'Resilience and Sustainability',
		'content' => '<p>Our methodology is built on a tripartite approach: local knowledge, technical precision, and sustainability. We begin with comprehensive due diligence, leveraging our deep understanding of Saudi regulations, geology, and climate to inform every phase. We utilize advanced simulation and BIM/GIS technologies to model utility systems for optimal performance, clash detection, and long-term asset management. Crucially, our infrastructure approach prioritizes sustainable material selection and energy-efficient design for pumping and treatment facilities, minimizing the lifecycle cost and environmental footprint. This holistic view ensures the infrastructure we design is a long-term, resilient asset to the nation.</p>',
		'button_text' => '',
		'button_link' => esc_url( home_url( '' ) ),
		'section_class' => 'row_reverse ',
		'bg_style' => 'bg_gradient',
		'image_container_class' => '',
		'text_container_class' => ''
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>

	<?php 
	$why_partner_data = array(
		'title' => 'Why Partner with',
		'title_span' => 'Saud Consult for <br>Infrastructure?',
		'section_wrapper_class' => array(),
		'section_class' => 'bg_img_02 pt_80',
		'items' => array(
			array(
				'icon' => get_template_directory_uri() . '/assets/images/why-ic-01.svg',
				'icon_alt' => 'Integrated Service',
				'title' => 'Full Lifecycle Control',
				'text' => 'Our integrated service model (Design, Supervision, Management) eliminates coordination gaps and ensures superior quality.'
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/why-ic-02.svg',
				'icon_alt' => 'Integrated Service',
				'title' => 'Full Lifecycle Control',
				'text' => 'Our integrated service model (Design, Supervision, Management) eliminates coordination gaps and ensures superior quality.'
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/why-ic-03.svg',
				'icon_alt' => 'Integrated Service',
				'title' => 'Full Lifecycle Control',
				'text' => 'Our integrated service model (Design, Supervision, Management) eliminates coordination gaps and ensures superior quality.'
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/why-ic-04.svg',
				'icon_alt' => 'Integrated Service',
				'title' => 'Full Lifecycle Control',
				'text' => 'Our integrated service model (Design, Supervision, Management) eliminates coordination gaps and ensures superior quality.'
			)
		)
	);
	get_template_part( 'template-parts/Why-Partner', null, $why_partner_data ); 
	?>

 


<?php 
		$banner_add_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/design-bg-img.jpg',
			'title' => 'Need help choosing the',
			'subtitle' => 'right service?',
			'description' => 'Let’s discuss how we can align our technology with your goals.',
			'button_text' => 'Get in Touch',
			'button_link' => '#'
		);
		get_template_part( 'template-parts/banner-add', null, $banner_add_data ); 
		?>




</main><!-- #main -->

<?php
get_footer();

