<?php
/**
 * Template Name: Clients
 *
 * The template for displaying the Clients page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/client-img.jpg',
		'title' => 'Clients',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>
 




<div class="  pt_80">
 
 <div class="wrap">

<div class="project_filter_container d_flex_wrap justify-content-between align-items-center">
			 



				<div class="project_filter_title">
					<h3 class="h3_title_50">
					Our
							<span>Clients</span>
						 
					</h3>
				</div>

				<div class="clients-filter-block">
					 <ul class="clients-filter-list">
						<li><a  class="active"  href="#">All</a></li>
						<li><a href="#">Government & Semi-Government sectors</a></li>
						<li><a href="#">PIF</a></li>
						<li><a href="#">Private Sectors</a></li>
					 </ul>
				</div>


				</div>

</div>


<div class="wrap">
	<?php
	// Manually specify client images
	$clients = array(
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-01.jpg',
			'name' => 'Client 02',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-02.jpg',
			'name' => 'Client 02',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-03.jpg',
			'name' => 'Client 03',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-04.jpg',
			'name' => 'Client 04',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-05.jpg',
			'name' => 'Client 05',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-06.jpg',
			'name' => 'Client 06',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-07.jpg',
			'name' => 'Client 07',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-08.jpg',
			'name' => 'Client 08',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-09.jpg',
			'name' => 'Client 09',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-10.jpg',
			'name' => 'Client 10',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-11.jpg',
			'name' => 'Client 11',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-12.jpg',
			'name' => 'Client 12',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-13.jpg',
			'name' => 'Client 13',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-14.jpg',
			'name' => 'Client 14',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-15.jpg',
			'name' => 'Client 15',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-16.jpg',
			'name' => 'Client 16',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-17.jpg',
			'name' => 'Client 17',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-18.jpg',
			'name' => 'Client 18',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-19.jpg',
			'name' => 'Client 19',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-20.jpg',
			'name' => 'Client 20',
			'link' => '#',
		),
		array(
			'logo' => get_template_directory_uri() . '/assets/images/client-20.jpg',
			'name' => 'Client 21',
			'link' => '#',
		),
	);

	get_template_part(
		'template-parts/Client-List',
		null,
		array(
			'title' => '',
			'title_span' => '',
			'clients' => $clients,
			'display_type' => 'grid',
			'section_class' => 'clients_page_grid',
			'grid_id' => 'clients-grid',
			'enable_load_more' => true,
			'load_more_btn_id' => 'load-more-clients',
			'load_more_label' => 'Load more',
		)
	);
	?>
</div>

</main><!-- #main -->

<?php
get_footer();

