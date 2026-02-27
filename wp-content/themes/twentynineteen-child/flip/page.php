<?php
/**
 * The template for displaying all single posts
 */

get_header();?>
<main>
    	<section class="banner">
			<figure class="banner-area-wrap">
				<picture>
				<?php 
				$jpg_image = get_field('banner_image');
				if( !empty( $jpg_image ) ): ?>
					<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
					<?php else: ?>
                <source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/about-banner.jpg" type="image/jpg">
                <?php endif; ?>

				<?php 
				$jpg_image = get_field('banner_image');
				if( !empty( $jpg_image ) ): ?>
					<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
				<?php else: ?>
                    <img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/about-banner.jpg" alt="image">
                <?php endif; ?>
			</picture>
			<figcaption>
				<div class="container">
					<?php if( get_field('banner_title') ): ?><h1><?php echo get_field('banner_title'); ?></h1><?php else: ?><h1><?php the_title(); ?></h1><?php endif; ?>
					<?php echo get_field('banner_sub_heading'); ?>
				</div>
			</figcaption>
				
			</figure>
	</section> 


    <section class="page-wrap-default">
        <div class="container">
            <div class="page-inside-default">
                <?php the_content();?> 
            </div>
        </div>
    </section>
</main>
<?php get_footer();
