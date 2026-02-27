<?php
/**
 * Fallback mobile header menu when no WordPress menu is assigned.
 * Uses translatable strings for WPML support.
 *
 * @package tasheel
 */

if ( ! function_exists( 'is_current_menu_item' ) ) {
	return;
}
$company_pages = array( '/about-us', '/our-team', '/leadership', '/our-journey-legacy', '/vision-mission-values', '/company-milestones', '/awards' );
$is_company_active = false;
foreach ( $company_pages as $page ) {
	if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], $page ) !== false ) {
		$is_company_active = true;
		break;
	}
}
$services_url = home_url( '/products' );
$services_active = is_current_menu_item( $services_url ) || ( isset( $_SERVER['REQUEST_URI'] ) && ( strpos( $_SERVER['REQUEST_URI'], '/services' ) !== false || strpos( $_SERVER['REQUEST_URI'], '/engineering-design' ) !== false ) );
$projects_url = home_url( '/projects' );
$projects_active = is_current_menu_item( $projects_url );
$clients_url = home_url( '/clients' );
$clients_active = is_current_menu_item( $clients_url ) || ( is_page() && ( get_page_uri() === 'clients' || basename( get_permalink() ) === 'clients' ) ) || ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/clients' ) !== false );
$media_center_url = home_url( '/media-center' );
$media_center_active = is_current_menu_item( $media_center_url );
$careers_url = home_url( '/careers' );
$careers_active = is_current_menu_item( $careers_url );
$vendor_url = home_url( '/vendor-registration' );
$vendor_active = is_current_menu_item( $vendor_url );
$contact_url = home_url( '/contact' );
$contact_active = is_current_menu_item( $contact_url );
$arrow = get_template_directory_uri() . '/assets/images/menu-arrow-01.svg';
$arrow_sub = get_template_directory_uri() . '/assets/images/menu-arrow.svg';
?>
<ul class="mobile_menu_list">
	<li class="mobile_menu_item mobile_menu_item_has_submenu <?php echo $is_company_active ? 'active' : ''; ?>">
		<a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>" class="<?php echo $is_company_active ? 'active' : ''; ?>"><?php echo esc_html__( 'Company', 'tasheel' ); ?></a>
		<span class="mobile_menu_submenu_toggle" data-submenu="mobile-submenu-company"><img src="<?php echo esc_url( $arrow ); ?>" alt=""></span>
		<div class="mobile_menu_submenu" id="mobile-submenu-company">
			<div class="mobile_submenu_content">
				<ul class="mobile_submenu_list">
					<li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>"><?php echo esc_html__( 'Who We Are', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					<li><a href="<?php echo esc_url( home_url( '/our-team' ) ); ?>"><?php echo esc_html__( 'Our Team', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					<li><a href="<?php echo esc_url( home_url( '/leadership' ) ); ?>"><?php echo esc_html__( 'Leadership', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					<li><a href="<?php echo esc_url( home_url( '/our-journey-legacy' ) ); ?>"><?php echo esc_html__( 'Our Journey & Legacy', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					<li><a href="<?php echo esc_url( home_url( '/vision-mission-values' ) ); ?>"><?php echo esc_html__( 'Vision, Mission & Values', 'tasheel' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/company-milestones' ) ); ?>"><?php echo esc_html__( 'Company Milestones', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					<li><a href="<?php echo esc_url( home_url( '/awards' ) ); ?>"><?php echo esc_html__( 'Awards & Certifications', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
				</ul>
			</div>
		</div>
	</li>
	<li class="mobile_menu_item mobile_menu_item_has_submenu <?php echo $services_active ? 'active' : ''; ?>">
		<a href="<?php echo esc_url( home_url( '/services' ) ); ?>" class="<?php echo $services_active ? 'active' : ''; ?>"><?php echo esc_html__( 'Services', 'tasheel' ); ?></a>
		<span class="mobile_menu_submenu_toggle" data-submenu="mobile-submenu-services"><img src="<?php echo esc_url( $arrow ); ?>" alt=""></span>
		<div class="mobile_menu_submenu" id="mobile-submenu-services">
			<div class="mobile_submenu_content">
				<ul class="mobile_submenu_list">
					<li><a href="<?php echo esc_url( home_url( '/engineering-design' ) ); ?>"><?php echo esc_html__( 'Engineering Design', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Construction Supervision', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Project Management', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Specialized Studies', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
				</ul>
			</div>
		</div>
	</li>
	<li class="mobile_menu_item <?php echo $projects_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( $projects_url ); ?>" class="<?php echo $projects_active ? 'active' : ''; ?>"><?php echo esc_html__( 'Projects', 'tasheel' ); ?></a></li>
	<li class="mobile_menu_item <?php echo $clients_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( $clients_url ); ?>" class="<?php echo $clients_active ? 'active' : ''; ?>"><?php echo esc_html__( 'Clients', 'tasheel' ); ?></a></li>
	<li class="mobile_menu_item <?php echo $media_center_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( $media_center_url ); ?>" class="<?php echo $media_center_active ? 'active' : ''; ?>"><?php echo esc_html__( 'Media Center', 'tasheel' ); ?></a></li>
	<li class="mobile_menu_item <?php echo $careers_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( $careers_url ); ?>" class="<?php echo $careers_active ? 'active' : ''; ?>"><?php echo esc_html__( 'Careers', 'tasheel' ); ?></a></li>
	<li class="mobile_menu_item <?php echo $vendor_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( $vendor_url ); ?>" class="<?php echo $vendor_active ? 'active' : ''; ?>"><?php echo esc_html__( 'Vendor Registration', 'tasheel' ); ?></a></li>
	<li class="mobile_menu_item <?php echo $contact_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( $contact_url ); ?>" class="<?php echo $contact_active ? 'active' : ''; ?>"><?php echo esc_html__( 'Contact', 'tasheel' ); ?></a></li>
</ul>
