<?php 
/**
* Template Name: Homepage
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/home.css?ver=1.0" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/slick-theme.css?ver=1.0" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/slick.css?ver=1.0" rel="stylesheet">
<?php get_header()?>
<main>

	
	
<div style="display:none">
<input type="chekbox" id="options-rewind-checkbox" name="">
<input type="chekbox" id="options-rewind-checkbox2" name="">
<input type="chekbox" id="options-rewind-checkboxs" name="">
<input type="chekbox" id="options-rewind-checkboxb" name="">
<input type="chekbox" id="options-rewind-checkboxem" name="">
</div>

<?php // flexible
if( have_rows('home_page_section') ): ?>
    <?php while( have_rows('home_page_section') ): the_row(); ?>

	<?php if( get_row_layout() == 'hm_banner_section' ): ?>

		<section class="hero-banner">
		
	  <?php 
	  if(get_sub_field('vedio')){
	  ?>
		<div class="hero-video">
	       <video class="lazy" id="hm-video" autoplay loop muted playsinline poster="<?php echo get_sub_field('vedio_cover_image')['url']; ?>">
	        	<source data-src="<?php echo get_sub_field('vedio'); ?>" type="video/mp4">
	       </video> 
    	</div>
		<?php } ?>
    	<div class="video-content-overlay">
    		<div class="container">
    			<div class="content-overlay-inside">
    				<h1><?php echo get_sub_field('Banner_title'); ?></h1>
	       			<?php if ( wp_is_mobile() ){ ?>
	       			<div class="text-block-mobile">
	       				<?php echo get_sub_field('mobile_content'); ?>
						<?php 
					/*$mobile_banner_button = get_sub_field('mobile_banner_button_');
					if( $mobile_banner_button ): ?>
	       				<a href="<?php echo $mobile_banner_button['url']; ?>" target="<?php echo $mobile_banner_button['target']; ?>"><?php echo $mobile_banner_button['title']; ?></a>
						 <?php endif;*/ ?>
	       			</div>
	       		<?php } else { ?>
	       			<div class="text-block-desktop">
						<?php echo get_sub_field('desktop_content'); ?>
	       			
	       			</div>
	       		<?php } ?>
				<?php 
					$banner_button = get_sub_field('banner_button');
					if( $banner_button ): ?>
	       			<a href="<?php echo $banner_button['url']; ?>" class="btn-link" target="<?php echo $banner_button['target']; ?>"><?php echo $banner_button['title']; ?><span class="arrow-img"></span></a>
					 <?php endif; ?>
    			</div>	
    		</div>
	       	
	     </div>
		 



		<div class="hero-banner-widget">
			<div class="weather-widget">
				<span class="heading-temp"><?php echo get_sub_field('weather_title'); ?></span>
				<div class="weather-inside-wrap">
					<figure>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/weather-image.png" alt="icon">	
					</figure>
					<div class="temp-date-sec">
						<?php
						include "weather_class.php";
						$weatherdata = new Currentweather;
						$getFullJson = $weatherdata->getFullJson($weatherdata->locationbycity(25.204849, 55.270782));
						$main = $getFullJson->main;
						 
						
						function locationbycity($lat, $lon) {
							$apikey = '141322a5ac0e93e95ca1a0dd2e7a9bf1';
							$currenturl = "http://api.openweathermap.org/data/2.5/weather?lat=". str_replace(' ', '%20', $lat) ."&lon=". str_replace(' ', '%20', $lon) ."&units=metric&appid=". $apikey ."&cnt=1";
							  return $currenturl;
						  }
						?>
						<p><?php echo date("D M jS"); ?></p>
						<?php
						$tz = 'Asia/Dubai'; // your required location time zone.
						$timestamp = time();
						$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
						$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
						
						?>
						<p><?php echo $dt->format('g:i a'); ?></p>
						<p><?php echo round($main->temp).' °C'; ?></p>
					</div>
				</div>
			</div>


							
					      
	 <?php
global $wpdb;
$table_name = $wpdb->prefix . 'Stockmarket'; // replace 'my_table' with your table name
$result = $wpdb->get_results( "SELECT * FROM  ".$table_name );
?>   				
			<div class="stock-market-widget">
				<span class="heading-temp"><?php echo get_sub_field('stock_market_title'); ?></span>
				<div class="stock-slider-area">
					<div class="glide" id="stock-slider">
						<div class="glide__track" data-glide-el="track">
							 <ul class="glide__slides">	
									<?php foreach ($result as $row) { ?>
										<!-- 
										$id = $row->ID;   
										$name = $row->Symbol;
										$price = $row->Price;
										$valuechange = $row->ValueChange;
										$changepercent = $row->ChangePercent;
										$weeklypercent = $row->WeeklyPercent;
										$valuedate = $row->Valuedate;
										-->
										<li class="glide__slide">
											<div class="stock-slide">
												<h4><?php echo $row->Symbol; ?></h4>
												<p>$ <?php echo $row->Price; ?></p>												
													<?php $string = $row->WeeklyPercent;
													if (substr($string, 0, 1) === "-") {
														echo '<span class="stock-down">';
													} else {
														echo '<span class="stock-up">';
													} ?>
													<i class="fa-solid fa-arrow-up"></i><?php echo $row->WeeklyPercent; ?>% this week</span>	
											</div>
										</li>
									<?php } ?>
							 </ul>
 				

	    				</div>
	    				<div class="glide__arrows" data-glide-el="controls">
						    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
						    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
					  </div>
					</div>
				</div>
			</div>
			
			<div class="news-widget">
				<span class="heading-temp"><?php echo get_sub_field('news_title'); ?></span>
				<div class="top-news-slider-area">
					<div class="glide" id="news-top">						
							<?php 
							$news_lisings = get_sub_field('news_banner');
                   		    if( $news_lisings ): ?>
							<div class="glide__track" data-glide-el="track">
					      <ul class="glide__slides">
					        <?php  foreach( $news_lisings as $post ): 
									setup_postdata($post);  ?>
						 	 <li class="glide__slide">
					        	<div class="news-top-slide">
					        		<a href="<?php the_permalink(); ?>">
					        		<figure>
										<picture>
											<?php $webp_image = get_field('webp_image');
										if( !empty( $webp_image ) ): ?>
										<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
										<?php /* else: ?>
										<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/webp">
										<?php */ endif; ?>
										<?php 
										$jpg_image = get_field('post_image');
										if( !empty( $jpg_image ) ): ?>
										<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
										<?php else: ?>
										<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/jpg">
										<?php endif; ?>
										<?php 
										$jpg_image = get_field('post_image');
										if( !empty( $jpg_image ) ): ?>
										<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
										<?php else: 	
										$content = get_the_content();
										$first_image = '';

										if (preg_match('/<img.+?src="(.+?)"/', $content, $matches)) {
										$first_image = $matches[1];
										}

										if (!empty( $first_image )) {
													//	var_dump($first_image);
											// Display the first image
												echo '<source srcset="' . $first_image . '" alt=""  type="image/jpg">';
												echo '<img src="' . $first_image . '" alt="">';
											} else {
												echo '<source srcset="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt=""  type="image/jpg">';
												echo '<img src="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="">';
												
											}
											endif; ?>
										<?php /*
										$jpg_image = get_field('post_image');
										if( !empty( $jpg_image ) ): ?>
										<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
										<?php else: ?>
										<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="image">
										<?php endif; */ ?>
										</picture>
									  <figcaption>
									  	<?php the_title(); ?>
									  </figcaption>
									  
									</figure>
									</a>
					        	</div>
					        </li>
					        <?php wp_reset_query(); endforeach; ?> 
					      </ul>
						</div>
					<div class="glide__arrows" data-glide-el="controls">
						    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
						    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
					  </div>

						  <?php else: ?>
							<?php 

							$i = $i+1;

							$args = array(
								'post_status'     => array('publish'),
								'post_type'       => array('post','deep_dive','guide'),
								'orderby'         => 'date',
								'order'           => 'DESC',
								'paged'           => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
								'cat'             => $get_queried_object_id,
								'posts_per_page' => 10,

							);


							$the_query = new WP_Query( $args );

							if ( $the_query->have_posts() ){ ?>
						<div class="glide__track" data-glide-el="track">
							  <ul class="glide__slides">
								<?php  while ( $the_query->have_posts() ){
											$the_query->the_post(); 
											?>

											<li class="glide__slide">
					        	<div class="news-top-slide">
					        		<figure>
										<picture>
											<?php $webp_image = get_field('webp_image');
										if( !empty( $webp_image ) ): ?>
										<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
										<?php /* else: ?>
										<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/webp">
										<?php */ endif; ?>
										<?php 
										$jpg_image = get_field('post_image');
										if( !empty( $jpg_image ) ): ?>
										<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
										<?php else: ?>
										<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/jpg">
										<?php endif; ?>
										<?php 
										$jpg_image = get_field('post_image');
										if( !empty( $jpg_image ) ): ?>
										<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
										<?php else: ?>
										<img src="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="image">
										<?php endif; ?>
										</picture>
									  <figcaption>
									  	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									  </figcaption>
									</figure>
					        	</div>
					        </li>

											<?php } ?>

							  </ul>
							   </div>
						<?php wp_reset_query(); } ?>

					   
					    <div class="glide__arrows" data-glide-el="controls">
						    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
						    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
					  </div>
					<?php  endif; ?>
					</div>
				</div>
			</div>


		</div>
	</section>

