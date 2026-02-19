<?php
   /**
    * The template for displaying 404 pages (not found)
    *
    * @link https://codex.wordpress.org/Creating_an_Error_404_Page
    *
    * @package WordPress
    * @subpackage Twenty_Seventeen
    * @since 1.0
    * @version 1.0
    */
   
   get_header('inner'); ?>
<div class="banner-404" >
   <div class="container" >
      <h1 data-aos="fade-up" data-aos-delay="200">404</h1>
   </div>
</div>
<div class="container pt-80 pb-80 cont-404">
   <div class="error-404">
      <h1><?php _e( 'Whoops, Our Bad...', 'twentyseventeen' ); ?></h1>
      <h4><?php _e( 'The page you requested was not found and here are the possible solutions:', 'twentyseventeen' ); ?></h4>
      <ul>
         <li><?php _e( 'If you have typed the URL directly on the address bar, please make sure the spelling is correct', 'twentyseventeen' ); ?></li>
         <li><?php _e( 'If you reached this page when you clicked a product link or any link, then that link is probably outdated.', 'twentyseventeen' ); ?></li>
      </ul>
      <h3>What can you do?</h3>
      <h4><?php _e( 'Here are what you could try to get back to our Store:', 'twentyseventeen' ); ?></h4>
      <ul>
         <li><?php _e( 'Click the back button to go back the previous page', 'twentyseventeen' ); ?></li>
         <li><?php _e( 'Click on the search icon to find another item / text', 'twentyseventeen' ); ?></li>
      </ul>
      <a class="btn btn-primary" href="<?php echo site_url(); ?>">Go back to home</a>
   </div>
</div>
<?php get_footer('inner');