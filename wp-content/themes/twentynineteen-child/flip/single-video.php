<link href="<?php echo get_template_directory_uri(); ?>/assets/css/blog.css?ver=2.5" rel="stylesheet">
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
	<section class="single-video-sec">
		<div class="container">
			<iframe width="100%" height="800" src="<?php echo get_field('youtube_video_url'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			   
			<div class="single-video-area">
				

				<!-- <figure>

					<a href="<?php the_field('youtube_video_url'); ?>" class="popup-youtube">
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
								<i class="fa-sharp fa-solid fa-play"></i>
							</a>
						</figure>
					</div>
				</div> -->
			</section>
			<section class="single-top-image-sec single-top-image-sec-3">
				<div class="container">
					<div class="single-top-image-inner">
						<div class="single-top-image-heading">
							<div class="single-top-heading-area">
								<h1 class="h2"><?php the_title(); ?></h1>
								<div class="single-date-share">
									<?php /* if(get_field('reading_time') != ''){ ?>
									<div class="single-date-area">
										<!-- <time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time> -->
											<time class="article-publish-time secondary_font"><strong><?php _e('Reading Time:'); ?></strong> <?php the_field('reading_time'); ?></time>
										</div><?php } */ ?>
										<?php get_template_part('template-parts/blog-share'); ?>
									</div>
								</div>
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</section>
				<?php if(get_field('related_videos')||get_field('latest_business_guides')) { ?>
				<section class="content-sidebar-sec content-sidebar-sec-2">
					<div class="container">
						<div class="content-sidebar-inner">


							<?php 

							$related_videos = get_field('related_videos');

							if ( $related_videos ){ ?>

								<div class="content-block-area">
									<h2 class="h4"><?php the_field('related_videos_title'); ?></h2>
									<ul class="videos-article-listing videos-article-list-view">

										<?php foreach( $related_videos as $post ){ 

											setup_postdata($post);

											$youtube_url = get_field('youtube_video_url');
											if($youtube_url!= ''){

												preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtube_url, $match);
												$youtubeId = $match[1];
												$videoDetail = getYouTubeDetails($youtubeId);
                                                        //echo "<pre>"; print_r($videoDetail); echo "</pre>";
												$publishedAt = $videoDetail['items'][0]['snippet']['publishedAt'];
												if(empty($urlTitle)): $urlTitle = $videoDetail['items'][0]['snippet']['title']; endif;
												if(empty($video_thumbnail)): $thumbnail = $videoDetail['items'][0]['snippet']['thumbnails']['maxres']['url']; else: $thumbnail = $video_thumbnail['url']; endif;
												$viewCount = $videoDetail['items'][0]['statistics']['viewCount'];
												$duration = $videoDetail['items'][0]['contentDetails']['duration']; 
												$duration_formatted = duration($duration );
											}



											?>
											<li>
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
																<i></i>
															<figcaption><?php echo $duration_formatted; ?></figcaption>
														</figure>
														<div class="video-article-list-content">
															<!-- <time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time> -->
																<h4 class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
																<p><?php echo wp_trim_words(get_field('short_description'),12,'') ?></p>
																<a href="<?php the_permalink(); ?>" class="read-more-btn"><?php echo get_field('read_more_button_text'); ?></a>
															</div>
																<a href="<?php the_permalink(); ?>" class="full-link"></a>
														</li>

													<?php
												  } ?>

												</ul>
											</div>


										<?php wp_reset_postdata();   } ?>



										<?php
										$latest_business_guides = get_field('latest_business_guides');
										if( $latest_business_guides ): ?>
											<div class="sidebar-area" id="fixed-outer">
												<div id="fixed-area">
													<div class="posts-widget-3">
														<h6><?php the_field('business_guide_title'); ?></h6>
														<ul>
															<?php foreach( $latest_business_guides as $post ): 

																setup_postdata($post); ?> 

																<li>
																	<figure>
																		<picture>
																			<?php $webp_image = get_field('webp_image');
																			if( !empty( $webp_image ) ): ?>
																				<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
																				<?php /* else: ?>
																					<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-363X514.jpg" type="image/webp">
																				<?php */ endif; ?>
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
															</div>
															<?php  
															wp_reset_postdata(); ?>
														<?php endif; ?>




													</div>
												</div>
											</section>
											<?php } ?>
											<?php get_template_part('template-parts/faqs'); ?>
											<?php get_template_part('template-parts/bottom-banner'); ?>
										</main>
										<?php get_footer(); ?>