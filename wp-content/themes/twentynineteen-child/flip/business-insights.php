<?php 
/**
* Template Name: Business Insights
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/blog.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<main>
<div style="display:none">
<input type="chekbox" id="options-rewind-checkboxg" name="">
<input type="chekbox" id="options-rewind-checkboxb" name="">
</div>
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

	if( have_rows('featured_articles') ):

		while ( have_rows('featured_articles') ) : the_row();
		
		if( get_row_layout() == 'latest_articles' ):  ?>


	<section class="content-sec-21">
		<?php if ( wp_is_mobile() ){ ?>
			<div class="glide" id="guides-slider-mob">
				<div class="glide__track" data-glide-el="track">	
			      <ul class="glide__slides">
					<?php
						$featured_guide = get_sub_field('featured_guide');
						if( $featured_guide ): ?>
						<?php $select_guide = $featured_guide['select_guide'];?>
			        <li class="glide__slide">
			        		<div class="black-bg-imgae-content">
								<figure class="black-bg-image">
									<picture>
							<?php $webp_image = get_field('webp_image',$select_guide->ID);				
							$frg_webp_image = $featured_guide['guide_webp_image'];				
										if( !empty( $webp_image ) ): ?>
										<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
										<?php elseif(!empty($frg_webp_image)): ?>
								<source srcset="<?php echo esc_url($frg_webp_image['url']); ?>" alt="<?php echo esc_attr($frg_webp_image['alt']); ?>" type="image/webp">
										<?php endif; ?>
								<?php 
							$jpg_image = get_field('post_image',$select_guide->ID);
								$frg_image = $featured_guide['guide_image'];	
								if( !empty( $jpg_image ) ): ?>
									<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
									<?php elseif( !empty( $frg_image ) ): ?>
									<source srcset="<?php echo esc_url($frg_image['url']); ?>" alt="<?php echo esc_attr($frg_image['alt']); ?>" type="image/jpg">
									<?php else: ?>
										<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/jpg">
									<?php endif; ?>

								<?php 
								$jpg_image = get_field('post_image',$select_guide->ID);
								$frg_image = $featured_guide['guide_image'];	
								if( !empty( $jpg_image ) ): ?>
									<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
									<?php elseif( !empty( $frg_image ) ): ?>
							<img src="<?php echo esc_url($frg_image['url']); ?>" alt="<?php echo esc_attr($frg_image['alt']); ?>">
								<?php else: ?>
									<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="image">
								<?php endif; ?>
							</picture>
								</figure>
								<div class="black-bg-content">
													<span class="secondary_font"><?php echo $featured_guide['guide_tag']; ?></span>
													
													<h4><?php echo $select_guide->post_title; ?></h4>
													
													<a href="<?php echo get_the_permalink($select_guide->ID); ?>" class="btn-download"><i class="fa-solid fa-arrow-down"></i><?php echo get_field('read_more_button_text',$select_guide->ID); ?></a>
												</div>

                                <a href="<?php echo get_the_permalink($select_guide->ID); ?>" class="full-link"></a>
							</div>
			        </li>
					<?php endif; ?>
					<?php 
						$featured_dives = get_sub_field('featured_dives');
						if( $featured_dives ) {
							?>
							<?php foreach( $featured_dives as $row ) { 
													$select_latest_dives = $row['select_latest_dives'];
													?>
			        <li class="glide__slide">
				        	<div class="right-articles right-articles-view">
								<article>
									<figure>
										<a href="<?php echo get_the_permalink($select_latest_dives->ID); ?>">
										<picture>
											<?php $webp_image = get_field('listing_imagewebp',$select_latest_dives->ID);
											if( !empty( $webp_image ) ): ?>
												<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
												<?php endif; ?>
													<?php 
													$jpg_image = get_field('listing_image',$select_latest_dives->ID);
													if( !empty( $jpg_image ) ): ?>
														<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
														<?php else: ?>
															<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/jpg">
															<?php endif; ?>

															<?php 
															$jpg_image = get_field('listing_image',$select_latest_dives->ID);
															if( !empty( $jpg_image ) ): ?>
																<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
															<?php else: ?>
																<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="image">
															<?php endif; ?>
														</picture>
												</a>
									</figure>
									<div class="listing-article-content">
																			<span class="article-cat-name"><?php echo $row['dive_tag'];  ?></span>
																			<h4><a href="<?php echo get_the_permalink($select_latest_dives->ID); ?>"><?php echo $select_latest_dives->post_title; ?></a></h4>
																			
																			<a href="<?php echo get_the_permalink($select_latest_dives->ID); ?>" class="read-more-btn"><?php echo get_field('read_more_button_text',$select_latest_dives->ID); ?></a>
																		</div>
									<a href="<?php echo get_the_permalink($select_latest_dives->ID); ?>" class="full-link"></a>									
								</article>
							</div>
			        </li>
			       	<?php }	?>
					 <?php }	?>
			     </ul>
				
			  </div>
			  <div class="glide__bullets" data-glide-el="controls[nav]">
			    <button class="glide__bullet" data-glide-dir="=0"></button>
			    <button class="glide__bullet" data-glide-dir="=1"></button>
			    <button class="glide__bullet" data-glide-dir="=2"></button>
			 	</div>
			</div>
			<?php } else{ ?>	
		<div class="container">

						<?php
						$featured_guide = get_sub_field('featured_guide');
						if( $featured_guide ): 
						 
						?>

	<?php $select_guide = $featured_guide['select_guide'];?>
	<div class="black-bg-imgae-content">
		<figure class="black-bg-image">
			<picture>
				<?php $webp_image = get_field('webp_image',$select_guide->ID);				
				$frg_webp_image = $featured_guide['guide_webp_image'];				
				if( !empty( $webp_image ) ): ?>
					<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
					<?php elseif(!empty($frg_webp_image)): ?>
						<source srcset="<?php echo esc_url($frg_webp_image['url']); ?>" alt="<?php echo esc_attr($frg_webp_image['alt']); ?>" type="image/webp">
					<?php /* else: ?>
						<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/webp">
					<?php */ endif; ?>
						<?php 
						$jpg_image = get_field('post_image',$select_guide->ID);
						$frg_image = $featured_guide['guide_image'];	
						if( !empty( $jpg_image ) ): ?>
							<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
							<?php elseif( !empty( $frg_image ) ): ?>
							<source srcset="<?php echo esc_url($frg_image['url']); ?>" alt="<?php echo esc_attr($frg_image['alt']); ?>" type="image/jpg">
							<?php else: ?>
								<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/jpg">
								<?php endif; ?>

								<?php 
								$jpg_image = get_field('post_image',$select_guide->ID);
								$frg_image = $featured_guide['guide_image'];	
								if( !empty( $jpg_image ) ): ?>
									<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
									<?php elseif( !empty( $frg_image ) ): ?>
							<img src="<?php echo esc_url($frg_image['url']); ?>" alt="<?php echo esc_attr($frg_image['alt']); ?>">
								<?php else: ?>
									<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="image">
								<?php endif; ?>
							</picture>
						</figure>
						<div class="black-bg-content">
							<span class="secondary_font"><?php echo $featured_guide['guide_tag']; ?></span>						
							<h4><?php echo $select_guide->post_title; ?></h4>
							<p><?php echo wp_trim_words(get_field('short_description',$select_guide->ID),35,'...') ?></p>
							<a href="<?php echo get_the_permalink($select_guide->ID); ?>" class="btn-download"><i class="fa-solid fa-arrow-down"></i><?php echo get_field('read_more_button_text',$select_guide->ID); ?></a>
						</div>
						<a href="<?php echo get_the_permalink($select_guide->ID); ?>" class="full-link"></a>
					</div>



				<?php endif; ?>

				<?php 
				$featured_dives = get_sub_field('featured_dives');
				if( $featured_dives ) {
					?>
					<div class="right-articles right-articles-view">
						<?php foreach( $featured_dives as $row ) { 
							$select_latest_dives = $row['select_latest_dives'];
							?>
							<article>
								<figure>
									<a href="<?php echo get_the_permalink($select_latest_dives->ID); ?>">
										<picture>
											<?php $webp_image = get_field('listing_imagewebp',$select_latest_dives->ID);
											if( !empty( $webp_image ) ): ?>
												<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
												<?php /* else: ?>
													<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/webp">
												<?php */ endif; ?>
													<?php 
													$jpg_image = get_field('listing_image',$select_latest_dives->ID);
													if( !empty( $jpg_image ) ): ?>
														<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
														<?php else: ?>
															<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/jpg">
															<?php endif; ?>

															<?php 
															$jpg_image = get_field('listing_image',$select_latest_dives->ID);
															if( !empty( $jpg_image ) ): ?>
																<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
															<?php else: ?>
																<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="image">
															<?php endif; ?>
														</picture>
													</a>
												</figure>
												<div class="listing-article-content">
													<span class="article-cat-name"><?php echo $row['dive_tag'];  ?></span>
													<h4><?php echo $select_latest_dives->post_title; ?></h4>
													<p><?php echo wp_trim_words(get_field('short_description',$select_latest_dives->ID),15,'...') ?></p>
													<a href="<?php echo get_the_permalink($select_latest_dives->ID); ?>" class="read-more-btn"><?php echo get_field('read_more_button_text',$select_latest_dives->ID); ?></a>
												</div>
												<a href="<?php echo get_the_permalink($select_latest_dives->ID); ?>" class="full-link"></a>
											</article>
											<?php
										}
										?>
									</div>
								<?php } ?>







							</div>
		<?php } ?>
	</section>
		<?php	elseif( get_row_layout() == 'blogs_news' ): ?>

	<section class="posts-section posts-section-2">
		<div class="container">
			<span class="sub_heading"><?php echo get_sub_field('blog_sub_title'); ?></span>
			<h2><?php echo get_sub_field('blog_title'); ?></h2>
			<?php 
                        $featured_blog = get_sub_field('featured_blog');
                   		    if( $featured_blog ): ?>
			<?php if ( wp_is_mobile() ){ ?>
			<div class="posts-slider-mob-wrap">
				<div class="glide" id="blog-slider-mob">
					<div class="glide__track" data-glide-el="track">
						
                             <ul class="glide__slides">
                            <?php $bs=1; foreach( $featured_blog as $post ): 
									setup_postdata($post);  ?>
							<li class="glide__slide">
								<?php if($bs!=1){  ?><div class="right-articles"> <?php } ?>
				        	<article <?php if($bs==1){ echo'class="ifza-post"'; }?>>
								<figure>
									<a href="<?php the_permalink(); ?>">
									<picture>
										<?php $webp_image = get_field('webp_image');
										if( !empty( $webp_image ) ): ?>
										<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
										<?php /* else: ?>
										<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/webp">
										<?php */ endif; ?>
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
									</a>
								</figure>
								<?php if($bs==1){  ?><div class="ifza-post-content"> <?php } ?>
									<div class="listing-article-content">
										<span class="article-cat-name"><?php echo $first_category = wp_get_post_terms( $post->ID, 'category' )[0]->name; ?></span>
										<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<span class="article-publish-date"><?php echo get_the_date('j F, Y'); ?></span>	
									</div>
									<a href="<?php the_permalink(); ?>" class="full-link"></a>
								<?php if($bs==1){  ?></div><?php } ?>
							</article>
							<?php if($bs!=1){  ?></div> <?php } ?>
				        </li>       
							                        
                            <?php $bs++; endforeach; ?>   
				      </ul>
					</div>
					<div class="glide__arrows" data-glide-el="controls">
					    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
					    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
				  </div>
				  <div class="glide__bullets" data-glide-el="controls[nav]">
					    <button class="glide__bullet" data-glide-dir="=0"></button>
					    <button class="glide__bullet" data-glide-dir="=1"></button>
					    <button class="glide__bullet" data-glide-dir="=2"></button>
					    <button class="glide__bullet" data-glide-dir="=3"></button>
					 </div>
				</div>
			</div>
			<?php } else{ ?>

			<div class="posts-area">
				<div class="posts-left-section">
		<?php $i=0; foreach( $featured_blog as $post ): 
		setup_postdata($post); 
		$i= $i+1;
		?> 

		<?php if($i ==3){ ?>
		</div>
	<div class="ifza-post-section">
			<div class="right-articles right-articles-2">


			<?php } ?>

			<article class="<?php if($i == 1){ ?>ifza-post ifza-post-view<?php }else if($i == 2){ ?>ifza-post-2 ifza-post-2-view<?php } ?>">
				<figure>
					<a href="<?php the_permalink(); ?>">
						<picture>
							<?php $webp_image = get_field('webp_image');
							if( !empty( $webp_image ) ): ?>
								<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
								<?php /*else: ?>
									<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/webp">
								<?php */ endif; ?>
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
									</a>
								</figure>
								<div class="<?php if($i==1){ ?>ifza-post-content ifza-post-content-view <?php } else if($i == 2){ ?>image-left-blog-content<?php } else{ ?> listing-article-content<?php } ?>">
									<time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time>
										<h4><?php the_title(); ?></h4>
										<?php /*if($i == 1 || $i == 2){ ?><p><?php echo wp_trim_words(get_field('short_description'),25,'...') ?></p><?php }*/ ?>
										<a href="<?php the_permalink(); ?>" class="read-more-btn"><?php echo get_field('read_more_button_text'); ?></a>
									</div>
									<a href="<?php the_permalink(); ?>" class="full-link"></a>
								</article>

							<?php endforeach; ?>

						</div>
					</div>
				</div>
				<?php } ?>	
				<?php wp_reset_query(); endif; ?>				
			<?php 
				$blog_page_link = get_sub_field('blog_page_link');
				if( $blog_page_link ): 
					$link_url = $blog_page_link['url'];
					$link_title = $blog_page_link['title'];
					$link_target = $blog_page_link['target'] ? $blog_page_link['target'] : '_self';
					?>
					<a class="btn-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><span class="arrow-img"></span> </a>
				<?php endif; ?>
			
			
		</div>
	</section>

	<?php elseif( get_row_layout() == 'business_guides' ):  ?>
	<?php
	$featured_guides = get_sub_field('featured_guides');

