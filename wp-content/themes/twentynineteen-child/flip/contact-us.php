<?php 
/**
* Template Name: Contact us
*/
wp_enqueue_script( 'contact-validation', get_template_directory_uri() . '/assets/js/contact-validation.js', array(), $ver, true );
?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/contact.css?ver=1.0" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/form.css?ver=1.0" rel="stylesheet">


<?php get_header()?>

<main>
		<?php // flexible
if( have_rows('contact_page_section') ): ?>
    <?php while( have_rows('contact_page_section') ): the_row(); ?>

	<?php if( get_row_layout() == 'contact_us_form_section' ): ?>
		<section class="contact-sec">
		<figure class="contact-left-image">
			<picture>
					<?php if( get_sub_field('left_side_image_webp') ){ ?><source srcset="<?php echo get_sub_field('left_side_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('left_side_image') ){ ?><source srcset="<?php echo get_sub_field('left_side_image')['url']; ?>" type="image/jpg"><?php } ?>
					<?php if( get_sub_field('left_side_image') ){ ?><img src="<?php echo get_sub_field('left_side_image')['url']; ?>" alt=image><?php } ?>
						</picture>
	
		</figure>
		<div class="contact-right-content">
			<div class="left-right-content">
				<h1><?php echo get_sub_field('section_title'); ?></h1>
			<?php  if (have_rows('address_more')) :
               while (have_rows('address_more')) : the_row(); ?>
				<div class="contact-call-btn">
					<span><?php the_sub_field('call_landline'); ?></span>
					<a href="tel:<?php the_sub_field('call_landline_number'); ?>"><?php the_sub_field('call_landline_number'); ?></a>
				</div>
			<?php endwhile; 
				endif; ?>

				  <?php  if (have_rows('reception_hours')) :
						// Loop through rows.
						while (have_rows('reception_hours')) : the_row(); ?>
				<div class="conatct-hours">
					<span><?php echo get_sub_field('block_title'); ?></span>
                        <?php  if (have_rows('timings')) :
                            while (have_rows('timings')) : the_row(); ?>
						<p><strong><?php the_sub_field('t_date'); ?> </strong><?php the_sub_field('t_time'); ?></p>
                        <?php endwhile; 
                        endif; ?>
				</div>
				 <?php endwhile; 
                        endif; ?>
				
				<?php
// Check rows exists.
					if (have_rows('social_media', 'options')) :?>
                       			<ul class="social-media-contact">
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
			<div class="right-right-content">
				<h1 class="mobile-heading"><?php echo get_sub_field('section_title'); ?></h1>
				<?php echo get_sub_field('form_content'); ?>
				<div class="contact-form-area">
					<div class="zf-templateWidth">
						<form action='https://forms.zohopublic.com/ifzafjr/form/IFZAWebsiteContactus/formperma/1MvS-nWRnFOBrBs22x4ZYzhLVratw-wgfa5-AuANQ_Y/htmlRecords/submit' name='form' method='POST' onSubmit='javascript:document.charset="UTF-8"; return zf_ValidateAndSubmit();' accept-charset='UTF-8' enctype='multipart/form-data' id='form'><input type="hidden" name="zf_referrer_name" value=""><!-- To Track referrals , place the referrer name within the " " in the above hidden input field -->
							<input type="hidden" name="zf_redirect_url" value=""><!-- To redirect to a specific page after record submission , place the respective url within the " " in the above hidden input field -->
							<input type="hidden" name="zc_gad" value=""><!-- If GCLID is enabled in Zoho CRM Integration, click details of AdWords Ads will be pushed to Zoho CRM -->
							<div class="zf-templateWrapper"><!---------template Header Starts Here---------->
							<ul class="zf-tempHeadBdr">
								<!-- <li class="zf-tempHeadContBdr">
								<h2 class="zf-frmTitle"><em>IFZA Website - Contact us</em></h2>
							<p class="zf-frmDesc"></p>
							<div class="zf-clearBoth"></div></li> -->
						</ul><!---------template Header Ends Here---------->
							<!---------template Container Starts Here---------->
							<div class="zf-subContWrap zf-topAlign"><ul>
							<!---------Dropdown Starts Here---------->
							<li class="zf-tempFrmWrapper zf-large"><label class="zf-labelName">
							</label>
							<div class="zf-tempContDiv">
							<select class="zf-form-sBox" name="Dropdown" checktype="c1">
							<option selected="true" value="-Select-">Select subject</option>
							<option value="Become&#x20;a&#x20;Professional&#x20;Partner">Become a Professional Partner</option>
							<option value="Business&#x20;Setup&#x20;enquiries">Business Setup enquiries</option>
							<option value="Office&#x20;Space&#x20;enquiries">Office Space enquiries</option>
							<option value="General&#x20;enquiries">General enquiries</option>
							</select><p id="Dropdown_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
							</div><div class="zf-clearBoth"></div></li><!---------Dropdown Ends Here---------->
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
							<!-- <label>Code</label>  --> </span>
							<span> <input type="text" compname="PhoneNumber" name="PhoneNumber_countrycode" maxlength="20" checktype="c7" value="" phoneFormat="1" isCountryCodeEnabled=true fieldType="11" id="international_PhoneNumber_countrycode" valType="number" phoneFormatType="2" placeholder="Phone&#x20;number&#x2a;" />
							<!-- <label>Number</label>  --> </span>
							<div class="zf-clearBoth"></div></div><p id="PhoneNumber_error" class="zf-errorMessage" style="display:none;">Invalid value</p>
							</div><div class="zf-clearBoth"></div></li><!---------Phone Ends Here----------> 
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
			</div>
		</div>
	</section>
	<?php elseif( get_row_layout() == 'how_to_reach_section' ): ?>

	
	<section class="contact-sec-2">
		<div class="contact-sec-2-left">
			<h2><?php echo get_sub_field('hr_title'); ?></h2>
			<h4 class="h6"><?php echo get_sub_field('hr_sub_title'); ?></h4>
			<?php echo get_sub_field('hr_content'); ?>
			<div class="address-widget">
				<?php echo get_sub_field('reception_content'); ?>
			</div>
		</div>
		<figure class="contact-sec-2-image">
			<picture>
					<?php if( get_sub_field('hr_image_webp') ){ ?><source srcset="<?php echo get_sub_field('hr_image_webp')['url']; ?>" type="image/webp"><?php } ?>
					<?php if( get_sub_field('hr_image') ){ ?><source srcset="<?php echo get_sub_field('hr_image')['url']; ?>" type="image/jpg"><?php } ?>
					<?php if( get_sub_field('hr_image') ){ ?><img src="<?php echo get_sub_field('hr_image')['url']; ?>" alt=image><?php } ?>
						</picture>
			
		</figure>
	</section>

<?php endif; ?>
    <?php endwhile; ?>
<?php endif; // flexible?>
	
	
</main>

<?php get_footer(); ?>

<script type="text/javascript">var zf_DateRegex = new RegExp("^(([0][1-9])|([1-2][0-9])|([3][0-1]))[-](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec|JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)[-](?:(?:19|20)[0-9]{2})$");
var zf_MandArray = [ "Dropdown", "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "DecisionBox"]; 
var zf_FieldArray = [ "Dropdown", "Name_First", "Name_Last", "Email", "PhoneNumber_countrycode", "PhoneNumber_countrycodeVal", "MultiLine", "DecisionBox"]; 
var isSalesIQIntegrationEnabled = false;
var salesIQFieldsArray = [];</script>