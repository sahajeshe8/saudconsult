<?php
/**
 * Leadership Section Component Template
 * Accepts $args with visionary and executive data. Matches home page design with desktop list + mobile swiper.
 *
 * @package tasheel
 */

$args      = isset( $args ) ? $args : array();
$visionary = isset( $args['visionary'] ) ? $args['visionary'] : array(
	'label'              => 'Our Leadership Team',
	'title'              => 'Our Visionary',
	'title_span'         => 'Leadership',
	'leadership_members' => array(
		array( 'image' => get_template_directory_uri() . '/assets/images/l1.png', 'name' => 'Sami Sidawi', 'position' => 'Chairman', 'linkedin_url' => '#' ),
		array( 'image' => get_template_directory_uri() . '/assets/images/l2.png', 'name' => 'John N Helou', 'position' => 'Chairman', 'linkedin_url' => '#' ),
	),
);
$executive = isset( $args['executive'] ) ? $args['executive'] : array(
	'title'        => 'Our Executive',
	'title_span'   => 'Team',
	'team_members' => array(
		array( 'image' => get_template_directory_uri() . '/assets/images/l3.png', 'name' => 'Hadi Sha', 'position' => 'Chief Development Officer', 'linkedin_url' => '#' ),
		array( 'image' => get_template_directory_uri() . '/assets/images/l4.png', 'name' => 'Mohammed El D', 'position' => 'Chief Operating Officer', 'linkedin_url' => '#' ),
		array( 'image' => get_template_directory_uri() . '/assets/images/l5.png', 'name' => 'Jihad Khoury', 'position' => 'Chief Operating Officer', 'linkedin_url' => '#' ),
	),
);

// Only show blocks when there are members (no heading-only or default cards).
$has_visionary = ! empty( $visionary['leadership_members'] );
$has_executive = ! empty( $executive['team_members'] );

if ( ! $has_visionary && ! $has_executive ) {
	return;
}

$dot_svg     = get_template_directory_uri() . '/assets/images/dot-02.svg';
$green_diamond_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none"><rect y="7.07129" width="10" height="10" transform="rotate(-45 0 7.07129)" fill="#A9D159"/></svg>';
$linkedin_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"><rect width="16" height="16" rx="3" fill="#676767"/><path d="M3.5 4.71003C3.5 4.42142 3.60135 4.18332 3.80405 3.99574C4.00675 3.80815 4.27027 3.71436 4.59459 3.71436C4.91313 3.71436 5.17085 3.8067 5.36776 3.99141C5.57046 4.18189 5.67181 4.43008 5.67181 4.736C5.67181 5.01306 5.57336 5.24393 5.37645 5.42864C5.17375 5.61912 4.90734 5.71435 4.57722 5.71435H4.56853C4.25 5.71435 3.99228 5.61912 3.79537 5.42864C3.59845 5.23816 3.5 4.99862 3.5 4.71003ZM3.61293 12.2858V6.50223H5.54151V12.2858H3.61293ZM6.61004 12.2858H8.53861V9.05634C8.53861 8.85432 8.56178 8.69847 8.60811 8.58881C8.68919 8.39256 8.81226 8.22661 8.97732 8.09098C9.14237 7.95533 9.34942 7.88751 9.59846 7.88751C10.2471 7.88751 10.5714 8.3233 10.5714 9.19487V12.2858H12.5V8.96976C12.5 8.11551 12.2973 7.4676 11.8919 7.02604C11.4865 6.58448 10.9508 6.3637 10.2847 6.3637C9.53764 6.3637 8.9556 6.68405 8.53861 7.32474V7.34206H8.52992L8.53861 7.32474V6.50223H6.61004C6.62162 6.68693 6.62741 7.26125 6.62741 8.22518C6.62741 9.1891 6.62162 10.5426 6.61004 12.2858Z" fill="white"/></svg>';
?>

