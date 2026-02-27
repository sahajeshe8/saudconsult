<?php
/**
 * Clients filter section: title + category tabs (All + client_category terms)
 * Used on Clients page with AJAX filter. All strings are WPML-ready.
 *
 * @package tasheel
 */

$args = isset( $args ) ? $args : array();
$title         = isset( $args['title'] ) ? $args['title'] : '';
$title_span    = isset( $args['title_span'] ) ? $args['title_span'] : __( 'Clients', 'tasheel' );
$categories    = isset( $args['categories'] ) ? $args['categories'] : array(); // array of [ 'slug' => '', 'name' => '' ]
$active_slug   = isset( $args['active_slug'] ) ? $args['active_slug'] : '';
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
$filter_id     = isset( $args['filter_id'] ) ? $args['filter_id'] : 'clients-section';
?>

<div class="project_filter_container d_flex_wrap justify-content-between align-items-center clients_filter_container" id="<?php echo esc_attr( $filter_id ); ?>" data-filter-type="clients">
	<?php if ( $title || $title_span ) : ?>
		<div class="project_filter_title">
			<h3 class="h3_title_50">
				<?php if ( $title ) : ?>
					<?php echo esc_html( $title ); ?>
				<?php endif; ?>
				<?php if ( $title_span ) : ?>
					<span><?php echo esc_html( $title_span ); ?></span>
				<?php endif; ?>
			</h3>
		</div>
	<?php endif; ?>

	<div class="clients-filter-block">
		<ul class="clients-filter-list">
			<li>
				<a href="#" class="clients-filter-link <?php echo $active_slug === '' ? 'active' : ''; ?>" data-client-category="">
					<?php echo esc_html__( 'All', 'tasheel' ); ?>
				</a>
			</li>
			<?php foreach ( $categories as $cat ) :
				$slug = isset( $cat['slug'] ) ? $cat['slug'] : '';
				$name = isset( $cat['name'] ) ? $cat['name'] : $slug;
				if ( $slug === '' ) {
					continue;
				}
				$is_active = $active_slug === $slug;
			?>
				<li>
					<a href="#" class="clients-filter-link <?php echo $is_active ? 'active' : ''; ?>" data-client-category="<?php echo esc_attr( $slug ); ?>">
						<?php echo esc_html( $name ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
