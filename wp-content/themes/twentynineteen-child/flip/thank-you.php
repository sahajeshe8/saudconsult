<?php 
/**
* Template Name: Thank you
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/blog.css?ver=1.0" rel="stylesheet">
<?php get_header()?>
<main>
	<section class="banner-two">
		<div class="container">
			<div class="banner-menu-search">
				<nav>
					<?php
					wp_nav_menu( array(
						'menu'   => 'Blog Menu',
						'container' => 'ul',
						'menu_class' => 'banner-main-menu'
					) );
					?>
				</nav>
				<?php get_template_part('template-parts/blog-search'); ?>
			</div>
		</div>
	</section>
	<section class="thanks-content-sec">
		<div class="container">
			<h1><?php echo get_field('title-msg'); ?></h1>
			
			<h3><?php echo get_field('title_content'); ?> <?php if(!empty($_GET['formid'])){ echo get_the_title($_GET['formid']); }?></h3>
		</div>
	</section>
	<?php
	$latest_business_guides = get_field('latest_business_guides');
	if( $latest_business_guides ): ?>
	<section class="content-sec-25">
		<div class="container">
			<div class="content-sec-25-inner">
				<div class="content-sec-25-inner-heading">
					<h3><?php echo get_field('business_guide_title'); ?></h3>
					<?php echo get_field('business_guide_content'); ?>
				</div>
				<?php 
				$business_guide_link = get_field('business_guide_link');
				if( $business_guide_link ): 
					$link_url = $business_guide_link['url'];
					$link_title = $business_guide_link['title'];
					$link_target = $business_guide_link['target'] ? $business_guide_link['target'] : '_self';
					?>
					<a class="btn-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><span class="arrow-img"></span></a>
				<?php endif; ?>
			</div>
			<ul class="image-content-article">
				<?php foreach( $latest_business_guides as $post ): 

																setup_postdata($post); ?> 
				<li>
					<figure>
						<picture>
							<?php $webp_image = get_field('webp_image');
							if( !empty( $webp_image ) ): ?>
								<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
								<?php else: ?>
									<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-363X514.jpg" type="image/webp">
									<?php endif; ?>
									<?php 
									$jpg_image = get_field('post_image');
									if( !empty( $jpg_image ) ): ?>
										<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
										<?php else: ?>
											<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/guide.jpg" type="image/jpg">
											<?php endif; ?>

											<?php 
											$jpg_image = get_field('post_image');
											if( !empty( $jpg_image ) ): ?>
												<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
											<?php else: ?>
												<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/guide.jpg" alt="image">
											<?php endif; ?>
										</picture>
					</figure>
					<div class="image-content-article-content">
					
						<h4><?php the_title(); ?></h4>
						<p><?php echo wp_trim_words(get_field('short_description'),12,'...') ?></p>
					<a href="<?php the_permalink(); ?>" class="btn-download"><i class="fa-solid fa-arrow-down"></i><?php echo get_field('read_more_button_text'); ?></a>
					</div>
					<a href="<?php the_permalink(); ?>" class="full-link"></a>
				</li>
				<?php endforeach; ?>
				
			</ul>
		</div>
	</section>
	
	<?php  
		wp_reset_postdata(); ?>
	<?php endif; ?>
	<?php if(!empty($_GET['formid'])){ ?>
	<a id="pdffile" href="<?php echo get_field('download_file',$_GET['formid']); ?>" download style="display:none;"> Download file</a>
	<?php } ?>
</main>
<?php get_footer(); ?>
<script>
	window.onload = function() {
  setTimeout(function() {
    // Code to be executed after a delay
    console.log('Delayed code executed');
	document.getElementById("pdffile").click();
  }, 5000); // Delay time in milliseconds (2000ms = 2 seconds)
};


// 	jQuery(document).ready(function() {
// 		jQuery('#pdffile').trigger('click');

// });
</script>


