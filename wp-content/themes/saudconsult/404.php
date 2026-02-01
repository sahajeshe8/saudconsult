<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';

get_header();
?>

<main id="primary" class="site-main no_banner_section">
 

<?php
// Breadcrumb for 404 page
$custom_breadcrumb = array(
	array(
		'title' => 'Home',
		'url' => home_url( '/' ),
	),
	array(
		'title' => '404 - Page Not Found',
		'url' => '',
	),
);
set_query_var( 'breadcrumb_items', $custom_breadcrumb );

get_template_part( 'template-parts/breadcrumb' );
?>

<section class="error_404_section pt_80 pb_80">
	<div class="wrap">
		<div class="error_404_content text_center">
			<div class="error_404_number">
				<h1 class="error_404_title">404</h1>
			</div>
			
			<div class="error_404_message">
				<h3 class="h3_title_55 text_black">Oops! Page Not Found</h3>
				<p class="error_404_description">
					The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
				</p>
			</div>

			<div class="error_404_actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="  me-1 btn_style btn_green">Go Back Home</a>
			</div>

			<!-- <div class="error_404_search">
				<h4>Or try searching for what you need:</h4>
				<?php //get_search_form(); ?>
			</div> -->
		</div>
	</div>
</section>

</main><!-- #main -->

<?php
get_footer();

