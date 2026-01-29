<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tasheel
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php
	// Determine header classes based on page type
	$header_classes = array( 'header-main', 'header_b' );
	
	// Front page
	if ( is_front_page() ) {
		$header_classes[] = 'header-front-page';
	}
	
	// Inner pages with banner
	if ( is_page() && ! is_front_page() ) {
		$header_classes[] = 'header-inner-page';
		
		// Check if page has banner (inner-banner template part)
		$has_banner = true; // Default to true for inner pages
		if ( ! $has_banner ) {
			$header_classes[] = 'header-no-banner';
		}
	}
	
	// Media Center Detail page
	if ( is_page_template( 'page-media-center-detail.php' ) ) {
		$header_classes[] = 'header-media-center-detail';
		$header_classes[] = 'media-center-detail-page';
		$header_classes[] = 'header-no-banner';
	}
	
	// Contact Us page
	if ( is_page_template( 'page-contact-us.php' ) ) {
		$header_classes[] = 'header-contact-page';
	}
	
	// Careers page
	if ( is_page_template( 'page-careers.php' ) ) {
		$header_classes[] = 'header-careers-page';
	}
	
	// Career Detail page
	if ( is_page_template( 'page-career-detail.php' ) ) {
		$header_classes[] = 'header-career-detail';
		$header_classes[] = 'career-detail-page';
		$header_classes[] = 'header-no-banner';
	}
	
	// About Us page
	if ( is_page_template( 'page-about-us.php' ) ) {
		$header_classes[] = 'header-about-page';
	}
	
	// Awards page
	if ( is_page_template( 'page-template-awards.php' ) ) {
		$header_classes[] = 'header-awards-page';
	}
	
	// Products pages
	if ( is_page_template( 'page-products.php' ) || is_page_template( 'page-product-detail.php' ) ) {
		$header_classes[] = 'header-products-page';
	}
	
	// Projects pages
	if ( is_page_template( 'page-projects.php' ) || is_page_template( 'page-project-detail.php' ) ) {
		$header_classes[] = 'header-projects-page';
	}
	
	// Brands pages
	if ( is_page_template( 'page-brands.php' ) || is_page_template( 'page-brand-detail.php' ) ) {
		$header_classes[] = 'header-brands-page';
	}
	
	// Blog/Archive pages
	if ( is_home() || is_archive() || is_single() ) {
		$header_classes[] = 'header-blog-page';
	}
	
	// 404 page
	if ( is_404() ) {
		$header_classes[] = 'header-404-page';
	}
	
	// Sitemap page
	if ( is_page_template( 'page-sitemap.php' ) ) {
		$header_classes[] = 'header-sitemap-page';
	}
	
	// Check for custom header class from page template
	global $header_custom_class;
	if ( ! empty( $header_custom_class ) ) {
		$header_classes[] = $header_custom_class;
	}
	
	$header_class_string = implode( ' ', array_unique( $header_classes ) );
	
	// Determine which logo to use based on header class
	$is_black_header = in_array( 'black-header', $header_classes );
	$logo_filename = $is_black_header ? 'saudconsult-logo-black.svg' : 'saudconsult-logo.svg';
	$logo_path = get_template_directory() . '/assets/images/' . $logo_filename;
	$logo_url = get_template_directory_uri() . '/assets/images/' . $logo_filename;
	
	// Helper function to check if a URL matches the current page
	if ( ! function_exists( 'is_current_menu_item' ) ) {
		function is_current_menu_item( $url ) {
			// Get menu URL path
			$menu_url = esc_url( $url );
			$menu_path = parse_url( $menu_url, PHP_URL_PATH );
			$menu_path = untrailingslashit( $menu_path );
			$menu_slug = basename( $menu_path );
			
			// Get current request URI
			$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
			$request_path = untrailingslashit( parse_url( $request_uri, PHP_URL_PATH ) );
			
			// Check if request path matches menu path
			if ( $request_path === $menu_path || $request_path === $menu_path . '/' ) {
				return true;
			}
			
			// Check using WordPress functions
			if ( is_page() ) {
				global $post;
				if ( $post ) {
					$page_slug = $post->post_name;
					$page_uri = get_page_uri( $post->ID );
					
					// Check by slug
					if ( $menu_slug === $page_slug ) {
						return true;
					}
					
					// Check by URI
					if ( $page_uri && ( $menu_path === '/' . $page_uri || $menu_path === '/' . basename( $page_uri ) ) ) {
						return true;
					}
					
					// Check by permalink
					$page_permalink = get_permalink( $post->ID );
					$page_permalink_path = untrailingslashit( parse_url( $page_permalink, PHP_URL_PATH ) );
					if ( $page_permalink_path === $menu_path ) {
						return true;
					}
				}
			}
			
			// Check if current page is a child of the menu URL
			if ( $menu_path && $request_path && strpos( $request_path, $menu_path ) === 0 ) {
				return true;
			}
			
			// Final check: compare current URL with menu URL
			$current_url = home_url( $request_uri );
			$current_path = untrailingslashit( parse_url( $current_url, PHP_URL_PATH ) );
			if ( $current_path === $menu_path ) {
				return true;
			}
			
			return false;
		}
	}
	
	// Get current page URL for comparison
	$current_page_url = home_url( $_SERVER['REQUEST_URI'] );
	?>
	<header class="<?php echo esc_attr( $header_class_string ); ?>" id="headerMainSection">
   <div class="wrap">

     <div class="header_main_wrapper">
        <div class="logo_desktop text-center d-flex">
            <?php 
            if ( file_exists( $logo_path ) ) : ?>
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                </a>
            <?php endif; ?>
           
        </div>
 <div class="desk_nav_right">
                <div class="navbar nav_desk">
                    <ul class="list-unstyled">
                        <?php
                        // Check if Company menu should be active
                        $company_pages = array( '/about-us', '/our-team', '/leadership', '/our-journey-legacy', '/vision-mission-values', '/company-milestones', '/awards' );
                        $is_company_active = false;
                        foreach ( $company_pages as $page ) {
                            if ( strpos( $_SERVER['REQUEST_URI'], $page ) !== false ) {
                                $is_company_active = true;
                                break;
                            }
                        }
                        ?>
                        <li class="nav-item <?php echo $is_company_active ? 'active' : ''; ?>">
                            <a href="#" class="nav-link <?php echo $is_company_active ? 'active' : ''; ?>" >
							Company  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow-01.svg' ); ?>" alt="Arrow Down">
                            </a>

