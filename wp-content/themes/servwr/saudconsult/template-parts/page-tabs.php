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
$active_tab      = isset( $args['active_tab'] ) ? $args['active_tab'] : ( ! empty( $tabs ) ? $tabs[0]['id'] : 'overview' );
$active_page_id  = isset( $args['active_page_id'] ) ? (int) $args['active_page_id'] : 0;
$nav_class       = isset( $args['nav_class'] ) ? $args['nav_class'] : '';
$logout_url      = isset( $args['logout_url'] ) ? $args['logout_url'] : '';

// Build ul classes
$ul_classes = 'page_tabs_nav';
if ( ! empty( $nav_class ) ) {
	$ul_classes .= ' ' . esc_attr( $nav_class );
}

?>

<section class="page_tabs_section  ">
	<div class="wrap">
		<div class="page_tabs_container<?php echo ! empty( $logout_url ) ? ' page_tabs_container--has-logout' : ''; ?>" data-page-tabs>
			<ul class="<?php echo $ul_classes; ?>">
				<?php foreach ( $tabs as $tab ) : 
					$tab_id   = isset( $tab['id'] ) ? $tab['id'] : '';
					$tab_page_id = isset( $tab['page_id'] ) ? (int) $tab['page_id'] : 0;
					$tab_link = isset( $tab['link'] ) ? $tab['link'] : '';
					$tab_title = isset( $tab['title'] ) ? $tab['title'] : '';
					$is_active = ( $active_page_id && $tab_page_id && $tab_page_id === $active_page_id )
						|| ( $tab_id && strtolower( $tab_id ) === strtolower( $active_tab ) );
					$is_active = $is_active ? 'active' : '';
					
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
			<?php if ( ! empty( $logout_url ) ) : ?>
			<a href="<?php echo esc_url( $logout_url ); ?>" class="page-tabs-logout js-logout-confirm btn_style btn_transparent but_black" title="<?php esc_attr_e( 'Logout', 'tasheel' ); ?>">
				<span class="page-tabs-logout-text"><?php esc_html_e( 'Logout', 'tasheel' ); ?></span>
				<span class="page-tabs-logout-icon" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
				</span>
			</a>
			<?php endif; ?>
		</div>
	</div>
</section>

