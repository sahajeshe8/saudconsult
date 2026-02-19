<?php 
/**
* Template Name: Sliders
*/?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/blog.css?ver=1.0" rel="stylesheet">
<?php get_header()?>
<main>
	<section class="banner-two">
		<div class="container">
			<div class="banner-menu-search">
				<nav>

<div class="glide">
  <div class="glide__track" data-glide-el="track">
    <ul class="glide__slides">
      <li class="glide__slide">Slide 1</li>
      <li class="glide__slide">Slide 2</li>
      <li class="glide__slide">Slide 3</li>
      <li class="glide__slide">Slide 4</li>
    </ul>
  </div>
</div>

<div class="thumbnails">
  <div data-glide-to="0">Thumbnail 1</div>
  <div data-glide-to="1">Thumbnail 2</div>
  <div data-glide-to="2">Thumbnail 3</div>
  <div data-glide-to="3">Thumbnail 4</div>
</div>
  
                </nav>
            </div>
        </div></section>
</main>
<?php get_footer(); ?>
<script>
   var glide = new Glide('.glide');

   console.log(glide);

jQuery('.thumbnails div').on('click', function() {
  if (glide !== undefined) { // check if glide is defined
    glide.go(jQuery(this).data('glide-to'));
  }
});
</script>