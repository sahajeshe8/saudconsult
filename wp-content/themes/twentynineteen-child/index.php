<?php
get_header(); 
// -------------------------------------
wp_enqueue_script('script');
add_action('wp_footer','page_script',21);
function page_script(){
  ?>
  <script>

  // -------script-------
  
</script>
<?php
}
// -------------------------------------

$post_pageId = get_queried_object_id();

?>


<section class="inner-banner" style="background:  url(<?php the_field('select_banner',$post_pageId); ?>) center center no-repeat; background-size: cover;">
 <div class="container">
  <h1><?php echo get_the_title($post_pageId); ?></h1>
</div>
</section>

<section class="clearfix pt-100 pb-100">
  <div class="container">


    <?php  

    if(get_query_var('paged') == 0){


     $featured_args = array(
       'post_status'     => array('publish'),
       'post_type'       => array('post'),
       'meta_key'        => 'posted_date',
       'orderby'         => 'meta_value',
       'order'           => 'DESC',
       'posts_per_page'  => 1,
       'meta_query'      => array(
         array(
           'key' => 'featured_post',
           'value' => '1',
           'type' => 'NUMERIC',
           'compare' => '=',
         ),
       )

     );


     $featured_query = new WP_Query( $featured_args );

                  // The Loop
     if ( $featured_query->have_posts() ){ 
      while ( $featured_query->have_posts() ){
        $featured_query->the_post(); ?>

        <h2 data-aos-delay="300" data-aos="fade-up"><?php the_title(); ?></h2>

        <div class="row-02" data-aos-delay="300" data-aos="fade-up"><a href="<?php the_permalink(); ?>">
          <img data-aos-delay="300" data-aos="fade-up"  class="res-img" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>">
          <ul class="post-info">
            <li><p><?php _e('Featured Article'); ?></p></li>
            <li><p><?php the_field('posted_date'); ?></p></li>
          </ul>
          <h3 ><?php the_field('journel_caption'); ?></h3></a>
          <p  ><?php the_excerpt(); ?></p>
        
        </div>
      <?php } 
    }  wp_reset_postdata();
  } ?>

  <?php 
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

  $i = $i+1;

  $args = array(
   'post_status'     => array('publish'),
   'post_type'       => array('post'),
   'meta_key'        => 'posted_date',
   'orderby'         => 'meta_value',
   'order'           => 'DESC',
   'paged'           => get_query_var('paged'),
   'meta_query'      => array(
     array(
       'key' => 'featured_post',
       'value' => '1',
       'type' => 'NUMERIC',
       'compare' => '!=',
     ),
   )

 );


    $the_query = new WP_Query( $args ); //echo "<pre>"; print_r($the_query); echo "</pre>";

                  // The Loop
    if ( $the_query->have_posts() ){
      ?>
      <div class="row-03 row-02 pt-100">
        <ul>
          <?php  while ( $the_query->have_posts() ){
            $the_query->the_post();

            if(get_field('featured_post') != 1){

             $img_url = get_the_post_thumbnail_url(get_the_ID(), array(562, 313)); 

             ?> 
             <li data-aos-delay="300" data-aos="fade-up">
              <a href="<?php the_permalink(); ?>"><div class="grid-02">

                <figure class="effect-bubba"><img style="background:  url(<?php echo $img_url; ?>) left bottom no-repeat; background-size: cover;"  class="res-img desk-non-01" src="<?php echo get_stylesheet_directory_uri(); ?>/images/image-placeholder-06.png">
                  <figcaption>  </figcaption>
                </figure>
                
              </div></a>
              <ul class="post-info" data-aos-delay="300" data-aos="fade-up">
                <li ><p><?php the_field('posted_date'); ?></p></li>

              </ul>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p><?php the_excerpt(); ?></p>
            </li>

            <?php 
          } 
        } 
      } ?>
    </ul>

    <div class="pagination" data-aos-delay="300" data-aos="fade-up">
     <?php
     $big = 999999999;
     echo paginate_links( array(
      'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
      'format' => '?paged=%#%',
      'current' => max( 1, get_query_var('paged') ),
      'total' => $the_query->max_num_pages,
      'prev_text' => '&laquo;',
      'next_text' => '&raquo;'
    ) );
                  // Reset Post Data
    wp_reset_postdata(); ?>
  </div>


</div>
</div>
</section>



<?php 
get_footer(); ?>