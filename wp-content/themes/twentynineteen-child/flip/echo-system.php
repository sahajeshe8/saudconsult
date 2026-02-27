<?php 
/**
* Template Name: Echo System
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/echo-system.css" rel="stylesheet">
<?php get_header()?>

<main>
	<?php // flexible
if( have_rows('echo_system_section') ): ?>
    <?php while( have_rows('echo_system_section') ): the_row(); ?>

<?php if( get_row_layout() == 'eco_banner_section' ): ?>
	<section class="banner">
		<div class="banner-box-wrap">
			<div class="container">
				<div class="banner-box">
					<div class="full-banner-box">
						<h1><?php echo get_sub_field('eco_title'); ?></h1>
					<?php echo get_sub_field('echo_content'); ?>
					</div>
				</div>
			</div>
		</div>
	</section>


<?php elseif( get_row_layout() == 'globe_ecosystem' ): ?>
	
	<section class="center-image-sec">
		<div class="container">
			<div class="center-image-inner">
				<?php if( get_sub_field('echo_left_side_content') ){ ?>
				<div class="center-image-left-box">
					<?php echo get_sub_field('echo_left_side_content'); ?>
				</div>
				<?php } ?>
				<?php if( get_sub_field('echo_image') || get_sub_field('echo_image_webp')){ ?>
				<figure class="center-image-center-box">
					<picture>
						<?php if( get_sub_field('echo_image_webp') ){ ?><source srcset="<?php echo get_sub_field('echo_image_webp')['url']; ?>" type="image/webp"><?php } ?>
						<?php if( get_sub_field('echo_image') ){ ?><source srcset="<?php echo get_sub_field('echo_image')['url']; ?>" type="image/png"><?php } ?>
						<?php if( get_sub_field('echo_image') ){ ?><img src="<?php echo get_sub_field('echo_image')['url']; ?>" alt=image><?php } ?>

					</picture>
				</figure>
				<?php } ?>
					<?php if( get_sub_field('right_side_content') || get_sub_field('writer_name')){ ?>
				<div class="center-image-right-box">
					<?php echo get_sub_field('right_side_content'); ?>
						<?php if( get_sub_field('writer_name') ){ ?><span><?php echo get_sub_field('writer_name'); ?></span><?php } ?>
				</div>
					<?php } ?>
			</div>
		</div>
	</section>

<?php elseif( get_row_layout() == 'ecosystem_listing' ): ?>
	<?php if( have_rows('eco_listing') ): ?> 
	<section class="text-image-list-sec">
		<div class="container">
			<?php while( have_rows('eco_listing') ): the_row();  ?>
			<div class="text-image-list-inner">
				<figure class="text-image-list-image mob-text-image-list-image">
					<picture>
					<?php if( get_sub_field('blo_image_webp') ){ ?><source srcset="<?php echo get_sub_field('blo_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><source srcset="<?php echo get_sub_field('blo_image')['url']; ?>" type="image/jpg"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><img src="<?php echo get_sub_field('blo_image')['url']; ?>" alt=image><?php } ?>
					</picture>
					<?php if ( wp_is_mobile() ){ ?>
					<div class="mob-heading-area">
					   <h3><?php echo get_sub_field('blo_title'); ?></h3>
					   <h4><?php echo get_sub_field('blo_sub_title'); ?></h4>
					</div>
					<?php } ?>
				</figure>
				<div class="text-image-list-content mob-text-image-list-content">
					<h3><?php echo get_sub_field('blo_title'); ?></h3>
					<h5><?php echo get_sub_field('blo_sub_title'); ?></h5>
					<?php echo get_sub_field('blo_content'); ?>
					<?php 
				$blo_link = get_sub_field('blo_link'); 
				if( $blo_link ): ?>
				<a href="<?php echo $blo_link['url']; ?>" class="btn-link" target="<?php echo $blo_link['target']; ?>"><?php echo $blo_link['title']; ?><span class="arrow-img"></span></a>												
				<?php endif; ?>
				</div>
			</div>
			<?php endwhile; ?>
		
		</div>
	</section>
	<?php endif; ?>
<?php elseif( get_row_layout() == 'get_in_touch' ): ?>
	<section class="bottom-banner">
		<figure>
			<picture>
				<?php if( get_sub_field('cc_image_webp') ){ ?><source srcset="<?php echo get_sub_field('cc_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('cc_image') ){ ?><source srcset="<?php echo get_sub_field('cc_image')['url']; ?>" type="image/jpg"><?php } ?>
					<?php if( get_sub_field('cc_image') ){ ?><img src="<?php echo get_sub_field('cc_image')['url']; ?>" alt=image><?php } ?>
			</picture>
			<?php 
				$cc_link = get_sub_field('cc_link'); 
				if( $cc_link ): ?>
				<a href="<?php echo $cc_link['url']; ?>" target="<?php echo $cc_link['target']; ?>"></a>												
				<?php endif; ?>	
		</figure>
		<div class="bottom-banner-content">
			<div class="container">
				<div class="bottom-banner-inner">
				<h3 class="h2"><?php echo get_sub_field('cc_title'); ?></h3>					
				<?php 
				$cc_link = get_sub_field('cc_link'); 
				if( $cc_link ): ?>
				<a href="<?php echo $cc_link['url']; ?>" target="<?php echo $cc_link['target']; ?>"><?php echo $cc_link['title']; ?><span class="arrow-img"></span></a>												
				<?php endif; ?>					
					
				</div>
			</div>
		</div>
	</section>

	<?php endif; ?>

    <?php endwhile; ?>
<?php endif; // flexible?>


</main>
<?php get_footer(); ?>