<?php
/**
 * Project Filter Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Latest';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Projects';

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
$section_id = isset( $args['section_id'] ) ? $args['section_id'] : '';
$sectors_by_category = isset( $args['sectors_by_category'] ) && is_array( $args['sectors_by_category'] ) ? $args['sectors_by_category'] : array();

// Filters array - each filter should have: label, options (array), default_value
$filters = isset( $args['filters'] ) ? $args['filters'] : array(
	array(
		'label' => 'Services',
		'options' => array(
			array( 'value' => '', 'text' => 'All Services' ),
			array( 'value' => 'engineering-design', 'text' => 'Engineering Design' ),
			array( 'value' => 'construction-supervision', 'text' => 'Construction Supervision' ),
			array( 'value' => 'project-management', 'text' => 'Project Management' )
		),
		'default_value' => ''
	),
	array(
		'label' => 'Sectors',
		'options' => array(
			array( 'value' => '', 'text' => 'All Sectors' ),
			array( 'value' => 'infrastructure', 'text' => 'Infrastructure' ),
			array( 'value' => 'building', 'text' => 'Building' ),
			array( 'value' => 'transportation', 'text' => 'Transportation' )
		),
		'default_value' => ''
	),
	array(
		'label' => 'Location',
		'options' => array(
			array( 'value' => '', 'text' => 'All Locations' ),
			array( 'value' => 'riyadh', 'text' => 'Riyadh' ),
			array( 'value' => 'jeddah', 'text' => 'Jeddah' ),
			array( 'value' => 'dammam', 'text' => 'Dammam' )
		),
		'default_value' => ''
	)
);

$clear_filter_text = isset( $args['clear_filter_text'] ) ? $args['clear_filter_text'] : 'Clear Filter';
$clear_filter_link = isset( $args['clear_filter_link'] ) ? $args['clear_filter_link'] : '#';

?>
<style type="text/css">
.project_filter_section .project_filter_select.project_filter_select--disabled,
.project_filter_section .project_filter_select:disabled {
	opacity: 0.6;
	cursor: not-allowed;
	pointer-events: none;
	background-color: #f0f0f0;
}
</style>
<section <?php if ( $section_id ) : ?>id="<?php echo esc_attr( $section_id ); ?>"<?php endif; ?> class="project_filter_section pt_80  <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<script type="text/javascript">
		window.tasheelSectorsByCategory = <?php echo wp_json_encode( $sectors_by_category ); ?>;
	</script>
	<div class="wrap">
		<div class="project_filter_container">
			<?php if ( $title || $title_span ) : ?>
				<div class="project_filter_title">
					<h3 class="h3_title_50">
						<?php if ( $title ) : ?>
							<?php echo esc_html( $title ); ?>
						<?php endif; ?>
						<?php if ( $title_span ) : ?>
							<span><?php echo esc_html( $title_span ); ?></span>
						<?php endif; ?>
					</h3>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $filters ) ) : ?>
				<div class="project_filter_buttons">
					<?php foreach ( $filters as $filter ) : 
						$filter_label = isset( $filter['label'] ) ? $filter['label'] : '';
						$filter_options = isset( $filter['options'] ) ? $filter['options'] : array();
						$filter_default = isset( $filter['default_value'] ) ? $filter['default_value'] : '';
						$filter_disabled = ! empty( $filter['disabled'] );
						$filter_id = isset( $filter['filter_type'] ) && $filter['filter_type'] !== '' ? $filter['filter_type'] : sanitize_title( $filter_label );
						$select_class = 'project_filter_select' . ( $filter_disabled ? ' project_filter_select--disabled' : '' );
					?>
						<?php if ( $filter_label && ! empty( $filter_options ) ) : ?>
							<div class="project_filter_item">
								<select class="<?php echo esc_attr( $select_class ); ?>" id="filter_<?php echo esc_attr( $filter_id ); ?>" data-filter-type="<?php echo esc_attr( $filter_id ); ?>"<?php if ( $filter_disabled ) : ?> disabled="disabled" aria-disabled="true"<?php endif; ?>>
									<?php foreach ( $filter_options as $option ) : 
										$option_value = isset( $option['value'] ) ? $option['value'] : '';
										$option_text = isset( $option['text'] ) ? $option['text'] : '';
										$selected = ( $option_value === $filter_default ) ? 'selected' : '';
									?>
										<option value="<?php echo esc_attr( $option_value ); ?>" <?php echo $selected; ?>>
											<?php echo esc_html( $option_text ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>



                    <?php if ( $clear_filter_text ) : ?>
				<div class="project_filter_clear">
					<a href="<?php echo esc_url( $clear_filter_link ); ?>" class="project_filter_clear_link">
						<?php echo esc_html( $clear_filter_text ); ?>
					</a>
				</div>
			<?php endif; ?>
				</div>
			<?php endif; ?>

			
		</div>
	</div>
</section>