<div class="sub_menu_block">
							 <div class="sub_menu_block_inner">
								 <div class="sub_menu_block_left_block">
									 <h3>Company  <a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>"  > <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/company-arrow.svg' ); ?>" alt="Arrow Down"></a></h3>
								
									<p>
									Established in 1965 as the first Saudi Engineering Consulting Firm, Saud Consult has been integral to shaping the nation's built environment.
									</p>
									</div>
								 <div class="sub_menu_block_right_block">
									 <ul class="list-submenu colom-2">
										<?php
										$about_us_url = home_url( '/about-us' );
										$about_us_active = is_current_menu_item( $about_us_url );
										?>
										<li class="<?php echo $about_us_active ? 'active' : ''; ?>">
											<a href="<?php echo esc_url( $about_us_url ); ?>" class="<?php echo $about_us_active ? 'active' : ''; ?>">
											Who We Are <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<?php
										$our_team_url = home_url( '/our-team' );
										$our_team_active = is_current_menu_item( $our_team_url );
										?>
										<li class="<?php echo $our_team_active ? 'active' : ''; ?>">
										<a href="<?php echo esc_url( $our_team_url ); ?>" class="<?php echo $our_team_active ? 'active' : ''; ?>">
										Our Team  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<?php
										$leadership_url = home_url( '/leadership' );
										$leadership_active = is_current_menu_item( $leadership_url );
										?>
										<li class="<?php echo $leadership_active ? 'active' : ''; ?>">
										<a href="<?php echo esc_url( $leadership_url ); ?>" class="<?php echo $leadership_active ? 'active' : ''; ?>">
										Leadership <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<?php
										$journey_url = home_url( '/our-journey-legacy' );
										$journey_active = is_current_menu_item( $journey_url );
										?>
										<li class="<?php echo $journey_active ? 'active' : ''; ?>">
										<a href="<?php echo esc_url( $journey_url ); ?>" class="<?php echo $journey_active ? 'active' : ''; ?>">
										Our Journey & Legacy <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>

										<?php
										$vision_url = home_url( '/vision-mission-values' );
										$vision_active = is_current_menu_item( $vision_url );
										?>
										<li class="<?php echo $vision_active ? 'active' : ''; ?>">
										<a href="<?php echo esc_url( $vision_url ); ?>" class="<?php echo $vision_active ? 'active' : ''; ?>">
										Vision, Mission & Values <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>

										<?php
										$milestones_url = home_url( '/company-milestones' );
										$milestones_active = is_current_menu_item( $milestones_url );
										?>
										<li class="<?php echo $milestones_active ? 'active' : ''; ?>">
										<a href="<?php echo esc_url( $milestones_url ); ?>" class="<?php echo $milestones_active ? 'active' : ''; ?>">
										Company Milestones <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>

										<?php
										$awards_url = home_url( '/awards' );
										$awards_active = is_current_menu_item( $awards_url );
										?>
										<li class="<?php echo $awards_active ? 'active' : ''; ?>">
										<a href="<?php echo esc_url( $awards_url ); ?>" class="<?php echo $awards_active ? 'active' : ''; ?>">
										Awards & Certifications <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
									 </ul>
								 </div>
							 </div>
							</div>
							 
                        </li>
                        <?php
                        // Check if Services menu should be active
                        $services_url = home_url( '/products' );
                        $services_active = is_current_menu_item( $services_url ) || strpos( $_SERVER['REQUEST_URI'], '/services' ) !== false || strpos( $_SERVER['REQUEST_URI'], '/engineering-design' ) !== false;
                        ?>
                        <li class="nav-item <?php echo $services_active ? 'active' : ''; ?>">
                            <a class="nav-link <?php echo $services_active ? 'active' : ''; ?>" href="<?php echo esc_url( $services_url ); ?>">
							Services  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow-01.svg' ); ?>" alt="Arrow Down">
                            </a>
							<div class="sub_menu_block">
							 <div class="sub_menu_block_inner">
								 <div class="sub_menu_block_left_block">
									 <h3>Services <a href="<?php echo esc_url( home_url( '/services' ) ); ?>"  > <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/company-arrow.svg' ); ?>" alt="Arrow Down"></a></h3>
								
									<p>
									Our multidisciplinary team is structured to deliver integrated solutions across the following critical sectors, ensuring innovation and efficiency in every design.
									</p>
									</div>
								 <div class="sub_menu_block_right_block">
									 <ul class="list-submenu  ">
										<?php
										$engineering_url = home_url( '/engineering-design' );
										$engineering_active = is_current_menu_item( $engineering_url );
										?>
										<li class="<?php echo $engineering_active ? 'active' : ''; ?>">
											<a href="<?php echo esc_url( $engineering_url ); ?>" class="<?php echo $engineering_active ? 'active' : ''; ?>">
											Engineering Design <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<?php
										$construction_url = home_url( '/#' );
										// Don't check active class if URL is just a hash placeholder
										$construction_active = false;
										?>
										<li class="<?php echo $construction_active ? 'active' : ''; ?>">
										<a href="<?php echo esc_url( $construction_url ); ?>" class="<?php echo $construction_active ? 'active' : ''; ?>">
										Construction Supervision <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<?php
										$project_mgmt_url = home_url( '/#' );
										// Don't check active class if URL is just a hash placeholder
										$project_mgmt_active = false;
										?>
										<li class="<?php echo $project_mgmt_active ? 'active' : ''; ?>">
										<a href="<?php echo esc_url( $project_mgmt_url ); ?>" class="<?php echo $project_mgmt_active ? 'active' : ''; ?>">
										Project Management <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<?php
										$specialized_url = home_url( '/#' );
										// Don't check active class if URL is just a hash placeholder
										$specialized_active = false;
										?>
										<li class="<?php echo $specialized_active ? 'active' : ''; ?>">
										<a href="<?php echo esc_url( $specialized_url ); ?>" class="<?php echo $specialized_active ? 'active' : ''; ?>">
										Specialized Studies <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
 
									 </ul>
								 </div>
							 </div>
							</div>
							
                        </li>
                        <?php
                        $projects_url = home_url( '/projects' );
                        $projects_active = is_current_menu_item( $projects_url );
                        ?>
                        <li class="nav-item <?php echo $projects_active ? 'active' : ''; ?>">
                            <a class="nav-link <?php echo $projects_active ? 'active' : ''; ?>" href="<?php echo esc_url( $projects_url ); ?>">
							Projects
                            </a>
                        </li>
                        <?php
                        $clients_url = home_url( '/clients' );
                        // Check if on clients page using multiple methods
                        $clients_active = is_current_menu_item( $clients_url ) || 
                                         ( is_page() && ( get_page_uri() === 'clients' || basename( get_permalink() ) === 'clients' ) ) ||
                                         ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/clients' ) !== false );
                        ?>
                        <li class="nav-item <?php echo $clients_active ? 'active' : ''; ?>">
                            <a class="nav-link <?php echo $clients_active ? 'active' : ''; ?>" href="<?php echo esc_url( $clients_url ); ?>">
							Clients
                            </a>
                        </li>
                        <?php
                        $media_center_url = home_url( '/media-center' );
                        $media_center_active = is_current_menu_item( $media_center_url );
                        ?>
                        <li class="nav-item <?php echo $media_center_active ? 'active' : ''; ?>">
                            <a class="nav-link <?php echo $media_center_active ? 'active' : ''; ?>" href="<?php echo esc_url( $media_center_url ); ?>">
							Media Center 
                            </a>
                        </li>
						<?php
                        $careers_url = home_url( '/careers' );
                        $careers_active = is_current_menu_item( $careers_url );
                        ?>
						<li class="nav-item <?php echo $careers_active ? 'active' : ''; ?>">
                            <a class="nav-link <?php echo $careers_active ? 'active' : ''; ?>" href="<?php echo esc_url( $careers_url ); ?>">
							Careers
                            </a>
                        </li>





						<?php
                        $vendor_url = home_url( '/vendor-registration' );
                        $vendor_active = is_current_menu_item( $vendor_url );
                        ?>
						<li class="nav-item <?php echo $vendor_active ? 'active' : ''; ?>">
                            <a class="nav-link <?php echo $vendor_active ? 'active' : ''; ?>" href="<?php echo esc_url( $vendor_url ); ?>">
							Vendor Registration
                            </a>
                        </li>
 
                    </ul>

                    <div class="menu_right_block">
