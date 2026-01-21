<?php
/**
 * Template Name: News Detail
 *
 * The template for displaying the News Detail page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/news-banner-01.jpg',
		'title' => 'News Detail',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$breadcrumb_data = array(
		'breadcrumb_items' => array(
			array(
				'url' => esc_url( home_url( '/' ) ),
				'icon' => true
			),
			array(
				'title' => 'Media Center',
				'url' => esc_url( home_url( '/media-center' ) )
			),
			array(
				'title' => 'News',
				'url' => esc_url( home_url( '/news' ) )
			),
			array(
				'title' => 'Saud Consult Secures Design Contract for Jeddah\'s New Central Utility Plant',
				'url' => '' // Empty URL makes it active
			)
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data ); 
	?>

	<section class="news_detail_section pt_80 pb_80">
		<div class="wrap">
			<div class="news_detail_container">
				
				<h1 class="h3_title_50 text-black">Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant</h1>
				<div class="news_detail_header">
					<span class="news_detail_date">September 03, 2020</span>
					 
				</div>
				<div class="news_detail_image">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-detail-image.jpg' ); ?>" alt="News Detail">
				</div>

		  <div class="news_detail_content">
            <div class="news_detail_left_block">
                <span class="update_lable">Update</span>
                <h5>News - November 13, 2024</h5>

                <ul class="news_detail_share_list">
                    <li>
                    Share:
                    </li>
                    <li>
                        <a href="#">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/fb-n.svg' ); ?>" alt="News">
                        </a>    
                    <li>
                    <li>
                        <a href="#">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/insta-n.svg' ); ?>" alt="News">
                        </a>    
                    <li>
                    <li>
                        <a href="#">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/x-n.svg' ); ?>" alt="News">
                        </a>    
                    <li>
                    <li>
                        <a href="#">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/in-n.svg' ); ?>" alt="News">
                        </a>    
                    <li>
                    
                </ul>
            </div>
            <div class="news_detail_right_block">
                <h5>Dubai, UAE, 25 August 2020</h5>


                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum justo quis tempor elementum. Cras dapibus, ante non egestas viverra, mi ante venenatis est, non feugiat sem elit eu nisl. Vivamus efficitur luctus rutrum. Nulla nisi turpis, elementum in cursus venenatis, vehicula non ante. Maecenas fermentum odio ut nisi tempus interdum. Sed posuere, mi eu tempor accumsan, mi sem consectetur quam, vel ultrices sapien enim sit amet felis. Phasellus mattis nulla ac condimentum scelerisque. Etiam accumsan non neque eget mattis. Vestibulum luctus fermentum sodales. Vivamus finibus cursus mollis. Integer condimentum finibus nibh id egestas. Curabitur efficitur nibh eros, in interdum risus ultrices at. Mauris neque lorem, fringilla sit amet elementum vitae, posuere a velit. Proin ac neque non nisi bibendum tincidunt id et neque.</p>

<p>Donec pellentesque orci tincidunt, ultricies dui at, pharetra metus. In in dolor egestas, lacinia enim vel, congue turpis. Nam in ligula lobortis, ultrices purus ut, sodales orci. Donec nulla nibh, condimentum in mauris quis, molestie luctus diam. Sed eget enim quis sapien fermentum consequat. Morbi dictum molestie lorem, ut faucibus enim sodales quis. Quisque nec augue consectetur justo facilisis laoreet. Nunc vulputate interdum nunc, nec tincidunt felis pellentesque fringilla. Sed elementum sed sem tempus tempus. Cras dapibus efficitur diam vitae finibus. Sed nec metus dolor. Praesent consequat eget purus id laoreet. Sed luctus, nibh sit amet ultricies placerat, orci dui imperdiet nibh, a porta arcu nisi eget nisl. Pellentesque quis rhoncus velit. Mauris pellentesque dui sed orci efficitur lobortis. Proin aliquet fringilla accumsan.</p>

<p>Morbi a ex ac sem malesuada elementum. Aliquam posuere dui quis mattis tincidunt. Maecenas iaculis est vitae dui luctus porttitor. Aliquam tristique iaculis dolor porta euismod. Sed eu lacus maximus, cursus risus vitae, scelerisque nulla. Quisque porttitor velit velit, id sagittis sem imperdiet sed. Ut pulvinar vestibulum orci ut lobortis. Donec facilisis justo ac mauris mattis posuere vitae ac elit.</p>

<p>Phasellus quis maximus risus. Etiam dictum vel libero eu convallis. Etiam accumsan dolor vitae augue aliquet mattis placerat et nisi. Suspendisse sollicitudin imperdiet metus hendrerit lobortis. Integer vulputate sodales odio, id ullamcorper nibh faucibus ac. Morbi blandit tincidunt libero, et pulvinar sem. Pellentesque tristique magna sed nisl porttitor, in faucibus lorem vulputate. Nullam cursus turpis lacinia nibh rhoncus imperdiet. Nunc vel magna consequat, finibus quam id, posuere dui.</p>
            </div>
          </div>
				</div>
			</div>
		</div>
	</section>

	<?php 
	$insights_resources_data = array(
		'label' => '',
		'title' => 'Related Posts',
		'title_span' => '',
		'title_break' => true,
		'section_class' => 'bg_color_01' // Add custom CSS classes here, e.g., 'custom-class another-class'
	);
	get_template_part( 'template-parts/Insights-Resources', null, $insights_resources_data ); 
	?>

</main><!-- #main -->

<?php
get_footer();

