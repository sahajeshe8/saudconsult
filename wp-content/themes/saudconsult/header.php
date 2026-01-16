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
	
	$header_class_string = implode( ' ', array_unique( $header_classes ) );
	?>
	<header class="<?php echo esc_attr( $header_class_string ); ?>" id="headerMainSection">
   <div class="wrap">

     <div class="header_main_wrapper">
        <div class="logo_desktop text-center d-flex">
            <?php 
            $logo_path = get_template_directory() . '/assets/images/saudconsult-logo.svg';
            $logo_url = get_template_directory_uri() . '/assets/images/saudconsult-logo.svg';
            if ( file_exists( $logo_path ) ) : ?>
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                </a>
            <?php endif; ?>
           
        </div>
 <div class="desk_nav_right">
                <div class="navbar nav_desk">
                    <ul class="list-unstyled">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/brands' ) ); ?>">
							Company
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
							Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/industries' ) ); ?>">
							Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/projects' ) ); ?>">
							Clients
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/media-center' ) ); ?>">
							Media Center 
                            </a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/careers' ) ); ?>">
							Careers
                            </a>
                        </li>





						<li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/media-center' ) ); ?>">
							Vendor Registration
                            </a>
                        </li>
 
                    </ul>

                    <div class="menu_right_block">


                    <a class="language_button button_link" href="">
					عربي
                    </a>
                    <a class="btn_style btn_transparent" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
                        Contact
                    </a>

                    </div>
                </div>

            </div>

            <div class="menu_toggle">
                <button id="menuIcon" class="menu_icon" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <div id="mobileMenuOverlay" class="mobile_menu_overlay">
                <ul class="mobile_menu_list">
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/brands' ) ); ?>">Brands</a></li>
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/products' ) ); ?>">Products</a></li>
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/industries' ) ); ?>">Industries We Serve</a></li>
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/projects' ) ); ?>">Projects</a></li>
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/media-center' ) ); ?>">Media Center</a></li>
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a></li>
                </ul>
            </div>

            </div>

    </div>
</header>
</body>