<?php elseif( get_row_layout() == 'services_section' ): ?>
	<?php 
      $services = get_sub_field('services'); 
      if( $services ): ?>
	<section class="content-sec-0">
		<div class="container">
			<div class="heading-widget">
					<?php if($services['services_title']){?><span class="sub_heading"><?php echo $services['services_title']; ?></span><?php } ?>
				<?php if($services['services_sub_title']){?><h2><?php echo $services['services_sub_title']; ?></h2><?php } ?>
				<?php echo $services['services_content']; ?>
			</div>
			<?php
$services_listings = $services['services_listings'];
if( $services_listings ): ?>
			<div class="glide" id="service-slider">
					<div class="glide__track" data-glide-el="track">

						<ul class="glide__slides hm-services-listing">
<?php foreach($services_listings as $ls_image){ ?>
							<li class="glide__slide" >
							    
								<div class="service-list-wrap">
								    <?php $ls_link = $ls_image['ls_link']; 
								    ?>
								    <a href="<?php echo $ls_link['url']; ?>">
									<figure class="service-image-wrap">
										<picture>
										 <?php if( !empty($ls_image['webp_image']) ){ ?> <source srcset="<?php echo $ls_image['webp_image']['url']; ?>" type="image/webp"><?php } ?>
										 <?php if( !empty($ls_image['ls_image']) ){ ?> <source srcset="<?php echo $ls_image['ls_image']['url']; ?>" type="image/jpeg"><?php } ?>
										 <?php if( !empty($ls_image['ls_image']) ){ ?> <img src="<?php echo $ls_image['ls_image']['url']; ?>" alt=<?php echo $ls_image['ls_image']['alt']; ?>> <?php } ?>
										</picture>
									</figure>
									<div class="service-content-wrap">
										<h3><?php echo $ls_image['ls_title']; ?></h3>
										<?php echo $ls_image['ls_content']; ?>	
																			
					<?php 
					$ls_link = $ls_image['ls_link']; 
					if( $ls_link ): ?>
	       			<span class="btn-link" target="<?php echo $ls_link['target']; ?>"><?php echo $ls_link['title']; ?><span class="arrow-img"></span></span>
					 <?php endif; ?>

									</div>
									</a>
								</div>
								
							</li>
<?php } ?>


						</ul>
					</div>

					<div class="glide__arrows" data-glide-el="controls">
						<button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
						<button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
					</div>
					<div class="glide__bullets" data-glide-el="controls[nav]">
					    <button class="glide__bullet" data-glide-dir="=0"></button>
					    <button class="glide__bullet" data-glide-dir="=1"></button>
					    <button class="glide__bullet" data-glide-dir="=2"></button>
					 </div>
					 <?php endif; ?>
			</div>
	</section>
	<?php endif; ?>

