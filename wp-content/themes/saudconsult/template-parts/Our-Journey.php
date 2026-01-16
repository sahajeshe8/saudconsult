<?php
/**
 * Our Journey Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title       = isset( $args['title'] ) ? $args['title'] : 'Our Journey &';
$title_span  = isset( $args['title_span'] ) ? $args['title_span'] : 'Legacy';
$description = isset( $args['description'] ) ? $args['description'] : 'Since our founding, we have been committed to excellence and innovation in engineering consultancy. Our journey spans decades of growth, achievement, and contribution to the development of Saudi Arabia.';
$milestones  = isset( $args['milestones'] ) ? $args['milestones'] : array(
	array(
		'year'   => '1965',
		'title'  => 'Founded',
		'text'   => 'Established as one of the first Saudi engineering consulting firms.',
	),
	array(
		'year'   => '1995',
		'title'  => 'Regional Growth',
		'text'   => 'Expanded multidisciplinary services across major sectors and regions.',
	),
	array(
		'year'   => '2024',
		'title'  => 'Shaping the Future',
		'text'   => 'Delivering sustainable, innovative solutions for the next generation.',
	),
);

?>

<section class="our_journey_section pt_80 pb_80 bg-style">
	<div class="wrap">
		 <div class="our_journey_row_01">
            <div class="our_journey_row_01_left">
         <h4 class="h4_title_35 pb_20">
         Our Journey & <br><span>Legacy</span>
				</h4>
            </div>
            <div class="our_journey_row_01_right">
                <p>Our legacy of excellence is built on a foundation of trust, innovation, and technical precision. Our integrated structure ensures we secure all project requirements single-handedly, minimizing risk and maximizing efficiency across the entire project lifecycle. We manage complexity, deliver quality, and build for the long term.</p>
            </div>
         </div>



         <div class="our_journey_row_02">
            <div class="our_journey_row_02_left">
               <ul class="our_journey_row_02_left_list">
                <li class="active"><span class="timeline_dot "></span> 1965 – 1980s</li> 
                <li><span class="timeline_dot"></span> 1980s – 2000s </li> 
                <li><span class="timeline_dot"></span> 2000s – Present</li> 
               <ul>
            </div>
            <div class="our_journey_row_02_right">
                dfdf dfdf df s
            </div>
 
         </div>


	</div>
</section>

