<?php
/**
 * Template Name: Password Management
 *
 * The template for displaying the Password Management page
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';
get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
 

	<?php 
	$page_tabs_data = array(
		'tabs' => array(
			array( 'id' => 'My Jobs', 'title' => 'My Jobs', 'link' => esc_url( home_url( '/my-job' ) ) ),
			array( 'id' => 'My Profile', 'title' => 'My Profile', 'link' => esc_url( home_url( '/my-profile' ) ) ),
			array( 'id' => 'Password Management', 'title' => 'Password Management', 'link' => esc_url( home_url( '/password-management' ) ) )  
		),
		'active_tab' => 'Password Management',
		'nav_class' => 'profile-tabs-nav',
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>

	<section class="password_management_section pt_80 pb_80">
		<div class="wrap">
			<div class="password_management_container">
				<div class="password_management_content">
					<div class="profile-title-block text-center-title">
						<h3 class="h3_title_50 pb_10 text_center mb_20">Password Management</h3>
					</div>

					<form class="password_management_form" method="post" action="">
                    <ul class="career-form-list-ul ">
						<li><input class="input" type="text" placeholder="Current Password*"></li>
						<li><input class="input" type="text" placeholder="New Password*"></li>
						<li><input class="input" type="text" placeholder="Retype New Password*"></li>
					 
					</ul>

                    <span class="profile-link"><a href="#">Password Policy</a></span>
                    <button type="button" class="btn_style but_black but-position w_100">Reset Password</button>
					</form>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();

