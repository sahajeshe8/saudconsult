<?php
/**
 * Brochures List Component Template
 *
 * Brochures list section for Media Center page
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : '';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : '';
$show_view_all = isset( $args['show_view_all'] ) ? $args['show_view_all'] : true;

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
?>

<div class="brochures_list_section <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="brochures_list_wrapper">
		<div class="wrap">
			<?php if ( $title || $title_span ) : ?>
				<div class="title_block">
					<div class="title_block_left">
						<h3 class="h3_title_50">
							<?php if ( $title ) : ?>
								<?php echo esc_html( $title ); ?>
							<?php endif; ?>
							<?php if ( $title_span ) : ?>
								<span><?php echo esc_html( $title_span ); ?></span>
							<?php endif; ?>
						</h3>
					</div>
					<?php if ( $show_view_all ) : ?>
						<div class="title_block_right">
							<a class="btn_style btn_transparent but_black" href="#">
								View all
								<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="View All Brochures"></span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="brochures_list_content">
				<div class="swiper brochures_list_swiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="brochures_item">
								<div class="brochures_item_text">
									<h5>Annual Report 2024</h5>
									<p>Saud Consult mobilized a multidisciplinary team to deliver a comprehensive design</p>
									<a href="#" class="brochures_download_link">
										<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/download-icn.svg' ); ?>" alt="Download PDF"></span>
									</a>
								</div>
								<div class="brochures_item_image">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/brochure-01.jpg' ); ?>" alt="Brochure">
								</div>
							</div>
						</div>

						<div class="swiper-slide">
							<div class="brochures_item">
								<div class="brochures_item_text">
									<h5>Annual Report 2024</h5>
									<p>Saud Consult mobilized a multidisciplinary team to deliver a comprehensive design</p>
									<a href="#" class="brochures_download_link">
										<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/download-icn.svg' ); ?>" alt="Download PDF"></span>
									</a>
								</div>
								<div class="brochures_item_image">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/brochure-02.jpg' ); ?>" alt="Brochure">
								</div>
							</div>
						</div>

						<div class="swiper-slide">
							<div class="brochures_item">
								<div class="brochures_item_text">
									<h5>Annual Report 2024</h5>
									<p>Saud Consult mobilized a multidisciplinary team to deliver a comprehensive design</p>
									<a href="#" class="brochures_download_link">
										<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/download-icn.svg' ); ?>" alt="Download PDF"></span>
									</a>
								</div>
								<div class="brochures_item_image">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/brochure-03.jpg' ); ?>" alt="Brochure">
								</div>
							</div>
						</div>

						<div class="swiper-slide">
							<div class="brochures_item">
								<div class="brochures_item_text">
									<h5>Annual Report 2024</h5>
									<p>Saud Consult mobilized a multidisciplinary team to deliver a comprehensive design</p>
									<a href="#" class="brochures_download_link">
										<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/download-icn.svg' ); ?>" alt="Download PDF"></span>
									</a>
								</div>
								<div class="brochures_item_image">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/brochure-04.jpg' ); ?>" alt="Brochure">
								</div>
							</div>
						</div>

						<div class="swiper-slide">
							<div class="brochures_item">
								<div class="brochures_item_text">
									<h5>Annual Report 2024</h5>
									<p>Saud Consult mobilized a multidisciplinary team to deliver a comprehensive design</p>
									<a href="#" class="brochures_download_link">
										<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/download-icn.svg' ); ?>" alt="Download PDF"></span>
									</a>
								</div>
								<div class="brochures_item_image">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/brochure-05.jpg' ); ?>" alt="Brochure">
								</div>
							</div>
						</div>

                        

						<div class="swiper-slide">
							<div class="brochures_item">
								<div class="brochures_item_text">
									<h5>Annual Report 2024</h5>
									<p>Saud Consult mobilized a multidisciplinary team to deliver a comprehensive design</p>
									<a href="#" class="brochures_download_link">
										<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/download-icn.svg' ); ?>" alt="Download PDF"></span>
									</a>
								</div>
								<div class="brochures_item_image">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/brochure-06.jpg' ); ?>" alt="Brochure">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="brochures_list_pagination">
				<!-- Pagination will be added here -->
			</div>
		</div>
	</div>
</div>