<?php elseif( get_row_layout() == 'ecosystem_section_mobile' ): ?>

	
	<?php if ( wp_is_mobile() ){ ?>
	<section class="echo-system-mobile">
		<div class="container">
			<h2><?php echo get_sub_field('main_title'); ?></h2>
		</div>
<?php if( have_rows('ecosystem') ):  $ec= 0;?>

			<ul class="echo-system-list">
				  <?php while( have_rows('ecosystem') ): the_row(); $ec= $ec+1; ?>
				  
				<li>
					<div class="echo-system-area show-echo-slider">
					    <span data-slide="<?php echo $ec; ?>"></span>
						<figure>
							<picture>
								<?php if( get_sub_field('ecosystem_m_webp_image') ){ ?><source srcset="<?php echo get_sub_field('ecosystem_m_webp_image')['url']; ?>" type="image/webp"><?php } ?>
								<?php if( get_sub_field('ecosystem_m_image') ){ ?><source srcset="<?php echo get_sub_field('ecosystem_m_image')['url']; ?>" type="image/png"><?php } ?>
								<?php if( get_sub_field('ecosystem_m_image') ){ ?><img src="<?php echo get_sub_field('ecosystem_m_image')['url']; ?>" alt=image><?php } ?>
							</picture>
							<figcaption>
								<h4><?php echo get_sub_field('ecosystem_m_title'); ?></h4>
							</figcaption>
						</figure>
					</div>
				</li>
			<?php endwhile; ?>

				
			</ul>
	<?php endif; ?>

		<div class="echo-mob-slider-wrap">
				<span class="slider-close"><i class="fa-solid fa-xmark"></i></span>
				<?php if( have_rows('ecosystem') ): ?> 
				<div class="echo-mob-slider">
				    <?php $sl=0; $mr=0; $mord =array('mob-overlay-a','mob-overlay-c','mob-overlay-e','mob-overlay-l','mob-overlay-p','mob-overlay-m');
                        $m=1; while( have_rows('ecosystem') ): the_row(); $sl = $sl+1; ?>
				    <div>
				        <div class="echo-slide-area">
				        		<div class="echo-slide-content">
				        			<h4><?php echo get_sub_field('popup_title'); ?></h4>
				        			<span><?php echo get_sub_field('popup_sub_title'); ?></span>
				        			<?php echo get_sub_field('popup_content'); ?>
									<?php 
								$popup_link = get_sub_field('popup_link'); 
								if( $popup_link ): ?>
								<a href="<?php echo $popup_link['url']; ?>" class="btn-link" target="<?php echo $popup_link['target']; ?>"><?php echo $popup_link['title']; ?><span class="arrow-img"></span></a>												
				        		 <?php endif; ?>
								</div>
				        		<div class="echo-slide-video">									
								 <video class="<?php echo $mord[$mr]; ?> clip-video lazy" loop autoplay muted playsinline >
								 <?php 					 
								if( get_sub_field('popup_video_link') ){ ?>
						        	<source data-src="<?php echo get_sub_field('popup_video_link'); ?>" type="video/mp4">
								<?php } else {?>
									<source data-src="<?php echo get_template_directory_uri(); ?>/assets/videos/dummy.mp4" type="video/mp4">
								<?php }  ?>
						       	</video> 
						        <div class="video-overlay-letter">
									<?php if($m==1) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="247.772" height="230.001" viewBox="0 0 247.772 230.001">
									  <path id="Exclusion_2" data-name="Exclusion 2" d="M247.773,230H0V0H247.773V230Zm-162.63-47.43h77l11,42.429h69.143L181,5H66.286L5,225H74.143l11-42.429ZM148,129.143H99.285L115,66.286h17.285Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==2) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="240.455" height="230.001" viewBox="0 0 240.455 230.001">
									  <path id="Exclusion_5" data-name="Exclusion 5" d="M240.455,230H0V0H240.455V230ZM122.432,5C88.9,5,60.639,15.753,38.446,36.96S5,84.424,5,115s11.253,56.834,33.446,78.04S88.9,225,122.432,225c39.06,0,69.868-15.2,91.568-45.189a139.919,139.919,0,0,0,21.406-45.487H167.027a38.842,38.842,0,0,1-8.324,15.757,43.1,43.1,0,0,1-7.172,6.763,41.34,41.34,0,0,1-8.436,4.831,52.5,52.5,0,0,1-20.663,3.865,53,53,0,0,1-19.51-3.419A41.828,41.828,0,0,1,87.8,151.866a44.709,44.709,0,0,1-9.7-16.054A62.916,62.916,0,0,1,74.866,115,62.918,62.918,0,0,1,78.1,94.19a44.7,44.7,0,0,1,9.7-16.054,41.82,41.82,0,0,1,15.125-10.257,53,53,0,0,1,19.51-3.419,54.169,54.169,0,0,1,18.879,3.2,47.543,47.543,0,0,1,15.608,9.588,34.359,34.359,0,0,1,8.621,12.486h68.378a113.888,113.888,0,0,0-20.513-42.215C192.3,19.3,161.69,5,122.432,5Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==3) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="184" height="230.001" viewBox="0 0 184 230.001">
									  <path id="Exclusion_3" data-name="Exclusion 3" d="M184,230H0V0H184V230ZM4,5H4V225H180V165.286H74.714V140.143H158V89.857H74.714V64.715H180V5Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==4) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="178.772" height="230.001" viewBox="0 0 178.772 230.001">
									  <path id="Exclusion_4" data-name="Exclusion 4" d="M178.772,230H0V0H178.772V230ZM4,5H4V225H175.287V162.143H74.714V5Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==5) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="218" height="230.578" viewBox="0 0 218 230.578">
									  <path id="Exclusion_1" data-name="Exclusion 1" d="M218,230.578H0V0H218V230.577ZM5,5H5V225H75.715V171.572h44c27.737,0,50.365-7.983,67.257-23.728s25.457-35.784,25.457-59.558-8.565-43.811-25.457-59.557S147.452,5,119.715,5H5ZM113.429,111.857H75.715V64.715h37.714a37.846,37.846,0,0,1,11.393,1.571A22.456,22.456,0,0,1,133.229,71a20.1,20.1,0,0,1,5.186,7.464,28.765,28.765,0,0,1,0,19.643,20.1,20.1,0,0,1-5.186,7.464,22.456,22.456,0,0,1-8.407,4.714A37.846,37.846,0,0,1,113.429,111.857Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==6) { ?>
											<svg xmlns="http://www.w3.org/2000/svg" width="284.364" height="230.001" viewBox="0 0 284.364 230.001">
									  <path id="Exclusion_6" data-name="Exclusion 6" d="M284.364,230H0V0H284.364V230ZM208.715,86.713h3.143L207.143,115V225h70.714V5H182L145.858,111.857H138L101.858,5H6V225H76.714V115L72,86.714h3.143l31.429,88h70.714l31.429-88Z" fill="#fff"/>
									</svg>
								
									<?php } else{ } ?>
				       			</div>
							</div>
				        	</div>
				    </div>
				    <?php $m++; $mr++; endwhile; ?>
				</div>
				<?php endif; ?>
				
				<!--<div class="glide" id="echo-mob-slider">
					<div class="glide__track" data-glide-el="track">	
				   <?php if( have_rows('ecosystem') ): ?> 
					<ul class="glide__slides">
 <?php $sl=0; $mr=0; $mord =array('mob-overlay-a','mob-overlay-c','mob-overlay-e','mob-overlay-l','mob-overlay-p','mob-overlay-m');
 $m=1; while( have_rows('ecosystem') ): the_row(); $sl = $sl+1; ?> 
				        <li class="glide__slide" id="glide__slide-<?php echo $sl;?>">
				        	<div class="echo-slide-area">
				        		<div class="echo-slide-content">
				        			<h4><?php echo get_sub_field('popup_title'); ?></h4>
				        			<span><?php echo get_sub_field('popup_sub_title'); ?></span>
				        			<?php echo get_sub_field('popup_content'); ?>
									<?php 
								$popup_link = get_sub_field('popup_link'); 
								if( $popup_link ): ?>
								<a href="<?php echo $popup_link['url']; ?>" class="btn-link" target="<?php echo $popup_link['target']; ?>"><?php echo $popup_link['title']; ?><span class="arrow-img"></span></a>												
				        		 <?php endif; ?>
								</div>
				        		<div class="echo-slide-video">									
								 <video class="<?php echo $mord[$mr]; ?> clip-video lazy" loop autoplay muted playsinline >
								 <?php 					 
								if( get_sub_field('popup_video_link') ){ ?>
						        	<source data-src="<?php echo get_sub_field('popup_video_link'); ?>" type="video/mp4">
								<?php } else {?>
									<source data-src="<?php echo get_template_directory_uri(); ?>/assets/videos/dummy.mp4" type="video/mp4">
								<?php }  ?>
						       	</video> 
						        <div class="video-overlay-letter">
									<?php if($m==1) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="247.772" height="230.001" viewBox="0 0 247.772 230.001">
									  <path id="Exclusion_2" data-name="Exclusion 2" d="M247.773,230H0V0H247.773V230Zm-162.63-47.43h77l11,42.429h69.143L181,5H66.286L5,225H74.143l11-42.429ZM148,129.143H99.285L115,66.286h17.285Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==2) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="240.455" height="230.001" viewBox="0 0 240.455 230.001">
									  <path id="Exclusion_5" data-name="Exclusion 5" d="M240.455,230H0V0H240.455V230ZM122.432,5C88.9,5,60.639,15.753,38.446,36.96S5,84.424,5,115s11.253,56.834,33.446,78.04S88.9,225,122.432,225c39.06,0,69.868-15.2,91.568-45.189a139.919,139.919,0,0,0,21.406-45.487H167.027a38.842,38.842,0,0,1-8.324,15.757,43.1,43.1,0,0,1-7.172,6.763,41.34,41.34,0,0,1-8.436,4.831,52.5,52.5,0,0,1-20.663,3.865,53,53,0,0,1-19.51-3.419A41.828,41.828,0,0,1,87.8,151.866a44.709,44.709,0,0,1-9.7-16.054A62.916,62.916,0,0,1,74.866,115,62.918,62.918,0,0,1,78.1,94.19a44.7,44.7,0,0,1,9.7-16.054,41.82,41.82,0,0,1,15.125-10.257,53,53,0,0,1,19.51-3.419,54.169,54.169,0,0,1,18.879,3.2,47.543,47.543,0,0,1,15.608,9.588,34.359,34.359,0,0,1,8.621,12.486h68.378a113.888,113.888,0,0,0-20.513-42.215C192.3,19.3,161.69,5,122.432,5Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==3) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="184" height="230.001" viewBox="0 0 184 230.001">
									  <path id="Exclusion_3" data-name="Exclusion 3" d="M184,230H0V0H184V230ZM4,5H4V225H180V165.286H74.714V140.143H158V89.857H74.714V64.715H180V5Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==4) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="178.772" height="230.001" viewBox="0 0 178.772 230.001">
									  <path id="Exclusion_4" data-name="Exclusion 4" d="M178.772,230H0V0H178.772V230ZM4,5H4V225H175.287V162.143H74.714V5Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==5) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="218" height="230.578" viewBox="0 0 218 230.578">
									  <path id="Exclusion_1" data-name="Exclusion 1" d="M218,230.578H0V0H218V230.577ZM5,5H5V225H75.715V171.572h44c27.737,0,50.365-7.983,67.257-23.728s25.457-35.784,25.457-59.558-8.565-43.811-25.457-59.557S147.452,5,119.715,5H5ZM113.429,111.857H75.715V64.715h37.714a37.846,37.846,0,0,1,11.393,1.571A22.456,22.456,0,0,1,133.229,71a20.1,20.1,0,0,1,5.186,7.464,28.765,28.765,0,0,1,0,19.643,20.1,20.1,0,0,1-5.186,7.464,22.456,22.456,0,0,1-8.407,4.714A37.846,37.846,0,0,1,113.429,111.857Z" fill="#fff"/>
									</svg>
									<?php } elseif($m==6) { ?>
											<svg xmlns="http://www.w3.org/2000/svg" width="284.364" height="230.001" viewBox="0 0 284.364 230.001">
									  <path id="Exclusion_6" data-name="Exclusion 6" d="M284.364,230H0V0H284.364V230ZM208.715,86.713h3.143L207.143,115V225h70.714V5H182L145.858,111.857H138L101.858,5H6V225H76.714V115L72,86.714h3.143l31.429,88h70.714l31.429-88Z" fill="#fff"/>
									</svg>
								
									<?php } else{ } ?>
				       			</div>
							</div>
				        	</div>
				        </li>
						<?php $m++; $mr++; endwhile; ?>
						
				      </ul>
					  	<?php endif; ?>
    				</div>
				</div>-->
			</div>
	</section>
	<?php } else{ ?>

	<section class="black-bg-sec">
		<div class="container">
			<div class="ecosystem">
				<span class="sub_heading"><?php echo get_sub_field('desktop_title'); ?></span>
				<h2><?php echo get_sub_field('desktop_content'); ?></h2>
			</div>
		</div>
	</section>
	<?php if( have_rows('deskstop_ecosystem') ): ?> 
	<section class="tabs-sec">
		<div class="ifza-tabs-wrap">
 <?php $r=0; $ord =array('video-overlay-a','video-overlay-c','video-overlay-e','video-overlay-l','video-overlay-p','video-overlay-m');
 $mc=0; $mcord =array('video-wrap-a','video-wrap-c','video-wrap-e','video-wrap-l','video-wrap-p','video-wrap-m');
 $d=1; while( have_rows('deskstop_ecosystem') ): the_row();  ?> 
			<div class="ifza-tabs-panel <?php  if($d==1) { echo 'ifza-tabs-panel-first';} ?>">
				<figure class="ifza-tab-header <?php  if($d==1) { echo 'ifza-tab-header-first active'; }?>">
					<picture>
					<?php if( get_sub_field('horizontal_webp_image') ){ ?><source srcset="<?php echo get_sub_field('horizontal_webp_image')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('horizontal_image') ){ ?><source srcset="<?php echo get_sub_field('horizontal_image')['url']; ?>" type="image/png"><?php } ?>
					<?php if( get_sub_field('horizontal_image') ){ ?><img src="<?php echo get_sub_field('horizontal_image')['url']; ?>" alt=image><?php } ?>
							</picture>
					<figcaption>
						<?php echo get_sub_field('horizontal_title'); ?>
					</figcaption>
				</figure>
				<div class="ifza-body <?php  if($d==1) { echo 'ifza-body-show'; }?>">
					<div class="ifza-tab-body">
					<div class="video-wrap <?php echo $mcord[$mc]; ?>">
						 <video class="<?php echo $ord[$r]; ?> clip-video lazy" autoplay loop muted playsinline>
						 <?php 					 
								if( get_sub_field('horizontal_video_link') ){ ?>
						        	<source data-src="<?php echo get_sub_field('horizontal_video_link'); ?>" type="video/mp4">
								<?php } else {?>
									<source data-src="<?php echo get_template_directory_uri(); ?>/assets/videos/dummy.mp4" type="video/mp4">
								<?php }  ?>
				        	
				       	</video>
				       	  <div class="video-overlay-letter">
									<?php if($d==1) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="247.772" height="230.001" viewBox="0 0 247.772 230.001">
							  <path id="Exclusion_2" data-name="Exclusion 2" d="M247.773,230H0V0H247.773V230Zm-162.63-47.43h77l11,42.429h69.143L181,5H66.286L5,225H74.143l11-42.429ZM148,129.143H99.285L115,66.286h17.285Z" fill="#fff"/>
							</svg>
									<?php } elseif($d==2) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="240.455" height="230.001" viewBox="0 0 240.455 230.001">
							  <path id="Exclusion_5" data-name="Exclusion 5" d="M240.455,230H0V0H240.455V230ZM122.432,5C88.9,5,60.639,15.753,38.446,36.96S5,84.424,5,115s11.253,56.834,33.446,78.04S88.9,225,122.432,225c39.06,0,69.868-15.2,91.568-45.189a139.919,139.919,0,0,0,21.406-45.487H167.027a38.842,38.842,0,0,1-8.324,15.757,43.1,43.1,0,0,1-7.172,6.763,41.34,41.34,0,0,1-8.436,4.831,52.5,52.5,0,0,1-20.663,3.865,53,53,0,0,1-19.51-3.419A41.828,41.828,0,0,1,87.8,151.866a44.709,44.709,0,0,1-9.7-16.054A62.916,62.916,0,0,1,74.866,115,62.918,62.918,0,0,1,78.1,94.19a44.7,44.7,0,0,1,9.7-16.054,41.82,41.82,0,0,1,15.125-10.257,53,53,0,0,1,19.51-3.419,54.169,54.169,0,0,1,18.879,3.2,47.543,47.543,0,0,1,15.608,9.588,34.359,34.359,0,0,1,8.621,12.486h68.378a113.888,113.888,0,0,0-20.513-42.215C192.3,19.3,161.69,5,122.432,5Z" fill="#fff"/>
							</svg>
									<?php } elseif($d==3) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="184" height="230.001" viewBox="0 0 184 230.001">
							  <path id="Exclusion_3" data-name="Exclusion 3" d="M184,230H0V0H184V230ZM4,5H4V225H180V165.286H74.714V140.143H158V89.857H74.714V64.715H180V5Z" fill="#fff"/>
							</svg>
									<?php } elseif($d==4) { ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="178.772" height="230.001" viewBox="0 0 178.772 230.001">
							  <path id="Exclusion_4" data-name="Exclusion 4" d="M178.772,230H0V0H178.772V230ZM4,5H4V225H175.287V162.143H74.714V5Z" fill="#fff"/>
							</svg>
									<?php } elseif($d==5) { ?>
										<svg xmlns="http://www.w3.org/2000/svg" width="218" height="230.578" viewBox="0 0 218 230.578">
						  <path id="Exclusion_1" data-name="Exclusion 1" d="M218,230.578H0V0H218V230.577ZM5,5H5V225H75.715V171.572h44c27.737,0,50.365-7.983,67.257-23.728s25.457-35.784,25.457-59.558-8.565-43.811-25.457-59.557S147.452,5,119.715,5H5ZM113.429,111.857H75.715V64.715h37.714a37.846,37.846,0,0,1,11.393,1.571A22.456,22.456,0,0,1,133.229,71a20.1,20.1,0,0,1,5.186,7.464,28.765,28.765,0,0,1,0,19.643,20.1,20.1,0,0,1-5.186,7.464,22.456,22.456,0,0,1-8.407,4.714A37.846,37.846,0,0,1,113.429,111.857Z" fill="#fff"/>
						</svg>	
									<?php } elseif($d==6) { ?>
							
						<svg xmlns="http://www.w3.org/2000/svg" width="284.364" height="230.001" viewBox="0 0 284.364 230.001">
							  <path id="Exclusion_6" data-name="Exclusion 6" d="M284.364,230H0V0H284.364V230ZM208.715,86.713h3.143L207.143,115V225h70.714V5H182L145.858,111.857H138L101.858,5H6V225H76.714V115L72,86.714h3.143l31.429,88h70.714l31.429-88Z" fill="#fff"/>
							</svg>
									<?php } else{ } ?>
				       			</div>				       
					</div>
					<div class="tab-content-area">
						<h3><?php echo get_sub_field('popup_title'); ?></h3>
				        			<span><?php echo get_sub_field('popup_sub_title'); ?></span>
				        			<?php echo get_sub_field('popup_content'); ?>
									<?php 
								$popup_link = get_sub_field('popup_link'); 
								if( $popup_link ): ?>
								<a href="<?php echo $popup_link['url']; ?>" class="btn-link" target="<?php echo $popup_link['target']; ?>"><?php echo $popup_link['title']; ?><span class="arrow-img"></span></a>												
				        		 <?php endif; ?>						
					</div>
				</div>
				</div>
			</div>


			<?php $d++; $r++; $mc++; endwhile; ?>
		</div>
	</section>
	<?php endif; ?>
	<?php }?>	

