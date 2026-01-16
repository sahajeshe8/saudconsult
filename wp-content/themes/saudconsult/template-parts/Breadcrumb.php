<?php
/**
 * Breadcrumb Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Also check query var (for backward compatibility)
$breadcrumb_items = isset( $args['breadcrumb_items'] ) ? $args['breadcrumb_items'] : get_query_var( 'breadcrumb_items', array() );

// Set default values if empty
if ( empty( $breadcrumb_items ) ) {
	$breadcrumb_items = array(
		array(
			'title' => 'Home',
			'url' => esc_url( home_url( '/' ) ),
			'icon' => true
		),
		array(
			'title' => 'Page',
			'url' => ''
		)
	);
}

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

?>

<nav class="breadcrumb_section <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>" aria-label="Breadcrumb">
	<div class="wrap">
		<ul class="breadcrumb_list">
			<?php foreach ( $breadcrumb_items as $index => $item ) : 
				$item_title = isset( $item['title'] ) ? $item['title'] : '';
				$item_url = isset( $item['url'] ) ? $item['url'] : '';
				$item_icon = isset( $item['icon'] ) ? $item['icon'] : false;
				$is_last = ( $index === count( $breadcrumb_items ) - 1 );
				$is_active = $is_last || empty( $item_url );
			?>
				<li class="breadcrumb_item <?php echo $is_active ? 'active' : ''; ?>">
					<?php if ( $is_active ) : ?>
						<span class="breadcrumb_text">
							<?php if ( $item_icon && $index === 0 ) : ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/breadcrumb-icn.svg" alt="Home" class="breadcrumb_home_icon">
							<?php endif; ?>
							<?php echo esc_html( $item_title ); ?>
						</span>
					<?php else : ?>
						<a href="<?php echo esc_url( $item_url ); ?>" class="breadcrumb_link">
							<?php if ( $item_icon && $index === 0 ) : ?>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/breadcrumb-icn.svg" alt="Home" class="breadcrumb_home_icon">
							<?php endif; ?>
							<?php echo esc_html( $item_title ); ?>
						</a>
					<?php endif; ?>
					
					<?php if ( ! $is_last ) : ?>
						<span class="breadcrumb_separator">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/breadcrumb_icn.svg" alt="" class="breadcrumb_separator_icon">
						</span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>

