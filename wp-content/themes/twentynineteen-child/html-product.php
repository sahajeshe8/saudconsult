<?php get_header('');
   /*Template Name: HTML Product*/
   wp_enqueue_script('script');
   add_action('wp_footer', 'page_script', 21);
   function page_script()
   {
       ?>
<script>

jQuery(document).ready(function(){
//  
jQuery('.main-nav > ul > li').removeClass("active");
jQuery('.main-nav > ul > :nth-child(3)').addClass("active");



});
</script>
<?php
   }
   ?>
<section class="inner-banner-02 pattern" style="background: url(<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-product-banner.jpg) center bottom;">
   <div class="banner-title-box">
      <h1 data-sr="wait 0.1s, enter right">Product</h1>
      <span class="title-line"></span>
   </div>
</section>
<ul class="tabs">
   <li class="active"><a href="<?php echo site_url('/product/');?>">Human Products</a></li>
   <li><a href="<?php echo site_url('/veterinary-products/');?>">Veterinary Products</a></li>
</ul>
<section class="pt-100 pb-100">
   <div class="padding-left ">
      <div class="title-line-02 rel mt-80">
      <h2>Our Products</h2>
</div>
      <div class="product-row">
         <ul class="pro-row-01">
         <li>
            <ul class="pro-block-02">
               <li class="block-01-pro arrow-pro arrow-left">
                  <div class="left-side" data-sr="wait 0.1s, enter right">
                     <h4><a href="<?php echo site_url('/veterinary-products');?>" data-fancybox="" data-src="#respiratory">Respiratory</a></h4>
                     <!-- <p>Donec sagittis sit amet enim quis fringilla. Mauris sceleris</p> -->
                  </div>
               </li>
               <li class="block-02-pro zoom-ef">
               <a class="link-block-a" data-fancybox="" data-src="#anti-infectives" href="#"><img data-sr="wait 0.1s, enter right" class="w-100 res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-prd-img2.jpg" alt="icon" /></a>
               </li>
            </ul>
         </li>
         <li>
            <ul class="pro-block-02">
               <li class="block-01-pro zoom-ef">
                  <a class="link-block-a" data-fancybox="" data-src="#respiratory" href="#"><img data-sr="wait 0.1s, enter right" class="w-100 res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-prd-img1.jpg" alt="icon" /></a>
               </li>
               <li class="block-02-pro arrow-pro arrow-right">
                  <div data-sr="wait 0.1s, enter right" class="left-side">
                     <h4><a href="<?php echo site_url('/veterinary-products');?>" data-fancybox="" data-src="#anti-infectives">Anti Infectives </a></h4>
                     <!-- <p>Amet enim quis fringilla. Mauris sceleris it sit amet</p> -->
                  </div>
               </li>
            </ul>
         </li>
         <li>
            <ul class="pro-block-02">
               <li class="block-01-pro arrow-pro arrow-left">
                  <div class="left-side" data-sr="wait 0.1s, enter right">
                     <h4><a href="<?php echo site_url('/veterinary-products');?>" data-fancybox="" data-src="#anti-infectives">Immunology / Hematology</a></h4>
                     <!-- <p>Sagittis sit amet enim quis fringilla. Mauris sceleris</p> -->
                  </div>
               </li>
               <li class="block-02-pro zoom-ef">
               <a class="link-block-a" data-fancybox="" data-src="#anti-infectives" href="#"><img  data-sr="wait 0.1s, enter right" class="w-100 res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-prd-img3.jpg" alt="icon" /></a>
               </li>
            </ul>
         </li>
         <li>
            <ul class="pro-block-02">
               <li class="block-01-pro arrow-pro arrow-right">
                  <div class="left-side" data-sr="wait 0.1s, enter right">
                     <h4><a href="<?php echo site_url('/veterinary-products');?>" data-fancybox="" data-src="#anti-infectives">Cardiovascular</a></h4>
                     <!-- <p>Sceleris elit sit amet feugiat aliquam.</p> -->
                  </div>
               </li>
               <li class="block-02-pro zoom-ef">
               <a class="link-block-a" data-fancybox="" data-src="#anti-infectives" href="#"><img data-sr="wait 0.1s, enter right" class="w-100 res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-prd-img4.jpg" alt="icon" /></a>
               </li>
            </ul>
         </li>
         <li class="w-2x">
            <ul class="pro-block-02">
               
               <li  class="block-02-pro arrow-pro arrow-left">
                  <div class="left-side" data-sr="wait 0.1s, enter right">
                     <h4><a href="<?php echo site_url('/veterinary-products');?>" data-fancybox="" data-src="#ophthalmology">Ophthalmology</a></h4>
                     <!-- <p>Mauris sceleri  sit amet feugiat aliquam. Orci varius natoque 
                        atibus et magnis dis parturient
                     </p> -->
                  </div>
               </li>
               <li class="block-01-pro zoom-ef">
               <a class="link-block-a" data-fancybox="" data-src="#ophthalmology" href="#"><img data-sr="wait 0.1s, enter right" class="w-100 res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-prd-img5.jpg" alt="icon" /></a>
               </li>
               </ul>
               </li>




               <li class="w-2x">
                  <ul class="pro-block-02">
                    
                     <li  class="block-02-pro arrow-pro arrow-left">
                        <div class="left-side" data-sr="wait 0.1s, enter right">
                           <h4><a href="<?php echo site_url('/veterinary-products');?>" data-fancybox="" data-src="#others-topical">Others</a></h4>
                           <!-- <p>Mauris sceleri  sit amet feugiat aliquam. Orci varius natoque 
                              atibus et magnis dis parturient
                           </p> -->
                        </div>
                     </li>
                     <li class="block-01-pro zoom-ef ">
                     <a class="link-block-a" data-fancybox="" data-src="#others-topical" href="#"><img data-sr="wait 0.1s, enter right" class="w-100 res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-prd-img7.jpg" alt="icon" /></a>
                     </li>
                     </ul>
                     </li>





              


            </ul>
      </div>
   </div>
