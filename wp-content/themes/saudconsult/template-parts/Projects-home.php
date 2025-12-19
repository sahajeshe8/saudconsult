<?php
/**
 * Projects Section Component Template
 *
 * @package tasheel
 */

?>

<section class="projects_section pt_80">
	<div class="wrap">
		<div class="title_block">
			<div class="title_block_left">
				<span class="lable_text green_text">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dot-02.svg" alt="Our Projects">
					Our Projects
				</span>

				<h3 class="h3_title_50">
					Our Work, <span>Across Industries</span>
				</h3>
				<p>Where Our Expertise Makes an Impact.</p>
			</div>

			<div class="title_block_right">
				<a class="btn_style btn_transparent but_black" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
					Explore More <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="Explore More"></span>
				</a>
			</div>
		</div>
	</div>

	<div class="projects_grid pt_40 ">
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
				<div class="swiper-slide">
					<div class="projects_slide_bg">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/pro-img.jpg" alt="Project Background">
					</div>
					<div class="wrap">
						<div class="projects_item pt_80 pb_80">
							<div class="projects_item_content_blck_01">
								<div class="projects_item_content_blck_01_left">
									<h3>Rayadah Housing Project</h3>
									<p>
										Detailed Infrastructure Design, Construction Supervision, Environmental Impact Study, and Value Engineering for the complete mixed-use development.
									</p>

									<a class="btn_style btn_transparent" href="#">
										Explore More <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="Explore More"></span>
									</a>
								</div>
							</div>

							<div class="projects_item_content_blck_02">
								<ul class="projects_item_content_blck_02_list">
									<li>
										<div class="project_ul_row">
											<h3>2011</h3>
											<h5>Completion</h5>
										</div>
									</li>
									<li>
										<div class="project_ul_row">
											<h3>22,000 M2</h3>
											<h5>Area</h5>
										</div>
									</li>
									<li>
										<div class="project_ul_row">
											<h3>20KM</h3>
											<h5>Length of Road</h5>
										</div>
									</li>
									<li>
										<div class="project_ul_row">
											<h3>(SAR) 1M</h3>
											<h5>Cost</h5>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="swiper-slide">
					<div class="projects_slide_bg">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/pro-img.jpg" alt="Project Background">
					</div>
					<div class="wrap">
						<div class="projects_item pt_80 pb_80">
							<div class="projects_item_content_blck_01">
								<div class="projects_item_content_blck_01_left">
									<h3>Rayadah Housing Project</h3>
									<p>
										Detailed Infrastructure Design, Construction Supervision, Environmental Impact Study, and Value Engineering for the complete mixed-use development.
									</p>

									<a class="btn_style btn_transparent" href="#">
										Explore More <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="Explore More"></span>
									</a>
								</div>
							</div>

							<div class="projects_item_content_blck_02">
								<ul class="projects_item_content_blck_02_list">
									<li>
										<div class="project_ul_row">
											<h3>2011</h3>
											<h5>Completion</h5>
										</div>
									</li>
									<li>
										<div class="project_ul_row">
											<h3>22,000 M2</h3>
											<h5>Area</h5>
										</div>
									</li>
									<li>
										<div class="project_ul_row">
											<h3>20KM</h3>
											<h5>Length of Road</h5>
										</div>
									</li>
									<li>
										<div class="project_ul_row">
											<h3>(SAR) 1M</h3>
											<h5>Cost</h5>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		 
		</div>
	</div>
</section>