<section class="leadership_section pt_100" style="background: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/leadershiop_bg_01.svg') no-repeat top left; background-size: 35%;">
	<div class="wrap">

		<div class="leadership_section_inner_content pb_50">

			<!-- Desktop/Tablet View: Original List -->
			<?php if ( $has_visionary ) : ?>
			<ul class="leadership_section_inner_left_list leadership-desktop-list">
				<?php if ( $visionary['label'] || $visionary['title'] || $visionary['title_span'] ) : ?>
				<li data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
					<?php if ( ! empty( $visionary['label'] ) ) : ?>
					<span class="lable_text green_text  ">
						<img src="<?php echo esc_url( $dot_svg ); ?>" alt="<?php echo esc_attr__( 'Our Projects', 'tasheel' ); ?>">
						<?php echo esc_html( $visionary['label'] ); ?>
					</span>
					<?php endif; ?>
					<?php if ( $visionary['title'] || $visionary['title_span'] ) : ?>
					<h3 class="h3_title_50">
						<?php echo esc_html( $visionary['title'] ?? '' ); ?> <?php if ( ! empty( $visionary['title_span'] ) ) : ?><span><?php echo esc_html( $visionary['title_span'] ); ?></span><?php endif; ?>
					</h3>
					<?php endif; ?>
				</li>
				<?php endif; ?>
				<?php
				if ( ! empty( $visionary['leadership_members'] ) ) :
					$delay = 100;
					foreach ( $visionary['leadership_members'] as $m ) :
						$img = isset( $m['image'] ) ? $m['image'] : get_template_directory_uri() . '/assets/images/l1.png';
						$name = isset( $m['name'] ) ? $m['name'] : '';
						$pos = isset( $m['position'] ) ? $m['position'] : '';
						$linkedin = isset( $m['linkedin_url'] ) ? $m['linkedin_url'] : '';
				?>
				<li data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
					<div class="leadership_block">
						<div class="leadership_img"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $name ); ?>"></div>
						<div class="leadership_content">
							<?php if ( $name ) : ?><h4><?php echo esc_html( $name ); ?></h4><?php endif; ?>
							<?php if ( $pos || $linkedin ) : ?>
							<div class="leadership_content_bottom">
								<?php if ( $pos ) : ?><p> <?php echo $green_diamond_svg; ?> <?php echo esc_html( $pos ); ?></p><?php endif; ?>
								<?php if ( $linkedin ) : ?><a href="<?php echo esc_url( $linkedin ); ?>"><?php echo $linkedin_svg; ?></a><?php endif; ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</li>
				<?php $delay += 100; endforeach; endif; ?>
			</ul>

			<!-- Mobile View: Swiper Slider Copy -->
			<?php if ( ! empty( $visionary['leadership_members'] ) ) : ?>
			<div class="leadership-mobile-slider">
				<div class="leadership-mobile-header">
					<?php if ( ! empty( $visionary['label'] ) ) : ?><span class="lable_text green_text"><img src="<?php echo esc_url( $dot_svg ); ?>" alt="<?php echo esc_attr__( 'Our Projects', 'tasheel' ); ?>"><?php echo esc_html( $visionary['label'] ); ?></span><?php endif; ?>
					<?php if ( $visionary['title'] || $visionary['title_span'] ) : ?><h3 class="h3_title_50"><?php echo esc_html( $visionary['title'] ?? '' ); ?> <?php if ( ! empty( $visionary['title_span'] ) ) : ?><span><?php echo esc_html( $visionary['title_span'] ); ?></span><?php endif; ?></h3><?php endif; ?>
				</div>
				<div class="swiper mySwiper-leadership-list">
					<div class="swiper-wrapper">
						<?php foreach ( $visionary['leadership_members'] as $m ) :
							$img = isset( $m['image'] ) ? $m['image'] : get_template_directory_uri() . '/assets/images/l1.png';
							$name = isset( $m['name'] ) ? $m['name'] : '';
							$pos = isset( $m['position'] ) ? $m['position'] : '';
							$linkedin = isset( $m['linkedin_url'] ) ? $m['linkedin_url'] : '';
						?>
						<div class="swiper-slide">
							<div class="leadership_block">
								<div class="leadership_img"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $name ); ?>"></div>
								<div class="leadership_content">
									<?php if ( $name ) : ?><h4><?php echo esc_html( $name ); ?></h4><?php endif; ?>
									<?php if ( $pos || $linkedin ) : ?><div class="leadership_content_bottom"><?php if ( $pos ) : ?><p> <?php echo $green_diamond_svg; ?> <?php echo esc_html( $pos ); ?></p><?php endif; ?><?php if ( $linkedin ) : ?><a href="<?php echo esc_url( $linkedin ); ?>"><?php echo $linkedin_svg; ?></a><?php endif; ?></div><?php endif; ?>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php endif; ?>

		</div>

		<?php if ( $has_executive ) : ?>
		<div class="leadership_section_inner_right" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
			<?php if ( $executive['title'] || $executive['title_span'] ) : ?>
			<h4 class="h4_title_35 pb_20">
				<?php echo esc_html( $executive['title'] ?? '' ); ?> <?php if ( ! empty( $executive['title_span'] ) ) : ?><span><?php echo esc_html( $executive['title_span'] ); ?></span><?php endif; ?>
			</h4>
			<?php endif; ?>

			<!-- Desktop/Tablet View: Original List -->
			<ul class="leadership_section_inner_left_list leadership-desktop-list">
					<?php $delay = 400;
					foreach ( $executive['team_members'] as $m ) :
						$img = isset( $m['image'] ) ? $m['image'] : get_template_directory_uri() . '/assets/images/l3.png';
						$name = isset( $m['name'] ) ? $m['name'] : '';
						$pos = isset( $m['position'] ) ? $m['position'] : '';
						$linkedin = isset( $m['linkedin_url'] ) ? $m['linkedin_url'] : '';
					?>
					<li data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
						<div class="leadership_block">
							<div class="leadership_img"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $name ); ?>"></div>
							<div class="leadership_content">
								<?php if ( $name ) : ?><h4><?php echo esc_html( $name ); ?></h4><?php endif; ?>
								<?php if ( $pos || $linkedin ) : ?>
								<div class="leadership_content_bottom">
									<?php if ( $pos ) : ?><p> <?php echo $green_diamond_svg; ?> <?php echo esc_html( $pos ); ?></p><?php endif; ?>
									<?php if ( $linkedin ) : ?><a href="<?php echo esc_url( $linkedin ); ?>"><?php echo $linkedin_svg; ?></a><?php endif; ?>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</li>
					<?php $delay += 100; endforeach; ?>
			</ul>

			<!-- Mobile View: Swiper Slider Copy -->
			<div class="leadership-mobile-slider">
				<div class="swiper mySwiper-executive-team">
					<div class="swiper-wrapper">
							<?php foreach ( $executive['team_members'] as $m ) :
								$img = isset( $m['image'] ) ? $m['image'] : get_template_directory_uri() . '/assets/images/l3.png';
								$name = isset( $m['name'] ) ? $m['name'] : '';
								$pos = isset( $m['position'] ) ? $m['position'] : '';
								$linkedin = isset( $m['linkedin_url'] ) ? $m['linkedin_url'] : '';
							?>
							<div class="swiper-slide">
								<div class="leadership_block">
									<div class="leadership_img"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $name ); ?>"></div>
									<div class="leadership_content">
										<?php if ( $name ) : ?><h4><?php echo esc_html( $name ); ?></h4><?php endif; ?>
										<?php if ( $pos || $linkedin ) : ?><div class="leadership_content_bottom"><?php if ( $pos ) : ?><p> <?php echo $green_diamond_svg; ?> <?php echo esc_html( $pos ); ?></p><?php endif; ?><?php if ( $linkedin ) : ?><a href="<?php echo esc_url( $linkedin ); ?>"><?php echo $linkedin_svg; ?></a><?php endif; ?></div><?php endif; ?>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>

	</div>
</section>
