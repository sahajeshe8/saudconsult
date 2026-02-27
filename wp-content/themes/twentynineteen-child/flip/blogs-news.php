<?php 
/**
* Template Name: Blog News
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
			
			<div class="banner-two-content">
				<h1 class="h2"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
			
		</div>
	</section>
							<?php 

							$i = 0;

							$args = array(
								'post_status'     => array('publish'),
								'post_type'       => array('post'),
								'orderby'         => 'date',
								'order'           => 'DESC',
								'paged'           => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
								'cat'             => $get_queried_object_id,
							//	'posts_per_page' => 11,

							);


							$the_query = new WP_Query( $args );

							if ( $the_query->have_posts() ){ ?>
							
	<?php  while ( $the_query->have_posts() ){
						$the_query->the_post(); 
					//	$latestPost = get_the_ID();
							$i = $i+1;
					if($i==0){ 
						?>
		<section class="first-article-sec">
			<div class="container">
				<div class="first-article-inner">
					
						<figure>
							<picture>

								<?php $webp_image = get_field('webp_image');
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
											<?php else: 	
											$content = get_the_content();
											$first_image = '';

											if (preg_match('/<img.+?src="(.+?)"/', $content, $matches)) {
											$first_image = $matches[1];
											}
									
											if (!empty( $first_image )) {
													//	var_dump($first_image);
											// Display the first image
												echo '<source srcset="' . $first_image . '" alt=""  type="image/jpg">';
												echo '<img src="' . $first_image . '" alt="">';
											} else {
												echo '<source srcset="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt=""  type="image/jpg">';
												echo '<img src="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="">';
												
											}
												endif; ?>


									</picture>

								</figure>
								<div class="first-article-content">
									<time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time>
										<h4 class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<?php if( get_field('short_description')): ?>
																<p><?php echo wp_trim_words(get_field('short_description'),12,'...') ?></p>
																<?php else: 	
																$content = get_the_content();
																$first_paragraph = '';

																// Use wp_trim_words() to extract the first paragraph
																$first_paragraph = wp_trim_words( $content,12,'...');

																if ($first_paragraph) {
																	// Display the first paragraph
																	echo '<p>' . $first_paragraph . '</p>';
																}
																endif; ?>

									

										<a href="<?php the_permalink(); ?>" class="read-more-btn"><?php echo get_field('read_more_button_text'); ?></a>
										
									</div>
									<a href="<?php the_permalink(); ?>" class="full-link"></a>
								
							</div>
						</div>
					</section>
					<?php } else { ?>

					<?php if($i==1): ?>
						<section class="content-sidebar-sec">
					<div class="container">
						<div class="content-sidebar-inner">

								<div class="content-block-area">

									<h2 class="h4">Latest news</h2>
									<div class="posts-listing">

										<?php endif; ?>

											<article>
											    <a href="<?php the_permalink(); ?>" class="full-link"></a>
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
															<?php else: 	
															$content = get_the_content();
															$first_image = '';

															if (preg_match('/<img.+?src="(.+?)"/', $content, $matches)) {
															$first_image = $matches[1];
															}

															if (!empty( $first_image )) {														
															// Display the first image
																echo '<source srcset="' . $first_image . '" alt=""  type="image/jpg">';
																echo '<img src="' . $first_image . '" alt="">';
															} else {
																echo '<source srcset="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt=""  type="image/jpg">';
																echo '<img src="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="">';
																
															}
															 endif; ?>
															</picture>
														</figure>
														<div class="post-list-content">
															<time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time>
															<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
															<?php if( get_field('short_description')): ?>
																<p><?php echo wp_trim_words(get_field('short_description'),12,'...') ?></p>
																<?php else: 	
																$content = get_the_content();
																$first_paragraph = '';

																// Use wp_trim_words() to extract the first paragraph
																$first_paragraph = wp_trim_words( $content,12,'...');

																if ($first_paragraph) {
																	// Display the first paragraph
																	echo '<p>' . $first_paragraph . '</p>';
																}
																endif; ?>
																<a href="<?php the_permalink(); ?>" class="read-more-btn"><?php echo get_field('read_more_button_text'); ?></a>
															</div>
														</article>

												


											<?php 
											/*
$numberOfPosts=$the_query->found_posts;
 $numberOfPosts;
										echo $i;	
											if($i==11){ ?>	</div><?php }  */?>


					<?php } 
	} //qeury if
					?>


	</div>

												<div class="numbers-pagination">


													<?php
													$big = 999999999;
													echo paginate_links( array(
														'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
														'format' => '?paged=%#%',
														'current' => max( 1, get_query_var('paged') ),
														'total' => $the_query->max_num_pages,
														'prev_text' => '&laquo;',
														'next_text' => '&raquo;'
													) ); 
													wp_reset_postdata(); ?>

												</div>






											</div>



											<?php 
										} else {

											get_template_part( 'template-parts/content/content', 'none' );

										}
										?>
					
										<div class="sidebar-area" id="fixed-outer">
											<div id="fixed-area">

												<?php
												$popular_articles = get_field('popular_articles');
												if( $popular_articles ): ?>
													<h3 class="h4"><?php the_field('popular_articles_title'); ?></h3>
													<div class="posts-widget-1 single-posts-widget-1">
														<?php foreach( $popular_articles as $post ): 

															setup_postdata($post); ?> 
															<article>
																<a href="<?php the_permalink(); ?>"><p><?php the_title(); ?></p><i class="fa-solid fa-arrow-right"></i></a>
																
															</article>
														<?php endforeach; ?>
													</div>
													<?php  
													wp_reset_postdata(); ?>
												<?php endif; ?>


												<?php
												$latest_business_guides = get_field('latest_business_guides');
												if( $latest_business_guides ): ?>
													<div class="posts-widget-2">
														<h4><?php the_field('latest_business_guides_title'); ?></h4>
														<ul class="image-content-article">
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
																							<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-363X514.jpg" type="image/jpg">
																							<?php endif; ?>

																							<?php 
																							$jpg_image = get_field('post_image');
																							if( !empty( $jpg_image ) ): ?>
																								<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
																							<?php else: ?>
																								<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-363X514.jpg" alt="image">
																							<?php endif; ?>
																						</picture>
																					</figure>
																					<div class="image-content-article-content">
																						<p><?php the_title(); ?></p>
																						<a href="<?php the_permalink(); ?>" class="btn-download"><?php echo get_field('read_more_button_text'); ?></a>
																					</div>
																					<a href="<?php the_permalink(); ?>" class="full-link"></a>
																				</li>
																			<?php endforeach; ?>
																		</ul>
																	</div>
																	<?php  
																	wp_reset_postdata(); ?>
																<?php endif; ?>


															</div>
														</div>
													</div>
												</div>
											</section>
											

											<?php get_template_part('template-parts/bottom-banner'); ?>

										</main>
										<?php get_footer(); ?>