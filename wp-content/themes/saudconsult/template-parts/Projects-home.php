<?php
/**
 * Projects Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$label_text = isset( $args['label_text'] ) ? $args['label_text'] : 'Our Projects';
$label_icon = isset( $args['label_icon'] ) ? $args['label_icon'] : get_template_directory_uri() . '/assets/images/dot-02.svg';
$title = isset( $args['title'] ) ? $args['title'] : 'Our Work,';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Across Industries';
$description = isset( $args['description'] ) ? $args['description'] : 'Where Our Expertise Makes an Impact.';
$button_text = isset( $args['button_text'] ) ? $args['button_text'] : 'Explore More';
$button_link = isset( $args['button_link'] ) ? $args['button_link'] : esc_url( home_url( '/contact' ) );

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

// Projects array - each project should have: background_image, title, description, button_text, button_link, stats (array with label and value)
$projects = isset( $args['projects'] ) ? $args['projects'] : array(
	array(
		'background_image' => get_template_directory_uri() . '/assets/images/pro-img.jpg',
		'background_image_alt' => 'Project Background',
		'title' => 'Rayadah Housing Project',
		'description' => 'Detailed Infrastructure Design, Construction Supervision, Environmental Impact Study, and Value Engineering for the complete mixed-use development.',
		'button_text' => 'Explore More',
		'button_link' => '#',
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
		'background_image' => get_template_directory_uri() . '/assets/images/home slide.jpg',
		'background_image_alt' => 'Project Background',
		'title' => 'Rayadah Housing Project',
		'description' => 'Detailed Infrastructure Design, Construction Supervision, Environmental Impact Study, and Value Engineering for the complete mixed-use development.',
		'button_text' => 'Explore More',
		'button_link' => '#',
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
	)
);

?>

<section class="projects_section pt_80 <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="wrap">
		<div class="title_block">
			<div class="title_block_left" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
				<?php if ( $label_text ) : ?>
					<span class="lable_text green_text">
						<?php if ( $label_icon ) : ?>
							<img src="<?php echo esc_url( $label_icon ); ?>" alt="<?php echo esc_attr( $label_text ); ?>">
						<?php endif; ?>
						<?php echo esc_html( $label_text ); ?>
					</span>
				<?php endif; ?>

				<?php if ( $title || $title_span ) : ?>
					<h3 class="h3_title_50">
						<?php if ( $title ) : ?>
							<?php echo esc_html( $title ); ?>
						<?php endif; ?>
						<?php if ( $title_span ) : ?>
							<span cla><?php echo esc_html( $title_span ); ?></span>
						<?php endif; ?>
					</h3>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<p class="project_description"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $button_text && $button_link ) : ?>
				<div class="title_block_right mobile_hide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
					<a class="btn_style btn_transparent but_black" href="<?php echo esc_url( $button_link ); ?>">
						<?php echo esc_html( $button_text ); ?> 
						<span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr( $button_text ); ?>"></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( ! empty( $projects ) ) : ?>
		<div class="projects_grid pt_40">
			<div class="projects_grid_inner_navigation">
				<div class="wrap">
					<div class="slider_arrow_block">
						<span class="slider_buttion but_next">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/slider-arrow.svg" alt="Next Project">
						</span>
						<span class="slider_buttion but_prev">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/slider-arrow.svg" alt="Previous Project">
						</span>
					</div>
				</div>
			</div>

			<div class="swiper mySwiper-projects">
				<div class="swiper-wrapper">
					<?php 
					$project_index = 0;
					foreach ( $projects as $project ) : 
						$project_bg_image = isset( $project['background_image'] ) ? $project['background_image'] : '';
						$project_bg_alt = isset( $project['background_image_alt'] ) ? $project['background_image_alt'] : 'Project Background';
						$project_title = isset( $project['title'] ) ? $project['title'] : '';
						$project_description = isset( $project['description'] ) ? $project['description'] : '';
						$project_button_text = isset( $project['button_text'] ) ? $project['button_text'] : '';
						$project_button_link = isset( $project['button_link'] ) ? $project['button_link'] : '#';
						$project_stats = isset( $project['stats'] ) ? $project['stats'] : array();
					?>
						<div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( 200 + ( $project_index * 100 ) ); ?>">
							<?php if ( $project_bg_image ) : ?>
								<div class="projects_slide_bg">
									<img src="<?php echo esc_url( $project_bg_image ); ?>" alt="<?php echo esc_attr( $project_bg_alt ); ?>">
								</div>
							<?php endif; ?>
							
							<div class="wrap">
								<div class="projects_item pt_80 pb_110">
									<div class="projects_item_content_blck_01">
										<div class="projects_item_content_blck_01_left">
											<?php if ( $project_title ) : ?>
												<h3><?php echo esc_html( $project_title ); ?></h3>
											<?php endif; ?>
											
											<?php if ( $project_description ) : ?>
												<p><?php echo wp_kses_post( $project_description ); ?></p>
											<?php endif; ?>

											<?php if ( $project_button_text && $project_button_link ) : ?>
												<a class="btn_style btn_transparent" href="<?php echo esc_url( $project_button_link ); ?>">
													<?php echo esc_html( $project_button_text ); ?> 
													<span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr( $project_button_text ); ?>"></span>
												</a>
											<?php endif; ?>
										</div>
									</div>

									<?php if ( ! empty( $project_stats ) ) : ?>
										<div class="projects_item_content_blck_02">
											<ul class="projects_item_content_blck_02_list">
												<?php foreach ( $project_stats as $stat ) : 
													$stat_value = isset( $stat['value'] ) ? $stat['value'] : '';
													$stat_label = isset( $stat['label'] ) ? $stat['label'] : '';
												?>
													<?php if ( $stat_value || $stat_label ) : ?>
														<li>
															<div class="project_ul_row">
																<?php if ( $stat_value ) : ?>
																	<h3><?php echo esc_html( $stat_value ); ?></h3>
																<?php endif; ?>
																<?php if ( $stat_label ) : ?>
																	<h5><?php echo esc_html( $stat_label ); ?></h5>
																<?php endif; ?>
															</div>
														</li>
													<?php endif; ?>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php 
						$project_index++;
					endforeach; ?>
				</div>


				
			</div>
		</div><div class="mobile_show_block mobile_show">
				<div class="title_block_right " data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
					<a class="btn_style btn_transparent but_black" href="<?php echo esc_url( $button_link ); ?>">
						<?php echo esc_html( $button_text ); ?> 
						<span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr( $button_text ); ?>"></span>
					</a>
				</div>
				</div>
	<?php endif; ?>
</section>
