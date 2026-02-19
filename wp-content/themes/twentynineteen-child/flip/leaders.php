<?php 
/**
* Template Name: Leaders
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/leaders.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<main>
	<?php // flexible
if( have_rows('leaders_section') ): ?>
    <?php while( have_rows('leaders_section') ): the_row(); ?>

<?php if( get_row_layout() == 'leaders_listing' ): ?>
	<section class="content-sec-12">
		<div class="container">
			<div class="content-sec-12-inner">
				<h1><?php echo get_sub_field('leaders_title'); ?></h1>
				<?php echo get_sub_field('leaders_content'); ?>
			</div>
			<?php if( have_rows('lead_listing') ): ?> 
			<ul class="team-member-list">
				<?php while( have_rows('lead_listing') ): the_row();  ?>
				<li>
					<figure class="team-member-image-box">
						<picture>
					<?php if( get_sub_field('blo_image_webp') ){ ?><source srcset="<?php echo get_sub_field('blo_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><source srcset="<?php echo get_sub_field('blo_image')['url']; ?>" type="image/jpg"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><img src="<?php echo get_sub_field('blo_image')['url']; ?>" alt=image><?php } ?>	
						</picture>
					  <figcaption>
					  	<h5><?php echo get_sub_field('blo_title'); ?></h5>
					  	<span><?php echo get_sub_field('blo_sub_title'); ?></span>
					  </figcaption>
					</figure>
				</li>
				<?php endwhile; ?>
				
			</ul>
			<?php endif; ?>
		</div>
	</section>

<?php elseif( get_row_layout() == 'testimonials_list' ): ?>
<section class="content-sec-13">
		<div class="container">
			<div class="content-sec-13-inner">
				<h2><?php echo get_sub_field('testimonials_title'); ?></h2>
				<?php echo get_sub_field('testimonials_content'); ?>				
			</div>
    <?php
		global $the_query;
			$args=array('post_type' => 'testimonials',
			'post_status' => 'publish',
			'posts_per_page' => -1,                   
			'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
			'orderby' => 'date',
			'order' => 'DESC',
		);
		    // The Query
		$the_query = new WP_Query( $args );?>
        <?php if ( $the_query->have_posts() ) : ?>

			<ul class="testimonials-listing" id="awardssec">
				 <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			
				<li>
					<div class="testimonial-image-box">
						<figure>
							<picture>
						<?php if( get_field('testimonials_image_webp') ){ ?><source srcset="<?php echo get_field('testimonials_image_webp')['url']; ?>" type="image/webp"><?php } ?>
						<?php if( get_field('testimonials_image') ){ ?><source srcset="<?php echo get_field('testimonials_image')['url']; ?>" type="image/png"><?php } ?>
						<?php if( get_field('testimonials_image') ){ ?><img src="<?php echo get_field('testimonials_image')['url']; ?>" alt=image><?php } ?>
								
							</picture>
						</figure>
						<?php if( get_field('video_url') ){ ?>
						<!-- <a href="#video" class="openVideo"><i class="fa-sharp fa-solid fa-play"></i></a> -->
						<a href="<?php echo get_field('video_url'); ?>" class="popup-youtube openVideo"><i></i></a>
						<!-- <div id="video" class="video-popup mfp-hide">
						<video preload="false" controls>
							<source src="<?php echo get_field('video_url'); ?>" type="video/mp4">
						</video>
					</div> -->
					<?php } ?>
					</div>
					<div class="testimonial-content-box">
						<h5><?php the_title(); ?></h5>
						<p><?php echo get_field('company_name'); ?></p>
						<p><?php echo get_field('department'); ?></p>
					</div>
				</li>
				  <?php endwhile; ?>
				  <?php wp_reset_postdata(); ?>
			</ul>
			<?php else : ?>
	    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif; ?>
		<?php /*
    if (  $the_query->max_num_pages > 1 ){	?>
    <a class="load-more-btn" id="awards-load-more" data-type="post"><?php _e('Load more testimonials','ifza'); ?></a>
    <?php } */ ?>
			<!-- <a href="#" class="load-more-btn">Load more testimonials</a> -->
		</div>
	</section>

	<?php elseif( get_row_layout() == 'get_in_touch' ): ?>
	<section class="bottom-banner">
		<figure>
			<picture>
				<?php if( get_sub_field('cc_image_webp') ){ ?><source srcset="<?php echo get_sub_field('cc_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('cc_image') ){ ?><source srcset="<?php echo get_sub_field('cc_image')['url']; ?>" type="image/jpg"><?php } ?>
					<?php if( get_sub_field('cc_image') ){ ?><img src="<?php echo get_sub_field('cc_image')['url']; ?>" alt=image><?php } ?>
			</picture>
		</figure>
		<div class="bottom-banner-content">
			<div class="container">
				<div class="bottom-banner-inner">
				<h3 class="h2"><?php echo get_sub_field('cc_title'); ?></h3>
				<?php echo get_sub_field('cc_content'); ?>					
				<?php 
				$cc_link = get_sub_field('cc_link'); 
				if( $cc_link ): ?>
				<a href="<?php echo $cc_link['url']; ?>" target="<?php echo $cc_link['target']; ?>"><?php echo $cc_link['title']; ?><span class="arrow-img"></span></a>												
				<?php endif; ?>					
					
				</div>
			</div>
		</div>
	</section>

	<?php endif; ?>
	

    <?php endwhile; ?>
<?php endif; // flexible?>	
	
</main>

<?php get_footer(); ?>