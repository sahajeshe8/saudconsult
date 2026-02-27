<link href="<?php echo get_template_directory_uri(); ?>/assets/css/blog.css" rel="stylesheet">
<?php get_header()?>
<?php 
if(is_archive()){ 
	$get_queried_object = get_queried_object(); 
	$get_queried_object_id = get_queried_object_id();
	$page_link = get_term_link($get_queried_object);
}else{
	$get_queried_object_id = 8; 
	$get_queried_object = get_term_by('term_id', $get_queried_object_id, 'category');
	$page_link = site_url('/blog-news/');
}

?>
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
				<h1 class="h2"><?php echo $get_queried_object->name ?></h1>
				<?php echo term_description($get_queried_object_id,$get_queried_object->taxonomy)?> 
			</div>
			
		</div>
	</section>

	<?php 

	$i = $i+1;

	$args = array(
		'post_status'     => array('publish'),
		'post_type'       => array('post'),
		'orderby'         => 'date',
		'order'           => 'DESC',
		'cat'             => $get_queried_object_id,
		'posts_per_page' => 1,

	);


	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ){ ?>
		<section class="first-article-sec">
			<div class="container">
				<div class="first-article-inner">
					<?php  while ( $the_query->have_posts() ){
						$the_query->the_post(); 
						$latestPost = get_the_ID();
						?>
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
										<?php endif; ?>


									</picture>

								</figure>
								<div class="first-article-content">
									<time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time>
									<h1 class="h4"><?php the_title(); ?></h1>
									<p><?php echo wp_trim_words(get_field('short_description'),12,'') ?></p>

									<?php  if($get_queried_object_id == 9){  ?>
										<a href="<?php if(get_field('download_file') == ''){ echo "#."; }else{ the_field('download_file'); } ?>" class="btn-download" <?php if(get_field('download_file') != ''){ ?> target="_blank" <?php } ?> ><i class="fa-solid fa-arrow-down"></i><?php _e('Download the guide'); ?></a>
									<?php }else if($get_queried_object_id == 11){  ?>
										<a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('Read More'); ?></a>
									<?php }else{ ?>
										<a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('Read this article...'); ?></a>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</section>
			<?php } ?>

			<section class="content-sidebar-sec">
				<div class="container">
					<div class="content-sidebar-inner">

						<?php 

						$i = $i+1;

						$args = array(
							'post_status'     => array('publish'),
							'post_type'       => array('post'),
							'orderby'         => 'date',
							'order'           => 'DESC',
							'paged'           => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
							'cat'             => $get_queried_object_id,
							'post__not_in'    => array($latestPost),

						);


						$the_query = new WP_Query( $args );

						if ( $the_query->have_posts() ){ ?>


							<div class="content-block-area">


								<h2 class="h4">Latest news</h2>
								<div class="posts-listing">

									<?php  while ( $the_query->have_posts() ){
										$the_query->the_post(); 
										?>

										<article>
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
													<div class="post-list-content">
														<time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time>
														<h4><?php the_title(); ?></h4>
														<p><?php echo wp_trim_words(get_field('short_description'),12,'') ?></p>
														<a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('Read this article...'); ?></a>
													</div>
												</article>

											<?php  } ?>


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

										$i = $i+1;

										$args = array(
											'post_status'     => array('publish'),
											'post_type'       => array('post'),
											'orderby'         => 'date',
											'order'           => 'DESC',
											'cat'             => 8,
											'posts_per_page'  => 3,

										);


										$the_query = new WP_Query( $args );

										if ( $the_query->have_posts() ){ ?>

											<h3 class="h4">popular articles</h3>
											<div class="posts-widget-1">
												<?php  while ( $the_query->have_posts() ){
													$the_query->the_post(); 
													?>

													<article>
														<p><?php echo wp_trim_words(get_field('short_description'),16,'') ?></p>
														<a href="<?php the_permalink(); ?>" class="read-more-btn"><?php _e('Read this article...'); ?></a>
													</article>
												<?php  }   ?>
											</div>



										<?php  }   ?>




										<?php 

										$i = $i+1;

										$args = array(
											'post_status'     => array('publish'),
											'post_type'       => array('post'),
											'orderby'         => 'date',
											'order'           => 'DESC',
											'cat'             => 9,
											'posts_per_page' => 3,

										);


										$the_query = new WP_Query( $args );

										if ( $the_query->have_posts() ){ ?>
											<div class="posts-widget-2">
												<h4>Latest <br>Business guides</h4>
												<ul class="image-content-article">
													<?php  while ( $the_query->have_posts() ){
														$the_query->the_post(); 
														$latestPost = get_the_ID();
														?>

														<li>
															<figure>
																<picture>
																	<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/guide-1.webp" type="image/webp">
																		<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/guide-1.jpg" type="image/jpg">
																			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/guide-1.jpg" alt=image>
																		</picture>
																	</figure>
																	<div class="image-content-article-content">
																		<p><?php the_title(); ?></p>
																		<a href="<?php if(get_field('download_file') == ''){ echo "#."; }else{ the_field('download_file'); } ?>" class="btn-download"><?php _e('Download the guide'); ?></a>
																	</div>
																</li>

															<?php } ?>
														</ul>
													</div>
												<?php } ?>


											</div>
										</div>
									</div>
								</div>
							</section>
							<section class="bottom-banner">
								<figure>
									<picture>
										<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/how-may-help.webp" type="image/webp">
											<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/how-may-help.jpg" type="image/jpg">
												<img src="<?php echo get_template_directory_uri(); ?>/assets/images/how-may-help.jpg" alt=image>
											</picture>
										</figure>
										<div class="bottom-banner-content">
											<div class="container">
												<div class="bottom-banner-inner">
													<h3 class="h2">How can we help you?</h3>
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt</p>
													<a href="#">Get in touch<span class="arrow-img"></span></a>

												</div>
											</div>
										</div>
									</section>
								</main>
								<?php get_footer(); ?>