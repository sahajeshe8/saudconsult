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
                        <li class="nav-item">
                            <a href="#" class="nav-link" >
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
										<li>
											<a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">
											Who We Are <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<li>
										<a href="<?php echo esc_url( home_url( '/our-team' ) ); ?>">
										Our Team  <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<li>
										<a href="<?php echo esc_url( home_url( '/leadership' ) ); ?>">
										Leadership <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<li>
										<a href="<?php echo esc_url( home_url( '/our-journey-legacy' ) ); ?>">
										Our Journey & Legacy <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>


										<li>
										<a href="<?php echo esc_url( home_url( '/vision-mission-values' ) ); ?>">
										Vision, Mission & Values <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>


										<li>
										<a href="<?php echo esc_url( home_url( '/company-milestones' ) ); ?>">
										Company Milestones <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>

										<li>
										<a href="<?php echo esc_url( home_url( '/awards' ) ); ?>">
										Awards & Certifications <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
									 </ul>
								 </div>
							 </div>
							</div>
							 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/products' ) ); ?>">
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
										<li>
											<a href="<?php echo esc_url( home_url( '/engineering-design' ) ); ?>">
											Engineering Design <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<li>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
										Construction Supervision <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<li>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
										Project Management <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
										<li>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
										Specialized Studies <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow.svg' ); ?>" alt="Arrow Down">
											</a>
										</li>
 
									 </ul>
								 </div>
							 </div>
							</div>
							
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/projects' ) ); ?>">
							Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/clients' ) ); ?>">
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
                            <a class="nav-link" href="<?php echo esc_url( home_url( '/vendor-registration' ) ); ?>">
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

            <div class="menu_toggle">
                <button id="menuIcon" class="menu_icon" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <div id="mobileMenuOverlay" class="mobile_menu_overlay">
                <ul class="mobile_menu_list">
                    <!-- Company with submenu -->
                    <li class="mobile_menu_item mobile_menu_item_has_submenu">
                        <a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">Company</a>
                        <span class="mobile_menu_submenu_toggle" data-submenu="mobile-submenu-company">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow-01.svg' ); ?>" alt="Toggle">
                        </span>
                        <div class="mobile_menu_submenu" id="mobile-submenu-company">
                            <div class="mobile_submenu_content">
                                <ul class="mobile_submenu_list">
                                    <li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>">Who We Are</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/our-team' ) ); ?>">Our Team</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/leadership' ) ); ?>">Leadership</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/our-journey-legacy' ) ); ?>">Our Journey & Legacy</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/vision-mission-values' ) ); ?>">Vision, Mission & Values</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/company-milestones' ) ); ?>">Company Milestones</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/awards' ) ); ?>">Awards & Certifications</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Services with submenu -->
                    <li class="mobile_menu_item mobile_menu_item_has_submenu">
                        <a href="<?php echo esc_url( home_url( '/services' ) ); ?>">Services</a>
                        <span class="mobile_menu_submenu_toggle" data-submenu="mobile-submenu-services">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/menu-arrow-01.svg' ); ?>" alt="Toggle">
                        </span>
                        <div class="mobile_menu_submenu" id="mobile-submenu-services">
                            <div class="mobile_submenu_content">
                                <ul class="mobile_submenu_list">
                                    <li><a href="<?php echo esc_url( home_url( '/engineering-design' ) ); ?>">Engineering Design</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Construction Supervision</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Project Management</a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Specialized Studies</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Projects -->
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/projects' ) ); ?>">Projects</a></li>
                    
                    <!-- Clients -->
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/clients' ) ); ?>">Clients</a></li>
                    
                    <!-- Media Center -->
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/media-center' ) ); ?>">Media Center</a></li>
                    
                    <!-- Careers -->
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/careers' ) ); ?>">Careers</a></li>
                    
                    <!-- Vendor Registration -->
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/vendor-registration' ) ); ?>">Vendor Registration</a></li>
                    
                    <!-- Contact -->
                    <li class="mobile_menu_item"><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a></li>
                </ul>
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