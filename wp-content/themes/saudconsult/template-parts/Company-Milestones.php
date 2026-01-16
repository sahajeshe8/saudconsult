<?php
/**
 * Company Milestones Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title       = isset( $args['title'] ) ? $args['title'] : 'Company';
$title_span  = isset( $args['title_span'] ) ? $args['title_span'] : 'Milestones';
$description = isset( $args['description'] ) ? $args['description'] : 'Our journey of growth and achievement spans decades, marked by significant milestones that reflect our commitment to excellence and innovation.';
$milestones  = isset( $args['milestones'] ) ? $args['milestones'] : array(
	array(
		'year'  => '1965',
		'title' => 'Founded',
		'text'  => 'Established as one of the first Saudi engineering consulting firms.',
	),
	array(
		'year'  => '1995',
		'title' => 'Regional Growth',
		'text'  => 'Expanded multidisciplinary services across major sectors and regions.',
	),
	array(
		'year'  => '2024',
		'title' => 'Shaping the Future',
		'text'  => 'Delivering sustainable, innovative solutions for the next generation.',
	),
);
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

?>

<section class="company_milestones_section pt_80 pb_80 <?php echo esc_attr( $section_class ); ?>">
	<div class="wrap">
		<div class="company_milestones_header pb_40">
			<?php if ( $title || $title_span ) : ?>
				<h3 class="h3_title_50">
					<?php if ( $title ) : ?>
						<?php echo wp_kses_post( $title ); ?>
					<?php endif; ?>
					<?php if ( $title_span ) : ?>
						<span><?php echo wp_kses_post( $title_span ); ?></span>
					<?php endif; ?>
				</h3>
			<?php endif; ?>

			<?php if ( $description ) : ?>
				<p class="company_milestones_desc"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $milestones ) ) : ?>
			<ul class="company_milestones_list">
				<?php foreach ( $milestones as $index => $milestone ) :
					$milestone_year  = isset( $milestone['year'] ) ? $milestone['year'] : '';
					$milestone_title = isset( $milestone['title'] ) ? $milestone['title'] : '';
					$milestone_text  = isset( $milestone['text'] ) ? $milestone['text'] : '';
					if ( ! $milestone_year && ! $milestone_title && ! $milestone_text ) {
						continue;
					}
					?>
					<li class="company_milestones_card">
						<?php if ( $milestone_year ) : ?>
							<div class="company_milestones_year">
								<span><?php echo esc_html( $milestone_year ); ?></span>
							</div>
						<?php endif; ?>

						<div class="company_milestones_content">
							<?php if ( $milestone_title ) : ?>
								<h4 class="h4_title_30"><?php echo esc_html( $milestone_title ); ?></h4>
							<?php endif; ?>

							<?php if ( $milestone_text ) : ?>
								<p class="company_milestones_text"><?php echo wp_kses_post( $milestone_text ); ?></p>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>



