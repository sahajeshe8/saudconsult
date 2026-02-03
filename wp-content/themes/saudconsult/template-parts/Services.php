<?php
/**
 * Services Section Component Template
 *
 * @package tasheel
 */

?>

<section class="services_section pt_80 height_100vh ">
	<div class="wrap">
		<span class="lable_text green_text " data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dot-02.svg" alt="Our Comprehensive Services">
			Our Comprehensive Services
		</span>

		<div class="services_section_01 pb_25">
			<div class="services_section_01_item_01 " data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
				<h3 class="h3_title_50">
					Explore Our Full Range <br>of <span>Professional Services</span>
				</h3>
			</div>
			<div class="services_section_01_item_02 pt_10" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
				<p>
					Our multidisciplinary team is structured to deliver integrated solutions across the following critical sectors, <b>ensuring innovation and efficiency in every design.</b>
				</p>
			</div>
		</div>
	</div>

	<div class="swiper mySwiper-services">
		<div class="swiper-wrapper">
			<div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
				<div class="services_section_item_01_content">
					<h3 class="h3_title_30">
						Engineering <br>Design
					</h3>
					<h5>
						Innovative Solutions
					</h5>
					<p>
						Translating vision into robust, buildable plans, including architectural, structural.
					</p>
					<a class="btn_style btn_transparent" href="<?php echo esc_url( home_url( '/engineering-design' ) ); ?>">
						View more <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-buttion.svg" alt="View more"></span>
					</a>
				</div>
				<div class="services_section_item_01">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/service-01.jpg" alt="Services">
				</div>
			</div>

			<div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
				<div class="services_section_item_01_content">
					<h3 class="h3_title_30">
					Construction <br>Supervision
					</h3>
					<h5>
					Quality Assurance
					</h5>
					<p>
					Providing on-site assurance and quality management to ensure execution..
					</p>
					<a class="btn_style btn_transparent short" href="<?php echo esc_url( home_url( '/engineering-design' ) ); ?>">
						View more <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-buttion.svg" alt="View more"></span>
					</a>
				</div>
				<div class="services_section_item_01">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/service-02.jpg" alt="Services">
				</div>
			</div>

			<div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
				<div class="services_section_item_01_content">
					<h3 class="h3_title_30">
					Project <br>Management
					</h3>
					<h5>
					On-Time Delivery
					</h5>
					<p>
					Offering end-to-end management consultancy (PMC) to control scope.
					</p>
					<a class="btn_style btn_transparent short" href="<?php echo esc_url( home_url( '/engineering-design' ) ); ?>">
						View more <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-buttion.svg" alt="View more"></span>
					</a>
				</div>
				<div class="services_section_item_01">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/service-03.jpg" alt="Services">
				</div>
			</div>

			<div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
				<div class="services_section_item_01_content">
					<h3 class="h3_title_30">
					Specialized <br>Studies
					</h3>
					<h5>
					Innovative Solutions
					</h5>
					<p>
					Conducting essential pre-design work, including feasibility studies..
					</p>
					<a class="btn_style btn_transparent short" href="<?php echo esc_url( home_url( '/engineering-design' ) ); ?>">
						View more <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-buttion.svg" alt="View more"></span>
					</a>
				</div>
				<div class="services_section_item_01">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/service-04.jpg" alt="Services">
				</div>
			</div>

			<!-- <div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
				<div class="services_section_item_01_content">
					<h3 class="h3_title_30">
					Construction <br>Supervision
					</h3>
					<h5>
					Quality Assurance
					</h5>
					<p>
					Providing on-site assurance and quality management to ensure execution..
					</p>
					<a class="btn_style btn_transparent short" href="<?php// echo esc_url( home_url( '/engineering-design' ) ); ?>">
						View more <span><img src="<?php //echo get_template_directory_uri(); ?>/assets/images/arrow-buttion.svg" alt="View more"></span>
					</a>
				</div>
				<div class="services_section_item_01">
					<img src="<?php //echo get_template_directory_uri(); ?>/assets/images/service-02.jpg" alt="Services">
				</div>
			</div> -->
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
