<?php
/**
 * Latest Openings Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Latest';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Openings';
$openings = isset( $args['openings'] ) ? $args['openings'] : array(
	array(
		'title' => 'Chief Financial Officer',
		'posted_date' => 'Posted 18 Hours Ago',
		'location' => 'Riyadh, Saudi Arabia',
		'job_id' => 'ID: 54294',
		'details_link' => esc_url( home_url( '/job-details' ) )
	),
	array(
		'title' => 'Senior Civil Engineer',
		'posted_date' => 'Posted 1 Day Ago',
		'location' => 'Jeddah, Saudi Arabia',
		'job_id' => 'ID: 54295',
		'details_link' => '#'
	),
	array(
		'title' => 'Project Manager',
		'posted_date' => 'Posted 2 Days Ago',
		'location' => 'Riyadh, Saudi Arabia',
		'job_id' => 'ID: 54296',
		'details_link' => '#'
	)
);
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
$show_load_more = isset( $args['show_load_more'] ) ? $args['show_load_more'] : true;

?>

<section class="latest_openings_section pt_80 pb_80 <?php echo esc_attr( $section_class ); ?>">
	<div class="wrap">
		<div class="latest_openings_section_inner  ">
			<?php if ( $title || $title_span ) : ?>
				<h4 class="h3_title_50 pb_20  ">
					<?php if ( $title ) : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
					<?php if ( $title_span ) : ?>
						<span><?php echo esc_html( $title_span ); ?></span>
					<?php endif; ?>
				</h4>
			<?php endif; ?>

			<?php if ( ! empty( $openings ) ) : ?>
				<ul class="latest_openings_list" data-openings-list>
					<?php foreach ( $openings as $opening ) : 
						$job_title = isset( $opening['title'] ) ? $opening['title'] : '';
						$posted_date = isset( $opening['posted_date'] ) ? $opening['posted_date'] : '';
						$opening_location = isset( $opening['location'] ) ? $opening['location'] : '';
						$job_id = isset( $opening['job_id'] ) ? $opening['job_id'] : '';
						$details_link = isset( $opening['details_link'] ) ? $opening['details_link'] : esc_url( home_url( '/job-details' ) );
						$opening_icon = isset( $opening['icon'] ) ? $opening['icon'] : '';
					?>
						<li>
							<div class="opening_block">
								<?php if ( $opening_icon ) : ?>
									<div class="opening_icon">
                                        <a href="<?php echo esc_url( $details_link ); ?>">
										<img src="<?php echo esc_url( $opening_icon ); ?>" alt="<?php echo esc_attr( $job_title ); ?>">
                                </a>
									</div>
								<?php endif; ?>
								<div class="opening_content">
									<?php if ( $job_title ) : ?>
										<h3><?php echo esc_html( $job_title ); ?></h3>
									<?php endif; ?>
									
									<?php if ( $posted_date ) : ?>
										<p class="opening_posted"><?php echo esc_html( $posted_date ); ?></p>
									<?php endif; ?>
									
									<?php if ( $opening_location ) : ?>
										<div class="opening_location">
											<img src="<?php echo get_template_directory_uri(); ?>/assets/images/map-pin.svg" alt="Location">
											<span><?php echo esc_html( $opening_location ); ?></span>
										</div>
									<?php endif; ?>
									
									<?php if ( $job_id ) : ?>
										<div class="opening_id">
											<img src="<?php echo get_template_directory_uri(); ?>/assets/images/id-icn.svg" alt="Job ID">
											<span><?php echo esc_html( $job_id ); ?></span>
										</div>
									<?php endif; ?>
								</div>
								
								<?php if ( $details_link ) : ?>
									<div class="opening_action">
										<a href="<?php echo esc_url( $details_link ); ?>" class="btn_style btn_transparent but_black">
											Job Details <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="Details"></span>
										</a>
									</div>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
				
				<?php if ( $show_load_more ) : ?>
					<div class="load_more_container">
						<button class="btn_style btn_green load_more_btn">Load more</button>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