if( $featured_guides ): ?>

<section class="content-sec-22">
<div class="container">
<div class="content-with-heading">
	<h2 class="h2"><?php the_sub_field('guides_title'); ?></h2>
	<?php the_sub_field('guides_short_description'); ?>
</div>
<ul class="image-content-article">



	<?php foreach( $featured_guides as $post ): 

		setup_postdata($post); 

		?> 

		<li>
			<figure>
				<picture>
					<?php $webp_image = get_field('webp_image');
						$image_webp = wp_get_attachment_image_url($webp_image['ID'],'webp_list');
					if( !empty( $webp_image ) ): ?>
						<source srcset="<?php echo $image_webp; ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
						<?php /* else: ?>
							<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-363X514.jpg" type="image/webp">
						<?php */ endif; ?>
							<?php 
							$jpg_image = get_field('post_image');
							$image_url = wp_get_attachment_image_url($jpg_image['ID'],'webp_list');										
								if( !empty( $jpg_image ) ): ?>
									<source srcset="<?php echo $image_url; ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
								<?php else: ?>
									<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-363X514.jpg" type="image/jpg">
									<?php endif; ?>

									<?php 
									$jpg_image = get_field('post_image');
									$imagall = wp_get_attachment_image($jpg_image['ID'],'webp_list');
									if( !empty( $jpg_image ) ): ?>
										<?php  echo $imagall; ?>
									<?php else: ?>
										<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-363X514.jpg" alt="image">
									<?php endif; ?>
								</picture> 
							</figure>
							<div class="image-content-article-content">
								<!-- <time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time> -->
									<h4><?php the_title(); ?></h4>
									<p><?php echo wp_trim_words(get_field('short_description'),12,'...') ?></p>
									<a href="<?php the_permalink(); ?>" class="btn-download"><i class="fa-solid fa-arrow-down"></i><?php echo get_field('read_more_button_text'); ?></a>
								</div>
									<a href="<?php the_permalink(); ?>" class="full-link"></a>
							</li>

						<?php endforeach; ?>


					</ul>
					<?php 
					$guide_page_link = get_sub_field('guide_page_link');
					if( $guide_page_link ): 
						$link_url = $guide_page_link['url'];
						$link_title = $guide_page_link['title'];
						$link_target = $guide_page_link['target'] ? $guide_page_link['target'] : '_self';
						?>
						<a class="btn-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><span class="arrow-img"></span> </a>
					<?php endif; ?>

				</div>
			</section>

			<?php  
			wp_reset_postdata(); ?>
		<?php endif; ?>

		<?php elseif( get_row_layout() == 'deep_dives' ):  ?>
