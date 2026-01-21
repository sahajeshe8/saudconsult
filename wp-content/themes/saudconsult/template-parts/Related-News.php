<?php
/**
 * Related News Component Template
 *
 * Related news section for News Detail page
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : '';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : '';
$news_items = isset( $args['news_items'] ) ? $args['news_items'] : array();

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
?>

<section class="related_news_section <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="wrap">
		<?php if ( $title || $title_span ) : ?>
			<div class="title_block mb_40">
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
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $news_items ) ) : ?>
			<ul class="related_news_list">
				<?php foreach ( $news_items as $item ) : 
					$item_image = isset( $item['image'] ) ? $item['image'] : '';
					$item_date = isset( $item['date'] ) ? $item['date'] : '';
					$item_title = isset( $item['title'] ) ? $item['title'] : '';
					$item_label = isset( $item['label'] ) ? $item['label'] : '';
					$item_link = isset( $item['link'] ) ? $item['link'] : '#';
				?>
					<li>
						<div class="insights_item">
							<a href="<?php echo esc_url( $item_link ); ?>" class="insights_item_image_link">
								<div class="insights_item_image">
									<span class="latest_news_lable"><?php echo esc_html( $item_date ); ?></span>
									<img src="<?php echo esc_url( $item_image ); ?>" alt="<?php echo esc_attr( $item_title ); ?>">
								</div>
							</a>
							<div class="insights_item_content">
								<a href="<?php echo esc_url( $item_link ); ?>"><h4><?php echo esc_html( $item_title ); ?></h4></a>
								<span class="latest_news_text_lable"><?php echo esc_html( $item_label ); ?></span>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>

