<?php if( have_rows('bottom_banner_details') ): ?>
	<?php while( have_rows('bottom_banner_details') ): the_row(); 
		$banner_webp = get_sub_field('banner_webp');
		$banner_jpg_image = get_sub_field('banner_jpg_image');
		if( !empty( $banner_webp ) || !empty( $banner_jpg_image )): 

			?>

		<section class="bottom-banner">
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
						<?php 
						$banner_link = get_sub_field('banner_link');
						if( $banner_link ): 
							$link_url = $banner_link['url'];
							$link_title = $banner_link['title'];
							$link_target = $banner_link['target'] ? $banner_link['target'] : '_self';
							?>
							<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"></a>
						<?php endif; ?>
					</figure>
					<div class="bottom-banner-content">
						<div class="container">
							<div class="bottom-banner-inner">
								<h3 class="h2"><?php the_sub_field('banner_title'); ?></h3>
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
					</div>
				</section>

			<?php endif; ?>
		<?php endwhile; ?>
		<?php endif; ?>