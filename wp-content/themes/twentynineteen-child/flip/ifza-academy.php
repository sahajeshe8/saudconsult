<?php 
/**
* Template Name: Ifza Academy
*/
wp_enqueue_style( 'academy-form', get_template_directory_uri() . '/assets/css/ifza-pages-form.css');
wp_enqueue_script( 'academy-validation', get_template_directory_uri() . '/assets/js/academy-validation.js', array(), $ver, true );
?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/ifza-academy.css?ver=1.0" rel="stylesheet">
<?php get_header()?>


<div style="display:none">
<input type="chekbox" id="options-rewind-checkbox5" name="">
</div>

<main>
	<?php // flexible
if( have_rows('ifza_academy_section') ): ?>
    <?php while( have_rows('ifza_academy_section') ): the_row(); ?>

<?php if( get_row_layout() == 'banner_section' ): ?>
		
	<section class="banner">
			<figure class="banner-area-wrap">
				<picture>
				<?php 
				$webp_image = get_sub_field('abt_sec1_image_webp');
				if( !empty( $webp_image ) ): ?>
				<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
				<?php endif; ?>

				<?php 
				$jpg_image = get_sub_field('abt_sec1_image');
				if( !empty( $jpg_image ) ): ?>
					<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
					<?php endif; ?>

				<?php 
				$jpg_image = get_sub_field('abt_sec1_image');
				if( !empty( $jpg_image ) ): ?>
					<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
				<?php endif; ?>
			</picture>
			<figcaption>
				<div class="container">
					<h1><?php echo get_sub_field('abt_sec1_heading'); ?></h1>
					<?php echo get_sub_field('abt_sec1_description'); ?>
					<?php 
					$bs_link = get_sub_field('banner_button'); 
					if( $bs_link ): ?>
					<a href="<?php echo $bs_link['url']; ?>" class="btn-link" target="<?php echo $bs_link['target']; ?>"><?php echo $bs_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
					
				</div>
			</figcaption>
				
			</figure>
	</section> 
	
<?php elseif( get_row_layout() == 'academy_overview' ): ?>
	<section class="content-sec-17">
		<div class="container">
			<div class="content-sec-17-inner">
				<h4><?php echo get_sub_field('bl_title'); ?></h4>
					<?php echo get_sub_field('bl_content'); ?>
			</div>
		</div>
	</section>


<?php elseif( get_row_layout() == 'why_choose' ): ?>
	<section class="text-image-list-sec">
		<div class="container">
			<h2><?php echo get_sub_field('why_choose_title'); ?></h2>
		</div>
		<?php if( have_rows('why_choose_list') ): ?> 
		<div class="container">
	<?php while( have_rows('why_choose_list') ): the_row();  ?>
			<div class="text-image-list-inner">
				<figure class="text-image-list-image">
					<picture>
						<?php if( get_sub_field('tm_image_webp') ){ ?><source srcset="<?php echo get_sub_field('tm_image_webp')['url']; ?>" type="image/webp"><?php } ?>
						<?php if( get_sub_field('tm_image') ){ ?><source srcset="<?php echo get_sub_field('tm_image')['url']; ?>" type="image/jpeg"><?php } ?>
						<?php if( get_sub_field('tm_image') ){ ?><img src="<?php echo get_sub_field('tm_image')['url']; ?>" alt=image><?php } ?>
					</picture>
				</figure>
				<div class="text-image-list-content">						
						<?php echo get_sub_field('tm_content'); ?>
				</div>
			</div>
			
	<?php endwhile; ?>
		</div>
		<?php endif; ?>
	</section>
