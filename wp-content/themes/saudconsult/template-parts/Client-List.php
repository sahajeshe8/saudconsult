<?php
/**
 * Client List Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Our';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Clients';
$clients = isset( $args['clients'] ) ? $args['clients'] : array(
	array(
		'logo' => get_template_directory_uri() . '/assets/images/partner-01.png',
		'name' => 'Client 1',
		'link' => '#'
	),
	array(
		'logo' => get_template_directory_uri() . '/assets/images/partner-02.png',
		'name' => 'Client 2',
		'link' => '#'
	),
	array(
		'logo' => get_template_directory_uri() . '/assets/images/partner-03.png',
		'name' => 'Client 3',
		'link' => '#'
	),
	array(
		'logo' => get_template_directory_uri() . '/assets/images/partner-04.png',
		'name' => 'Client 4',
		'link' => '#'
	),
	array(
		'logo' => get_template_directory_uri() . '/assets/images/partner-05.png',
		'name' => 'Client 5',
		'link' => '#'
	)
);
$display_type = isset( $args['display_type'] ) ? $args['display_type'] : 'grid'; // 'grid' or 'slider'
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

?>

<section class="client_list_section pt_80 pb_80 <?php echo esc_attr( $section_class ); ?>">
	<div class="wrap">
		<?php if ( $title || $title_span ) : ?>
			<h4 class="h4_title_35 pb_20">
				<?php if ( $title ) : ?>
					<?php echo esc_html( $title ); ?>
				<?php endif; ?>
				<?php if ( $title_span ) : ?>
					<span><?php echo esc_html( $title_span ); ?></span>
				<?php endif; ?>
			</h4>
		<?php endif; ?>

		<?php if ( ! empty( $clients ) ) : ?>
			<?php if ( $display_type === 'slider' ) : ?>
				<div class="swiper mySwiper-clients">
					<div class="swiper-wrapper">
						<?php foreach ( $clients as $client ) : 
							$client_logo = isset( $client['logo'] ) ? $client['logo'] : '';
							$client_name = isset( $client['name'] ) ? $client['name'] : '';
							$client_link = isset( $client['link'] ) ? $client['link'] : '#';
						?>
							<div class="swiper-slide">
								<?php if ( $client_link && $client_link !== '#' ) : ?>
									<a href="<?php echo esc_url( $client_link ); ?>" class="client_item_link">
										<img src="<?php echo esc_url( $client_logo ); ?>" alt="<?php echo esc_attr( $client_name ); ?>">
									</a>
								<?php else : ?>
									<img src="<?php echo esc_url( $client_logo ); ?>" alt="<?php echo esc_attr( $client_name ); ?>">
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
			<?php else : ?>
				<ul class="client_list_grid">
					<?php foreach ( $clients as $client ) : 
						$client_logo = isset( $client['logo'] ) ? $client['logo'] : '';
						$client_name = isset( $client['name'] ) ? $client['name'] : '';
						$client_link = isset( $client['link'] ) ? $client['link'] : '#';
					?>
						<li class="client_item">
							<?php if ( $client_link && $client_link !== '#' ) : ?>
								<a href="<?php echo esc_url( $client_link ); ?>" class="client_item_link">
									<img src="<?php echo esc_url( $client_logo ); ?>" alt="<?php echo esc_attr( $client_name ); ?>">
								</a>
							<?php else : ?>
								<img src="<?php echo esc_url( $client_logo ); ?>" alt="<?php echo esc_attr( $client_name ); ?>">
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>


