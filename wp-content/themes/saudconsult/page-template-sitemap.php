<?php
/**
 * Template Name: Sitemap
 *
 * The template for displaying the Sitemap page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/about-banner.jpg',
		'title' => 'Sitemap',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<div class="sitemap-container" style="padding: 60px 20px; max-width: 1200px; margin: 0 auto;">
		<div class="sitemap-content">
			<h2 style="margin-bottom: 30px; font-size: 32px; color: #333;">Sitemap</h2>
			
			<?php
			// Get all published pages
			$args = array(
				'post_type' => 'page',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'orderby' => 'title',
				'order' => 'ASC'
			);
			
			$all_pages = get_posts( $args );
			?>

			<?php if ( !empty( $all_pages ) ) : ?>
				<ul class="sitemap-list" style="list-style: none; padding: 0; margin: 0;">
					<?php foreach ( $all_pages as $page ) : 
						$page_link = get_permalink( $page->ID );
						$page_title = $page->post_title;
					?>
						<li style="margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #eee;">
							<a target="_blank" href="<?php echo esc_url( $page_link ); ?>" 
							   style="color: #0073aa; text-decoration: none; font-size: 18px; font-weight: 500; display: block;">
								<?php echo esc_html( $page_title ); ?>
							</a>
							<span style="color: #666; font-size: 14px; display: block; margin-top: 5px;">
								<?php echo esc_url( $page_link ); ?>
							</span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p style="font-size: 18px; color: #666;">No pages found.</p>
			<?php endif; ?>
		</div>
	</div>

</main><!-- #main -->

<?php
get_footer();

