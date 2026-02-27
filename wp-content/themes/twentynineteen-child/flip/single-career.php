<link href="<?php echo get_template_directory_uri(); ?>/assets/css/single-career.css" rel="stylesheet">
<?php get_header()?>
<?php $careerPage = 51; ?>
<main>
	<section class="detail-content-sec">
		<figure>
			<picture>
				<?php 
				$career_webp_banner = get_field('career_webp_banner');
				if( !empty( $career_webp_banner ) ): ?>
					<source srcset="<?php echo esc_url($career_webp_banner['url']); ?>" alt="<?php echo esc_attr($career_webp_banner['alt']); ?>" type="image/webp">
					<?php endif; ?>

					<?php 
					$career_banner = get_field('career_banner');
					if( !empty( $career_banner ) ): ?>
						<source srcset="<?php echo esc_url($career_banner['url']); ?>" alt="<?php echo esc_attr($career_banner['alt']); ?>" type="image/jpg">
						<?php endif; ?>

						<?php 
						$career_banner = get_field('career_banner');
						if( !empty( $career_banner ) ): ?>
							<img src="<?php echo esc_url($career_banner['url']); ?>" alt="<?php echo esc_attr($career_banner['alt']); ?>">
						<?php endif; ?>
					</picture>
				</figure>
				<div class="detail-content-inner">
					<h1 class="h2"><?php the_title(); ?></h1>
					<div class="detail-share-time">
						<div class="detail-time-widget">
							<span><?php _e('Date Posted'); ?>:</span> <time><?php echo date('F j, Y', strtotime(get_the_date())); ?></time>
						</div>
						<div class="detail-social-media-outer">
							<span><?php _e('Share'); ?>:</span>
							<?php
							$wplogoutURL = urlencode(get_the_permalink());
							$wplogoutTitle = urlencode(get_the_title());
							$wplogoutImage= urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full'));
							?>
							<ul class="detail-social-media">
								<li><a href="https://api.whatsapp.com/send?text=<?php echo $wplogoutTitle; echo " "; echo $wplogoutURL;?>" data-action="share/whatsapp/share" target="_blank" rel="nofollow"> <i class="fa-brands fa-whatsapp"></i></a></li>
								<li><a  href="mailto:?subject=<?php echo $wplogoutTitle; ?>&amp;body=<?php echo $wplogoutURL; ?>" target="_blank" rel="nofollow"><i class="fa-regular fa-envelope"></i></a></li>
								<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $wplogoutURL; ?>" target="_blank" rel="nofollow"><i class="fa-brands fa-facebook-f"></i></a></li>
								<li><a href="https://www.linkedin.com/shareArticle?url=<?php echo $wplogoutURL; ?>&amp;title=<?php echo $wplogoutTitle; ?>&amp;mini=true" target="_blank" rel="nofollow"><i class="fa-brands fa-linkedin-in"></i></a></li>
							</ul>
						</div>
					</div>
					<h6 class="secondary_font"><?php the_field('description_title'); ?></h6>
					<?php the_field('description'); ?>
					<a href="#" class="btn-link"><?php _e('Apply on this page'); ?><span class="arrow-img"></span></a>
					<a href="<?php if(get_field('linkedin_url') == ''){ echo "#."; }else{ the_field('linkedin_url'); } ?>" class="btn-link"><?php _e('Apply on Linkedin'); ?><span class="arrow-img"></span></a>
					
				</div>
			</section>
				<?php // flexible
if( have_rows('careers_details_page') ): ?>
    <?php while( have_rows('careers_details_page') ): the_row(); ?>
	
	
		
	<?php if( get_row_layout() == 'other_details' ): ?>
			<section class="detail-content-sec more-details">
			<div class="detail-content-inner">
				<h6 class="secondary_font"><?php echo get_sub_field('overview_title'); ?></h6>
					<?php echo get_sub_field('overview_content'); ?>
			</div>
					
		</section>
	<?php elseif( get_row_layout() == 'become_a_part_of_the_team' ): ?>

		<section class="form-sec">
				<figure>
					<picture>
						<?php 
						$webp_image = get_sub_field('webp_team_image');
						if( !empty( $webp_image ) ): ?>
							<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
							<?php endif; ?>

							<?php 
							$jpg_image = get_sub_field('team_image');
							if( !empty( $jpg_image ) ): ?>
								<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
								<?php endif; ?>

								<?php 
								$jpg_image = get_sub_field('team_image');
								if( !empty( $jpg_image ) ): ?>
									<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
								<?php endif; ?>
							</picture>
							<div class="form-outer-area">
								<h3 class="h2"><?php the_sub_field('team_title'); ?></h3>
								<?php the_sub_field('team_description'); ?>
								<?php echo do_shortcode('[contact-form-7 id="330" title="Become Part of the Team"]'); ?>
							</figure>
						</section>

		<?php elseif( get_row_layout() == 'more_jobs' ): ?>

		<section class="banner-widget-small">
							<div class="container">
								<div class="banner-widget-small-inner">
									<div class="banner-widget-small-content">
										<span><?php the_sub_field('career_caption'); ?></span>
										<h3><?php the_sub_field('career_title'); ?></h3>
										<?php 
										$link = get_sub_field('career_button');
										if( $link ): 
											$link_url = $link['url'];
											$link_title = $link['title'];
											$link_target = $link['target'] ? $link['target'] : '_self';
											?>
											<a class="btn-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><span class="arrow-img"></span></a>
										<?php endif; ?>


									</div>
									<div class="banner-widget-small-image">
										<figure>
											<picture>
												<?php 
												$webp_image = get_sub_field('career_webp_image');
												if( !empty( $webp_image ) ): ?>
													<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
													<?php endif; ?>

													<?php 
													$jpg_image = get_sub_field('career_image');
													if( !empty( $jpg_image ) ): ?>
														<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
														<?php endif; ?>

														<?php 
														$jpg_image = get_sub_field('career_image');
														if( !empty( $jpg_image ) ): ?>
															<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
														<?php endif; ?>
													</picture>
												</figure>
											</div>
										</div>
									</div>
								</section>
<?php endif; ?>
    <?php endwhile; ?>
<?php endif; // flexible?>
	

			

						
							</main>

							<?php get_footer(); ?>

							<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js'></script>
							<script type="text/javascript">
								function formatState (state) {
									if (!state.id) { return state.text; }
									var $state = jQuery(
										'<span><img src="' + jQuery(state.element).attr('data-src') + '" class="img-flag" /> ' + state.text + '</span>'
										);
									return $state;
								};
								jQuery('.country-select-inq select').select2({
									minimumResultsForSearch: Infinity,
									templateResult: formatState,
									templateSelection: formatState
								});
							</script>

