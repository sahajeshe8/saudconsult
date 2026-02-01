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

<section class="latest_openings_section pt_120 pb_120 <?php echo esc_attr( $section_class ); ?>">
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
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_516_6740)">
<path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="#0D6A37" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#0D6A37" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</g>
<defs>
<clipPath id="clip0_516_6740">
<rect width="24" height="24" fill="white"/>
</clipPath>
</defs>
</svg>


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

