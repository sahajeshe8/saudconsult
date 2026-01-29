<?php
/**
 * Executive Team Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Our Executive';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Team';
$team_members = isset( $args['team_members'] ) ? $args['team_members'] : array(
	array(
		'image' => get_template_directory_uri() . '/assets/images/l3.jpg',
		'name' => 'Hadi Sha',
		'position' => 'Chief Development Officer',
		'linkedin_url' => '#'
	),
	array(
		'image' => get_template_directory_uri() . '/assets/images/l4.jpg',
		'name' => 'Mohammed El D',
		'position' => 'Chief Operating Officer',
		'linkedin_url' => '#'
	),
	array(
		'image' => get_template_directory_uri() . '/assets/images/l5.jpg',
		'name' => 'Jihad Khoury',
		'position' => 'Chief Operating Officer',
		'linkedin_url' => '#'
	)
);

?>

<section class="executive_team_section pt_80 pb_80">
	<div class="wrap">
		<div class="executive_team_section_inner">
			<?php if ( $title || $title_span ) : ?>
				<h3 class="h3_title_50 pb_20" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
					<?php if ( $title ) : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
					<?php if ( $title_span ) : ?>
						<span><?php echo esc_html( $title_span ); ?></span>
					<?php endif; ?>
				</h3>
			<?php endif; ?>

			<?php if ( ! empty( $team_members ) ) : ?>
				<ul class="executive_team_list">
					<?php 
					$delay = 100;
					foreach ( $team_members as $member ) : 
						$member_image = isset( $member['image'] ) ? $member['image'] : get_template_directory_uri() . '/assets/images/l3.jpg';
						$member_name = isset( $member['name'] ) ? $member['name'] : '';
						$member_position = isset( $member['position'] ) ? $member['position'] : '';
						$member_linkedin = isset( $member['linkedin_url'] ) ? $member['linkedin_url'] : '#';
					?>
						<li data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
							<div class="leadership_block">
								<div class="leadership_img">
									<img src="<?php echo esc_url( $member_image ); ?>" alt="<?php echo esc_attr( $member_name ); ?>">
								</div>
								<div class="leadership_content">
									<?php if ( $member_name ) : ?>
										<h4><?php echo esc_html( $member_name ); ?></h4>
									<?php endif; ?>
									<?php if ( $member_position ) : ?>
										<div class="leadership_content_bottom">
											<p><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
<rect y="7.07129" width="10" height="10" transform="rotate(-45 0 7.07129)" fill="#A9D159"/>
</svg> <?php echo esc_html( $member_position ); ?></p>
											<?php if ( $member_linkedin ) : ?>
												<a href="<?php echo esc_url( $member_linkedin ); ?>">
													<img src="<?php echo get_template_directory_uri(); ?>/assets/images/in.svg" alt="LinkedIn">
												</a>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</li>
					<?php 
						$delay += 100;
					endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>

