<?php
/**
 * Visionary Leadership Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$label = array_key_exists( 'label', $args ) ? $args['label'] : 'Our Projects';
$title = array_key_exists( 'title', $args ) ? $args['title'] : 'Our Visionary';
$title_span = array_key_exists( 'title_span', $args ) ? $args['title_span'] : 'Leadership';
$list_class = isset( $args['list_class'] ) ? $args['list_class'] : '';
$leadership_members = isset( $args['leadership_members'] ) ? $args['leadership_members'] : array(
	array(
		'image' => get_template_directory_uri() . '/assets/images/l1.jpg',
		'name' => 'Sami Sidawi',
		'position' => 'Chairman',
		'linkedin_url' => '#'
	),
	array(
		'image' => get_template_directory_uri() . '/assets/images/l2.jpg',
		'name' => 'John N Helou',
		'position' => 'Chairman',
		'linkedin_url' => '#'
	)
);

?>

<section class="leadership_section ">
	<div class="wrap">
		<div class="leadership_section_inner_content pb_50">
			<ul class="leadership_section_inner_left_list<?php echo $list_class ? ' ' . esc_attr( $list_class ) : ''; ?>">
				<?php if ( $label || $title || $title_span ) : ?>
					<li>
						<?php if ( $label ) : ?>
							<span class="lable_text green_text mb_50">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/dot-02.svg" alt="<?php echo esc_attr( $label ); ?>">
								<?php echo esc_html( $label ); ?>
							</span>
						<?php endif; ?>

						<?php if ( $title || $title_span ) : ?>
							<h3 class="h3_title_50">
								<?php if ( $title ) : ?>
									<?php echo esc_html( $title ); ?>
								<?php endif; ?>
								<?php if ( $title_span ) : ?>
									<span><?php echo esc_html( $title_span ); ?></span>
								<?php endif; ?>
							</h3>
						<?php endif; ?>
					</li>
				<?php endif; ?>

				<?php if ( ! empty( $leadership_members ) ) : ?>
					<?php foreach ( $leadership_members as $member ) : 
						$member_image = isset( $member['image'] ) ? $member['image'] : get_template_directory_uri() . '/assets/images/l1.jpg';
						$member_name = isset( $member['name'] ) ? $member['name'] : '';
						$member_position = isset( $member['position'] ) ? $member['position'] : '';
						$member_linkedin = isset( $member['linkedin_url'] ) ? $member['linkedin_url'] : '#';
					?>
						<li>
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
											<p><img src="<?php echo get_template_directory_uri(); ?>/assets/images/green-dot.svg" alt="Position"> <?php echo esc_html( $member_position ); ?></p>
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
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</section>