<?php
	$featured_deep_dives = get_sub_field('featured_deep_dives');

	if( $featured_deep_dives ): ?>
		<section class="content-sec-23">
			<div class="container">
				<div class="content-with-heading">
					<h2 class="h2"><?php the_sub_field('deep_dives_title'); ?></h2>
					<?php the_sub_field('deep_dives_short_description'); ?>
				</div>
				<div class="articles-listing">
					<?php foreach( $featured_deep_dives as $post ): 

						setup_postdata($post); 



						?> 
						<article>
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
									<div class="article-list-content">
										<!-- <time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time> -->
											<h4><?php the_title(); ?></h4>
											<?php // echo mb_strimwidth(get_field('short_description'), 0, 50, '...'); ?></p>
											<p><?php echo wp_trim_words(get_field('short_description'),10,'...') ?></p>
											<a href="<?php the_permalink(); ?>" class="read-more-btn"><?php echo get_field('read_more_button_text'); ?></a>
										</div>
										<a href="<?php the_permalink(); ?>" class="full-link"></a>
									</article>
								<?php endforeach; ?>


							</div>
							<?php 
							$deep_dives_page_link = get_sub_field('deep_dives_page_link');
							if( $deep_dives_page_link ): 
								$link_url = $deep_dives_page_link['url'];
								$link_title = $deep_dives_page_link['title'];
								$link_target = $deep_dives_page_link['target'] ? $deep_dives_page_link['target'] : '_self';
								?>
								<a class="btn-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><span class="arrow-img"></span> </a>
							<?php endif; ?>


						</div>
					</section>

					<?php  
					wp_reset_postdata(); ?>
				<?php endif; ?>
	<?php elseif( get_row_layout() == 'videos' ):  ?>
	<?php
			$videos = get_sub_field('featured_videos');
			if( $videos ): ?>
				<section class="content-sec-24">
					<div class="container">
						<div class="content-with-heading">
							<h2 class="h2"><?php the_sub_field('Videos_title'); ?></h2>
							<?php the_sub_field('Videos_short_description'); ?>
						</div>
				<ul class="videos-article-listing">
					<?php foreach( $videos as $post ): 

						setup_postdata($post); 


						$youtube_url = get_sub_field('youtube_video_url');
						if($youtube_url!= ''){

							preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtube_url, $match);
							$youtubeId = $match[1];
							$videoDetail = getYouTubeDetails($youtubeId);
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
								<!-- <a href="<?php the_field('youtube_video_url'); ?>" class="popup-youtube"> -->
								<a href="<?php the_permalink(); ?>" >
									<picture>
										<?php $webp_image = get_field('webp_image');
										if( !empty( $webp_image ) ): ?>
											<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
											<?php /* else: ?>
												<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/webp">
											<?php */ endif; ?>
												<?php 
												$jpg_image = get_field('post_image');
												if( !empty( $jpg_image ) ): ?>
													<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
													<?php else: ?>
														<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/jpg">
														<?php endif; ?>

														<?php 
														$jpg_image = get_field('post_image');
														if( !empty( $jpg_image ) ): ?>
															<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
														<?php else: ?>
															<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="image">
														<?php endif; ?>
													</picture>
													<i></i>
												</a>
												<figcaption><?php echo $duration_formatted; ?></figcaption>
											</figure>
											<div class="video-article-list-content">
												<!-- <time class="article-publish-time secondary_font"><strong><?php _e('Published:'); ?></strong> <?php echo date('F j\<\s\u\p\>S\<\/\s\u\p\>, Y',strtotime(get_the_date())); ?></time> -->
													<h4><?php the_title(); ?></h4>
													<p><?php echo wp_trim_words(get_field('short_description'),25,'...') ?></p>
													<a href="<?php the_permalink(); ?>"><?php echo get_field('read_more_button_text'); ?></a>
												</div>
												<a href="<?php the_permalink(); ?>" class="full-link"></a>
											</li>
										<?php endforeach; ?>

									</ul>


									<?php 
									$videos_page_link = get_sub_field('videos_page_link');
									if( $videos_page_link ): 
										$link_url = $videos_page_link['url'];
										$link_title = $videos_page_link['title'];
										$link_target = $videos_page_link['target'] ? $videos_page_link['target'] : '_self';
										?>
										<a class="btn-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><span class="arrow-img"></span></a>
									<?php endif; ?>
								</div>
							</section>
							<?php  
							wp_reset_postdata(); ?>
						<?php endif; ?>


	<?php elseif( get_row_layout() == 'bottom_banner' ):  ?>
<?php get_template_part('template-parts/bottom-banner');  ?>




			<?php  endif; ?>

		<?php endwhile;

	else : 
	endif;
	?>
</main>
<?php get_footer(); ?>