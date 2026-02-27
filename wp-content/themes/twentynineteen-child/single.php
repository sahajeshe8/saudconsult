<?php
get_header(); 
// -------------------------------------
wp_enqueue_script('script');
add_action('wp_footer','page_script',21);
function page_script(){
	?>
	<script>
		jQuery(document).ready(function() {
			var swiper = new Swiper('.text-slider', {
				slidesPerView: 1,
				spaceBetween:0,
				loop: true,

				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
				autoplay: {
					delay: 5000,
					speed:3000,
					disableOnInteraction: false,
				},

			});


		});

	</script>
	<?php
}
// -------------------------------------

if ( have_posts() ) : 
	while ( have_posts() ) :  the_post();
		$img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
		?>

		


		<section data-aos-delay="300" data-aos="fade-in">
			<div class="container pt-100 "><section class="journel-banner"> <img src="<?php echo $img_url; ?>"></section>
				<div class="row-02">

					<ul class="post-info" data-aos-delay="300" data-aos="fade-up">
						<li><p><?php the_field('posted_date'); ?></p></li>
					</ul>

					<div data-aos-delay="300" data-aos="fade-up">
						<h1><?php the_title(); ?></h1>
						<?php the_content(); ?>
					</div>

				</div>

			</div>
		</div>

	</section>


	<?php
	$related_testimonial = get_field('related_testimonial');
	if( $related_testimonial ): ?>

		<section data-aos-delay="300" data-aos="fade-in" class="bg-gray slid-txtrow">

			<div class="container pt-100 pb-100">
				<div class="swiper-container text-slider" data-aos-delay="300" data-aos="fade-up">
					<div class="swiper-wrapper">

						<?php foreach( $related_testimonial as $post ): 
							setup_postdata($post); 
							?>


							
							<div class="swiper-slide">
								<h3><?php the_field('enter_testimonial'); ?></h3>
								<h4><?php the_title(); ?></h4>
							</div>



						<?php endforeach; ?>
					</div>
				</div>
				<div data-aos-delay="300" data-aos="fade-up" class="swiper-pagination"></div>
			</div>
		</section>

		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

	



	<?php
	$related_post = get_field('related_post');
	if( $related_post ): ?>
		<section class="related-sec" data-aos-delay="300" data-aos="fade-in">
			<div class="container">
				<div class=" row-03 row-02 pt-100">

					<h2 data-aos-delay="300" data-aos="fade-up"><?php _e('RELATED ARTICLES'); ?></h2>
					<ul>
						<?php foreach( $related_post as $post ): 
							setup_postdata($post); 
							$img_url = get_the_post_thumbnail_url(get_the_ID(), array(562, 313)); 
							?>
							
							<li data-aos-delay="300" data-aos="fade-up">
								<div class="grid-02">
									<a href="<?php the_permalink(); ?>">  
										<figure class="effect-bubba"> <img style="background:  url(<?php echo $img_url; ?>) left bottom no-repeat; background-size: cover;"  class="res-img desk-non-01" src="<?php echo get_stylesheet_directory_uri(); ?>/images/image-placeholder-06.png"><figcaption>

										</figcaption>
									</figure></a>
								</div>
								<ul class="post-info" data-aos-delay="300" data-aos="fade-up">
									<li><p><?php the_field('posted_date'); ?></p></li>

								</ul>
								<h3 data-aos-delay="300" data-aos="fade-up"><?php the_title(); ?></h3>
								<p data-aos-delay="300" data-aos="fade-up"><?php the_excerpt(); ?></p>
							</li>

						<?php endforeach; ?>

					</ul>

				</div>
			</section>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>



	<?php endwhile;
endif;

get_footer(); ?>