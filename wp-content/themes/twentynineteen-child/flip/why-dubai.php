<?php 
/**
* Template Name: Why Dubai
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/why-dubai.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<main>
	<?php // flexible
if( have_rows('why_dubai_section') ): ?>
    <?php while( have_rows('why_dubai_section') ): the_row(); ?>

<?php if( get_row_layout() == 'banner_section' ): ?>
	<section class="banner">
			<figure class="banner-area-wrap">
				<picture>
				<?php 
				$webp_image = get_sub_field('abt_sec1_image_webp');
				if( !empty( $webp_image ) ): ?>
				<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
				<?php endif; ?>

				<?php 
				$jpg_image = get_sub_field('abt_sec1_image');
				if( !empty( $jpg_image ) ): ?>
					<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
					<?php endif; ?>

				<?php 
				$jpg_image = get_sub_field('abt_sec1_image');
				if( !empty( $jpg_image ) ): ?>
					<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
				<?php endif; ?>
			</picture>
			<figcaption>
				<div class="container">
					<h1><?php echo get_sub_field('abt_sec1_heading'); ?></h1>
					<?php echo get_sub_field('abt_sec1_description'); ?>
				</div>
			</figcaption>
				
			</figure>
		</section> 
	
<?php elseif( get_row_layout() == 'why_overview_section' ): ?>
	<section class="content-sec-17">
		<div class="container">
			<div class="content-sec-17-inner">
				<div class="content-sec-17-left">
					<h3><?php echo get_sub_field('overview_title'); ?></h3>
					
					<?php 
				$overview_link = get_sub_field('overview_link'); 
				if( $overview_link ): ?>
				<a href="<?php echo $overview_link['url']; ?>" class="btn-link" target="<?php echo $overview_link['target']; ?>"><?php echo $overview_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
				</div>
				<div class="content-sec-17-right">
					<?php echo get_sub_field('overview_content'); ?>
					<?php if( have_rows('overview_listing') ): ?>
						<ul class="listing-points">
					<?php while( have_rows('overview_listing') ): the_row();  ?>               
					<li><?php the_sub_field('tm_name'); ?></li>       
					<?php endwhile; ?>
					</ul>
				<?php endif; ?>

				</div>
			</div>
		</div>
		
	</section>
<?php elseif( get_row_layout() == 'dubai_in_numbers_section' ): ?>
	<?php if( have_rows('we_offer_list') ): ?>
	<section class="numbers-sec">
		<div class="container">
			<h2><?php echo get_field('we_offer_heading'); ?></h2>
			<ul class="numbers-listing">

				<?php  while( have_rows('we_offer_list') ): the_row();  ?>               
					<li><span><?php the_sub_field('dub_numbers'); ?></span>
						<p><?php the_sub_field('dub_name'); ?></p>
					</li>       
					<?php  endwhile; ?>
				
			</ul>
		</div>
	</section>
	<?php endif; ?>

<?php elseif( get_row_layout() == 'dubai_free_zone_section' ): ?>

	<section class="image-left-content no-max-width">
		<figure class="image-left-content-left">
			<picture>
			<?php if( get_sub_field('dubai_free_zone_webp_image') ){ ?><source srcset="<?php echo get_sub_field('dubai_free_zone_webp_image')['url']; ?>" type="image/webp"><?php } ?>
			<?php if( get_sub_field('dubai_free_zone_image') ){ ?><source srcset="<?php echo get_sub_field('dubai_free_zone_image')['url']; ?>" type="image/jpg"><?php } ?>
			<?php if( get_sub_field('dubai_free_zone_image') ){ ?><img src="<?php echo get_sub_field('dubai_free_zone_image')['url']; ?>" alt=image><?php } ?>
				</picture>
		</figure>
		<div class="image-left-content-right padding-right padding-left">
			<h3><?php echo get_sub_field('dubai_free_zone_title'); ?></h3>
			<?php if( have_rows('dubai_free_zone_content') ): ?>
			<ul class="listing-points">
				<?php  while( have_rows('dubai_free_zone_content') ): the_row();  ?>               
					<li><?php the_sub_field('dubai_free_listing'); ?>
					</li>       
					<?php  endwhile; ?>
			</ul>
			<?php endif; ?>
			<?php 
				$dubai_free_zone_link = get_sub_field('dubai_free_zone_link'); 
				if( $dubai_free_zone_link ): ?>
				<a href="<?php echo $dubai_free_zone_link['url']; ?>" class="btn-link" target="<?php echo $dubai_free_zone_link['target']; ?>"><?php echo $dubai_free_zone_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
		</div>
	</section>


<?php elseif( get_row_layout() == 'career_opportunity_section' ): ?>
	<section class="banner-widget-small">
		<div class="container">
			<div class="banner-widget-small-inner">
				<div class="banner-widget-small-content">
					<span><?php echo get_sub_field('career_opportunity_sub_text'); ?></span>
					<h3><?php echo get_sub_field('career_opportunity_title'); ?></h3>
					<?php 
				$career_opportunity_button = get_sub_field('career_opportunity_button'); 
				if( $career_opportunity_button ): ?>
				<a href="<?php echo $career_opportunity_button['url']; ?>" class="btn-link" target="<?php echo $career_opportunity_button['target']; ?>"><?php echo $career_opportunity_button['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
				</div>
				<div class="banner-widget-small-image">
					<figure>
						<picture>
						<?php if( get_sub_field('career_opportunity_webp_image') ){ ?><source srcset="<?php echo get_sub_field('career_opportunity_webp_image')['url']; ?>" type="image/webp"><?php } ?>
						<?php if( get_sub_field('career_opportunity_image') ){ ?><source srcset="<?php echo get_sub_field('career_opportunity_image')['url']; ?>" type="image/png"><?php } ?>
						<?php if( get_sub_field('career_opportunity_image') ){ ?><img src="<?php echo get_sub_field('career_opportunity_image')['url']; ?>" alt=image><?php } ?>
					</picture>
					</figure>
				</div>
			</div>
		</div>
		<?php
		$career_opportunity_button = get_sub_field('career_opportunity_button'); 
				if( $career_opportunity_button ): ?>
				<a href="<?php echo $career_opportunity_button['url']; ?>" class="full-link" target="<?php echo $career_opportunity_button['target']; ?>"></a>												
					<?php endif; ?>
	</section>

	
<?php endif; ?>
    <?php endwhile; ?>
<?php endif; // flexible?>
	
	
	
	

	

	
	
</main>

<?php get_footer(); ?>