<a href="#login-popup" class="user-login-trigger" data-fancybox="login-popup">
                      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/user-logon.svg' ); ?>" alt="User Icon">
                    </a>

                    <a class="language_button button_link" href="">
					عربي
                    </a>
                    <a class="btn_style btn_transparent <?php echo $is_black_header ? 'btn_green' : ''; ?>" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
                        Contact
                    </a>

                    </div>
                </div>

            </div>

            <div class="mobile_header_actions">
                <div class="menu_right_block menu_right_block_mobile">
<a href="#login-popup" class="user-login-trigger" data-fancybox="login-popup">
                      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/user-logon.svg' ); ?>" alt="User Icon">
                    </a>

                    <a class="language_button button_link" href="">
					عربي
                    </a>
                    <a class="btn_style btn_transparent <?php echo $is_black_header ? 'btn_green' : ''; ?>" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
                        Contact
                    </a>

                </div>

                <div class="menu_toggle">
                    <button id="menuIcon" class="menu_icon" aria-label="Toggle navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>

            <div id="mobileMenuOverlay" class="mobile_menu_overlay">
				<div class="mobile_menu_overlay_inner">
                <ul class="mobile_menu_list">
                    <!-- Company with submenu -->
                    <li class="mobile_menu_item mobile_menu_item_has_submenu <?php echo $is_company_active ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>" class="<?php echo $is_company_active ? 'active' : ''; ?>">Company</a>
                        <span class="mobile_menu_submenu_toggle" data-submenu="mobile-submenu-company">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow-01.svg' ); ?>" alt="Toggle">
                        </span>
                        <div class="mobile_menu_submenu" id="mobile-submenu-company">
                            <div class="mobile_submenu_content">
                                <ul class="mobile_submenu_list">
                                    <li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">Who We Are <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/our-team' ) ); ?>">Our Team <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/leadership' ) ); ?>">Leadership <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/our-journey-legacy' ) ); ?>">Our Journey & Legacy <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/vision-mission-values' ) ); ?>">Vision, Mission & Values</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/company-milestones' ) ); ?>">Company Milestones <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/awards' ) ); ?>">Awards & Certifications <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Services with submenu -->
                    <li class="mobile_menu_item mobile_menu_item_has_submenu <?php echo $services_active ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url( home_url( '/services' ) ); ?>" class="<?php echo $services_active ? 'active' : ''; ?>">Services</a>
                        <span class="mobile_menu_submenu_toggle" data-submenu="mobile-submenu-services">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow-01.svg' ); ?>" alt="Toggle">
                        </span>
                        <div class="mobile_menu_submenu" id="mobile-submenu-services">
                            <div class="mobile_submenu_content">
                                <ul class="mobile_submenu_list">
                                    <li><a href="<?php echo esc_url( home_url( '/engineering-design' ) ); ?>">Engineering Design <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Construction Supervision <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Project Management <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Specialized Studies <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Toggle"></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Projects -->
                    <li class="mobile_menu_item <?php echo $projects_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/projects' ) ); ?>" class="<?php echo $projects_active ? 'active' : ''; ?>">Projects</a></li>
                    
                    <!-- Clients -->
                    <?php
                    // Re-check clients active state for mobile (same logic)
                    $clients_active_mobile = is_current_menu_item( $clients_url ) || 
                                             ( is_page() && ( get_page_uri() === 'clients' || basename( get_permalink() ) === 'clients' ) ) ||
                                             ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/clients' ) !== false );
                    ?>
                    <li class="mobile_menu_item <?php echo $clients_active_mobile ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/clients' ) ); ?>" class="<?php echo $clients_active_mobile ? 'active' : ''; ?>">Clients</a></li>
                    
                    <!-- Media Center -->
                    <li class="mobile_menu_item <?php echo $media_center_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/media-center' ) ); ?>" class="<?php echo $media_center_active ? 'active' : ''; ?>">Media Center</a></li>
                    
                    <!-- Careers -->
                    <li class="mobile_menu_item <?php echo $careers_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/careers' ) ); ?>" class="<?php echo $careers_active ? 'active' : ''; ?>">Careers</a></li>
                    
                    <!-- Vendor Registration -->
                    <li class="mobile_menu_item <?php echo $vendor_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/vendor-registration' ) ); ?>" class="<?php echo $vendor_active ? 'active' : ''; ?>">Vendor Registration</a></li>
                    
                    <!-- Contact -->
                    <?php
                    $contact_url = home_url( '/contact' );
                    $contact_active = is_current_menu_item( $contact_url );
                    ?>
                    <li class="mobile_menu_item <?php echo $contact_active ? 'active' : ''; ?>"><a href="<?php echo esc_url( $contact_url ); ?>" class="<?php echo $contact_active ? 'active' : ''; ?>">Contact</a></li>
                </ul>
			</div>
            </div>

            </div>

    </div>
