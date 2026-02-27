<?php 
/**
* Template Name: Promo Landing Page
*/
wp_enqueue_style( 'business-setup-form', get_template_directory_uri() . '/assets/css/promo-form.css');
wp_enqueue_script( 'business-setup-validation', get_template_directory_uri() . '/assets/js/promo-validation.js', array(), $ver, true );
//wp_enqueue_script( 'business-setup-validation', get_template_directory_uri() . '/assets/js/business-setup-validation.js', array(), $ver, true );
?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/promo.css?ver=1.0" rel="stylesheet">
<?php get_header()?>

<main>
	<?php // flexible
if( have_rows('promo_landing_section') ): ?>
    <?php while( have_rows('promo_landing_section') ): the_row(); ?>

	<?php if( get_row_layout() == 'pro_banner_section' ): ?>

		<section class="banner">
		<figure class="banner-area-wrap">
			<picture>
				<picture>
				<?php 
				$webp_image = get_sub_field('banner_image_webp');
				if( !empty( $webp_image ) ): ?>
				<source srcset="<?php echo esc_url($webp_image['url']); ?>" alt="<?php echo esc_attr($webp_image['alt']); ?>" type="image/webp">
				<?php endif; ?>

				<?php 
				$jpg_image = get_sub_field('banner_image');
				if( !empty( $jpg_image ) ): ?>
					<source srcset="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>" type="image/jpg">
					<?php endif; ?>

				<?php 
				$jpg_image = get_sub_field('banner_image');
				if( !empty( $jpg_image ) ): ?>
					<img src="<?php echo esc_url($jpg_image['url']); ?>" alt="<?php echo esc_attr($jpg_image['alt']); ?>">
				<?php endif; ?>
			</picture>
			</picture>
		</figure>
		<div class="contact-sec-16">
			<div class="container">
				<div class="contact-sec-16-inner">
					<h1><?php echo get_sub_field('banner_title'); ?></h1>
					<?php if( have_rows('banner_points') ): ?>
					<ul class="listing-with-arrow">
						<?php while( have_rows('banner_points') ): the_row();  ?> 
						<li><?php echo get_sub_field('listing_points'); ?></li>
						<?php endwhile; ?>				
					</ul>
					<?php endif; ?>
					
				</div>
			</div>
		</div>
	
		<div class="sidebar-contact-widget">
			<div class="sidebar-contact-widget-inner">
				<h6><?php echo get_sub_field('form_title'); ?></h6>
				<?php echo get_sub_field('form_content'); ?>
			</div>
			<?php /*$shortcode = get_sub_field('pro_form');
					echo do_shortcode($shortcode); */ ?>
					<!-- Change or deletion of the name attributes in the input tag will lead to empty values on record submission-->
<div class="zf-templateWidth"><form action='https://forms.zohopublic.com/ifzafjr/form/IFZAPromotionLandingPage1/formperma/oZVlKP-DGD8aDePXLgSsZ7y7CR1UYHszbb6jhBbAuxs/htmlRecords/submit' name='form' method='POST' onSubmit='javascript:document.charset="UTF-8"; return zf_ValidateAndSubmit();' accept-charset='UTF-8' enctype='multipart/form-data' id='form'><input type="hidden" name="zf_referrer_name" value=""><!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
<input type="hidden" name="zf_redirect_url" value=""><!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
<input type="hidden" name="zc_gad" value=""><!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->
<div class="zf-templateWrapper">
	<!---------template Header Starts Here---------->
<!-- <ul class="zf-tempHeadBdr"><li class="zf-tempHeadContBdr"><h2 class="zf-frmTitle"><em>IFZA Promotion Landing Page</em></h2>
<p class="zf-frmDesc"></p>
<div class="zf-clearBoth"></div></li></ul> -->
<!---------template Header Ends Here---------->
<!---------template Container Starts Here---------->
<div class="zf-subContWrap zf-topAlign"><ul>
<!---------Name Starts Here----------> 
<li class="zf-tempFrmWrapper zf-name zf-namelarge"><label class="zf-labelName"> 
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
<div class="zf-clearBoth"></div></div><p id="Name_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Name Ends Here----------> 
<!---------Email Starts Here---------->  
<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName"> 
</label>
<div class="zf-tempContDiv">
<span> <input fieldType=9  type="text" maxlength="255" name="Email" checktype="c5" value="" placeholder="Email&#x20;Address&#x2a;"/></span> <p id="Email_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Email Ends Here---------->  
<!---------Phone Starts Here----------> 
<li  class="zf-tempFrmWrapper zf-large"><label class="zf-labelName"> 
</label>
<div class="zf-tempContDiv zf-phonefld">
<div
class="zf-phwrapper"   
>
<span> <input type="text" compname="PhoneNumber_countrycodeval" name="PhoneNumber_countrycodeval" checktype="c7" maxlength="10" phoneFormat="1" isCountryCodeEnabled=true  id="international_PhoneNumber_countrycodeval" valType="code" placeholder="Code"/>
<!-- <label>Code</label> -->
 </span>
