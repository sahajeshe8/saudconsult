<?php 
/**
* Template Name: Business Setup
*/
wp_enqueue_style( 'business-setup-form', get_template_directory_uri() . '/assets/css/ifza-pages-form.css');
wp_enqueue_script( 'business-setup-validation', get_template_directory_uri() . '/assets/js/business-setup-validation.js', array(), $ver, true );
?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/business-setup.css?ver=1.0" rel="stylesheet">
<?php get_header()?>


<div style="display:none">
<input type="chekbox" id="options-rewind-checkbox4" name="">
</div>

<main>
<?php // flexible
if( have_rows('business_setup_section') ): ?>
    <?php while( have_rows('business_setup_section') ): the_row(); ?>

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
				</div>
			</figcaption>
				
			</figure>
	</section>            
        <?php elseif( get_row_layout() == 'overview_section' ):            
            ?>
			<section class="multi-steps" id="business_overview">
		<div class="container">
			<?php if(get_sub_field('overview_content') ){ ?>
			<div class="content-area">
				<?php echo get_sub_field('overview_content'); ?>
			</div>
			<?php } ?>

			<div class="multi-steps-outer">
				<h2><?php echo get_sub_field('we_offer_heading'); ?></h2>
				<div class="steps-inner-wrap">
					<div class="setps-listing-outer">
						<?php if( have_rows('we_offer_list') ): ?>
							<ul>
								<?php $l=1; while( have_rows('we_offer_list') ): the_row();  ?>     
								<li>
									<div class="approval-step-slide">
										<figure class="approval-step-image">
											<picture>
													<?php if( get_sub_field('tm_image_webp') ){ ?><source srcset="<?php echo get_sub_field('tm_image_webp')['url']; ?>" type="image/webp"><?php } ?>
													<?php if( get_sub_field('tm_image') ){ ?><source srcset="<?php echo get_sub_field('tm_image')['url']; ?>" type="image/jpeg"><?php } ?>
													<?php if( get_sub_field('tm_image') ){ ?><img src="<?php echo get_sub_field('tm_image')['url']; ?>" alt=image><?php } ?>
											</picture>
										</figure>
										<div class="approval-step-content">
											<span><?php if($l<10){ echo '0'.$l; } else{echo $l;}?>.<span><?php the_sub_field('tm_name'); ?></span></span>
											<?php the_sub_field('tm_content'); ?>
										</div>
									</div>
								</li>
								<?php $l++; endwhile; ?>								
							</ul>
							<?php endif; ?>					
					</div>
				</div>
			</div>
		</div>
	</section>  
	<?php elseif( get_row_layout() == 'left_image_right_content' ): ?>
