<?php
/**
 * The front page template file
 *
 * This is the template for the home page
 *
 * @package tasheel
 */

get_header();
?>

  
		<?php get_template_part( 'template-parts/Banner' ); ?>
 		<?php get_template_part( 'template-parts/About' ); ?>
 		<?php get_template_part( 'template-parts/Innovation' ); ?>
 		<?php get_template_part( 'template-parts/Services' ); ?>
 		<?php get_template_part( 'template-parts/Projects-home' ); ?>
 		<?php get_template_part( 'template-parts/Leadership' ); ?>
 		<?php get_template_part( 'template-parts/home-Partners' ); ?>
 		<?php get_template_part( 'template-parts/ready-to-partner' ); ?>
 		 

<?php
get_footer();

