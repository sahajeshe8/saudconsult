<?php 
/**
* Template Name: Ifza Cares
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/ifza-cares.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<div style="display:none">
<input type="chekbox" id="options-rewind-checkbox6" name="">
</div>

<main>
	<?php // flexible
if( have_rows('ifza_cares_section') ): ?>
    <?php while( have_rows('ifza_cares_section') ): the_row(); ?>

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
	
<?php elseif( get_row_layout() == 'academy_overview' ): ?>
		<section class="content-sec-5">
			<div class="container">
				<div class="contact-sec-5-inner">
					<h4><?php echo get_sub_field('cares_title'); ?></h4>
						<?php echo get_sub_field('cares_content'); ?>
				</div>
			</div>
		</section>

<?php elseif( get_row_layout() == 'image_content' ): ?>
<?php if( have_rows('image_content_listing') ): ?>
		<section class="text-image-list-sec">
		<div class="container">
<?php while( have_rows('image_content_listing') ): the_row();  ?>  
			<div class="text-image-list-inner">
				<figure class="text-image-list-image">
					<picture>
						<?php if( get_sub_field('cm_image_webp') ){ ?><source srcset="<?php echo get_sub_field('cm_image_webp')['url']; ?>" type="image/webp"><?php } ?>
							<?php if( get_sub_field('cm_image') ){ ?><source srcset="<?php echo get_sub_field('cm_image')['url']; ?>" type="image/jpg"><?php } ?>
							<?php if( get_sub_field('cm_image') ){ ?><img src="<?php echo get_sub_field('cm_image')['url']; ?>" alt=image><?php } ?>
					</picture>
				</figure>
				<div class="text-image-list-content">
					<?php echo get_sub_field('cm_content'); ?>
				</div>
			</div>
<?php endwhile; ?>	


		</div>
	</section>
		<?php endif; ?>

<?php elseif( get_row_layout() == 'events_example' ): ?>
		<section class="content-sec-6">
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

	<?php elseif( get_row_layout() == 'video_gallery' ): ?>

<section class="video-slider-sec padding-left">
		<h3 class="h2"><?php echo get_sub_field('Video_title'); ?></h3>
<?php if( have_rows('video_gallery_listing') ): ?>
		<div class="glide" id="video-slider">
			<div class="glide__track" data-glide-el="track">
				<ul class="glide__slides">
					
					<?php while( have_rows('video_gallery_listing') ): the_row();  ?>
					<li class="glide__slide">
		
						<div class="video-slide-area">
									<figure>
								<picture>
					<?php if( get_sub_field('vg_image_webp') ){ ?><source srcset="<?php echo get_sub_field('vg_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('vg_image') ){ ?><source srcset="<?php echo get_sub_field('vg_image')['url']; ?>" type="image/png"><?php } ?>
					<?php if( get_sub_field('vg_image') ){ ?><img src="<?php echo get_sub_field('vg_image')['url']; ?>" alt=image><?php } ?>
								</picture>
							<?php if( get_sub_field('vg_link') ){ ?>
								<figcaption>
									<!-- <a href="#video<?php echo $q; ?>" class="openVideo"><i class="fa-sharp fa-solid fa-play"></i></a> -->
									<a href="<?php echo get_sub_field('vg_link'); ?>" class="popup-youtube openVideo"><i></i></a>
								</figcaption>
							</figure>
							<?php } ?>
							
							 <div class="video-slide-content">
								<h5><?php echo get_sub_field('vg_title'); ?></h5>
								<?php echo get_sub_field('vg_content'); ?>
							</div> 
						</div>
					</li>
					<?php $q++; endwhile; ?>	
					
				</ul>
			</div>
			<div class="glide__arrows" data-glide-el="controls">
				    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
				    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
			  </div>			  
		</div>
		<?php endif; ?>
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
	<?php elseif( get_row_layout() == 'chairman_section' ): ?>
		<section class="bottom-banner">
		<figure>
			<picture>
				<?php if( get_sub_field('ch_image_webp') ){ ?><source srcset="<?php echo get_sub_field('ch_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('ch_image') ){ ?><source srcset="<?php echo get_sub_field('ch_image')['url']; ?>" type="image/png"><?php } ?>
					<?php if( get_sub_field('ch_image') ){ ?><img src="<?php echo get_sub_field('ch_image')['url']; ?>" alt=image><?php } ?>
			</picture>
		</figure>
		<div class="bottom-banner-content">
			<div class="container">
				<div class="bottom-banner-inner">
					<?php echo get_sub_field('ch_message'); ?>
					<span><?php echo get_sub_field('ch_name'); ?></span>
				</div>
			</div>
		</div>
	</section>

<?php endif; ?>
    <?php endwhile; ?>
<?php endif; // flexible?>
	

	
</main>

<?php get_footer(); ?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var checkbox6 = document.querySelector('#options-rewind-checkbox6')
		var glide6 = new Glide('#video-slider', {
		  //type: 'carousel',
		  perView:2.3,
		  draggable: true,
		  gap:0,
		  rewind: checkbox6.checked,
		  breakpoints: {
		  	1450:{
		      perView:2.2,
		    },
		    1366:{
		      perView:2.1,
		    },
		    1300:{
		      perView:2,
		    },
		  	991:{
		      perView:1.8,
		    },
		    860:{
		      perView:1.6,
		    },
		    767:{
		      perView:1.3,
		    },
		    641:{
		      perView:1.1,
		    },
		    480:{
		      perView:1,
		    },
		    400:{
		      perView:1,
		    },
		  }
		})
		checkbox6.addEventListener('change', function () {
		  glide6.update({
		    rewind: checkbox6.checked
		  })
		})
		glide6.mount();
	});

</script>