<?php elseif( get_row_layout() == 'courses_section' ): ?>
	<?php 

			$args = array(
				'post_type' => 'courses', 
				'post_status' => array('publish'),
				'posts_per_page' => -1, 
			);
			if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'name-asc'){
				$args['order'] = 'ASC';
				$args['orderby'] = 'name';
			}else{
				$args['order'] = 'DESC';
				$args['orderby'] = 'date';
			}
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) : ?>

	<section class="grey-bg-sec">
		<div class="container">
			<div class="heading-with-dropdown">
				<div class="content-block">
					<h3 class="h2"><?php echo get_sub_field('course_title'); ?></h3>
					<?php echo get_sub_field('course_content'); ?>
				</div>
				<div class="dropdown-box-area">
					<select id="sort-by">
						<option value="date-desc" <?php if($_REQUEST['orderby'] == 'date-desc'){ ?>select<?php } ?>><?php _e('Sort by: Date'); ?></option>
						<option value="name-asc" <?php if($_REQUEST['orderby'] == 'name-asc'){ ?>select<?php } ?>><?php _e('Sort by: Name'); ?></option>
					</select>
				</div>
				
			</div>
			

			<ul class="image-text-listing-block">
				<?php $ode=1; while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<li>
					<figure>
						<picture>
							<?php if( get_field('career_webp_banner') ){ ?><source srcset="<?php echo get_field('career_webp_banner')['url']; ?>" type="image/webp"><?php } ?>
						<?php if( get_field('career_banner') ){ ?><source srcset="<?php echo get_field('career_banner')['url']; ?>" type="image/jpg"><?php } ?>
						<?php if( get_field('career_banner') ){ ?><img src="<?php echo get_field('career_banner')['url']; ?>" alt=image><?php } ?>
							
						</picture>
					</figure>
					<div class="image-text-listing-content">
						<h4><?php the_title(); ?></h4>
						<?php the_field('short_description'); ?>
						<div class="image-text-listing-info">
							<span><?php _e('Date'); ?>:</span><time><?php echo date('F j, Y', strtotime(get_the_date())); ?></time>
						</div>
						<div class="image-text-listing-info">
							<?php if(get_field('work_location')!=''){ ?><span><?php _e('venue'); ?>:</span><p><?php the_field('work_location'); ?></p><?php } ?>
						</div>
						<a href="#ifza-popup<?php echo $ode; ?>" class="btn-link open-popup-link"><?php the_field('button_text'); ?><span class="arrow-img"></span></a>
					</div>
					<div class="popup-area mfp-hide" id="ifza-popup<?php echo $ode; ?>">
						<figure>
							<picture>
						<?php if( get_field('career_webp_banner') ){ ?><source srcset="<?php echo get_field('career_webp_banner')['url']; ?>" type="image/webp"><?php } ?>
						<?php if( get_field('career_banner') ){ ?><source srcset="<?php echo get_field('career_banner')['url']; ?>" type="image/jpg"><?php } ?>
						<?php if( get_field('career_banner') ){ ?><img src="<?php echo get_field('career_banner')['url']; ?>" alt=image><?php } ?>
							</picture>
						</figure>
						<div class="popup-content-area">
							<h2><?php the_title(); ?></h2>
							<h6 class="secondary_font"><?php the_field('responsibility_title'); ?></h6>
							<?php the_field('main_responsibilities'); ?>
							<h6 class="secondary_font"><?php the_field('qualifications_and_experience_title'); ?></h6>
							<?php the_field('qualifications_and_experience'); ?>
						</div>
						<div class="popup-form-area">
							<h3 class="h2"><?php the_field('c_form_title'); ?></h3>
							<?php the_field('c_form_content'); ?>
							<?php echo do_shortcode('[contact-form-7 id="1348" title="Courses Form"]'); ?>
							
						</div>
					</div>
				</li>
			<?php endwhile; ?>
			</ul>
			
		</div>
	</section>
	<?php endif;
			wp_reset_postdata();
			?>