<?php elseif( get_row_layout() == 'lets_create_section' ): ?>
			<section class="text-image-sec">
		<div class="container">
			<div class="text-image-inside">
				<div class="image-txt-heading">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="750.666" height="301.469" viewBox="0 0 750.666 301.469">
                          <defs>
                            <linearGradient id="linear-gradient" x1="0.5" x2="0.5" y2="1" gradientUnits="objectBoundingBox">
                              <stop offset="0" stop-color="#ececec"/>
                              <stop offset="1" stop-color="#dfdfdf"/>
                            </linearGradient>
                          </defs>
                          <path id="Union_2" data-name="Union 2" d="M533.4,286.287a37.655,37.655,0,0,1-7.047-15.3h29.861a11.09,11.09,0,0,0,2.269,4.542q3.464,4.424,10.273,4.423,8.959,0,8.959-4.782a3.643,3.643,0,0,0-1.076-2.57,9.73,9.73,0,0,0-3.583-2.092q-2.508-.957-4.658-1.614t-6.211-1.615q-4.539-1.076-7.525-1.972t-7.406-2.511a32.654,32.654,0,0,1-7.285-3.586,40.64,40.64,0,0,1-5.674-4.783,17.732,17.732,0,0,1-4.18-6.634,24.963,24.963,0,0,1-1.374-8.488q0-10.521,10.213-18.41t28.009-7.889q21.739,0,32.728,14.106a38.61,38.61,0,0,1,6.689,13.987H576.523a6.45,6.45,0,0,0-1.552-3.227q-2.508-3.348-7.405-3.347-7.764,0-7.764,4.184,0,1.912,2.986,3.048a72.849,72.849,0,0,0,9.795,2.57q4.061.956,5.733,1.374t5.853,1.494a35.368,35.368,0,0,1,6.271,2.092q2.09,1.017,5.495,2.689a18.854,18.854,0,0,1,5.255,3.587,56.853,56.853,0,0,1,3.822,4.424,16.188,16.188,0,0,1,2.867,5.738,26.288,26.288,0,0,1,.9,7.052q0,11.956-10.63,20.323t-29.383,8.368Q544.751,301.469,533.4,286.287Zm-84.416,0a37.656,37.656,0,0,1-7.047-15.3H471.8a11.091,11.091,0,0,0,2.27,4.542q3.464,4.424,10.272,4.423,8.959,0,8.959-4.782a3.642,3.642,0,0,0-1.075-2.57,9.742,9.742,0,0,0-3.584-2.092q-2.508-.957-4.658-1.614t-6.211-1.615q-4.539-1.076-7.525-1.972t-7.405-2.511a32.642,32.642,0,0,1-7.286-3.586,40.693,40.693,0,0,1-5.674-4.783,17.755,17.755,0,0,1-4.181-6.634,24.985,24.985,0,0,1-1.373-8.488q0-10.521,10.212-18.41t28.01-7.889q21.738,0,32.728,14.106a38.639,38.639,0,0,1,6.689,13.987H492.107a6.465,6.465,0,0,0-1.553-3.227q-2.508-3.348-7.406-3.347-7.764,0-7.763,4.184,0,1.912,2.986,3.048a72.829,72.829,0,0,0,9.794,2.57q4.061.956,5.734,1.374t5.853,1.494a35.353,35.353,0,0,1,6.27,2.092q2.09,1.017,5.495,2.689a18.84,18.84,0,0,1,5.255,3.587,56.477,56.477,0,0,1,3.822,4.424,16.2,16.2,0,0,1,2.867,5.738,26.324,26.324,0,0,1,.9,7.052q0,11.956-10.631,20.323t-29.383,8.368Q460.336,301.469,448.988,286.287Zm-165.131,2.451q-13.318-12.732-13.318-31.5t13.318-31.5q13.318-12.732,34.459-12.731,23.531,0,37.028,17.334a53.852,53.852,0,0,1,8.361,17.334H333.844a14.385,14.385,0,0,0-3.344-4.782,16.493,16.493,0,0,0-12.183-4.782,15.574,15.574,0,0,0-12,5.14q-4.718,5.141-4.719,13.987t4.719,13.987a15.577,15.577,0,0,0,12,5.14q8.242,0,13.019-5.977a16.561,16.561,0,0,0,3.106-5.978H364.3a55.655,55.655,0,0,1-8.481,18.53q-13.5,18.529-37.506,18.529Q297.176,301.469,283.857,288.738Zm-96.151,0q-13.318-12.732-13.318-31.5t13.318-31.5q13.318-12.732,34.459-12.731,23.53,0,37.028,17.334a53.87,53.87,0,0,1,8.361,17.334H237.693a14.411,14.411,0,0,0-3.344-4.782,16.5,16.5,0,0,0-12.183-4.782,15.577,15.577,0,0,0-12,5.14q-4.718,5.141-4.718,13.987t4.718,13.987a15.581,15.581,0,0,0,12,5.14q8.242,0,13.019-5.977a16.559,16.559,0,0,0,3.1-5.978h29.861a55.655,55.655,0,0,1-8.481,18.53q-13.5,18.529-37.5,18.529Q201.024,301.469,187.706,288.738Zm-90.18,2.63Q86.6,281.266,86.6,264.41V215.4h29.861v47.818q0,5.739,2.986,8.846t8.361,3.109q5.376,0,8.361-3.109t2.986-8.846V215.4h29.861V264.41q0,16.856-10.93,26.958t-30.279,10.1Q108.455,301.469,97.526,291.368ZM7.047,286.287A37.656,37.656,0,0,1,0,270.986H29.861a11.09,11.09,0,0,0,2.269,4.542q3.464,4.424,10.273,4.423,8.959,0,8.958-4.782a3.642,3.642,0,0,0-1.075-2.57,9.73,9.73,0,0,0-3.583-2.092q-2.508-.957-4.658-1.614t-6.211-1.615q-4.54-1.076-7.526-1.972T20.9,262.8a32.654,32.654,0,0,1-7.285-3.586,40.641,40.641,0,0,1-5.674-4.783,17.733,17.733,0,0,1-4.181-6.634,24.963,24.963,0,0,1-1.374-8.488q0-10.521,10.212-18.41t28.01-7.889q21.739,0,32.728,14.106A38.61,38.61,0,0,1,80.027,241.1H50.166a6.451,6.451,0,0,0-1.552-3.227q-2.508-3.348-7.405-3.347-7.764,0-7.764,4.184,0,1.912,2.986,3.048a72.85,72.85,0,0,0,9.795,2.57q4.061.956,5.733,1.374t5.853,1.494a35.368,35.368,0,0,1,6.271,2.092q2.09,1.017,5.494,2.689a18.846,18.846,0,0,1,5.256,3.587,56.86,56.86,0,0,1,3.822,4.424,16.2,16.2,0,0,1,2.867,5.738,26.287,26.287,0,0,1,.9,7.052q0,11.956-10.63,20.323T42.4,301.469Q18.394,301.469,7.047,286.287Zm363.228,12.791V215.4h68.68v23.909h-38.82v7.771h30.459V267.4H400.135v7.771h38.82v23.908Zm-101.4-116.843q-13.318-12.732-13.318-31.5t13.318-31.5Q282.194,106.5,303.335,106.5q23.53,0,37.028,17.334a53.852,53.852,0,0,1,8.361,17.334H318.863a14.384,14.384,0,0,0-3.344-4.782,16.493,16.493,0,0,0-12.183-4.782,15.574,15.574,0,0,0-12,5.14q-4.718,5.141-4.719,13.987t4.719,13.987a15.577,15.577,0,0,0,12,5.14q8.242,0,13.019-5.977a16.565,16.565,0,0,0,3.106-5.977h29.861a55.658,55.658,0,0,1-8.481,18.529q-13.5,18.529-37.506,18.529Q282.194,194.966,268.876,182.235Zm413.11,10.34V108.894h68.68V132.8h-38.82v7.771H742.3V160.9H711.846v7.771h38.82v23.908Zm-58.528,0V135.193H598.375v-26.3H678.4v26.3H653.319v57.381Zm-45.389,0-4.18-15.54h-25.68l-4.18,15.54H514.765l23.291-83.681h47.18l22.694,83.681Zm-25.083-36.461h16.125L563.737,134h-4.778Zm-109.3,36.461V108.894h68.68V132.8h-38.82v7.771H504V160.9H473.542v7.771h38.82v23.908Zm-35.833,0L395.9,169.862h-10.75v22.713H355.293V108.894h46.583q15.887,0,25.263,8.667t9.376,22.415q0,11.476-7.167,18.65a23.18,23.18,0,0,1-7.167,5.26l15.528,28.69Zm-22.694-45.427h13.139a7.928,7.928,0,0,0,5.674-1.973,7.515,7.515,0,0,0,0-10.4,7.931,7.931,0,0,0-5.674-1.972H385.154Zm14.591-73.868a37.656,37.656,0,0,1-7.047-15.3h29.861a11.1,11.1,0,0,0,2.269,4.543q3.464,4.423,10.273,4.423,8.959,0,8.958-4.782a3.644,3.644,0,0,0-1.075-2.57A9.73,9.73,0,0,0,439.4,57.5q-2.508-.957-4.658-1.614t-6.212-1.615q-4.539-1.075-7.525-1.972T413.6,49.79a32.662,32.662,0,0,1-7.286-3.586,40.621,40.621,0,0,1-5.673-4.782,17.75,17.75,0,0,1-4.181-6.635,24.985,24.985,0,0,1-1.373-8.488q0-10.521,10.212-18.41T433.309,0q21.739,0,32.728,14.107a38.6,38.6,0,0,1,6.689,13.986H442.864a6.454,6.454,0,0,0-1.553-3.227q-2.508-3.347-7.405-3.347-7.764,0-7.764,4.184,0,1.913,2.986,3.048a72.85,72.85,0,0,0,9.795,2.57q4.061.956,5.733,1.374t5.853,1.495a35.305,35.305,0,0,1,6.271,2.092q2.09,1.017,5.494,2.69a18.845,18.845,0,0,1,5.256,3.586,56.865,56.865,0,0,1,3.822,4.424,16.209,16.209,0,0,1,2.866,5.738,26.3,26.3,0,0,1,.9,7.053q0,11.954-10.63,20.322T435.1,88.463Q411.092,88.463,399.745,73.281ZM306.282,86.072V28.69H281.2V2.39h80.027v26.3H336.143V86.072Zm-99.554,0V2.39h68.68V26.3h-38.82V34.07h30.459V54.392H236.588v7.771h38.82V86.072Zm-75.069,0V2.39h29.861V59.773h37.624v26.3ZM369.407,31.679l-2.986-10.161V2.39h23.889V21.518l-2.986,10.161Z" fill="url(#linear-gradient)"/>
                        </svg>
				</div>
				<figure>
					<?php if (get_sub_field('lets_create_image')) : ?>
						<picture>
						<?php if( get_sub_field('lets_create_image_webp') ){ ?><source srcset="<?php echo get_sub_field('lets_create_image_webp')['url']; ?>" type="image/webp"><?php } ?>
						<?php if( get_sub_field('lets_create_image') ){ ?><source srcset="<?php echo get_sub_field('lets_create_image')['url']; ?>" type="image/png"><?php } ?>
						<?php if( get_sub_field('lets_create_image') ){ ?><img src="<?php echo get_sub_field('lets_create_image')['url']; ?>" alt=image><?php } ?>
					</picture>
					<?php endif; ?>
					<figcaption><?php echo get_sub_field('lets_create_content'); ?></figcaption>
				</figure>
				<?php 
				$lets_create_link = get_sub_field('lets_create_link'); 
				if( $lets_create_link ): ?>
				<a href="<?php echo $lets_create_link['url']; ?>" class="btn-link" target="<?php echo $lets_create_link['target']; ?>"><?php echo $lets_create_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>	
			</div>
			<div class="cloud-main">
	            <div class="clouds-1">
	            </div>
	            <div class="clouds-2">
	            </div>
	            <div class="clouds-3">
	            </div>
        	</div>
		</div>
	</section>