<section class="image-left-content wrapper no-max-width" id="business_imgleft">
		<figure class="image-left-content-left">
			<picture>
					<?php if( get_sub_field('bs_image_webp') ){ ?><source srcset="<?php echo get_sub_field('bs_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('bs_image') ){ ?><source srcset="<?php echo get_sub_field('bs_image')['url']; ?>" type="image/jpeg"><?php } ?>
					<?php if( get_sub_field('bs_image') ){ ?><img src="<?php echo get_sub_field('bs_image')['url']; ?>" alt=image><?php } ?>
			</picture>
		</figure>
		<div class="image-left-content-right padding-right">
			
			<h3 class="h2"><?php echo get_sub_field('bs_title'); ?></h3>
			<?php echo get_sub_field('bscontent'); ?>

			<?php 
			$bs_link = get_sub_field('bs_link'); 
			if( $bs_link ): ?>
			<a href="<?php echo $bs_link['url']; ?>" class="btn-link" target="<?php echo $bs_link['target']; ?>"><?php echo $bs_link['title']; ?><span class="arrow-img"></span></a>												
				<?php endif; ?>

		</div>
	</section>
	
	<?php elseif( get_row_layout() == 'content_and_repeater' ): ?>
		<section class="content-with-image-boxes" id="business_ctr">
		<div class="container">
			<div class="options-inside">
				<h3 class="h2"><?php echo get_sub_field('bl_title'); ?></h3>
			<?php echo get_sub_field('bl_content'); ?>
			</div>
			<?php if( have_rows('bl_listing') ):
				?>
			<ul class="options-list">
				<?php $bl=1; while( have_rows('bl_listing') ): the_row();  ?>
				

			<?php if( $bl % 2 == 1){ echo '<li>'; } ?>
					<div class="option-list-inner">
					<?php if($bl<3) { ?>				
					<figure class="option-list-image">
						<picture>
					<?php if( get_sub_field('blo_image_webp') ){ ?><source srcset="<?php echo get_sub_field('blo_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><source srcset="<?php echo get_sub_field('blo_image')['url']; ?>" type="image/jpeg"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><img src="<?php echo get_sub_field('blo_image')['url']; ?>" alt=image><?php } ?>
						</picture>
					</figure>
					<?php } ?>
					<div class="option-list-content">
						<span><?php if($bl<10){ echo '0'.$bl; } else{echo $bl;}?>.</span>
						<h4><?php the_sub_field('blo_title'); ?></h4>
						<?php the_sub_field('blo_content'); ?>
					</div>

					<?php if($bl>2) { ?>
						<figure class="option-list-image">
						<picture>
					<?php if( get_sub_field('blo_image_webp') ){ ?><source srcset="<?php echo get_sub_field('blo_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><source srcset="<?php echo get_sub_field('blo_image')['url']; ?>" type="image/jpeg"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><img src="<?php echo get_sub_field('blo_image')['url']; ?>" alt=image><?php } ?>
						</picture>
					</figure>
					<?php } ?>

					</div>
				<?php if($bl % 2 == 0){ echo '</li>'; } ?>
				<?php $bl++; endwhile; ?>
				

			</ul>
			<?php endif; ?>
		</div>	
	</section>
		
	<?php elseif( get_row_layout() == 'bullet_points_and_title' ): ?>
		<section class="content-sec-3" id="business_point">
		<div class="container">
			<h3 class="h2"><?php echo get_sub_field('bu_title'); ?></h3>
				<?php if( have_rows('bullet_points') ): ?>
						<ul class="listing-points">
							<?php while( have_rows('bullet_points') ): the_row();  ?>               
								<li><?php the_sub_field('points'); ?></li>       
							<?php endwhile; ?>
						</ul>
				<?php endif; ?>			
			<?php 
			$bu_links = get_sub_field('bu_links'); 
			if( $bu_links ): ?>
				<a href="<?php echo $bu_links['url']; ?>" class="btn-link" target="<?php echo $bu_links['target']; ?>"><?php echo $bu_links['title']; ?><span class="arrow-img"></span></a>												
			<?php endif; ?>
		</div>
	</section>

	<?php elseif( get_row_layout() == 'image_with_content_center' ): ?>
	<section class="image-bg-text-top" id="business_ctrcen">
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
		
	<?php elseif( get_row_layout() == 'glide_slide_with_contet' ): ?>
		<section class="content-sec-4 padding-left" id="business_slide">
		<div class="sliding-inside-content">
			<h3 class="h2"><?php the_sub_field('brp_title'); ?></h3>
						<?php the_sub_field('brp_content'); ?>			
		</div>
		<?php if( have_rows('brp_lisiting') ): ?>
		<div class="process-list-wrap">
			<?php if ( wp_is_mobile() ){ ?>
			<div class="glide mobile-view glide-slide-mobile ">
				<div class="glide__track" data-glide-el="track">
					<ul class="glide__slides">
						<?php $brp=1; while( have_rows('brp_lisiting') ): the_row();  ?>               
								<li class="glide__slide">
									<div class="process-list-slide">
									<span><?php if($brp<10){ echo '0'.$brp; } else{echo $brp;}?>.</span>
									<h3><?php the_sub_field('brpl_tilte'); ?></h3>
									<?php the_sub_field('brpl_content'); ?>
									</div>
								</li>       
						<?php $brp++; endwhile; ?>
					</ul>
				</div>
			</div>
			<?php } else {  ?> 
				
			<div class="glide  desktop-view" id="process-list">
				<div class="glide__track" data-glide-el="track">
					
						<ul class="glide__slides">
							<?php $brp=1; while( have_rows('brp_lisiting') ): the_row();  ?>               
									<li class="glide__slide">
										<div class="process-list-slide">
										<span><?php if($brp<10){ echo '0'.$brp; } else{echo $brp;}?>.</span>
										<h3><?php the_sub_field('brpl_tilte'); ?></h3>
										<?php the_sub_field('brpl_content'); ?>
										</div>
									</li>       
							<?php $brp++; endwhile; ?>
						</ul>
				
					
				</div>
				<div class="glide__arrows" data-glide-el="controls">
				    <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa-solid fa-angle-left"></i></button>
				    <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa-solid fa-angle-right"></i></button>
			  </div>
			</div>
			
				<?php } ?>
			
		</div>
		<?php endif; ?>
	</section>

	<?php elseif( get_row_layout() == 'enquiries_form' ): ?>

		<section class="form-sec" id="business_enquiries">
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
         <form action='https://forms.zohopublic.com/ifzafjr/form/IFZAWebsiteBusinessSetuppage/formperma/e4fSdGbsiYialG_4iMb-xaj5ISRfhmMGrraUI5D8p8A/htmlRecords/submit' name='form' method='POST' onSubmit='javascript:document.charset="UTF-8"; return zf_ValidateAndSubmit();' accept-charset='UTF-8' enctype='multipart/form-data' id='form'>
            <input type="hidden" name="zf_referrer_name" value=""><!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
            <input type="hidden" name="zf_redirect_url" value=""><!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
            <input type="hidden" name="zc_gad" value=""><!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->
            <div class="zf-templateWrapper">
               <!---------template Header Starts Here---------->
               <!-- <ul class="zf-tempHeadBdr">
                  <li class="zf-tempHeadContBdr">
                     <h2 class="zf-frmTitle"><em>IFZA Website - Business Setup page</em></h2>
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
                  <li class="zf-fmFooter"><button class="zf-submitColor" >Submit<span class="arrow-img"></span></button></li>
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

<script type="text/javascript">
	jQuery(document).ready(function() {
		var checkbox4 = document.querySelector('#options-rewind-checkbox4')
		var glide4 = new Glide('#process-list', {
		  //type: 'carousel',
		  perView:2.6,
		  draggable: true,
		  gap:0,
		  rewind: checkbox4.checked,
		  breakpoints: {
		  	991:{
		      perView:2.2,
		    },

			767:{
		      perView:1.5,
		    },

			600:{
		      perView:1.2,
		    },
		  }
		})
		checkbox4.addEventListener('change', function () {
		  glide4.update({
		    rewind: checkbox4.checked
		  })
		})
		glide4.mount();

		new Glide('#approval-steps', {
		  perView: 3,
		  draggable: true,
		  dragThreshold: false,
		  gap:20,
		  rewind: checkbox4.checked,
		  breakpoints: {
		    1367: {
		      gap:15,
		    },
		    1199: {
		      perView:2.5,
		    },
		    991: {
		      perView:2.2,
		      gap:10,
		    },
		    767: {
		      perView:2,
		      gap:10,
		    },
		    640: {
		      perView:1.1,
		      gap:10,
		      
		    }
		  }
		}).mount();
});

</script>

<!--remove when added dynamic form---->
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
</script>
<script type="text/javascript">var zf_DateRegex = new RegExp("^(([0][1-9])|([1-2][0-9])|([3][0-1]))[-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)[-](?:(?:19|20)[0-9]{2})$");
         var zf_MandArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "DecisionBox"]; 
         var zf_FieldArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "MultiLine", "DecisionBox"]; 
         var isSalesIQIntegrationEnabled = false;
         var salesIQFieldsArray = [];
      </script>