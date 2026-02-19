<?php 
/**
* Template Name: Thank you Career
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/careers-thankyou.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<main>
	<?php if(get_field('thank_you_tilte')||get_field('thank_you_message')) { ?>
	<section class="banner">
		<div class="banner-box-wrap">
			<div class="container">
				<div class="banner-box">
					<div class="left-banner-box">
						<h1 class="h2"><?php echo get_field('thank_you_tilte'); ?></h1>
						<?php echo get_field('thank_you_message'); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>
	<?php if( have_rows('hiring_process_steps') ): ?>
	<section class="content-sec">
		<div class="container">
			<h3 class="h2"><?php the_field('cr_title'); ?></h3>
			<ul class="steps-after-submission">
				<?php $l=1; while( have_rows('hiring_process_steps') ): the_row();  ?>
			<li>
					<span class="primary_font"><?php if($l<10){ echo '0'.$l; } else{echo $l;}?>.</span>
					<h3><?php the_sub_field('hp_title'); ?></h3>
					<?php the_sub_field('hp_content'); ?>
				</li>
				<?php $l++; endwhile; ?>
			</ul>

		</div>
	</section>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
