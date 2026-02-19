<?php 
/**
* Template Name: Ifza Events
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/ifza-events.css?ver=1.0" rel="stylesheet">
<?php get_header()?>
<main>
	<?php // flexible
if( have_rows('ifza_events_section') ): ?>
    <?php while( have_rows('ifza_events_section') ): the_row(); ?>

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
	
<?php elseif( get_row_layout() == 'events_overview' ): ?>
		<section class="content-sec-7">
		<div class="container">
			<div class="content-sec-7-inner">
				<div class="content-sec-7-left">
					<h2 ><?php echo get_sub_field('events_title'); ?></h2>
					<?php echo get_sub_field('events_content'); ?>
				</div>
				<div class="content-sec-7-right">
				<?php if( have_rows('events_listing') ): ?>		
				<ul class="listing-points">
					<?php while( have_rows('events_listing') ): the_row();  ?>  
					<li><?php the_sub_field('points'); ?></li>
					<?php endwhile; ?>					
				</ul>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php elseif( get_row_layout() == 'events_example' ): ?>
		<section class="content-sec-8">
		<div class="container">
			<h3 class="h2"><?php echo get_sub_field('ex_section_title'); ?></h3>
			<?php if( have_rows('events_examples') ): ?>
			<ul class="text-over-image-listing">
				<?php while( have_rows('events_examples') ): the_row();  ?>  
				<li>
					<figure>
						<picture>
							<?php if( get_sub_field('ex_image_webp') ){ ?><source srcset="<?php echo get_sub_field('ex_image_webp')['url']; ?>" type="image/webp"><?php } ?>
							<?php if( get_sub_field('ex_image') ){ ?><source srcset="<?php echo get_sub_field('ex_image')['url']; ?>" type="image/jpg"><?php } ?>
							<?php if( get_sub_field('ex_image') ){ ?><img src="<?php echo get_sub_field('ex_image')['url']; ?>" alt=image><?php } ?>
						</picture>
						<figcaption>
							<h3><?php echo get_sub_field('ex_title'); ?></h3>
							<?php echo get_sub_field('ex_content'); ?>
						</figcaption>
					</figure>
				</li>
				<?php endwhile; ?>	
				
			</ul>
			<?php endif; ?>
		</div>
	</section>

<?php elseif( get_row_layout() == 'left_image_right_content' ): ?>

		<section class="letter-text-sec">
		<div class="container">
			<div class="letter-text-inner">
				<figure class="letter-text-image">
					<picture>
					 <?php if( get_sub_field('bs_image_webp') ){ ?><source srcset="<?php echo get_sub_field('bs_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('bs_image') ){ ?><source srcset="<?php echo get_sub_field('bs_image')['url']; ?>" type="image/png"><?php } ?>
					<?php if( get_sub_field('bs_image') ){ ?><img src="<?php echo get_sub_field('bs_image')['url']; ?>" alt=image><?php } ?>
					</picture>
				</figure>
				<div class="letter-text-content">
					<span class="primary_font"><?php echo get_sub_field('bs_title'); ?></span>					
					<?php echo get_sub_field('bscontent'); ?>
					<?php 
					$bs_link = get_sub_field('bs_link'); 
					if( $bs_link ): ?>
					<a href="<?php echo $bs_link['url']; ?>" class="btn-link" target="<?php echo $bs_link['target']; ?>"><?php echo $bs_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php elseif( get_row_layout() == 'events_galleries' ): ?>

		<section class="gallery-sec">
				<div class="container">

					<h3 class="h2"><?php echo get_sub_field('gallery_title'); ?></h3>
					<?php if( have_rows('gallery_listing') ): ?>
					<ul class="gallery-list">
						<?php  while( have_rows('gallery_listing') ): the_row();  ?> 
						<li>
							<?php 
					$gallery_link = get_sub_field('gallery_link'); 
					if( $gallery_link ){ ?>
					<a href="<?php echo $gallery_link['url']; ?>" target="<?php echo $gallery_link['target']; ?>">										
					<?php } else { ?>
						<a href="javascript:void(0)">
						<?php } ?>
							<figure>
								<picture>
								<?php if( get_sub_field('gallery_image_webp') ){ ?><source srcset="<?php echo get_sub_field('gallery_image_webp')['url']; ?>" type="image/webp"><?php } ?>
								<?php if( get_sub_field('gallery_image') ){ ?><source srcset="<?php echo get_sub_field('gallery_image')['url']; ?>" type="image/jpg"><?php } ?>
								<?php if( get_sub_field('gallery_image') ){ ?><img src="<?php echo get_sub_field('gallery_image')['url']; ?>" alt=image><?php } ?>
								</picture>
								<?php if( get_sub_field('gallery_name') ){ ?><figcaption>
									<h3><?php echo get_sub_field('gallery_name'); ?>	</h3>
									<span class="link-arrow"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-white-s.png" alt="icon"></span>
								</figcaption><?php } ?>
							</figure>
							</a>
						</li>
						  <?php endwhile; ?>
					</ul>
					<?php endif; ?>

					<?php 
					$gvb_link = get_sub_field('gallery_view_all_button'); 
					if( $gvb_link ): ?>
					<a href="<?php echo $gvb_link['url']; ?>" class="btn-link" target="<?php echo $gvb_link['target']; ?>"><?php echo $gvb_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
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
			<?php $cc_link = get_sub_field('cc_link'); 
				if( $cc_link ): ?>
			<a href="<?php echo $cc_link['url']; ?>" target="<?php echo $cc_link['target']; ?>"></a>
			<?php endif; ?>	
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