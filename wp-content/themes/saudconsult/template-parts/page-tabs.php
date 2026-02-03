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

// Auto-detect active tab based on current page URL
$active_tab = isset( $args['active_tab'] ) ? $args['active_tab'] : null;
if ( empty( $active_tab ) ) {
	// Get current page URL and path
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
	$current_url = home_url( $request_uri );
	$current_path = untrailingslashit( parse_url( $current_url, PHP_URL_PATH ) );
	
	// Get current page slug if available
	$current_page_slug = '';
	if ( is_page() ) {
		global $post;
		if ( $post ) {
			$current_page_slug = $post->post_name;
		}
	}
	
	// Check each tab's link against current URL
	foreach ( $tabs as $tab ) {
		$tab_link = isset( $tab['link'] ) ? $tab['link'] : '';
		if ( ! empty( $tab_link ) ) {
			$tab_path = untrailingslashit( parse_url( $tab_link, PHP_URL_PATH ) );
			$tab_slug = basename( $tab_path );
			
			// Compare paths (handle trailing slashes)
			if ( $current_path === $tab_path || 
				 $current_path === $tab_path . '/' || 
				 $current_path === '/' . $tab_path ||
				 $current_path === '/' . $tab_path . '/' ) {
				$active_tab = isset( $tab['id'] ) ? $tab['id'] : '';
				break;
			}
			
			// Compare by slug if paths don't match
			if ( ! empty( $current_page_slug ) && ! empty( $tab_slug ) && $current_page_slug === $tab_slug ) {
				$active_tab = isset( $tab['id'] ) ? $tab['id'] : '';
				break;
			}
			
			// Check if current path contains tab path (for subpages)
			if ( ! empty( $tab_path ) && strpos( $current_path, $tab_path ) === 0 ) {
				$active_tab = isset( $tab['id'] ) ? $tab['id'] : '';
				break;
			}
		}
	}
	
	// If no match found, use first tab as default
	if ( empty( $active_tab ) && !empty( $tabs ) ) {
		$active_tab = isset( $tabs[0]['id'] ) ? $tabs[0]['id'] : 'overview';
	} elseif ( empty( $active_tab ) ) {
		$active_tab = 'overview';
	}
}

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

