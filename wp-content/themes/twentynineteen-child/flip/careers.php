<?php 
/**
* Template Name: Careers
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/careers.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<main>
	<?php // flexible
if( have_rows('work_with_us_section') ): ?>
    <?php while( have_rows('work_with_us_section') ): the_row(); ?>

	<?php if( get_row_layout() == 'car_banner_section' ): ?>
		<section class="banner">
		<div class="banner-box-wrap">
			<div class="container">
				<div class="banner-box">
					<div class="left-banner-box">
						<h1><?php echo get_sub_field('overview_title'); ?></h1>
					<?php echo get_sub_field('overview_content'); ?>

						<?php 
						$link = get_sub_field('overview_button');
						if( $link ): 
							$link_url = $link['url'];
							$link_title = $link['title'];
							$link_target = $link['target'] ? $link['target'] : '_self';
							?>
							<a class="btn-link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><span class="arrow-img"></span></a>
						<?php endif; ?>


					</div>
					<figure class="right-banner-image-box">
						<picture>
							<?php 
							$webp_image = get_sub_field('webp_image');
							if( !empty( $webp_image ) ): ?>
								<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
								<?php endif; ?>

								<?php 
								$jpg_image = get_sub_field('jpg_image');
								if( !empty( $jpg_image ) ): ?>
									<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/png">
									<?php endif; ?>

									<?php 
									$jpg_image = get_sub_field('jpg_image');
									if( !empty( $jpg_image ) ): ?>
										<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
									<?php endif; ?>

								</picture>
							</figure>
						</div>
					</div>
				</div>
			</section>
			<?php elseif( get_row_layout() == 'academy_overview' ): ?>

	<section class="content-sec">
		<div class="container">
				<?php if( !empty( get_sub_field('cr_title') ) ){ ?><h3 class="h2"><?php echo get_sub_field('cr_title'); ?></h3><?php } ?>
					<?php echo get_sub_field('cr_content'); ?>	
		</div>
	</section>
	<?php elseif( get_row_layout() == 'left_image_right_content' ): ?>
	<section class="image-left-content no-max-width">
		<figure class="image-left-content-left">
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
		</figure>
		<div class="image-left-content-right padding-left padding-right">
			<?php if( !empty( get_sub_field('team_title') ) ){ ?><h3 class="h2"><?php echo get_sub_field('team_title'); ?></h3><?php } ?>
					<?php echo get_sub_field('team_description'); ?>			
		</div>
	</section>
	<?php elseif( get_row_layout() == 'job_listing' ): ?>


				<section class="all-listing-sec" id="job_listing">
					<div class="container">
						<div class="heading-with-dropdown">
							<div class="content-block">
								<h2><?php echo get_sub_field('job_listing_title'); ?></h2>
								<?php echo get_sub_field('job_listing_description'); ?>
							</div>
							<!-- <div class="dropdown-box-area">
								<span class="secondary_font"><?php _e('Filter by:'); ?></span>
								<select id="sort-by">
									<option value="date-desc" <?php if($_REQUEST['orderby'] == 'date-desc'){ ?>select<?php } ?>><?php _e('All Jobs'); ?></option>
									<option value="name-asc" <?php if($_REQUEST['orderby'] == 'name-asc'){ ?>select<?php } ?>><?php _e('Sort by: Name'); ?></option>
								</select>
							</div> -->
						</div>
						<div class="job-listing-embeded">
						<link rel="stylesheet" href="https://static.zohocdn.com/recruit/embed_careers_site/css/v1.0/embed_jobs.f432da7752b1e1a34cd686051146d9b0.css" type="text/css">
						<div class="embed_jobs_head embed_jobs_with_style_1 "><div class="embed_jobs_head2"><div class="embed_jobs_head3"><div id="rec_job_listing_div"> </div><script type="text/javascript" src="https://static.zohocdn.com/recruit/embed_careers_site/javascript/v1.0/embed_jobs.5a71e72320d517a462350c6022ccfe36.js"></script><script type="text/javascript">
						            rec_embed_js.load({
						                widget_id:"rec_job_listing_div",
						                page_name:"Careers",
						                source:"CareerSite",
						                site:"https://careers.ifza.com",
						                empty_job_msg:"No current Openings"
						            });</script></div></div></div>
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


						jQuery(".dropdown-box-area").on('change', 'select', function() {
							var sortBy = jQuery("#sort-by").val();
							window.location.href= "<?php the_permalink();?>?orderby="+sortBy
						});
					</script>