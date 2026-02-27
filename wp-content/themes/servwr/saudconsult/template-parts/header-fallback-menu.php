<?php
/**
 * Fallback header menu when no WordPress menu is assigned.
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
$arrow = get_template_directory_uri() . '/assets/images/menu-arrow-01.svg';
$arrow_sub = get_template_directory_uri() . '/assets/images/menu-arrow.svg';
$company_arrow = get_template_directory_uri() . '/assets/images/company-arrow.svg';
?>
<ul class="list-unstyled">
	<li class="nav-item <?php echo $is_company_active ? 'active' : ''; ?>">
		<a href="#" class="nav-link <?php echo $is_company_active ? 'active' : ''; ?>"><?php echo esc_html__( 'Company', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow ); ?>" alt=""></a>
		<div class="sub_menu_block">
			<div class="sub_menu_block_inner">
				<div class="sub_menu_block_left_block">
					<h3><?php echo esc_html__( 'Company', 'tasheel' ); ?> <a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>"><img src="<?php echo esc_url( $company_arrow ); ?>" alt=""></a></h3>
					<p><?php echo esc_html__( 'Established in 1965 as the first Saudi Engineering Consulting Firm, Saud Consult has been integral to shaping the nation\'s built environment.', 'tasheel' ); ?></p>
				</div>
				<div class="sub_menu_block_right_block">
					<ul class="list-submenu colom-2">
						<li class="<?php echo is_current_menu_item( home_url( '/about-us' ) ) ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>" class="<?php echo is_current_menu_item( home_url( '/about-us' ) ) ? 'active' : ''; ?>"><?php echo esc_html__( 'Who We Are', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
						<li class="<?php echo is_current_menu_item( home_url( '/vision-mission-values' ) ) ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/vision-mission-values' ) ); ?>" class="<?php echo is_current_menu_item( home_url( '/vision-mission-values' ) ) ? 'active' : ''; ?>"><?php echo esc_html__( 'Vision, Mission & Values', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
						<li class="<?php echo is_current_menu_item( home_url( '/leadership' ) ) ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/leadership' ) ); ?>" class="<?php echo is_current_menu_item( home_url( '/leadership' ) ) ? 'active' : ''; ?>"><?php echo esc_html__( 'Leadership', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
						<li class="<?php echo is_current_menu_item( home_url( '/our-team' ) ) ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/our-team' ) ); ?>" class="<?php echo is_current_menu_item( home_url( '/our-team' ) ) ? 'active' : ''; ?>"><?php echo esc_html__( 'Our Team', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
						<li class="<?php echo is_current_menu_item( home_url( '/our-journey-legacy' ) ) ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/our-journey-legacy' ) ); ?>" class="<?php echo is_current_menu_item( home_url( '/our-journey-legacy' ) ) ? 'active' : ''; ?>"><?php echo esc_html__( 'Our Journey & Legacy', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
						<li class="<?php echo is_current_menu_item( home_url( '/company-milestones' ) ) ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/company-milestones' ) ); ?>" class="<?php echo is_current_menu_item( home_url( '/company-milestones' ) ) ? 'active' : ''; ?>"><?php echo esc_html__( 'Company Milestones', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
						<li class="<?php echo is_current_menu_item( home_url( '/awards' ) ) ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/awards' ) ); ?>" class="<?php echo is_current_menu_item( home_url( '/awards' ) ) ? 'active' : ''; ?>"><?php echo esc_html__( 'Awards & Certifications', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					</ul>
				</div>
			</div>
		</div>
	</li>
	<li class="nav-item <?php echo $services_active ? 'active' : ''; ?>">
		<a class="nav-link <?php echo $services_active ? 'active' : ''; ?>" href="<?php echo esc_url( $services_url ); ?>"><?php echo esc_html__( 'Services', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow ); ?>" alt=""></a>
		<div class="sub_menu_block">
			<div class="sub_menu_block_inner">
				<div class="sub_menu_block_left_block">
					<h3><?php echo esc_html__( 'Services', 'tasheel' ); ?> <a href="<?php echo esc_url( home_url( '/services' ) ); ?>"><img src="<?php echo esc_url( $company_arrow ); ?>" alt=""></a></h3>
					<p><?php echo esc_html__( 'Our multidisciplinary team is structured to deliver integrated solutions across the following critical sectors, ensuring innovation and efficiency in every design.', 'tasheel' ); ?></p>
				</div>
				<div class="sub_menu_block_right_block">
					<ul class="list-submenu">
						<li class="<?php echo is_current_menu_item( home_url( '/engineering-design' ) ) ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/engineering-design' ) ); ?>" class="<?php echo is_current_menu_item( home_url( '/engineering-design' ) ) ? 'active' : ''; ?>"><?php echo esc_html__( 'Engineering Design', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
						<li><a href="<?php echo esc_url( home_url( '/#' ) ); ?>"><?php echo esc_html__( 'Construction Supervision', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
						<li><a href="<?php echo esc_url( home_url( '/#' ) ); ?>"><?php echo esc_html__( 'Project Management', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
						<li><a href="<?php echo esc_url( home_url( '/#' ) ); ?>"><?php echo esc_html__( 'Specialized Studies', 'tasheel' ); ?> <img src="<?php echo esc_url( $arrow_sub ); ?>" alt=""></a></li>
					</ul>
				</div>
			</div>
		</div>
	</li>
	<li class="nav-item <?php echo $projects_active ? 'active' : ''; ?>"><a class="nav-link <?php echo $projects_active ? 'active' : ''; ?>" href="<?php echo esc_url( $projects_url ); ?>"><?php echo esc_html__( 'Projects', 'tasheel' ); ?></a></li>
	<li class="nav-item <?php echo $clients_active ? 'active' : ''; ?>"><a class="nav-link <?php echo $clients_active ? 'active' : ''; ?>" href="<?php echo esc_url( $clients_url ); ?>"><?php echo esc_html__( 'Clients', 'tasheel' ); ?></a></li>
	<li class="nav-item <?php echo $media_center_active ? 'active' : ''; ?>"><a class="nav-link <?php echo $media_center_active ? 'active' : ''; ?>" href="<?php echo esc_url( $media_center_url ); ?>"><?php echo esc_html__( 'Media Center', 'tasheel' ); ?></a></li>
	<li class="nav-item <?php echo $careers_active ? 'active' : ''; ?>"><a class="nav-link <?php echo $careers_active ? 'active' : ''; ?>" href="<?php echo esc_url( $careers_url ); ?>"><?php echo esc_html__( 'Careers', 'tasheel' ); ?></a></li>
	<li class="nav-item <?php echo $vendor_active ? 'active' : ''; ?>"><a class="nav-link <?php echo $vendor_active ? 'active' : ''; ?>" href="<?php echo esc_url( $vendor_url ); ?>"><?php echo esc_html__( 'Vendor Registration', 'tasheel' ); ?></a></li>
</ul>
