<?php 
/**
* Template Name: Guide Single
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/blog.css?ver=1.0" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/dflip.min.css" rel="stylesheet" type="text/css">
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
	<section class="single-top-image-sec single-top-image-sec-4">
		<div class="single-top-image-inner padding-left">
				<div class="single-top-image-heading">
					<div class="single-top-heading-area">
						<?php if(get_field('guide_tag') != ''){ ?><span class="secondary_font"><?php the_field('guide_tag'); ?></span><?php } ?>
					<h1 class="h2"><?php the_title(); ?></h1>
						<?php the_field('short_description'); ?>
						<div class="single-date-share">
							<div class="single-date-area">
								<!-- <time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time> -->
									<?php if(get_field('reading_time') != ''){ ?><time class="article-publish-time secondary_font"><strong><?php _e('Reading Time:'); ?></strong> <?php the_field('reading_time'); ?></time><?php } ?>	
								</div>
							</div>
							<?php if(get_field('download_file') !=''){ ?><a href="#guide-popup" class="btn-link open-popup-link"><?php echo get_field('read_more_button_text'); ?><span class="arrow-img"></span></a><?php } ?>
						</div>
				</div>
			</div>
		<div class="single-right-image-box">
					<figure>
							<picture>
								<?php 
								$webp_image = get_field('webp_image');
								if( !empty( $webp_image ) ): ?>
									<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
									<?php endif; ?>

									<?php 
									$jpg_image = get_field('post_image');
									if( !empty( $jpg_image ) ): ?>
										<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">																
										<?php endif; ?>

										<?php 
										$jpg_image = get_field('post_image');
										if( !empty( $jpg_image ) ): ?>
											<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
										<?php endif; ?>
									</picture>
					</figure>
				</div>
	</section>
	<section class="file-view-flip-sec">
		<div class="container">
			<div class="file-detail-view-area">
				<div class="file-detail-left <?php if( have_rows('technical_details') ==''){ ?>full-width<?php } ?>">
					<?php if(get_field('technical_title_left') != ''){ ?><h4><?php the_field('technical_title_left'); ?></h4><?php } ?>
					<?php the_field('technical_details_left'); ?>
				</div>
				<?php if( have_rows('technical_details') ): ?>
					<div class="file-detail-right">
						<h4><?php the_field('technical_title'); ?></h4>
						<table class="file-detail-table">
							<?php while( have_rows('technical_details') ): the_row(); ?>
								<tr>
									<td><?php the_sub_field('technical_title'); ?></td>
									<td><?php the_sub_field('technical_detail'); ?></td>
								</tr>
							<?php endwhile; ?>
						</table>
					</div>
				<?php endif; ?>
			</div>
			</div>
				<?php if(get_field('download_file') !=''){ ?>
						<div class="flip-book-section">
							<div class="container">
								<div class="flip-book-container">
									<div class="flip-book-text">
										<h3><?php the_field('download_file_title'); ?></h3>
										<?php the_field('download_file_description'); ?>
									</div>
									<!--Normal FLipbook-->
									<div class="_df_book" webgl="true" backgroundcolor="#F3F4F5" source="<?php the_field('download_file_preview'); ?>" id="df_manual_book">
									</div>
								</div>
								<a href="#guide-popup" class="btn-link open-popup-link"><?php echo get_field('read_more_button_text'); ?><span class="arrow-img"></span></a>
							</div>
						</div>
					<?php } ?>
	</section>
	<?php if( have_rows('banner_center_details') ): ?>
					<?php while( have_rows('banner_center_details') ): the_row(); 
						$banner_webp = get_sub_field('banner_webp');
						$banner_jpg_image = get_sub_field('banner_jpg_image');
						if( !empty( $banner_webp )  || !empty( $banner_jpg_image ) ): ?>

							<section class="image-bg-text-top image-bg-text-top-single">
								<figure>
									<picture>
										<?php 
										$banner_webp = get_sub_field('banner_webp');
										if( !empty( $banner_webp ) ): ?>
											<source srcset="<?php echo esc_url($banner_webp['url']); ?>" alt="<?php echo esc_attr($banner_webp['alt']); ?>" type="image/webp">
											<?php endif; ?>

											<?php 
											$banner_jpg_image = get_sub_field('banner_jpg_image');
											if( !empty( $banner_jpg_image ) ): ?>
												<source srcset="<?php echo esc_url($banner_jpg_image['url']); ?>" alt="<?php echo esc_attr($banner_jpg_image['alt']); ?>" type="image/jpg">
												<?php endif; ?>

												<?php 
												$banner_jpg_image = get_sub_field('banner_jpg_image');
												if( !empty( $banner_jpg_image ) ): ?>
													<img src="<?php echo esc_url($banner_jpg_image['url']); ?>" alt="<?php echo esc_attr($banner_jpg_image['alt']); ?>">
												<?php endif; ?>
											</picture>

											<figcaption>
												<div class="container">
													<div class="image-bg-text-top-content">
														<h3><?php the_sub_field('banner_title'); ?></h3>
														<p><?php the_sub_field('banner_short_description'); ?></p>
														<?php 
														$banner_link = get_sub_field('banner_link');
														if( $banner_link ): 
															$link_url = $banner_link['url'];
															$link_title = $banner_link['title'];
															$link_target = $banner_link['target'] ? $banner_link['target'] : '_self';
															?>
															<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><span class="arrow-img"></span></a>
														<?php endif; ?>
													</div>
												</div>
											</figcaption>
										</figure>

									</section>
								<?php endif; ?>

							<?php endwhile; ?>
						<?php endif; ?>


						<?php get_template_part('template-parts/faqs'); ?>
						<?php get_template_part('template-parts/bottom-banner'); ?>

	<div class="popup-area popup-area-2 mfp-hide" id="guide-popup">
		<div class="download-popup-banner">
			<figure class="download-book">
					<picture>
								<?php 
								$webp_image = get_field('webp_image');
								if( !empty( $webp_image ) ): ?>
									<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
									<?php endif; ?>

									<?php 
									$jpg_image = get_field('post_image');
									if( !empty( $jpg_image ) ): ?>
										<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">																
										<?php endif; ?>

										<?php 
										$jpg_image = get_field('post_image');
										if( !empty( $jpg_image ) ): ?>
											<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
										<?php endif; ?>
									</picture>
			</figure>
			<div class="download-popup-heading">			
					<h3 class="h2"><?php the_title(); ?></h3>					
						<?php if (get_field('gu_content','options')){ ?>
				 				<?php  the_field('gu_content','options'); ?>
						<?php } else { ?>
								 <?php  the_field('short_description'); ?>
						<?php } ?>				 
			</div>
		</div>
		<div class="download-popup-form">
			<?php echo do_shortcode('[contact-form-7 id="1535" title="Download File"]'); ?>
		
		</div>
	</div>
</main>
							<?php get_footer(); ?>
							<script src="<?php echo get_template_directory_uri(); ?>/assets/js/dflip.js" type="text/javascript"></script>
							<script type="text/javascript">

								jQuery( document ).ready(function() {
									jQuery('#download_file').val('<?php the_field('download_file'); ?>');
									jQuery('#download_name').val('<?php the_title(); ?>');
								}); 
								document.addEventListener( 'wpcf7mailsent', function( event ) {
									url = jQuery('#download_file').val();
									//window.open(url, '_blank');
									window.location.href = '<?php echo home_url(); ?>/thank-you/?formid=<?php echo get_the_ID(); ?>';
									
								}, false );
							</script>