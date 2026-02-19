<?php 
/**
* Template Name: Blog Single
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
	<section class="single-top-image-sec">
		<div class="container">
			<div class="single-top-image-inner">
				<div class="single-top-image-heading">
					<?php if( !empty( get_field('post_image') ) ){ ?>
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
<?php }  ?>
					<div class="single-top-heading-area">
						<h1 class="h2"><?php the_title(); ?></h1>
						<?php the_field('short_description'); ?>
						<div class="single-date-share">
							<div class="single-date-area">
										<time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong><?php echo date('F jS, Y',strtotime(get_the_date())); ?></time>
											<?php if(get_field('reading_time') != ''){ ?><time class="article-publish-time secondary_font"><strong><?php _e('Reading Time:'); ?></strong><?php the_field('reading_time'); ?></time><?php } ?>
										</div>
							<?php get_template_part('template-parts/blog-share'); ?>
						</div>
					</div>
					<div class="single-blog-guide-section">
						<div class="single-content-widget-inner">
							<?php
							$latest_business_guides = get_field('latest_business_guides');
							if( $latest_business_guides ): ?>
								<div class="single-widget-left">
									<div class="posts-widget-3">
										<h4><?php the_field('business_guide_title'); ?></h4>
										<ul>
											<?php foreach( $latest_business_guides as $post ): 

												setup_postdata($post); ?> 

												<li>
													<figure>
														<picture>
															<?php 
															$jpg_image = get_field('post_image');
															if( !empty( $jpg_image ) ): ?>
																<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
																<?php /* else: ?>
																	<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-363X514.jpg" type="image/jpg">
																<?php */ endif; ?>

																	<?php 
																	$jpg_image = get_field('post_image');
																	if( !empty( $jpg_image ) ): ?>
																		<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
																	<?php else: ?>
																		<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-363X514.jpg" alt="image">
																	<?php endif; ?>
																</picture>
															</figure>
															<div class="single-guide-content">
																<h6><?php the_title(); ?></h6>
																<a href="<?php the_permalink(); ?>" class="btn-download"><i class="fa-solid fa-arrow-down"></i><?php echo get_field('read_more_button_text'); ?></a>
															</div>
															<a href="<?php the_permalink(); ?>" class="full-link"></a>
														</li>

													<?php endforeach; ?>
												</ul>
											</div>
										</div>
										<?php  
										wp_reset_postdata(); ?>
									<?php endif; ?>

							<div class="single-content-center">
								<?php if( have_rows('blog_content') ): ?>
								<?php while( have_rows('blog_content') ): the_row();  ?>               
									<h4><?php the_sub_field('blg_title'); ?></h4>   
									<?php the_sub_field('blg_content'); ?>    
								<?php endwhile; ?>
								<?php else: ?>
								<?php the_content(); ?>
								<?php endif; ?>


							</div>

						</div>
					</div>
				</div>
				<?php
					$latest_related_topic = get_field('latest_related_topic');
					if( $latest_related_topic ): ?>
				<div class="single-widget-listing" id="fixed-outer">
					<div id="fixed-area">
						<h6><?php the_field('related_topic_title'); ?></h6>
						<div class="posts-widget-1 single-posts-widget-1">
							<?php foreach( $latest_related_topic as $post ): 

								setup_postdata($post); ?> 
								<article>
									<a href="<?php the_permalink(); ?>"><p><?php the_title(); ?></p>
									<i class="fa-solid fa-arrow-right"></i></a>
								</article>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
					<?php  
						wp_reset_postdata(); ?>
							<?php endif; ?>
			</div>
		</div>
	</section>

<?php
						$recent_news = get_field('recent_news');
						if( $recent_news ): ?>

							<section class="related-posts-sec">
								<div class="container">
									<h3><?php the_field('recent_news_title'); ?></h3>
											<ul class="single-related-posts">
												<?php foreach( $recent_news as $post ): 

													setup_postdata($post); ?> 

													<li>
														<figure class="related-post-image">
															<a href="<?php the_permalink($post->ID); ?>">
																<picture>
																	<?php 
																	$webp_image = get_field('webp_image',$post->ID);
																	if( !empty( $webp_image ) ): ?>
																		<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
																		<?php endif; ?>

																		<?php 
																		$jpg_image = get_field('post_image',$post->ID);
																		if( !empty( $jpg_image ) ): ?>
																			<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">																
																			<?php endif; ?>

																			<?php 
																			$jpg_image = get_field('post_image',$post->ID);
																			if( !empty( $jpg_image ) ): ?>
																				<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
																			<?php endif; ?>
																		</picture>
																	</a>
																</figure>
																<div class="related-post-content">
																	<time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time>
																		<h6><a href="<?php the_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h6>
																	</div>
																	<a href="<?php the_permalink($post->ID); ?>" class="full-link"></a>
																</li>
															<?php endforeach; ?>
														</ul>
											</div>
										</section>
										<?php  
										wp_reset_postdata(); ?>
									<?php endif; ?>


	<?php get_template_part('template-parts/bottom-banner'); ?>
</main>
<?php get_footer(); ?>
<!--<script type="text/javascript">
jQuery(document).ready(function() {
	new Glide('#related-posts', {
		type: 'carousel',
		perView: 4,
		draggable: true,
		gap: 25,
		breakpoints: {
			600: {
				perView: 2,
				gap: 10,
			},
			1024: {
				perView: 3,
				gap: 15,
			},
		}
	}).mount();
});

</script>-->