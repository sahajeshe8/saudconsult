<?php 
/**
* Template Name: Partnership
*/
wp_enqueue_style( 'partnership-form', get_template_directory_uri() . '/assets/css/ifza-pages-form.css');
wp_enqueue_script( 'partnership-validation', get_template_directory_uri() . '/assets/js/partnership-validation.js', array(), $ver, true );
?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/partnership.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<div style="display:none">
<input type="chekbox" id="options-rewind-checkbox3" name="">
</div>

<main>
<?php // flexible
if( have_rows('partnership_setup_section') ): ?>
    <?php while( have_rows('partnership_setup_section') ): the_row(); ?>

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
	<?php elseif( get_row_layout() == 'Part_overview_section' ): ?>

		<section class="contact-sec-14" id="Part_overview_section">
		<div class="container">
			<?php if(get_sub_field('overview_title') || get_sub_field('overview_content')){ ?>
			<div class="contact-sec-14-inner">
				<h2><?php echo get_sub_field('overview_title'); ?></h2>
				<?php echo get_sub_field('overview_content'); ?>
			</div>
			<?php } ?>
			
				<?php if( have_rows('overview_listing') ): ?>
			<ul class="text-image-block-list">
				<?php $l=1; while( have_rows('overview_listing') ): the_row();  ?> 
			<li>
					<figure class="text-image-block-list-image">
						<picture>
							<?php if( get_sub_field('ov_image_webp') ){ ?><source srcset="<?php echo get_sub_field('ov_image_webp')['url']; ?>" type="image/webp"><?php } ?>
							<?php if( get_sub_field('ov_image') ){ ?><source srcset="<?php echo get_sub_field('ov_image')['url']; ?>" type="image/jpeg"><?php } ?>
							<?php if( get_sub_field('ov_image') ){ ?><img src="<?php echo get_sub_field('ov_image')['url']; ?>" alt=image><?php } ?>
						</picture>
					</figure>
					<div class="text-image-block-list-content">
						<h3><?php echo get_sub_field('ov_name'); ?></h3>
						<?php echo get_sub_field('ov_content'); ?>
						<?php 
						$ov_button = get_sub_field('ov_button'); 
						if( $ov_button ): ?>
						<a href="<?php echo $ov_button['url']; ?>" class="btn-link" target="<?php echo $ov_button['target']; ?>"><?php echo $ov_button['title']; ?><span class="arrow-img"></span></a>												
							<?php endif; ?>
						
					</div>
				</li>
				<?php $l++; endwhile; ?>
				
			</ul>
				<?php endif; ?>
			<?php /* if(get_sub_field('buttom__title') || get_sub_field('buttom_content')){ ?>
			<div class="contact-sec-15">
				<h3 class="h2"><?php echo get_sub_field('buttom__title'); ?></h3>
				<?php echo get_sub_field('buttom_content'); ?>
			</div>
			<?php } */?>
		
		</div>
	</section>
	<?php elseif( get_row_layout() == 'Part_glide_slide_with_video_bg' ): ?>

		<section class="video-bg-sec" id="video-bg">
		<?php if(get_sub_field('video_file')){ ?><div class="video-bg-area">
	       <video class="lazy"  autoplay loop muted playsinline poster="<?php echo get_sub_field('cover_image')['url']; ?>">
	        	<source data-src="<?php echo get_sub_field('video_file'); ?>" type="video/mp4">
	       </video> 
    	</div><?php } ?>
		<?php $listtitle = get_sub_field('brp_title'); ?>
		<?php if( have_rows('brp_lisiting') ): ?>
    	<div class="slider-outer padding-left">
    	    
    	    <div class="slider-left-text">
    	        <h3 class="h1"><?php echo $listtitle; ?></h3>
    	    </div>
			<div class="glide" id="benefits-list">
				<div class="glide__track" data-glide-el="track">
					<ul class="glide__slides">
						<?php  while( have_rows('brp_lisiting') ): the_row();  ?>     
						<li class="glide__slide">
							<div class="benefits-list-slide">
								<h4 class="h3"><?php the_sub_field('brpl_tilte'); ?></h4>
									<?php the_sub_field('brpl_content'); ?>								
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
		</div>
		<?php endif; ?>
	</section>

	<?php elseif( get_row_layout() == 'Part_bullet_points_and_title' ): ?>

	<section class="steps-sec" id="points_and_title">
		<div class="container">
			<div class="steps-sec-inner">
			<h3 class="h2"><?php the_sub_field('bu_title'); ?></h3>
				<?php the_sub_field('bu_sub_content'); ?>	
				<?php if( have_rows('bullet_points') ): ?>		
				<ul class="list-with-number">
					<?php $bp=1; while( have_rows('bullet_points') ): the_row();  ?>  
					<li><span><?php if($bp<10){ echo '0'.$bp; } else{echo $bp;}?>.</span><?php the_sub_field('points'); ?></li>
					<?php $bp++; endwhile; ?>					
				</ul>
				<?php endif; ?>
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
					<h3><?php the_sub_field('form_title'); ?></h3>
					<p><?php the_sub_field('sub_title'); ?></p>
					<!-- <?php $shortcode = get_sub_field('form_shortcode');
					echo do_shortcode($shortcode);?> -->

					    <!-- Change or deletion of the name attributes in the input tag will lead to empty values on record submission-->
						<div class="zf-templateWidth">
         <form action='https://forms.zohopublic.com/ifzafjr/form/IFZAWebsitePartnershippage/formperma/qKK2uSLhJmETqVy9puk6j-T9cQBZkelNXx7oSnDPBcY/htmlRecords/submit' name='form' method='POST' onSubmit='javascript:document.charset="UTF-8"; return zf_ValidateAndSubmit();' accept-charset='UTF-8' enctype='multipart/form-data' id='form'>
            <input type="hidden" name="zf_referrer_name" value=""><!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
            <input type="hidden" name="zf_redirect_url" value=""><!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
            <input type="hidden" name="zc_gad" value=""><!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->
            <div class="zf-templateWrapper">
               <!---------template Header Starts Here---------->
               <!-- <ul class="zf-tempHeadBdr">
                  <li class="zf-tempHeadContBdr">
                     <h2 class="zf-frmTitle"><em>IFZA Website - Partnership page</em></h2>
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
                     
                     <!---------Decision Ends Here----------> 
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
	var checkbox3 = document.querySelector('#options-rewind-checkbox3');
