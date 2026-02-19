
<?php
/**
 * Template Name:sitemap
 */


?>

<?php get_header('');?>

<style type="text/css">

h2{font-size: 20px; margin: 0px 0px 25px 0px;}
 .sitemap ul{ margin:0px; padding: 50px 30px !important;    border: 1px solid #d4d4d4;
    border-radius: 10px;
    margin: 100px 0 !important;}
.sitemap ul li{margin-bottom: 10px; list-style-position: inside;}
.sitemap ul li a{color: #000; font-size: 16px; text-decoration: none; padding: 2px 10px;}
.done{color:green !important}
</style>

 
<section class="sitemap">
	<div class="container">
	<ul>
		<li><a  href="<?php echo site_url();?>" target="_blank" class="done">Home</a></li>
		<li><a  href="<?php echo site_url('/about-us/');?>" target="_blank"  class="done">About </a></li>
		<li><a  href="<?php echo site_url('/analytical-development/');?>" target="_blank"  class="done">Analytical Development </a></li>
		<li><a  href="<?php echo site_url('/careers/');?>" target="_blank"  class="done">Careers </a></li>
		<li><a  href="<?php echo site_url('/careers-detail/');?>" target="_blank"  class="done">Careers detail </a></li>
		<li><a  href="<?php echo site_url('/contact/');?>" target="_blank"  class="done">Contact </a></li>
		<li><a  href="<?php echo site_url('/manufacturing/');?>" target="_blank"  class="done">Manufacturing </a></li>
		<li><a  href="<?php echo site_url('/csr2/');?>" target="_blank"  class="done">CSR2</a></li>
		<li><a  href="<?php echo site_url('/events/');?>" target="_blank"  class="done">Events</a></li>
		<li><a  href="<?php echo site_url('/formulation/');?>" target="_blank"  class="done">formulation </a></li>
		<li><a  href="<?php echo site_url('/media-center');?>" target="_blank" class="done">media-center </a></li>
		<li><a  href="<?php echo site_url('/media-center-details');?>" target="_blank" class="done">Media center details </a></li>
		<li><a  href="<?php echo site_url('/parasite-control');?>" target="_blank" class="done">Parasite control </a></li>
		<li><a  href="<?php echo site_url('/parasite-control-details');?>" target="_blank" class="done">Parasite control details </a></li>
		<li><a  href="<?php echo site_url('/respiratory-products');?>" target="_blank" class="done">Respiratory products</a></li>
		<li><a  href="<?php echo site_url('/respiratory-products-details');?>" target="_blank" class="done">Respiratory products details </a></li>
		<li><a  href="<?php echo site_url('/services');?>" target="_blank" class="done">Services </a></li>
		<li><a  href="<?php echo site_url('/events-details');?>" target="_blank" class="done">Events details </a></li>
		<li><a  href="<?php echo site_url('/veterinary');?>" target="_blank" class="done">veterinary </a></li>
		<li><a  href="<?php echo site_url('/international-business-development-licensing');?>" target="_blank" class="done">International business development licensing</a></li>
		<li><a  href="<?php echo site_url('/product');?>" target="_blank" class="done">Product </a></li>
	 
		
		</ul>
		


	</div>
</section>


<?php
get_footer();


?>