</header>



<!-- Login Popup -->
<div id="login-popup-training" class="job-form-popup" style="display: none;">
	<span class="form-close-icon">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pop-close.svg' ); ?>" alt="Close">
	</span>
	<h3 class="h3_title_50 pb_10 text_center mb_20">Sign In</h3>

	<div class="related_jobs_section_content">
		<h5>Have an account?</h5>
		<p>Enter your email address and password</p>
	</div>

	<ul class="career-form-list-ul">
		<li><input class="input" type="email" placeholder="Email address" required></li>
		<li>
			<input class="input" type="password" placeholder="Password" required>
			<span class="form-icon">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="Eye">
			</span>
		</li>
		<li class="login-options">
			<label class="keep-logged-in">
				<input type="checkbox" checked>
				<span>Keep me logged in</span>
			</label>
			<a href="#" class="forget-password-link">Forget password?</a>
		</li>
		<li><a href="<?php echo esc_url( home_url( '/my-profile-training' ) ); ?>" class="input-buttion btn_style btn_transparent but_black" type="submit">Sign In</a></li>
	</ul>

	<div class="form-bottom-txt">
		<h5>Not a registered user yet?</h5>
		<p><a href="#job-form-popup" class="text_black" data-fancybox="job-form">Create an account</a>  to apply for our career opportunities.</p>
		<span class="or_span">or</span><br>
		<p><a href="<?php echo esc_url( home_url( '/apply-as-a-guest' ) ); ?>" class="text_black">Apply as a Guest</a></p>
	</div>