<span> <input type="text" compname="PhoneNumber" name="PhoneNumber_countrycode" maxlength="20" checktype="c7" value="" phoneFormat="1" isCountryCodeEnabled=true fieldType="11" id="international_PhoneNumber_countrycode" valType="number" phoneFormatType="2" placeholder="Phone&#x20;number&#x2a;" />
<!-- <label>Number</label>  -->
</span>
<div class="zf-clearBoth"></div></div><p id="PhoneNumber_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Phone Ends Here----------> 
<!---------Single Line Starts Here---------->
<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName"> 
</label>
<div class="zf-tempContDiv">
<span> <input type="text" name="SingleLine" checktype="c1" value="" maxlength="255" fieldType=1 placeholder="What&#x20;is&#x20;the&#x20;nature&#x20;of&#x20;your&#x20;business&#x3f;"/></span> <p id="SingleLine_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Single Line Ends Here---------->
<!---------Multiple Line Starts Here---------->
<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName"> 
</label>
<div class="zf-tempContDiv">
<span> <textarea name="MultiLine" checktype="c1" maxlength="65535" placeholder="Message"></textarea> </span><p id="MultiLine_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Multiple Line Ends Here---------->
<!---------Decision Starts Here----------> 
<li class="zf-tempFrmWrapper zf-decesion "><div class="zf-tempContDiv">
<input type="checkbox" checktype="c1" checked=true id="DecisionBox" name="DecisionBox"/>
<label for="DecisionBox" class="zf-labelName">I agree with the Terms and Conditions
<em class="zf-important">*</em>
</label>
<p id="DecisionBox_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
</div><div class="zf-clearBoth"></div></li><!---------Decision Ends Here----------> 
</ul></div><!---------template Container Starts Here---------->
<ul><li class="zf-fmFooter"><button class="zf-submitColor" >Submit<span class="arrow-img"></span></button></li></ul></div><!-- 'zf-templateWrapper' ends --></form></div><!-- 'zf-templateWidth' ends -->

		</div>

	</section>


	<?php elseif( get_row_layout() == 'formation_offers' ): ?>
		<section class="image-content-listing-sec">
		<div class="container">
			<h2><?php echo get_sub_field('formation_offers_title'); ?></h2>
			<?php echo get_sub_field('formation_offers_content'); ?>
			<?php if( have_rows('formation_offers_listing') ): ?>
			<ul class="image-content-listing">
				<?php while( have_rows('formation_offers_listing') ): the_row();  ?> 
				<li>
					<figure class="image-content-list-image">
						<picture>
							<?php if( get_sub_field('fo_image_webp') ){ ?><source srcset="<?php echo get_sub_field('fo_image_webp')['url']; ?>" type="image/webp"><?php } ?>
							<?php if( get_sub_field('fo_image') ){ ?><source srcset="<?php echo get_sub_field('fo_image')['url']; ?>" type="image/jpg"><?php } ?>
							<?php if( get_sub_field('fo_image') ){ ?><img src="<?php echo get_sub_field('fo_image')['url']; ?>" alt=image><?php } ?>
						</picture>
					</figure>
					<div class="image-content-list-content">
						<h6><?php echo get_sub_field('fo_title'); ?></h6>
					<?php echo get_sub_field('fo_content'); ?>
					</div>
				</li>
				<?php endwhile; ?>		
				
			</ul>
			<?php endif; ?>
		</div>
	</section>

	<?php elseif( get_row_layout() == 'freezone_company' ): ?>
	
	<section class="image-left-content wrapper">
		<figure class="image-left-content-left">
			<picture>
				<?php if( get_sub_field('fc_image_webp') ){ ?><source srcset="<?php echo get_sub_field('fc_image_webp')['url']; ?>" type="image/webp"><?php } ?>
				<?php if( get_sub_field('fc_image') ){ ?><source srcset="<?php echo get_sub_field('fc_image')['url']; ?>" type="image/jpeg"><?php } ?>
				<?php if( get_sub_field('fc_image') ){ ?><img src="<?php echo get_sub_field('fc_image')['url']; ?>" alt=image><?php } ?>
			</picture>
		</figure>
		<div class="image-left-content-right">
			<h3 class="h2"><?php echo get_sub_field('fc_title'); ?></h3>
			<?php if( have_rows('fc_listing_content') ): ?>
			<ul class="listing-with-arrow">
				<?php while( have_rows('fc_listing_content') ): the_row();  ?> 
				<li><?php echo get_sub_field('fc_points'); ?></li>
				<?php endwhile; ?>				
			</ul>
			<?php endif; ?>
			<?php 
				$fc_link = get_sub_field('fc_link'); 
				if( $fc_link ): ?>
				<a href="<?php echo $fc_link['url']; ?>" class="btn-link" target="<?php echo $fc_link['target']; ?>"><?php echo $fc_link['title']; ?><span class="arrow-img"></span></a>												
			<?php endif; ?>
		</div>
	</section>

	<?php elseif( get_row_layout() == 'company_formation' ): ?>
		<section class="toggle-faqs-wrap">
		<div class="container">
			<div class="faqs-inner-wrap">
				<div class="faqs-heading-left">
					<h3 class="h2"><?php echo get_sub_field('cf_title'); ?></h3>
					<?php echo get_sub_field('cf_content'); ?>
				</div>
				<?php if( have_rows('cf_listing_content') ): ?>
				<div class="faqs-tabs-right">
					<?php $bp=1; while( have_rows('cf_listing_content') ): the_row();  ?>
					<div class="accordion-panel">
						<div class="accordion__header">
							<span><?php if($bp<10){ echo '0'.$bp; } else{echo $bp;}?>.</span>
							<h4><?php echo get_sub_field('cfl_title'); ?></h4>
							<i class="fa-solid fa-caret-down arrow-view"></i>
						</div>
						<div class="accordion__body animated">
							<?php echo get_sub_field('cfl_content'); ?>
						</div>
					</div>
					<?php $bp++; endwhile; ?>
					
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php elseif( get_row_layout() == 'contact_us_section' ): ?>
		
	<section class="cta-sec">
		<figure>
			<picture>
				<?php if( get_sub_field('cs_image_webp') ){ ?><source srcset="<?php echo get_sub_field('cs_image_webp')['url']; ?>" type="image/webp"><?php } ?>
				<?php if( get_sub_field('cs_image') ){ ?><source srcset="<?php echo get_sub_field('cs_image')['url']; ?>" type="image/jpg"><?php } ?>
				<?php if( get_sub_field('cs_image') ){ ?><img src="<?php echo get_sub_field('cs_image')['url']; ?>" alt=image><?php } ?>
			</picture>
		</figure>
		<div class="cta-sec-outer">
			<div class="container">
				<div class="cta-sec-inner">
					<div class="cta-sec-inner-content">
						<h3 class="h2"><?php echo get_sub_field('cs_title'); ?></h3>
						<?php echo get_sub_field('cs_content'); ?>
					</div>
					<?php 
						$cs_link = get_sub_field('cs_link'); 
						if( $cs_link ): ?>
						<a href="<?php echo $cs_link['url']; ?>" class="btn-link" target="<?php echo $cs_link['target']; ?>"><?php echo $cs_link['title']; ?><span class="arrow-img"></span></a>												
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<?php elseif( get_row_layout() == 'footer_section' ): ?>
	<section class="footer-2">
		<div class="container">
			<div class="footer-2-content">
				<div class="footer-2-logo">
					<a href="<?php echo home_url(); ?>">
						<figure>
							<picture>
								<?php if( get_sub_field('logo_image_webp') ){ ?><source srcset="<?php echo get_sub_field('logo_image_webp')['url']; ?>" type="image/webp"><?php } ?>
								<?php if( get_sub_field('logo_image') ){ ?><source srcset="<?php echo get_sub_field('logo_image')['url']; ?>" type="image/png"><?php } ?>
								<?php if( get_sub_field('logo_image') ){ ?><img src="<?php echo get_sub_field('logo_image')['url']; ?>" alt=image><?php } ?>
							</picture>
						</figure>
					</a>
				</div>
				<p><?php echo get_sub_field('fx_address'); ?></p>
				<p><a href="tel:<?php echo str_replace(array('+','-',' ','(',')','tollfree'),'',get_sub_field('fx_toll_free')); ?>"><?php echo get_sub_field('fx_toll_free'); ?> | </a>
				<a href="tel:<?php echo get_sub_field('fx_phone'); ?>"><?php echo get_sub_field('fx_phone'); ?> |</a>
					<a href="mailto:<?php echo get_sub_field('fx_email'); ?>"><?php echo get_sub_field('fx_email'); ?></a></p>
				
				<?php
// Check rows exists.
					if (have_rows('social_media', 'options')) :?>
                       			<ul class="footer-social-media">
                            <?php
						// Loop through rows.
						while (have_rows('social_media', 'options')) : the_row(); ?>

							<li><a href="<?php the_sub_field('sm_link', 'options'); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php the_sub_field('sm_name', 'options'); ?> icon"><i class="fa-brands <?php the_sub_field('sm_icon', 'options'); ?>"></i></a>
                            </li>

					<?php
						// End loop.
						endwhile;?>
                            
                        </ul>
                        <?php
					// No value.
					else :
					// Do something...
					endif; ?>
			</div>
		</div>
	</section>

	<?php endif; ?>

    <?php endwhile; ?>
<?php endif; // flexible?>
</main>

<?php get_footer(); ?>
<script type="text/javascript">var zf_DateRegex = new RegExp("^(([0][1-9])|([1-2][0-9])|([3][0-1]))[-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)[-](?:(?:19|20)[0-9]{2})$");
var zf_MandArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "DecisionBox"]; 
var zf_FieldArray = [ "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "SingleLine", "MultiLine", "DecisionBox"]; 
var isSalesIQIntegrationEnabled = false;
var salesIQFieldsArray = [];</script>