</section>


















<div id="respiratory" style="display: none;" class="list-popup">
   <h2>Respiratory</h2>
   <div class="inner">
   <div class="item">
   <div  >
   <!-- <h4 >Dry powder inhaler</h4> -->
   </div>

   <h4>Dry powder inhalers</h4>
   <ul>
   <li>Formoterol  fumarate 4.5/6/12 MCG</li>
   <li>Tiotropium Bromide</li>
   <li>Budesonide 100/200/320/400 </li>
   <li>Formoterol Fumarate + Budesonide Powder for Inhalation  6 mcg + 200 mcg</li>
   <li>Formoterol Fumarate + Budesonide Powder for Inhalation 12 mcg +  400 mcg</li>
   <li>Fluticasone Propionate 100mcg & Salmeterol 50mcg powder for Inhalation</li>
   <li>Fluticasone Propionate 250mcg & Salmeterol 50mcg powder for Inhalation</li>
   </ul>
   <h4>Nasal Sprays</h4>
   <ul>
   <li>Xylometazoline</li>
<li>Fluticasone Furoate</li>
<li>Fluticasone Propionate </li>
<li>Mometasone</li>
<li>Calcitonin</li>
<li>Desmopressin</li>
<li>Zolmitriptan</li>
<li>Tiotropium Bromide </li>
<li>Xylometazoline 0.5 mg + Ipratropium 0.6 mg </li>
<li>Azelastine Hydrochloride & Fluticasone Furoate</li>
<li>Azelastine Hydrochloride & Fluticasone Propionate </li>
   </ul>

   </div>
   </div>
   </div>








   <div id="anti-infectives" style="display: none;" class="list-popup">
      <h2>Anti-infectives</h2>
      <div class="inner">
      <div class="item">
      <div  >
      <!-- <h4 >Dry powder inhaler</h4> -->
      </div>
      <p>Under development</p>
      </div>
      </div>
      </div>





      <div id="others-topical" style="display: none;" class="list-popup">
         <h2>Others</h2>
         <div class="inner">
         <div class="item">
         <div  >
         <!-- <h4 >Dry powder inhaler</h4> -->
         </div>
         <h4>Topicals</h4>
         <ul>
         <li>Clobetasol Propionate BP Ointment</li>
         <li>Fluticasone Propionate Ointment</li>
         <li>Acyclovir Cream</li>
         <li>Adapalene Gel </li>
         <li>Terbinafine Cream</li>
         <li>Clotrimazole Cream</li>
            
      
         </ul>
         </div>
         </div>
         </div>








      <div id="ophthalmology" style="display: none;" class="list-popup">
         <h2>Ophthalmology</h2>
         <div class="inner">
         <div class="item">
         <div  >
         <!-- <h4 >Dry powder inhaler</h4> -->
         </div>

         <h4>Ophthalmic Ointments</h4>

         <ul>
         <li>Azithromycin Dihydrate USP 10mg</li>
<li>Erythromycin USP 0.5% w/w</li>
<li>Erythromycin BP 10000 IU</li>
<li>Glycerin Lubricating Gel BP 11.25% w/v</li>
<li>Sodium Chloride Ophthalmic drops USP 6% w/w</li>
<li>Ciprofloxacin Hydrochloride USP 0.3% w/w</li>
<li>Tetracycline Hydrochloride Ophthalmic drops USP 1% w/w</li>
<li>Gentamicin Sulfate Ophthalmic drops USP 0.3% w/w</li>
<li>Chloramphenicol BP 1% w/w</li>
<li>Ofloxacin USP 0.3% w/w</li>
<li>Acyclovir BP 3%</li>
<li>Lignocaine USP 2.5% , 5.0%</li>
<li>Norfloxacin USP 0.3% w/w</li>
<li>Ciprofloxacin Hydrochloride USP 0.3% w/w</li>
<li>Tacrolimus 0.3%</li>
<li>Tacrolimus  0.1%</li>
<li>Moxifloxacin Hydrochloride  BP 0.5% w/w</li>
<li>Cyclosporin</li>
<li>Sodium chloride 5% </li> 
<li>Tobramycin & Dexamethasone </li>
 

         </ul>


<h4>Ophthalmic Gels
</h4>

