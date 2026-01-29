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
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
<rect width="16" height="16" rx="3" fill="#676767"></rect>
<path d="M3.5 4.71003C3.5 4.42142 3.60135 4.18332 3.80405 3.99574C4.00675 3.80815 4.27027 3.71436 4.59459 3.71436C4.91313 3.71436 5.17085 3.8067 5.36776 3.99141C5.57046 4.18189 5.67181 4.43008 5.67181 4.736C5.67181 5.01306 5.57336 5.24393 5.37645 5.42864C5.17375 5.61912 4.90734 5.71435 4.57722 5.71435H4.56853C4.25 5.71435 3.99228 5.61912 3.79537 5.42864C3.59845 5.23816 3.5 4.99862 3.5 4.71003ZM3.61293 12.2858V6.50223H5.54151V12.2858H3.61293ZM6.61004 12.2858H8.53861V9.05634C8.53861 8.85432 8.56178 8.69847 8.60811 8.58881C8.68919 8.39256 8.81226 8.22661 8.97732 8.09098C9.14237 7.95533 9.34942 7.88751 9.59846 7.88751C10.2471 7.88751 10.5714 8.3233 10.5714 9.19487V12.2858H12.5V8.96976C12.5 8.11551 12.2973 7.4676 11.8919 7.02604C11.4865 6.58448 10.9508 6.3637 10.2847 6.3637C9.53764 6.3637 8.9556 6.68405 8.53861 7.32474V7.34206H8.52992L8.53861 7.32474V6.50223H6.61004C6.62162 6.68693 6.62741 7.26125 6.62741 8.22518C6.62741 9.1891 6.62162 10.5426 6.61004 12.2858Z" fill="white"></path>
</svg>
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

