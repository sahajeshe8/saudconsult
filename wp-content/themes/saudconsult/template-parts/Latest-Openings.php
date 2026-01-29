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
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
<rect width="16" height="16" rx="3" fill="#676767"></rect>
<path d="M3.5 4.71003C3.5 4.42142 3.60135 4.18332 3.80405 3.99574C4.00675 3.80815 4.27027 3.71436 4.59459 3.71436C4.91313 3.71436 5.17085 3.8067 5.36776 3.99141C5.57046 4.18189 5.67181 4.43008 5.67181 4.736C5.67181 5.01306 5.57336 5.24393 5.37645 5.42864C5.17375 5.61912 4.90734 5.71435 4.57722 5.71435H4.56853C4.25 5.71435 3.99228 5.61912 3.79537 5.42864C3.59845 5.23816 3.5 4.99862 3.5 4.71003ZM3.61293 12.2858V6.50223H5.54151V12.2858H3.61293ZM6.61004 12.2858H8.53861V9.05634C8.53861 8.85432 8.56178 8.69847 8.60811 8.58881C8.68919 8.39256 8.81226 8.22661 8.97732 8.09098C9.14237 7.95533 9.34942 7.88751 9.59846 7.88751C10.2471 7.88751 10.5714 8.3233 10.5714 9.19487V12.2858H12.5V8.96976C12.5 8.11551 12.2973 7.4676 11.8919 7.02604C11.4865 6.58448 10.9508 6.3637 10.2847 6.3637C9.53764 6.3637 8.9556 6.68405 8.53861 7.32474V7.34206H8.52992L8.53861 7.32474V6.50223H6.61004C6.62162 6.68693 6.62741 7.26125 6.62741 8.22518C6.62741 9.1891 6.62162 10.5426 6.61004 12.2858Z" fill="white"></path>
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

