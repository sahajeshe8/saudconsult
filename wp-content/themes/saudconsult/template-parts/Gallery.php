<?php
/**
 * Gallery Component Template
 *
 * Gallery section with Masonry layout
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

// Gallery items - can be passed via args or use defaults
$gallery_items = isset( $args['gallery_items'] ) ? $args['gallery_items'] : array();
?>

<div class="gallery_section <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="gallery_wrapper">
		<div class="wrap">
			<?php if ( $title || $title_span ) : ?>
				<div class="title_block" data-aos="fade-up" data-aos-delay="0">
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
								<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="View All Gallery"></span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="gallery_content">
				<div class="gallery_masonry" id="gallery-masonry">
					<?php if ( ! empty( $gallery_items ) ) : ?>
						<?php foreach ( $gallery_items as $index => $item ) :
							$delay = 100 + ($index * 50); 
							$image = isset( $item['image'] ) ? $item['image'] : '';
							$alt = isset( $item['alt'] ) ? $item['alt'] : 'Gallery Image';
							$size_class = isset( $item['size'] ) ? $item['size'] : 'normal'; // normal, wide, tall, large
						?>
							<div class="gallery_item <?php echo esc_attr( $size_class ); ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
								<div class="gallery_item_image">
									<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
								</div>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<!-- Default gallery items - 3x4 grid layout matching the image order -->
						<?php 
						$default_gallery_items = array(
							array('image' => 'gallery-01.jpg', 'alt' => 'Gallery Image 1 - Conference Meeting'),
							array('image' => 'gallery-02.jpg', 'alt' => 'Gallery Image 2 - Award Presentation'),
							array('image' => 'gallery-03.jpg', 'alt' => 'Gallery Image 3 - Conference Stage'),
							array('image' => 'gallery-04.jpg', 'alt' => 'Gallery Image 4 - Exhibition Booth'),
							array('image' => 'gallery-05.jpg', 'alt' => 'Gallery Image 5 - Document Exchange'),
							array('image' => 'gallery-06.jpg', 'alt' => 'Gallery Image 6 - Architectural Rendering'),
							array('image' => 'gallery-07.jpg', 'alt' => 'Gallery Image 7 - Red Sea Development'),
							array('image' => 'gallery-08.jpg', 'alt' => 'Gallery Image 8 - Document Handover'),
							array('image' => 'gallery-09.jpg', 'alt' => 'Gallery Image 9 - Award Ceremony'),
							array('image' => 'gallery-10.jpg', 'alt' => 'Gallery Image 10 - Company Booth'),
							array('image' => 'gallery-11.jpg', 'alt' => 'Gallery Image 11 - Business Discussion'),
							array('image' => 'gallery-12.jpg', 'alt' => 'Gallery Image 12 - Meeting with Presentation'),
						);
						foreach ( $default_gallery_items as $index => $gallery_item ) : 
							$delay = 100 + ($index * 50);
						?>
						<div class="gallery_item normal" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
							<div class="gallery_item_image">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $gallery_item['image'] ); ?>" alt="<?php echo esc_attr( $gallery_item['alt'] ); ?>">
							</div>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