var glide3 = new Glide('#benefits-list', {
		  //type: 'carousel',
		  perView:2,
		  draggable: true,
		  rewind: checkbox3.checked,
		  gap:0, 
		   breakpoints: {
		    1366: {
		      gap:0,
		      perView: 1.8,
		    },
		    1280: {
		      gap:0,
		      perView: 1.6,
		    },
		    1199:{
		      gap:0,
		      perView: 1.8,
		    },
		    991:{
		      gap:0,
		      perView: 1.5,
		    },
		     768:{
		      gap:0,
		      perView: 1.3,
		    },
             641:{
		      gap:0,
		      perView:1.3,
		    },
		     480:{
		      gap:0,
		      perView:1.1,
		    }
		  }
		})
		checkbox3.addEventListener('change', function () {
		  glide.update({
		    rewind: checkbox3.checked
		  })
		})
		glide3.mount();
});

</script>

<script type="text/javascript">var zf_DateRegex = new RegExp("^(([0][1-9])|([1-2][0-9])|([3][0-1]))[-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)[-](?:(?:19|20)[0-9]{2})$");
         var zf_MandArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "DecisionBox"]; 
         var zf_FieldArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "MultiLine", "DecisionBox"]; 
         var isSalesIQIntegrationEnabled = false;
         var salesIQFieldsArray = [];
      </script>