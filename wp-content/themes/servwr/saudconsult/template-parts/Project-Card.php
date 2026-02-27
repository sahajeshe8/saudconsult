<?php
/**
 * Project Card Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$image = isset( $args['image'] ) ? $args['image'] : get_template_directory_uri() . '/assets/images/pro-img.jpg';
$image_alt = isset( $args['image_alt'] ) ? $args['image_alt'] : 'Project';
$title = isset( $args['title'] ) ? $args['title'] : 'Project Title';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'View Details';
$description = isset( $args['description'] ) ? $args['description'] : '';
$link = isset( $args['link'] ) ? $args['link'] : '#';
$link_text = isset( $args['link_text'] ) ? $args['link_text'] : 'View Details';
$card_class = isset( $args['card_class'] ) ? $args['card_class'] : '';
$overlay_text = isset( $args['overlay_text'] ) ? $args['overlay_text'] : '';

// Stats array - optional project statistics
$stats = isset( $args['stats'] ) ? $args['stats'] : array();

?>

<article class="project_card <?php echo esc_attr( $card_class ); ?>">
	<a href="<?php echo esc_url( $link ); ?>" class="project_card_link_wrapper">
		<?php if ( $image ) : ?>
			<div class="project_card_image">
				<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
			</div>
		<?php endif; ?>
		
		<?php if ( $title ) : ?>
			<div class="project_card_content">
				<h3 class="project_card_title">
					<?php echo esc_html( $title ); ?>
					<?php if ( $title_span ) : ?>
						<span class="project_card_title_span"><?php echo esc_html( $title_span ); ?></span>
					<?php endif; ?>
				</h3>

				<?php if ( $description ) : ?>
					<p class="project_card_description">
						<?php echo wp_kses_post( $description ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</a>
</article>

