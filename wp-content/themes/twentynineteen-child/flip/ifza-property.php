<?php 
/**
* Template Name: Ifza Property
*/
wp_enqueue_style( 'property-form', get_template_directory_uri() . '/assets/css/ifza-pages-form.css');
wp_enqueue_script( 'property-validation', get_template_directory_uri() . '/assets/js/property-validation.js', array(), $ver, true );
?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/Ifza-property.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<main>
	<?php // flexible
if( have_rows('ifza_property_section') ): ?>
    <?php while( have_rows('ifza_property_section') ): the_row(); ?>

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
	<?php elseif( get_row_layout() == 'flexible_workspaces' ): ?>
		<section class="sliding-list-sec">
		<div class="container">
			<h2><?php echo get_sub_field('flexible_workspaces_title'); ?></h2>
			
			<?php if( have_rows('we_offer_list') ): ?> 
			<div class="listing-slide-outer" >
					<ul>						
					<?php while( have_rows('we_offer_list') ): the_row();  ?>
						<li>
							<figure class="workspace-image-wrap">
								<picture>
									<?php if( get_sub_field('tm_image_webp') ){ ?><source srcset="<?php echo get_sub_field('tm_image_webp')['url']; ?>" type="image/webp"><?php } ?>
									<?php if( get_sub_field('tm_image') ){ ?><source srcset="<?php echo get_sub_field('tm_image')['url']; ?>" type="image/jpeg"><?php } ?>
									<?php if( get_sub_field('tm_image') ){ ?><img src="<?php echo get_sub_field('tm_image')['url']; ?>" alt=image><?php } ?>
								</picture>
							</figure>
							<div class="workspace-content-wrap">
								<h3><?php echo get_sub_field('tm_name'); ?></h3>
								<?php echo get_sub_field('tm_content'); ?>
								<?php if( have_rows('listing_points') ): ?> 
								<ul class="bullet-listing">
									<?php $l=1; while( have_rows('listing_points') ): the_row();  ?>
									<li><?php echo get_sub_field('points_list'); ?></li>
									<?php endwhile; ?>
									
								</ul>
								<?php endif; ?>
								</div>
						</li>
					<?php endwhile; ?>
						
					</ul>
						
			</div>
		<?php endif; ?>

		</div>
	</section>

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
		

	<?php elseif( get_row_layout() == 'private_office_list' ): ?>
		<section class="content-sec-11">
		<div class="container">
			<div class="content-sec-11-inner">
			<h3 class="h2"><?php echo get_sub_field('bl_title'); ?></h3>
			<?php echo get_sub_field('bl_content'); ?>
			</div>
		</div>
		<?php if( have_rows('bl_listing') ): ?> 
		<div class="container">
			<?php while( have_rows('bl_listing') ): the_row();  ?>
			<div class="text-image-list-inner">
				<figure class="text-image-list-image">
					<picture>
						<?php if( get_sub_field('blo_image_webp') ){ ?><source srcset="<?php echo get_sub_field('blo_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><source srcset="<?php echo get_sub_field('blo_image')['url']; ?>" type="image/jpeg"><?php } ?>
					<?php if( get_sub_field('blo_image') ){ ?><img src="<?php echo get_sub_field('blo_image')['url']; ?>" alt=image><?php } ?>
					</picture>
				</figure>
				<div class="text-image-list-content">
					<h3><?php echo get_sub_field('blo_title'); ?></h3>
						<?php echo get_sub_field('blo_content'); ?>
						<?php if( have_rows('blo_listing_points') ): ?> 
								<ul class="bullet-listing">
									<?php while( have_rows('blo_listing_points') ): the_row();  ?>
									<li><?php echo get_sub_field('blo_points'); ?></li>
									<?php endwhile; ?>									
								</ul>
						<?php endif; ?>
						
				</div>
			</div>
			<?php endwhile; ?>



		</div>
			<?php endif; ?>
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
         <form action='https://forms.zohopublic.com/ifzafjr/form/IFZAWebsitePropertypage/formperma/MDtTxE4npRoGhQnzPkzGwj3E8M-TgIplNm_bVLKBVdU/htmlRecords/submit' name='form' method='POST' onSubmit='javascript:document.charset="UTF-8"; return zf_ValidateAndSubmit();' accept-charset='UTF-8' enctype='multipart/form-data' id='form'>
            <input type="hidden" name="zf_referrer_name" value=""><!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
            <input type="hidden" name="zf_redirect_url" value=""><!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
            <input type="hidden" name="zc_gad" value=""><!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->
            <div class="zf-templateWrapper">
               <!---------template Header Starts Here---------->
               <!-- <ul class="zf-tempHeadBdr">
                  <li class="zf-tempHeadContBdr">
                     <h2 class="zf-frmTitle"><em>IFZA Website - Property page</em></h2>
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
<script type="text/javascript">
	jQuery(document).ready(function() {
		new Glide('#workspace-slider', {
		  type: 'carousel',
		  perView: 3,
		  draggable: true,
		  dragThreshold: false,
		  gap:20,
		   breakpoints: {
		    1280: {
		      gap:10,
		      perView: 2.4,
		    },
		    1199: {
		      gap:10,
		      perView: 2.1,
		    }
		  }
		}).mount();
	    
	});

</script>

<script type="text/javascript">var zf_DateRegex = new RegExp("^(([0][1-9])|([1-2][0-9])|([3][0-1]))[-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)[-](?:(?:19|20)[0-9]{2})$");
         var zf_MandArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "DecisionBox"]; 
         var zf_FieldArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "MultiLine", "DecisionBox"]; 
         var isSalesIQIntegrationEnabled = false;
         var salesIQFieldsArray = [];
      </script>