</div>





<div id="login-popup-training-submit" class="job-form-popup" style="display: none;">
	<span class="form-close-icon">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pop-close.svg' ); ?>" alt="Close">
	</span>
	<h3 class="h3_title_35 pb_10 text_center mb_20">Training Program Enrollment</h3>

	 

	<ul class="career-form-list-ul">
		<li>
			<div class="select-wrapper">
				<select class="input select-input" name="training_start_date" required>
					<option value="">Start Date *</option>
					<option value="2026-01">January 2026</option>
					<option value="2026-02">February 2026</option>
					<option value="2026-03">March 2026</option>
					<option value="2026-04">April 2026</option>
				</select>
				<span class="select-arrow"></span>
			</div>
		</li>
		<li>
			<div class="select-wrapper">
				<select class="input select-input" name="training_duration" required>
					<option value="">Duration Time *</option>
					<option value="1-month">1 Month</option>
					<option value="3-months">3 Months</option>
					<option value="6-months">6 Months</option>
					<option value="12-months">12 Months</option>
				</select>
				<span class="select-arrow"></span>
			</div>
		</li>
	 
		<li><a href="<?php echo esc_url( home_url( '/application-received' ) ); ?>" class="input-buttion btn_style btn_transparent but_black" type="submit">Submit</a></li>
	</ul>
 