<?php elseif( get_row_layout() == 'image_with_content_center' ): ?>
	<section class="image-bg-text-top">
		<figure>
			<picture>
				<?php if( get_sub_field('bcf_image_webp') ){ ?><source srcset="<?php echo get_sub_field('bcf_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('bcf_image') ){ ?><source srcset="<?php echo get_sub_field('bcf_image')['url']; ?>" type="image/jpeg"><?php } ?>
					<?php if( get_sub_field('bcf_image') ){ ?><img src="<?php echo get_sub_field('bcf_image')['url']; ?>" alt=image><?php } ?>
			
			</picture>
			<figcaption>
				<div class="container">
					<div class="image-bg-text-top-content">
						<h3 class="h2"><?php the_sub_field('bcf_title'); ?></h3>
						<?php the_sub_field('bcf_content'); ?>
					</div> 
				</div>
			</figcaption>
		</figure>
	</section>

<?php elseif( get_row_layout() == 'left_image_right_content' ): ?>

		<section class="letter-text-sec">
		<div class="container">
			<div class="letter-text-inner">
				<figure class="letter-text-image">
					<picture>
					 <?php if( get_sub_field('bs_image_webp') ){ ?><source srcset="<?php echo get_sub_field('bs_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('bs_image') ){ ?><source srcset="<?php echo get_sub_field('bs_image')['url']; ?>" type="image/png"><?php } ?>
					<?php if( get_sub_field('bs_image') ){ ?><img src="<?php echo get_sub_field('bs_image')['url']; ?>" alt=image><?php } ?>
					</picture>
				</figure>
				<div class="letter-text-content">
					<span class="primary_font"><?php echo get_sub_field('bs_title'); ?></span>					
					<?php echo get_sub_field('bscontent'); ?>
					<?php 
					$bs_link = get_sub_field('bs_link'); 
					if( $bs_link ): ?>
					<a href="<?php echo $bs_link['url']; ?>" class="btn-link" target="<?php echo $bs_link['target']; ?>"><?php echo $bs_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

<?php elseif( get_row_layout() == 'why_choose_listing' ): ?>

	<section class="grey-bg-sec-2">
		<div class="container">
			<h3 class="h2"><?php echo get_sub_field('if_why_choose_title'); ?></h3>
<?php if( have_rows('if_why_choose_list') ): ?>
			<ul class="image-content-listing">
<?php  while( have_rows('if_why_choose_list') ): the_row();  ?>   
				<li>
					<figure class="image-content-list-image">
						<picture>
									<?php if( get_sub_field('if_image_webp') ){ ?><source srcset="<?php echo get_sub_field('if_image_webp')['url']; ?>" type="image/webp"><?php } ?>
									<?php if( get_sub_field('if_image') ){ ?><source srcset="<?php echo get_sub_field('if_image')['url']; ?>" type="image/jpg"><?php } ?>
									<?php if( get_sub_field('if_image') ){ ?><img src="<?php echo get_sub_field('if_image')['url']; ?>" alt=image><?php } ?>
						</picture>
					</figure>
					<div class="image-content-list-content">
						<h6><?php echo get_sub_field('if_title'); ?></h6>
						<?php echo get_sub_field('if_content'); ?>
					</div>
				</li>
				<?php endwhile; ?>	
			</ul>
	<?php endif; ?>
		</div>
	</section>

	<?php elseif( get_row_layout() == 'what_we_offer' ): ?>
	<section class="slider-text-left-sec padding-left">
		<div class="slider-left-text-area">
			<h3 class="h2"><?php echo get_sub_field('what_we_offer_title'); ?></h3>
			<?php echo get_sub_field('what_we_offer_content'); ?>
		</div>
		<?php /*if ( wp_is_mobile() ){ ?>
			<?php if( have_rows('what_we_offer_list') ): ?>
		<div class="text-left-without-slider">
			<ul>
				<?php  while( have_rows('what_we_offer_list') ): the_row();  ?>   
				<li>
					<div class="text-left-slide">
							<figure>
								<picture>
									<?php if( get_sub_field('wf_image_webp') ){ ?><source srcset="<?php echo get_sub_field('wf_image_webp')['url']; ?>" type="image/webp"><?php } ?>
									<?php if( get_sub_field('wf_image') ){ ?><source srcset="<?php echo get_sub_field('wf_image')['url']; ?>" type="image/jpg"><?php } ?>
									<?php if( get_sub_field('wf_image') ){ ?><img src="<?php echo get_sub_field('wf_image')['url']; ?>" alt=image><?php } ?>
								</picture>
								<figcaption>
									<h6><?php echo get_sub_field('wf_title'); ?></h6>
								</figcaption>
							</figure>
						</div>
				</li>
				<?php endwhile; ?>	
			</ul>

		</div>	
			<?php endif; ?>
		
		<?php } else{*/ ?>
			<?php if( have_rows('what_we_offer_list') ): ?>
		<div class="glide" id="text-left-slider">
			<div class="glide__track" data-glide-el="track">
				<ul class="glide__slides">
					<?php  while( have_rows('what_we_offer_list') ): the_row();  ?>
					<li class="glide__slide">
						<div class="text-left-slide">
							<figure>
								<picture>
									<?php if( get_sub_field('wf_image_webp') ){ ?><source srcset="<?php echo get_sub_field('wf_image_webp')['url']; ?>" type="image/webp"><?php } ?>
									<?php if( get_sub_field('wf_image') ){ ?><source srcset="<?php echo get_sub_field('wf_image')['url']; ?>" type="image/jpg"><?php } ?>
									<?php if( get_sub_field('wf_image') ){ ?><img src="<?php echo get_sub_field('wf_image')['url']; ?>" alt=image><?php } ?>
								</picture>
								<figcaption>
									<h6><?php echo get_sub_field('wf_title'); ?></h6>
								</figcaption>
							</figure>
						</div>
					</li>
					<?php endwhile; ?>	
				</ul>
			</div>
			<div class="glide__arrows" data-glide-el="controls">
				    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
				    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
			  </div>
		</div>
		<?php endif; ?>
	<?php /*}*/ ?>
	</section>
	<?php elseif( get_row_layout() == 'enquiries_form' ): ?>
	<section class="form-sec" id="enquiries_form">
		<figure>
			<picture>
				<?php if( get_sub_field('form_image_webp') ){ ?><source srcset="<?php echo get_sub_field('form_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('form_image') ){ ?><source srcset="<?php echo get_sub_field('form_image')['url']; ?>" type="image/jpeg"><?php } ?>
					<?php if( get_sub_field('form_image') ){ ?><img src="<?php echo get_sub_field('form_image')['url']; ?>" alt=image><?php } ?>
				</picture>
			<div class="form-outer-area">
				<h3 class="h2"><?php the_sub_field('form_title'); ?></h3>
					<p><?php the_sub_field('sub_title'); ?></p>
					<!-- <?php $shortcode = get_sub_field('form_shortcode');
					echo do_shortcode($shortcode);?> -->
					      <!-- Change or deletion of the name attributes in the input tag will lead to empty values on record submission-->
						  <div class="zf-templateWidth">
         <form action='https://forms.zohopublic.com/ifzafjr/form/IFZAWebsiteAcademypage/formperma/a1Mwxc6cUFklpt7btrY01yGuss6BNhnWyKmpe7s_G3k/htmlRecords/submit' name='form' method='POST' onSubmit='javascript:document.charset="UTF-8"; return zf_ValidateAndSubmit();' accept-charset='UTF-8' enctype='multipart/form-data' id='form'>
            <input type="hidden" name="zf_referrer_name" value=""><!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
            <input type="hidden" name="zf_redirect_url" value=""><!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
            <input type="hidden" name="zc_gad" value=""><!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->
            <div class="zf-templateWrapper">
               <!---------template Header Starts Here---------->
               <!-- <ul class="zf-tempHeadBdr">
                  <li class="zf-tempHeadContBdr">
                     <h2 class="zf-frmTitle"><em>IFZA Website - Academy page</em></h2>
                     <p class="zf-frmDesc"></p>
                     <div class="zf-clearBoth"></div>
                  </li>
               </ul> -->
               <!---------template Header Ends Here---------->
               <!---------template Container Starts Here---------->
               <div class="zf-subContWrap zf-topAlign">
                  <ul>
                     <!---------Name Starts Here----------> 
                     <li class="zf-tempFrmWrapper zf-name zf-namelarge">
                        <label class="zf-labelName"> 
                        </label>
                        <div 
                           class="zf-tempContDiv zf-twoType"  
                           >
                           <div
                              class="zf-nameWrapper"  
                              >
                              <span> <input type="text" maxlength="255" name="Name_First" fieldType=7 placeholder="First&#x20;Name&#x2a;"/> </span> 
                              </span> </span>
                              <span> <input type="text" maxlength="255" name="Name_Last" fieldType=7 placeholder="Last&#x20;Name&#x2a;"/> </span> 
                              </span> </span>
                              <div class="zf-clearBoth"></div>
                           </div>
                           <p id="Name_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </li>
                     <!---------Name Ends Here----------> 
                     <!---------Email Starts Here---------->  
                     <li class="zf-tempFrmWrapper zf-large">
                        <label class="zf-labelName"> 
                        </label>
                        <div class="zf-tempContDiv">
                           <span> <input fieldType=9  type="text" maxlength="255" name="Email" checktype="c5" value="" placeholder="Email&#x20;Address&#x2a;"/></span> 
                           <p id="Email_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </li>
                     <!---------Email Ends Here---------->  
                     <!---------Phone Starts Here----------> 
                     <li  class="zf-tempFrmWrapper zf-large">
                        <label class="zf-labelName"> 
                        </label>
                        <div class="zf-tempContDiv zf-phonefld">
                           <div
                              class="zf-phwrapper"   
                              >
                              <span> <input type="text" compname="PhoneNumber_countrycodeval" name="PhoneNumber_countrycodeval" checktype="c7" maxlength="10" phoneFormat="1" isCountryCodeEnabled=true  id="international_PhoneNumber_countrycodeval" valType="code" placeholder="Code"/>
                              </span>
                              <span> <input type="text" compname="PhoneNumber" name="PhoneNumber_countrycode" maxlength="20" checktype="c7" value="" phoneFormat="1" isCountryCodeEnabled=true fieldType="11" id="international_PhoneNumber_countrycode" valType="number" phoneFormatType="2" placeholder="Phone&#x20;Number&#x2a;" />
                              </span>
                              <div class="zf-clearBoth"></div>
                           </div>
                           <p id="PhoneNumber_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </li>
                     <!---------Phone Ends Here----------> 
                     <!---------Single Line Starts Here---------->
                     <li class="zf-tempFrmWrapper zf-large">
                        <label class="zf-labelName"> 
                        </label>
                        <div class="zf-tempContDiv">
                           <span> <input type="text" name="SingleLine" checktype="c1" value="" maxlength="255" fieldType=1 placeholder="Company&#x20;name"/></span> 
                           <p id="SingleLine_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </li>
                     <!---------Single Line Ends Here---------->
                     <!---------Multiple Line Starts Here---------->
                     <li class="zf-tempFrmWrapper zf-large">
                        <label class="zf-labelName"> 
                        </label>
                        <div class="zf-tempContDiv">
                           <span> <textarea name="MultiLine" checktype="c1" maxlength="65535" placeholder="Notes"></textarea> </span>
                           <p id="MultiLine_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </li>
                     <!---------Multiple Line Ends Here---------->
                     
                  </ul>
               </div>
               <!---------template Container Starts Here---------->
               <ul class="zf-agree-submit-wrappper">
                    <!---------Decision Starts Here----------> 
                     <li class="zf-tempFrmWrapper zf-decesion ">
                        <div class="zf-tempContDiv">
                           <input type="checkbox" checktype="c1" checked=true id="DecisionBox" name="DecisionBox"/>
                           <label for="DecisionBox" class="zf-labelName">I agree with the Terms and Conditions
                           <em class="zf-important">*</em>
                           </label>
                           <p id="DecisionBox_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
                        </div>
                        <div class="zf-clearBoth"></div>
                     </li>
                     <!---------Decision Ends Here---------->
                  <li class="zf-fmFooter"><button class="zf-submitColor" >Submit <span class="arrow-img"></span></button></li>
               </ul>
            </div>
            <!-- 'zf-templateWrapper' ends -->
         </form>
      </div>
      <!-- 'zf-templateWidth' ends -->
					
				
			</div>
		</figure>
	</section>
	

	
	<?php endif; ?>

    <?php endwhile; ?>
<?php endif; // flexible?>

</main>
<?php get_footer(); ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js'></script>
<script type="text/javascript">
	function formatState (state) {
  if (!state.id) { return state.text; }
  var $state = jQuery(
    '<span><img src="' + jQuery(state.element).attr('data-src') + '" class="img-flag" /> ' + state.text + '</span>'
  );
  return $state;
};
jQuery('.country-select-inq select').select2({
 minimumResultsForSearch: Infinity,
  templateResult: formatState,
  templateSelection: formatState
});
jQuery(".dropdown-box-area").on('change', 'select', function() {
	var sortBy = jQuery("#sort-by").val();
	window.location.href= "<?php the_permalink();?>?orderby="+sortBy
});
</script>


<script type="text/javascript">
	jQuery(document).ready(function() {
		var checkbox5 = document.querySelector('#options-rewind-checkbox5')
		var glide5 = new Glide('#text-left-slider', {
		  //type: 'carousel',
		  perView:3.3,
		  draggable: true,
		  rewind: checkbox5.checked,
		  gap:0,
		  breakpoints: {
		  	1600:{
		      perView:2.8,
		    },
		    1450:{
		      perView:2.5,
		    },
		    1366:{
		      perView:2.2,
		    },
		    1280:{
		      perView:2.5,
		    },
		    991:{
		      perView:2.2,
		    },
		    768:{
		      perView:2.1,
		    },
		    641:{
		      perView:1.5,
		    },
		    480:{
		      perView:1.1,
		    },
		  }
		})
		checkbox5.addEventListener('change', function () {
		  glide5.update({
		    rewind: checkbox5.checked
		  })
		})
		glide5.mount();
	});

</script>
<script type="text/javascript">var zf_DateRegex = new RegExp("^(([0][1-9])|([1-2][0-9])|([3][0-1]))[-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)[-](?:(?:19|20)[0-9]{2})$");
         var zf_MandArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "DecisionBox"]; 
         var zf_FieldArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "MultiLine", "DecisionBox"]; 
         var isSalesIQIntegrationEnabled = false;
         var salesIQFieldsArray = [];
      </script>