<?php elseif( get_row_layout() == 'careers_section' ): ?>
	<section class="banner-widget">
		<div class="container">
			<div class="banner-widget-inside">
				<div class="banner-widget-content">
					<h2><?php echo get_sub_field('career_title'); ?></h2>
					<h4 class="h3"><?php echo get_sub_field('career_title_sub'); ?></h4>
					<?php echo get_sub_field('career_sub_title'); ?>
					<?php 
				$career_button_link = get_sub_field('career_button_link'); 
				if( $career_button_link ): ?>
				<a href="<?php echo $career_button_link['url']; ?>" class="btn-link" target="<?php echo $career_button_link['target']; ?>"><?php echo $career_button_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>	
				</div>
				<div class="banner-widget-image wow slideInRight">
					<figure>
						<?php if (get_sub_field('career_image')) : ?>
						<picture>
						<?php if( get_sub_field('career_webp_image') ){ ?><source srcset="<?php echo get_sub_field('career_webp_image')['url']; ?>" type="image/webp"><?php } ?>
						<?php if( get_sub_field('career_image') ){ ?><source srcset="<?php echo get_sub_field('career_image')['url']; ?>" type="image/png"><?php } ?>
						<?php if( get_sub_field('career_image') ){ ?><img src="<?php echo get_sub_field('career_image')['url']; ?>" alt=image><?php } ?>
					</picture>
					<?php endif; ?>
					</figure>
				</div>
			</div>
		</div>
		<?php $career_button_link = get_sub_field('career_button_link'); 
				if( $career_button_link ): ?>
				<a href="<?php echo $career_button_link['url']; ?>" class="full-link" target="<?php echo $career_button_link['target']; ?>"></a>												
					<?php endif; ?>
	</section>

		<?php elseif( get_row_layout() == 'blog_section' ): ?>

		<section class="posts-section">
		<div class="container">
			<span class="sub_heading"><?php echo get_sub_field('blog_title'); ?></span>
			<h2><?php echo get_sub_field('blog_sub_title'); ?></h2>
			<?php 
                        $blog_lisings = get_sub_field('blog_lising');
                   		    if( $blog_lisings ): ?>
			<?php if ( wp_is_mobile() ){ ?>
			<div class="posts-slider-mob-wrap">
				<div class="glide" id="blog-slider-mob">
					<div class="glide__track" data-glide-el="track">
						
                             <ul class="glide__slides">
                            <?php $bs=1; foreach( $blog_lisings as $post ): 
									setup_postdata($post);  ?>
							<li class="glide__slide">
								<?php if($bs!=1){  ?><div class="right-articles"> <?php } ?>
				        	<article <?php if($bs==1){ echo'class="ifza-post"'; }?>>
								<figure>
									<a href="<?php the_permalink(); ?>">
									<picture>
										<?php $webp_image = get_field('webp_image');
										if( !empty( $webp_image ) ): ?>
										<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
										<?php /* else: ?>
										<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/webp">
										<?php */ endif; ?>
										<?php 
										$jpg_image = get_field('post_image');
										if( !empty( $jpg_image ) ): ?>
										<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">										
										<?php endif; ?>
										<?php 
											$jpg_image = get_field('post_image');
											if( !empty( $jpg_image ) ): ?>
											<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
											<?php else: 	
											$content = get_the_content();
											$first_image = '';

											if (preg_match('/<img.+?src="(.+?)"/', $content, $matches)) {
											$first_image = $matches[1];
											}
									
											if (!empty( $first_image )) {
													//	var_dump($first_image);
											// Display the first image
												echo '<source srcset="' . $first_image . '" alt=""  type="image/jpg">';
												echo '<img src="' . $first_image . '" alt="">';
											} else {
												echo '<source srcset="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt=""  type="image/jpg">';
												echo '<img src="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="">';
												
											}
												endif; ?>
										
									</picture>
									</a>
								</figure>
								<?php if($bs==1){  ?><div class="ifza-post-content"> <?php } ?>
									<div class="listing-article-content">
										<!-- <span class="article-cat-name"><?php echo $first_category = wp_get_post_terms( $post->ID, 'category' )[0]->name; ?></span> -->
										<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										
										<span class="article-publish-date"><?php echo get_the_date('j F, Y'); ?></span>										
									</div>
								<?php if($bs==1){  ?></div><?php } ?>
							</article>
							<?php if($bs!=1){  ?></div> <?php } ?>
				        </li>       
							                        
                            <?php $bs++; endforeach; ?>   
				      </ul>
					</div>
					<div class="glide__arrows" data-glide-el="controls">
					    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
					    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
				  </div>
				  <div class="glide__bullets" data-glide-el="controls[nav]">
					    <button class="glide__bullet" data-glide-dir="=0"></button>
					    <button class="glide__bullet" data-glide-dir="=1"></button>
					    <button class="glide__bullet" data-glide-dir="=2"></button>
					    <button class="glide__bullet" data-glide-dir="=3"></button>
					 </div>
				</div>
			</div>
			<?php } else{ ?>

				<div class="posts-area">
	<div class="posts-left-section wow slideInLeft">
		<?php $i=0; foreach( $blog_lisings as $post ): 
		setup_postdata($post); 
		$i= $i+1;
		?> 

		<?php if($i ==3){ ?>
		</div>
		<div class="ifza-post-section wow slideInRight">
			<div class="right-articles">

			<?php } ?>

			<article class="<?php if($i == 1){ ?>ifza-post <?php }else if($i == 2){ ?>ifza-post-2 <?php } ?>">
				<figure>	
					<a href="<?php the_permalink(); ?>">
						<picture>
							<?php $webp_image = get_field('webp_image');
							if( !empty( $webp_image ) ): ?>
								<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
								<?php /* else: ?>
									<source srcset="<?php echo site_url(); ?>/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" type="image/webp">
								<?php */ endif; ?>
									<?php 
									$jpg_image = get_field('post_image');
									if( !empty( $jpg_image ) ): ?>
										<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
										<?php endif; ?>

											<?php 
											$jpg_image = get_field('post_image');
											if( !empty( $jpg_image ) ): ?>
											<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
											<?php else: 	
											$content = get_the_content();
											$first_image = '';

											if (preg_match('/<img.+?src="(.+?)"/', $content, $matches)) {
											$first_image = $matches[1];
											}
									
											if (!empty( $first_image )) {
													//	var_dump($first_image);
											// Display the first image
												echo '<source srcset="' . $first_image . '" alt=""  type="image/jpg">';
												echo '<img src="' . $first_image . '" alt="">';
											} else {
												echo '<source srcset="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt=""  type="image/jpg">';
												echo '<img src="' . site_url() . '/wp-content/themes/ifza/assets/images/ifza-no-image-583X500.jpg" alt="">';
												
											}
												endif; ?>
										</picture>
									</a>
								</figure>
								<div class="<?php if($i==1){ ?>ifza-post-content<?php } else if($i==2){echo'image-left-blog-content';} else{ ?> listing-article-content<?php } ?>">	
										<!-- <span class="article-cat-name"><?php echo $first_category = wp_get_post_terms( $post->ID, 'category' )[0]->name; ?></span>								 -->
										<?php if($i == 1){ ?><h4 class="h2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4><?php }else{ ?><h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4><?php } ?>
										<?php /* if($i == 2 || $i == 1){ ?><p><?php echo wp_trim_words(get_field('short_description'),30,'...') ?></p><?php } ?>
										<?php if($i == 3 || $i == 4){ ?><p><?php echo wp_trim_words(get_field('short_description'),15,'...') ?></p><?php } */ ?>
										<?php if ( get_post_type( get_the_ID() ) == 'post' ) { ?>
   											<time class="article-publish-date"><?php echo get_the_date('j F, Y'); ?></time>
										<?php } ?>
										
									</div>
									<a href="<?php the_permalink(); ?>" class="full-link"></a>
								</article>

							<?php endforeach; ?>

						</div>
					</div>
				</div>
				<?php } ?>	
				<?php wp_reset_query(); endif; ?>				
			<?php 
				$blog_link = get_sub_field('blog_link'); 
				if( $blog_link ): ?>
				<a href="<?php echo $blog_link['url']; ?>" class="btn-link" target="<?php echo $blog_link['target']; ?>"><?php echo $blog_link['title']; ?><span class="arrow-img"></span></a>												
				<?php endif; ?>
			
			
		</div>
	</section>
	  


			
<?php endif; ?>
    <?php endwhile; ?>
<?php endif; // flexible?>
	
	
	
</main>

<?php get_footer(); ?>

<script src='<?php echo get_template_directory_uri(); ?>/assets/js/home.js?ver=1.1' id='home-js'></script>
<script src='<?php echo get_template_directory_uri(); ?>/assets/js/slick-min.js' id="slick-js"></script>