</div>




<!-- Login Popup -->
<div id="login-popup" class="job-form-popup" style="display: none;">
	<span class="form-close-icon">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pop-close.svg' ); ?>" alt="Close">
	</span>
	<h3 class="h3_title_50 pb_10 text_center mb_20">Sign In</h3>

	<div class="related_jobs_section_content">
		<h5>Have an account?</h5>
		<p>Enter your email address and password</p>
	</div>

	<ul class="career-form-list-ul">
		<li><input class="input" type="email" placeholder="Email address" required></li>
		<li>
			<input class="input" type="password" placeholder="Password" required>
			<span class="form-icon">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="Eye">
			</span>
		</li>
		<li class="login-options">
			<label class="keep-logged-in">
				<input type="checkbox" checked>
				<span>Keep me logged in</span>
			</label>
			<a href="#" class="forget-password-link">Forget password?</a>
		</li>
		<li><a href="<?php echo esc_url( home_url( '/my-profile' ) ); ?>" class="input-buttion btn_style btn_transparent but_black" type="submit">Sign In</a></li>
	</ul>

	<div class="form-bottom-txt">
		<h5>Not a registered user yet?</h5>
		<p><a href="#job-form-popup" class="text_black" data-fancybox="job-form">Create an account</a>  to apply for our career opportunities.</p>
	</div>
</div>

<!-- Job Form Popup (Sign Up) -->
<div id="job-form-popup" class="job-form-popup" style="display: none;">
	<span class="form-close-icon">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pop-close.svg' ); ?>" alt="Close">
	</span>
	<h3 class="h3_title_50 pb_10 text_center mb_20">Sign Up</h3>

	<div class="related_jobs_section_content">
		<h5>Create an account</h5>
		<p>Create your account in a seconds</p>
	</div>

	<ul class="career-form-list-ul">
		<li><input class="input" type="text" placeholder="Email Address *"></li>
		<li><input class="input" type="email" placeholder="Retype Email Address *"></li>
		<li><input class="input" type="text" placeholder="First Name *"></li>
		<li><input class="input" type="text" placeholder="Last Name *"></li>
		<li>
			<input class="input" type="password" placeholder="Choose Password *">
			<span class="form-icon">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="Eye">
			</span>
		</li>
		<li>
			<input class="input" type="password" placeholder="Retype Password *">
			<span class="form-icon">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="Eye">
			</span>
		</li>
		<li><a href="<?php echo esc_url( home_url( '/create-profile' ) ); ?>" class="input-buttion btn_style btn_transparent but_black" type="submit" value="Create Account">Create Account</a></li>
	</ul>

	<div class="form-bottom-txt">
		<p>Already a registered user? <a href="#login-popup" class="text_black" data-fancybox="login-popup"> Please sign in</a></p>
	</div>
</div>
</body>