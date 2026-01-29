<?php
/**
 * Design Scope Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Comprehensive, Multi-Disciplinary';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Design Scope.';
$image = isset( $args['image'] ) ? $args['image'] : '';
$image_alt = isset( $args['image_alt'] ) ? $args['image_alt'] : 'Design Scope';
$show_play_button = isset( $args['show_play_button'] ) ? $args['show_play_button'] : false;
$video_url = isset( $args['video_url'] ) ? $args['video_url'] : '';
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
$scope_items = isset( $args['scope_items'] ) ? $args['scope_items'] : array();

// Build section wrapper classes
$wrapper_classes = array( 'design_scope_section ' );
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
	<div class="wrap">
		<div class="design_scope_container">
			<?php if ( $title || $title_span ) : ?>
				<div class="design_scope_title_wrapper">
					<h2 class="design_scope_title">
						<?php if ( $title ) : ?>
							<span class="design_scope_title_bold"><?php echo wp_kses_post( $title ); ?></span>
						<?php endif; ?>
						<?php if ( $title_span ) : ?>
							<span class="design_scope_title_regular"><?php echo esc_html( $title_span ); ?></span>
						<?php endif; ?>
					</h2>
				</div>
			<?php endif; ?>

			<?php if ( $image ) : ?>
				<div class="design_scope_image_wrapper">
					<?php if ( $show_play_button && $video_url ) : ?>
						<a href="<?php echo esc_url( $video_url ); ?>" class="design_scope_video_link" data-fancybox="design-scope-video" data-type="video">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="design_scope_image">
							<div class="design_scope_play_button">
								<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
									viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
									<style type="text/css">
										.st0{fill:#A9D159;}
										.st1{fill:#FFFFFF;}
									</style>
									<circle class="st0" cx="25" cy="25" r="25"/>
									<path class="st1" d="M21.7,17.4v15.3L33.3,25L21.7,17.4z"/>
								</svg>
							</div>
						</a>
					<?php else : ?>
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="design_scope_image">
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $scope_items ) ) : ?>
				<ul class="design_scope_items_grid">
					<?php foreach ( $scope_items as $item ) : 
						$icon = isset( $item['icon'] ) ? $item['icon'] : '';
						$icon_alt = isset( $item['icon_alt'] ) ? $item['icon_alt'] : '';
						$title_item = isset( $item['title'] ) ? $item['title'] : '';
						$title_span = isset( $item['title_span'] ) ? $item['title_span'] : '';
						$description = isset( $item['description'] ) ? $item['description'] : '';
					?>
						<?php if ( $title_item ) : ?>
							<li class="design_scope_item">
								<?php if ( $icon ) : ?>
									<div class="design_scope_item_icon">
										<img src="<?php echo esc_url( $icon ); ?>" alt="<?php echo esc_attr( $icon_alt ); ?>">
									</div>
								<?php endif; ?>
								<h4 class="h4_title_35 pb_20">
									<?php echo esc_html( $title_item ); ?>
									<?php if ( $title_span ) : ?>
										<span><?php echo esc_html( $title_span ); ?></span>
									<?php endif; ?>
								</h4>
								<?php if ( $description ) : ?>
									<p class="design_scope_item_description"><?php echo wp_kses_post( $description ); ?></p>
								<?php endif; ?>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>

