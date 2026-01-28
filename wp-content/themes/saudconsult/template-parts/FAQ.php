<?php
/**
 * FAQ Component Template
 *
 * FAQ section template part
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

// Build section wrapper classes
$wrapper_classes = array( 'faq_section' );
if ( $section_wrapper_class ) {
	if ( is_array( $section_wrapper_class ) ) {
		$wrapper_classes = array_merge( $wrapper_classes, $section_wrapper_class );
	} else {
		$wrapper_classes[] = $section_wrapper_class;
	}
}
$wrapper_class_string = implode( ' ', array_map( 'esc_attr', $wrapper_classes ) );

// FAQ items - each item should have: question, answer
$faq_items = isset( $args['faq_items'] ) ? $args['faq_items'] : array();
?>

<section class="<?php echo $wrapper_class_string; ?> <?php echo esc_attr( $section_class ); ?>">
	<div class="wrap">
		<div class="faq_wrapper">
			<?php if ( !empty( $faq_items ) ) : ?>
				<h3 class="h3_title_50" data-aos="fade-up" data-aos-delay="0">
					 Frequently 
					<span  >Asked Questions</span>
				</h3>
				
				<ul class="faq_list pt_80">
					<?php foreach ( $faq_items as $index => $item ) :
						$delay = 100 + ($index * 50); 
						$question = isset( $item['question'] ) ? $item['question'] : '';
						$answer = isset( $item['answer'] ) ? $item['answer'] : '';
						$is_open = isset( $item['is_open'] ) && $item['is_open'] ? true : ( $index === 0 ? true : false );
						$faq_id = 'faq-' . $index;
					?>
						<li class="faq_item <?php echo $is_open ? 'faq_item_open' : ''; ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
							<button class="faq_question" type="button" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $faq_id ); ?>">
								<span class="faq_question_text"><?php echo esc_html( $question ); ?></span>
								<span class="faq_icon">
									<span class="faq_icon_plus">+</span>
									<span class="faq_icon_minus">−</span>
								</span>
							</button>
							<div class="faq_answer" id="<?php echo esc_attr( $faq_id ); ?>">
								<p>
								<?php echo wp_kses_post( $answer ); ?>
					</p>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>

