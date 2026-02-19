<?php 
/**
* Template Name: Ifza Life
*/
wp_enqueue_style( 'life-form', get_template_directory_uri() . '/assets/css/ifza-pages-form.css');
wp_enqueue_script( 'life-validation', get_template_directory_uri() . '/assets/js/life-validation.js', array(), $ver, true );
?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/ifza-life.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<main>
<?php // flexible
if( have_rows('ifza_life_section') ): ?>
    <?php while( have_rows('ifza_life_section') ): the_row(); ?>

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


	<?php elseif( get_row_layout() == 'life_overview' ): ?>
		<section class="content-sec-9">
		<div class="container">
			<h2><?php echo get_sub_field('life_title'); ?></h2>
			<?php if( have_rows('life_content') ): ?>
			<ul class="listing-points">
				<?php while( have_rows('life_content') ): the_row();  ?> 
				<li><?php echo get_sub_field('life_points'); ?></li>
				<?php endwhile; ?>				
			</ul>
			<?php endif; ?>
			<?php 
			$ov_button = get_sub_field('download_file'); 
			if( $ov_button ): ?>
			
			<a href="<?php echo $ov_button['url']; ?>" class="btn-link" target="<?php echo $ov_button['target']; ?>"><?php echo $ov_button['title']; ?><span class="arrow-img"></span></a>													
				<?php endif; ?>
			
		</div>
	</section>
	<?php elseif( get_row_layout() == 'why_choose' ): ?>
	<section class="text-image-list-sec">
		<?php if( get_sub_field('why_choose_title') ){ ?>
			<div class="container">
			<h2><?php echo get_sub_field('why_choose_title'); ?></h2>
		</div><?php } ?>
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
	
	<?php elseif( get_row_layout() == 'hospitals_included' ): ?>
	<section class="content-sec-10">
		<div class="container">
			<h3 class="h2"><?php echo get_sub_field('hs_title'); ?></h3>
			<?php if( have_rows('hs_content') ): ?>
			<ul class="image-name-listing">
				<?php while( have_rows('hs_content') ): the_row();  ?> 
				<li>
					<?php 
						$hospital_logo = get_sub_field('hospital_logo'); 	
						if ( $hospital_logo ){ ?>
							<source srcset="<?php echo $hospital_logo['url']; ?>" type="image/png">
							<img src="<?php echo $hospital_logo['url']; ?>" alt=image>
						<?php } else { ?>
							<div class="image-name-list-image"></div>
						<?php } ?>
					<h6 class="secondary_font"><?php echo get_sub_field('hs_name'); ?></h6>
				</li>
				<?php endwhile; ?>				
			</ul>
			<?php endif; ?>		
				
		</div>
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

	<?php elseif( get_row_layout() == 'download_the_brochure' ): ?>

	<section class="form-sec form-brochure-area" id="life_enquiries">
	    <div class="brochure-image-outer">
	    <figure class="brochure-image">
			<picture>
			 <?php if( get_sub_field('form_image_webp') ){ ?><source srcset="<?php echo get_sub_field('form_image_webp')['url']; ?>" type="image/webp"><?php } ?>
			 <?php if( get_sub_field('form_image') ){ ?><source srcset="<?php echo get_sub_field('form_image')['url']; ?>" type="image/png"><?php } ?>
			 <?php if( get_sub_field('form_image') ){ ?><img src="<?php echo get_sub_field('form_image')['url']; ?>" alt=image><?php } ?>
			</picture>
		</figure>
		</div>
		<figure>
			<picture>
				<?php if( get_sub_field('form_bg_image_webp') ){ ?><source srcset="<?php echo get_sub_field('form_bg_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('form_bg_image') ){ ?><source srcset="<?php echo get_sub_field('form_bg_image')['url']; ?>" type="image/jpeg"><?php } ?>
					<?php if( get_sub_field('form_bg_image') ){ ?><img src="<?php echo get_sub_field('form_bg_image')['url']; ?>" alt=image><?php } ?>			 
			</picture>
			<div class="form-outer-area">
				<div class="container">
					<div class="enquiry-form-inner">
					
					<div class="brochure-form-area">
						<h3 class="h2"><?php echo get_sub_field('form_title'); ?></h3>
						<?php echo get_sub_field('form_content'); ?>

						      <!-- Change or deletion of the name attributes in the input tag will lead to empty values on record submission-->
							  <div class="zf-templateWidth">
         <form action='https://forms.zohopublic.com/ifzafjr/form/IFZAWebsiteLifebrochuredownload/formperma/qykFcvsri-ABVOS6uyIkD3DwEb91x2PRUUxhFPP-irk/htmlRecords/submit' name='form' method='POST' onSubmit='javascript:document.charset="UTF-8"; return zf_ValidateAndSubmit();' accept-charset='UTF-8' enctype='multipart/form-data' id='form'>
            <input type="hidden" name="zf_referrer_name" value=""><!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
            <input type="hidden" name="zf_redirect_url" value=""><!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
            <input type="hidden" name="zc_gad" value=""><!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->
            <div class="zf-templateWrapper">
               <!---------template Header Starts Here---------->
               <!-- <ul class="zf-tempHeadBdr">
                  <li class="zf-tempHeadContBdr">
                     <h2 class="zf-frmTitle"><em>IFZA Website - Life brochure download</em></h2>
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
						
						<!-- <div class="form-area-inner">
							<div class="form-field-area">
								<input type="text" name="" placeholder="First Name*">
							</div>
							<div class="form-field-area">
								<input type="text" name="" placeholder="Last Name*">
							</div>
							<div class="form-field-area">
								<input type="email" name="" placeholder="Email Address*">
							</div>
							<div class="agree-submit-wrap">
							<div class="agree-checkbox">
		                        <input type="checkbox" id="policy" name="" class="checkbox-field">
		                        <label for="policy">I agree with the <a href="#">Terms and Conditions*</a></label>
		                    </div>
		                    <div class="submit-enquire-wrap">
								<input type="submit" name="" value="Download" class="btn-submit">
							</div>
							</div>
						</div> -->

					</div>
					</div>
				</div>
			</div>
		</figure>
	</section>


	
<?php endif; ?>
    <?php endwhile; ?>
<?php endif; // flexible?>
	
	
	
	
	
	
</main>
<script type="text/javascript">var zf_DateRegex = new RegExp("^(([0][1-9])|([1-2][0-9])|([3][0-1]))[-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)[-](?:(?:19|20)[0-9]{2})$");
         var zf_MandArray = [ "Name_First", "Name_Last", "Email", "DecisionBox"]; 
         var zf_FieldArray = [ "Name_First", "Name_Last", "Email", "DecisionBox"]; 
         var isSalesIQIntegrationEnabled = false;
         var salesIQFieldsArray = [];
      </script>
<?php get_footer(); ?>