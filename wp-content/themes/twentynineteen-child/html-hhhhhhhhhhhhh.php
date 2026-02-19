<?php get_header('black'); 
    /*Template Name: HTML Career Detail*/
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

<section class="inner-banner pattern"style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/banner-pattern.jpg) center bottom">
    <div class="banner-title-box" data-sr="wait 0.1s, enter right">
        <p>Posted 18 hours ago</p>
        <h1>Creative Graphic Designer</h1>
        <p>Draftsman / Modeller   |   United Arab Emirates</p>
    </div>
</section>




<section>
<div class="container-02">
<div class="flx-row">
<div class="job-left-box ">
    <div class="title-35 mb-30" data-sr="wait 0.1s, enter right">
    <h3>Job Roles & Responsibilities:</h3>
</div>
<ul class="list-01">
    <li data-sr="wait 0.1s, enter right">Archive and control revisions of design drawings, shop drawings, and as-builts.</li>
    <li data-sr="wait 0.1s, enter right">Must have a experience in CAD drafting/design experience in civil infrastructure projects (roads, bridges, utilities, manholes, landscaping, etc.)</li>
    <li data-sr="wait 0.1s, enter right">Must be fluent in English with an excellent understanding of technical terminology.</li>
    <li data-sr="wait 0.1s, enter right">Civil AutoCAD drafters have to draw diagrams and maps for projects and structures in construction.</li>
 
</ul>

<div class="title-35 mb-30 pt-70" data-sr="wait 0.1s, enter right">
    <h3>Qualifications:</h3>
</div>

<ul class="list-01">
    <li data-sr="wait 0.1s, enter right">
    Minimum Education:
    <span>Diploma/Bachelor degree/ ITI</span>
    </li>
    <li data-sr="wait 0.1s, enter right">
    Minimum Experience Required:
    <span>3- 10 years experience &  3+ years of minimum GCC experience</span>
    </li>
    <li data-sr="wait 0.1s, enter right">
    Software Knowledge:
    <span>Civil 3D<br>
    AutoCAD
</span>
    </li>
    
  
</ul>




</div>
<div class="job-right-box">
<div class="title-35 mb-30" data-sr="wait 0.1s, enter right">
    <h3>Skill Sets Required:</h3></div>
    <ul class="list-01">
        <li data-sr="wait 0.1s, enter right">Drafting Skill</li>
        <li data-sr="wait 0.1s, enter right">Computer Skill</li>
        <li data-sr="wait 0.1s, enter right">Collaboration Skill</li>
        <li data-sr="wait 0.1s, enter right">Attention to Details</li>
        <li data-sr="wait 0.1s, enter right">Communication Skill</li>
    </ul>



    <ul class="list-01 mt-130">
        <li>We are looking for immediate joiners.</li>
    </ul>
</div>
 
</div>



<div class="form-block-01 mt-120" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/form-bg.jpg) center top">
    <div class="form-container pb-100">
        <div class="title-40 align-center pt-100 pb-40" data-sr="wait 0.1s, enter right">
            <h3>Apply Online</h3>
        </div>
        <form class="form">
        <ul class="form-ul">
            <li data-sr="wait 0.1s, enter right">
                <input placeholder="First Name*" class="feald-01" type="text">
            </li>
            <li data-sr="wait 0.1s, enter right">
                <input placeholder="Last Name*" class="feald-01" type="text">
            </li>
            <li data-sr="wait 0.1s, enter right">
                <input placeholder="Email*" class="feald-01" type="text">
            </li>
            <li data-sr="wait 0.1s, enter right">
                <input placeholder="Phone Number*" class="feald-01" type="text">
            </li>
            <li data-sr="wait 0.1s, enter right">
                <input placeholder="City*" class="feald-01" type="text">
            </li>
            <li data-sr="wait 0.1s, enter right">
                <input placeholder="Linkedin URL" class="feald-01" type="text">
            </li>
            <li class="w-100" data-sr="wait 0.1s, enter right">
            
            <div class="file-upload-wrapper" data-text="Select your file!"  >
      <input name="file-upload-field" type="file" class="file-upload-field feald-01" value="" >
    </div>
            </li>

            <li class="w-100" data-sr="wait 0.1s, enter right">
                <a href="#" class="form-buttion">Submit</a>
            </li>
            
        </ul>
</form>
    </div>
</div>
</div>
</section>
 
 
<?php get_footer('inner'); ?>
 