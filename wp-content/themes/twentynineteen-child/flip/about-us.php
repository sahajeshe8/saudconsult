<?php 
/**
* Template Name: About us
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/about.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<div style="display:none">
<input type="chekbox" id="options-rewind-checkbox3" name="">
</div>

<main>
	<?php // flexible
if( have_rows('about_page_section') ): ?>
    <?php while( have_rows('about_page_section') ): the_row(); ?>

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
	
<?php elseif( get_row_layout() == 'abt_overview_section' ): ?>
	<section class="content-sec">
		<div class="container">
			<div class="content-sec-inner">
				<h3><?php echo get_sub_field('overview_title'); ?></h3>
				<?php echo get_sub_field('overview_content'); ?>
				<?php 
				$overview_link = get_sub_field('overview_link'); 
				if( $overview_link ): ?>
				<a href="<?php echo $overview_link['url']; ?>" class="btn-link" target="<?php echo $overview_link['target']; ?>"><?php echo $overview_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
			</div>
		</div>
	</section>
<?php elseif( get_row_layout() == 'we_offer_section' ): ?>
	<section class="content-sec-2">
		<div class="container">
			<div class="content-sec-2-inner">
				<div class="left-heading">
					<h3><?php echo get_sub_field('we_offer_heading'); ?></h3>
				</div>
				<div class="right-points">
					<?php if( have_rows('we_offer_list') ): ?>
						<ul>
					<?php $l=1; while( have_rows('we_offer_list') ): the_row();  ?>               
					<li><span><?php if($l<10){ echo '0'.$l; } else{echo $l;}?>.</span>
						<p><?php the_sub_field('tm_name'); ?></p>
					</li>       
					<?php $l++; endwhile; ?>
					</ul>
				<?php endif; ?>

					
			</div>
		</div>
	</section>
<?php elseif( get_row_layout() == 'vision_and_mission_section' ): ?>
	<?php if( have_rows('abt_vision_mission') ): ?>
	<section class="image-box-center-sec">
		<div class="container">

			<ul class="image-box-center-inner">
				<?php $l=1; while( have_rows('abt_vision_mission') ): the_row();  ?> 
				<li>
					<div class="image-box-center-content">
						<h3 class="h2"><?php the_sub_field('v_m_title'); ?></h3>
						<?php the_sub_field('v_m_content'); ?>
					</div>
				</li>
				<?php if( get_sub_field('v_m_image') ){ ?>
					<li>
					<figure class="image-box-center-image">
						<picture>
					<?php if( get_sub_field('v_m_image_webp') ){ ?><source srcset="<?php echo get_sub_field('v_m_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('v_m_image') ){ ?><source srcset="<?php echo get_sub_field('v_m_image')['url']; ?>" type="image/jpg"><?php } ?>
					<?php if( get_sub_field('v_m_image') ){ ?><img src="<?php echo get_sub_field('v_m_image')['url']; ?>" alt=image><?php } ?>
						</picture>
						

					</figure>
				</li>
				<?php } ?>
				<?php if ( wp_is_mobile() ){ ?>
				<li class="mob-image-box-wrap">
				    <figure class="image-box-center-image">
						<picture>
					        <?php if( get_sub_field('v_m_image_webp') ){ ?><source srcset="<?php echo get_sub_field('v_m_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					        <?php if( get_sub_field('v_m_image') ){ ?><source srcset="<?php echo get_sub_field('v_m_image')['url']; ?>" type="image/jpg"><?php } ?>
					        <?php if( get_sub_field('v_m_image') ){ ?><img src="<?php echo get_sub_field('v_m_image')['url']; ?>" alt=image><?php } ?>
						</picture>
						<div class="image-box-center-content">
						    <h3 class="h2"><?php the_sub_field('v_m_title'); ?></h3>
						    <?php the_sub_field('v_m_content'); ?>
					    </div>

					</figure>
				</li>
				<?php } ?>
			<?php $l++; endwhile; ?>
			
			</ul>
		</div>
	</section>
<?php endif; ?>
<?php elseif( get_row_layout() == 'listing_section' ): ?>
	<?php $videolink = get_sub_field('bg_listing_image'); ?>
	<?php if( have_rows('abt_sec6_listing') ): ?>
<?php if ( wp_is_mobile() ){ ?>
	<section class="parallax-sec-mob">
	    <div class="parallax-mob-video-bg-area">
	       <video class="lazy"  autoplay muted playsinline poster="<?php echo get_template_directory_uri(); ?>/assets/images/about-poster.png">
	        	<source data-src="<?php echo $videolink; ?>" type="video/mp4">
	       </video> 
    	</div>
    	<div class="parallax-mob-slider-outer padding-left">
    	    <div class="glide" id="parallax-list">
				<div class="glide__track" data-glide-el="track">
					<ul class="glide__slides">
					    <?php $l=1; while( have_rows('abt_sec6_listing') ): the_row(); ?>
						<li class="glide__slide">
							<div class="parallax-list-slide">
								<h3><?php the_sub_field('listing_title'); ?></h3>
								<?php the_sub_field('listing_content'); ?>
							</div>
						</li>
						<?php endwhile; ?>
					</ul>
				</div>
				<div class="glide__arrows" data-glide-el="controls">
				    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
				    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
			  </div>
			</div>
		</div>
	</section>
	<?php } else { ?>
	<section class="parallax-sec" style="background-image:url(<?php //echo get_field('listing_image')['url']; ?>)">
	     <video class="lazy" autoplay loop muted playsinline poster="<?php echo get_template_directory_uri(); ?>/assets/images/about-poster.png">
	        <source data-src="<?php echo $videolink; ?>" type="video/mp4">
	   </video> 
		<?php $l=1; while( have_rows('abt_sec6_listing') ): the_row(); 
		      if($l == 2):
				$animate_class= 'slideInRight';
			  else:
				$animate_class= 'slideInLeft';
			  endif;
		?> 
		<div class="parallax-content-area-outer">
			<div class="container">
				<div class="parallax-content-area wow <?php echo $animate_class; ?>">
			<h3 class="h1"><?php the_sub_field('listing_title'); ?></h3>
			<?php the_sub_field('listing_content'); ?>
				</div>
			</div>
		</div>
		<?php $l++; endwhile; ?>		
	</section>
	<?php } ?>
<?php endif; ?>

<?php elseif( get_row_layout() == 'management_team_section' ): ?>
	<section class="message-widget">
		<div class="message-widget-content">
			<div class="container">
				<div class="message-widget-content-inner">
					<h3 class="h2"><?php echo get_sub_field('management_heading'); ?></h3>
					<div class="quotes-area">
						<?php echo get_sub_field('abt_sec4_description'); ?>
						<?php if ( wp_is_mobile() ){ ?>
						<span class="ceo-name-mob">Martin (Chairman of IFZA)</span>
						<?php } ?>
					</div>
					<?php 
				$abt_sec4_button = get_sub_field('abt_sec4_button'); 
				if( $abt_sec4_button ): ?>
				<a href="<?php echo $abt_sec4_button['url']; ?>" class="btn-link" target="<?php echo $abt_sec4_button['target']; ?>"><?php echo $abt_sec4_button['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
				</div>
			</div>
		</div>
		<figure class="message-widget-image">
			<picture>
					<?php if( get_sub_field('management_image_webp') ){ ?><source srcset="<?php echo get_sub_field('management_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('abt_sec4_image') ){ ?><source srcset="<?php echo get_sub_field('abt_sec4_image')['url']; ?>" type="image/jpg"><?php } ?>
					<?php if( get_sub_field('abt_sec4_image') ){ ?><img src="<?php echo get_sub_field('abt_sec4_image')['url']; ?>" alt=image><?php } ?>
						</picture>
		</figure>
		<?php if ( wp_is_mobile() ){ ?>
		<figure class="mob-message-widget-image">
		    <picture>
				<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/ceo-image.webp" type="image/webp">
				<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/ceo-image.png" type="image/png">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/ceo-image.png" alt=image>
			</picture>
		</figure>
		<?php } ?>
	</section>
<?php elseif( get_row_layout() == 'bottom_banner_with_content' ): ?>
	<section class="bottom-banner">
								<figure>
									<picture>
									<?php if( get_sub_field('banner_webp') ){ ?><source srcset="<?php echo get_sub_field('banner_webp')['url']; ?>" type="image/webp"><?php } ?>
					               <?php if( get_sub_field('banner_jpg_image') ){ ?><source srcset="<?php echo get_sub_field('banner_jpg_image')['url']; ?>" type="image/jpg"><?php } ?>
				                	<?php if( get_sub_field('banner_jpg_image') ){ ?><img src="<?php echo get_sub_field('banner_jpg_image')['url']; ?>" alt=image><?php } ?>
											</picture>
											<?php $banner_link = get_sub_field('banner_link');  ?>
											<a href="<?php echo $banner_link['url'];?>"></a>
										</figure>
										<div class="bottom-banner-content">
											<div class="container">
												<div class="bottom-banner-inner">
													<h3 class="h2"><?php echo get_sub_field('title');?></h3>
													<p><?php echo get_sub_field('short_description');?></p>
													<?php $banner_link = get_sub_field('banner_link');  ?>
													<a href="<?php echo $banner_link['url'];?>"><?php echo $banner_link['title'];?><span class="arrow-img"></span></a>

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
	    var checkbox3 = document.querySelector('#options-rewind-checkbox3');
		var glide3 = new Glide('#parallax-list', {
		  //type: 'carousel',
		  perView:2.7,
		  draggable: true,
		  rewind: checkbox3.checked,
		  gap:0, 
		   breakpoints: {
		    1280: {
		      gap:0,
		      perView:3,
		    },
		    1199: {
		      gap:0,
		      perView: 2.4,
		    },
		    991: {
		      gap:0,
		      perView:1.8,
		    },
		    767: {
		      gap:0,
		      perView: 1.4,
		    },
		    641: {
		      gap:0,
		      perView: 1.1,
		    },
		    380: {
		      gap:0,
		      perView:1,
		    }
		  }
		});
		checkbox3.addEventListener('change', function () {
		  glide.update({
		    rewind: checkbox3.checked
		  })
		})
		glide3.mount();
});

</script>