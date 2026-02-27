<?php get_header('inner'); 
    /*Template Name: About*/
    wp_enqueue_script('script');
    add_action('wp_footer','page_script',21);
    function page_script(){
?>
<script>

jQuery('.marquee_text').marquee({
    direction: 'left',
    duration: 50000,
    gap: 50,
    delayBeforeStart: 0,
    duplicated: true,
    startVisible: true
});
</script>


<?php } ?>

<section class="inner-banner">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/about-banner.jpg" />
</section>

<section class="pt-130">
    <div class="container-02">
        <div class="title-row-01 title-left-line" data-sr="wait 0.1s, enter right">
            <h2>
            Niche mark is a <span>Saudi-based</span>
brand consultancy
            </h2>
            
        </div>
        <div class="sub-title-02a pt-100" data-sr="wait 0.1s, enter right">
        <h3>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer tobut also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets.
            </h3>

        </div>


        <div class="sub-para pt-40" data-sr="wait 0.1s, enter right">
            <p>A digital agency is a company that provides various services related to digital marketing, such as website design and development, search engine optimization (SEO), social media management, email marketing, and more. </p>
            <p>The goal of a digital agency is to help clients promote their products or services online and reach their target audience effectively through digital channels.</p>
        </div>

        <div class="image-section-about">
            
        <!-- <ul >
            <li>
            <?xml //version="1.0" encoding="utf-8"?>
 Generator: Adobe Illustrator 25.2.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<!-- <svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 123.26 880.88" style="enable-background:new 0 0 123.26 880.88;" xml:space="preserve">
<style type="text/css">
	.st0{fill:#AF2627;}
</style>
<rect y="113.09" class="st0" width="100.99" height="649.29"/>
</svg> -->
<!--  
            <img src="<?php //echo get_stylesheet_directory_uri(); ?>/images/about-img-01.jpg" /></li>
            <li></li>
            <li></li>
        </ul>  -->





        <svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 1216.21 880.88" style="enable-background:new 0 0 1216.21 880.88;" xml:space="preserve">
<style type="text/css">
	.st0{fill:#AF2627;}
</style>
<rect y="113.09" class="st0" width="100.99" height="649.29"/>
<rect x="123.26" class="st0" width="164.74" height="686.33"/>
<rect x="377.02" y="68.07" class="st0" width="137.92" height="649.03"/>
<rect x="536.01" y="113.1" class="st0" width="120.99" height="573.96"/>
<rect x="677.03" y="0.64" class="st0" width="164.31" height="612"/>
<rect x="862.02" y="113.1" class="st0" width="100.62" height="429"/>
<rect x="983.04" y="68.17" class="st0" width="147.73" height="649.04"/>
<path class="st0" d="M356.51,806.36V158.23h-48.52v648.68c-9.98,7.5-16.43,19.43-16.43,32.87c0,22.69,18.4,41.09,41.09,41.09
	c22.69,0,41.09-18.4,41.09-41.09C373.73,826,366.93,813.81,356.51,806.36z M332.71,855.67c-8.81,0-15.95-7.14-15.95-15.95
	c0-8.81,7.14-15.95,15.95-15.95c8.81,0,15.95,7.14,15.95,15.95C348.65,848.53,341.51,855.67,332.71,855.67z"/>
<path class="st0" d="M1200,736.52V88.16h-48.96v648.65c-9.63,7.49-15.84,19.25-15.84,32.48c0,22.62,18.13,40.96,40.5,40.96
	s40.5-18.34,40.5-40.96C1216.21,755.89,1209.84,743.99,1200,736.52z M1175.55,785.54c-8.78,0-15.9-7.2-15.9-16.08
	s7.12-16.08,15.9-16.08c8.78,0,15.9,7.2,15.9,16.08S1184.33,785.54,1175.55,785.54z"/>
</svg>





        </div>


        <div class="align-center mb-80 pt-120 "  >
            <div class="max-750" data-sr="wait 0.1s, enter right">
                <div data-sr="wait 0.1s, enter right" class="pb-20"><h2>Our Mission</h2></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras laoreet, nibh sed feugiat facilisis, ante nisi tincidunt sapien, vitae malesuada lorem augue non risus. Fusce ipsum libero, imperdiet vitae maximus cursus, elementum ac risus. Sed vel mauris laoreet, rhoncus diam sed, ultricies nulla. Suspendisse vel iaculis nulla, sit amet aliquam metus.</p>
            </div>

            <div class="about-image-box-02 mt-100">
                <div  class="img-block-01"><img data-sr="wait 0.1s, enter left" src="<?php echo get_stylesheet_directory_uri(); ?>/images/about-img-b-a.jpg" /></div>
                <div   class="img-block-02"><img data-sr="wait 0.1s, enter top" src="<?php echo get_stylesheet_directory_uri(); ?>/images/about-img-b-b.jpg" /></div>
                <div   class="img-block-03"><img data-sr="wait 0.1s, enter right" src="<?php echo get_stylesheet_directory_uri(); ?>/images/about-img-b-c.jpg" /></div>
            </div>
        </div>



    </div>

</section>

<section class="marquee-block mt-100 pt-100" data-sr="wait 0.1s, enter right">
    <div class="marquee_text txt-running">Core Values Core Values Core Values Core Values </div>
</section>


<section class="pt-80 pb-90">
    <div class="container-02 flx-row">
        <div class="about-right-block w-50" data-sr="wait 0.1s, enter right">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras laoreet, nibh sed feugiat facilisis, ante nisi tincidunt sapien, vitae malesuada lorem augue non risus. Fusce ipsum libero, imperdiet vitae maximus cursus, elementum ac risus. Sed vel mauris.</p>
            <p>Fusce facilisis magna pellentesque dui scelerisque, eu aliquet nibh varius. Suspendisse tempor interdum nulla sit amet varius.</p>
        </div>
    </div>

</section>
 
<?php get_footer('inner'); ?>
 