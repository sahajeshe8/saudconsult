<?php get_header(''); 
   /*Template Name: HTML presentation Products*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>

 

</script>

<style>
 
</style>

<?php } ?>
 
<section class="pt-100 pb-100 border-top"  >
   
       
   <div class="  presantation-slide">
   <div class="_df_book" webgl="true" source="<?php echo get_stylesheet_directory_uri(); ?>/images/presentation-home.pdf" id="df_manual_book"> </div>
       <div class="but-row- flx-row pt-30">

<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/presentation-home.pdf" target="_blank" class="but-01 mx-auto">Download the Presentation</a>
</div> 
</section>
<?php get_footer('inner'); ?>