<ul>
   <li>Dexpanthenol USP 5% w/w</li>
   <li>Vitamin A Palmitate BP 10mg</li>
   <li>Carbomer NF 3.5mg</li>
   <li>Ganciclovir USP 0.15% w/w</li>
   <li>Carbomer 974P 0.25 %</li>
   <li>Carbomer 980P 0.2 % </li>
   <li>Dexpanthenol USP 5% w/w</li>
   <li>Lidocaine Hydrochloride BP 2% w/v</li>
   <li>Lidocaine Hydrochloride BP 4% w/v</li>
   <li>Hydroxyethyl cellulose BP </li>
</ul>






         </div>
         </div>
         </div>













<div id="list-content" style="display: none;" class="list-popup">
<h2>Respiratory</h2>
<div class="inner">
<div class="item">
<div  >
<h4 >Dry powder inhaler</h4>
</div>
<ul>
 
<li> Formoterol fumarate 4.5/6/12 MCG</li>
<li>Tiotropium Bromide</li>
<li>Budesonide 100/200/320/400 MCG</li>
<li>Formoterol Fumarate + Budesonide Powder for Inhalation  6 mcg + 200 mcg</li>
<li>Formoterol Fumarate + Budesonide Powder for Inhalation 12 mcg +  400 mcg</li>
<li>Fluticasone Propionate 100mcg & Salmeterol 50mcg powder for Inhalation</li>
<li>Fluticasone Propionate 250mcg & Salmeterol 50mcg powder for Inhalation</li>

 
</ul>
</div>
<div class="item">
<div>
<h4 >Nasal Spray</h4>
</div>
<ul>

<li>Xylometazoline</li>
<li>Fluticasone Furoate</li>
<li>Fluticasone Propionate</li> 
<li>Mometasone</li>
<li>Calcitonin</li>
<li>Desmopressin</li>
<li>Zolmitriptan</li>
<li>Tiotropium Bromide </li>
<li>Xylometazoline 0.5  mg + Ipratropium 0.6 mg</li> 
<li>Azelastine Hydrochloride & Fluticasone Furoate</li>
<li>Azelastine Hydrochloride & Fluticasone Propionate</li> 



</ul>
</div>
<div class="item">
<div><h4>Topical</h4></div>
<ul>
<li>Clobetasol Propionate BP</li> 
<li>Fluticasone Propionate  ointment</li> 
<li>Acyclovir Cream</li> 
<li>Adapalene gel</li>  
<li>Terbinafine </li> 
<li>Clotrimazole Cream</li> 

</ul>


</div>



<div class="item">
<div><h4>Ophthalmic Ointment</h4></div>
<ul>
<li>Azithromycin Dihydrate Eye  USP 10mg</li> 
<li>Erythromycin Eye  USP 0.5% w/w</li> 
<li>Erythromycin Eye  BP 10000 IU</li> 
<li>Glycerin Lubricating Gel BP 11.25% w/v</li> 
<li>Sodium Chloride Ophthalmic  USP 6% w/w</li> 
<li>Ciprofloxacin Hydrochloride Eye  USP 0.3% w/w</li> 
<li>Tetracycline Hydrochloride Ophthalmic  USP 1% w/w</li> 
<li>Gentamicin Sulfate Ophthalmic  USP 0.3% w/w</li> 
<li>Chloramphenicol Eye  BP 1% w/w</li> 
<li>Ofloxacin Eye  USP 0.3% w/w</li> 
<li>Acyclovir Eye  BP 3%</li> 
<li>Lignocaine USP 2.5% , 5.0%</li> 
<li>Norfloxacin Eye Ointment USP 0.3% w/w</li> 
<li>Ciprofloxacin Hydrochloride Eye Ointment USP 0.3% w/w</li> 
<li>Tacrolimus Eye Ointment 0.3%</li> 
<li>Tacrolimus Eye Ointment  0.1%</li> 
<li>Moxifloxacin Hydrochloride Eye Ointment BP 0.5% w/w</li> 
<li>Cyclosporin Ophthalmic Ointment </li> 
<li>Sodium chloride 5 % ointment </li> 
<li>Tobramycin & Dexamethasone Ophthalmic Ointment </li> 
</ul>
</div>

<div class="item">
<div><h4>Ophthalmic Gels</h4></div>
<ul>
<li>Dexpanthenol Ophthalmic Gel USP 5% w/w</li>
<li>Vitamin A Palmitate BP 10mg, Carbomer NF 3.5mg Ophthalmic Gel</li>
<li>Ganciclovir Ophthalmic Gel USP 0.15% w/w</li>
<li>Carbomer 974P eye gel 0.25 %</li>
 <li>Carbomer 980P eye gel 0.2 % </li>
 <li>Dexpanthenol Ophthalmic Gel USP 5% w/w</li>
<li>Lidocaine Hydrochloride Gel BP 2% w/v</li>
<li>Lidocaine Hydrochloride Gel BP 4% w/v</li>
 <li>Hydroxyethyl cellulose  BP </li>

</ul>
</div>








</div>
</div>
<?php get_footer('inner'); ?>