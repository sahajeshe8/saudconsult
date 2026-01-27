<?php
/**
 * Page Tabs Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$tabs = isset( $args['tabs'] ) && is_array( $args['tabs'] ) ? $args['tabs'] : array(
	array( 'id' => 'overview', 'title' => 'Who We Are' ),
	array( 'id' => 'history', 'title' => 'Our Team' ),
	array( 'id' => 'mission', 'title' => 'Leadership' ),
	array( 'id' => 'journey', 'title' => 'Our Journey & Legacy' ),
	array( 'id' => 'vision', 'title' => 'Vision, Mission & Values' ),
	array( 'id' => 'milestones', 'title' => 'Company Milestones' ),
	array( 'id' => 'awards', 'title' => 'Awards' )
);
$active_tab = isset( $args['active_tab'] ) ? $args['active_tab'] : ( !empty( $tabs ) ? $tabs[0]['id'] : 'overview' );
$nav_class = isset( $args['nav_class'] ) ? $args['nav_class'] : '';

// Build ul classes
$ul_classes = 'page_tabs_nav';
if ( ! empty( $nav_class ) ) {
	$ul_classes .= ' ' . esc_attr( $nav_class );
}

?>

<section class="page_tabs_section  ">
	<div class="wrap">
		<div class="page_tabs_container" data-page-tabs>
			<ul class="<?php echo $ul_classes; ?>">
				<?php foreach ( $tabs as $tab ) : 
					$tab_id = isset( $tab['id'] ) ? $tab['id'] : '';
					$tab_link = isset( $tab['link'] ) ? $tab['link'] : '';
					$tab_title = isset( $tab['title'] ) ? $tab['title'] : '';
					$is_active = ( strtolower( $tab_id ) === strtolower( $active_tab ) ) ? 'active' : '';
					
					// Generate unique ID if not provided
					if ( empty( $tab_id ) ) {
						$tab_id = uniqid( 'tab_' );
					}
					
					// Use link if provided, otherwise use hash link with id
					$href = ! empty( $tab_link ) ? esc_url( $tab_link ) : '#' . esc_attr( $tab_id );
				?>
				<li class="page_tabs_item <?php echo esc_attr( $is_active ); ?>">
					<a href="<?php echo $href; ?>" class="page_tabs_link" data-tab="<?php echo esc_attr( $tab_id ); ?>">
						<?php echo esc_html( $tab_title ); ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

