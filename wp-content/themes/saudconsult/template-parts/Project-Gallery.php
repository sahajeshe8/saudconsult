<?php
/**
 * Project Gallery Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Gallery';
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
$gallery_items = isset( $args['gallery_items'] ) ? $args['gallery_items'] : array();

// Build section wrapper classes
$wrapper_classes = array( 'project_gallery_section pt_100 pb_100' );
if ( $section_wrapper_class ) {
	if ( is_array( $section_wrapper_class ) ) {
		$wrapper_classes = array_merge( $wrapper_classes, $section_wrapper_class );
	} else {
		$wrapper_classes[] = $section_wrapper_class;
	}
}
$wrapper_class_string = implode( ' ', array_map( 'esc_attr', $wrapper_classes ) );

?>

<section class="<?php echo $wrapper_class_string; ?> <?php echo esc_attr( $section_class ); ?>">
	 
		<div class="project_gallery_container">
            <div class="wrap">
			<?php if ( $title ) : ?>
				<h2 class="project_gallery_title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
            </div>

			<?php if ( ! empty( $gallery_items ) ) : ?>
				<div class="project_gallery_slider_wrapper">
					<div class="swiper project_gallery_swiper">
						<div class="swiper-wrapper">
							<?php foreach ( $gallery_items as $item ) : 
								$image = isset( $item['image'] ) ? $item['image'] : '';
								$image_alt = isset( $item['image_alt'] ) ? $item['image_alt'] : '';
								$is_video = isset( $item['is_video'] ) ? $item['is_video'] : false;
								$video_url = isset( $item['video_url'] ) ? $item['video_url'] : '';
							?>
								<?php if ( $image ) : ?>
									<div class="swiper-slide">
										<div class="project_gallery_slide">
											<?php if ( $is_video && $video_url ) : 
												// Convert YouTube URL to embed format for Fancybox
												$fancybox_video_url = $video_url;
												// If it's a YouTube watch URL, keep it as is (Fancybox handles it)
												if ( strpos( $video_url, 'youtube.com/watch' ) !== false ) {
													parse_str( parse_url( $video_url, PHP_URL_QUERY ), $youtube_params );
													if ( isset( $youtube_params['v'] ) ) {
														$fancybox_video_url = 'https://www.youtube.com/watch?v=' . $youtube_params['v'];
													}
												}
											?>
												<a href="<?php echo esc_url( $fancybox_video_url ); ?>" class="project_gallery_image_link" data-fancybox="project-gallery" data-type="video" data-caption="<?php echo esc_attr( $image_alt ); ?>">
													<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="project_gallery_image">
													<div class="project_gallery_overlay">
														<div class="project_gallery_play_button">
															<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
																<circle cx="40" cy="40" r="40" fill="#A9D159"/>
																<path d="M32 24L32 56L56 40L32 24Z" fill="#000"/>
															</svg>
														</div>
													</div>
												</a>
											<?php else : ?>
												<a href="<?php echo esc_url( $image ); ?>" class="project_gallery_image_link" data-fancybox="project-gallery" data-caption="<?php echo esc_attr( $image_alt ); ?>">
													<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="project_gallery_image">
													<div class="project_gallery_overlay">
														<span class="project_gallery_zoom_icon">+</span>
													</div>
												</a>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
					
					<!-- Navigation buttons -->
					<div class="project_gallery_navigation">
						<button type="button" class="project_gallery_prev" aria-label="Previous slide">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-arrow_prev.svg' ); ?>" alt="Previous">
						</button>
						<button type="button" class="project_gallery_next" aria-label="Next slide">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-arrow_next.svg' ); ?>" alt="Next">
						</button>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

