<?php get_header(''); 
   /*Template Name: HTML finance-manager*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>
 jQuery("form").on("change", ".file-upload-field", function () {
      jQuery(this).parent(".file-upload-wrapper").attr("data-text", jQuery(this).val().replace(/.*(\/|\\)/, ''));
    });

</script>
<?php } ?>
<section class="inner-banner-02 pattern"style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/careers-banner.jpg) center bottom; background-size: cover;">
   <div class="banner-title-box" data-sr="wait 0.1s, enter right" >
      <h1>Careers</h1>
      <span class="title-line"></span>
   </div>
</section>
<section class="pt-100 pb-100"  >
   <div class="wrap">
      <div class="career-title-row align-center" >
         <div data-sr="wait 0.1s, enter right" >
            <h5>Posted 18 hours ago</h5>
            <h2>Finance Manager</h2>
         </div>
         <ul class="brud-career" >
            <li data-sr="wait 0.1s, enter right">4 to 9 Years</li>
            <li data-sr="wait 0.1s, enter right">Accounts</li>
         </ul>
      </div>
      <ul class="career-block-ul">
         <li >
            <h3>Job Roles & Responsibilities</h3>
            <ul>
               <li>Perform and control the full accounting process, audit cycle including risk management and control management over operations’ effectiveness, financial reliability and compliance with all applicable directives and regulations</li>
               <li>Monthly and Yearly closing and timely submission of Management report to Directors / Shareholders. Finalization of all company accounts and intercompany transaction and consolidation of account.</li>
               <li>Dealing with bankers on any matters related to company.</li>
               <li>Obtain, analyse and evaluate accounting / commercial documentation, previous reports, data, flowcharts etc related to various functions of an organization.</li>
               <li>Handling legal formalities required for setup of new company, renewal of licenses, certificates etc.</li>
               <li>Conduct statutory audits for the company and its subsidiaries</li>
               <li>Participating weekly meeting with Sales / Operational team & Shareholder’s based at Bar</li>
               <li>Review of contracts and Agreements, Minutes of the Directors meeting and Board Resolution</li>
               <li>Identify loopholes and recommend risk aversion measures and cost savings</li>
               <li>Engage to continuous knowledge development regarding sector’s rules, regulations, best practices, tools, techniques and performance standards</li>
 
               
            </ul>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <h3>Skill Sets Required </h3>
            <ul>
               <li>Professional degree in Accounts – CA is must</li>
               <li>Proven working experience as Finance / Accounts Manager</li>
               <li>Strong Analytical, written/verbal communication, interpersonal and relationship building skills</li>
               <li>Knowledge of Tally accounting system will be added advantage</li>
               <li>Systems knowledge and familiarity</li>
               <li>Proven knowledge of auditing standards and procedures, laws, rules and regulations</li>
               <li>Sound independent judgement</li>
            </ul>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <h3 data-sr="wait 0.1s, enter right">Qualifications</h3>
            <ul data-sr="wait 0.1s, enter right">
               <li>CA is must</li>
              
            </ul>
         </li>
      </ul>
      <div class="form-block-main">
         <div class="align-center" data-sr="wait 0.1s, enter right">
            <h2>Apply Online</h2>
         </div>
         <div class="form-box">
         <form class="form">
            <ul class="form-ul">
               <li data-sr="wait 0.1s, enter right">
                  <input class="fld-01" type="text" placeholder="First Name*">
               </li>
               <li data-sr="wait 0.1s, enter right">
                  <input class="fld-01" type="text" placeholder="Last Name*">
               </li>
               <li data-sr="wait 0.1s, enter right">
                  <input class="fld-01" type="text" placeholder="Email Address*">
               </li>
               <li data-sr="wait 0.1s, enter right">
                  <input class="fld-01" type="text" placeholder="Contact Number*">
               </li>
               <li data-sr="wait 0.1s, enter right">
                  <input class="fld-01" type="text" placeholder="City*">
               </li>
               <li data-sr="wait 0.1s, enter right">
                  <input class="fld-01" type="text" placeholder="Linkedin URL">
               </li>
               <li class="w-100" data-sr="wait 0.1s, enter right">
                  <div class="upload-fld fld-01">
                  <div class="file-upload-wrapper" data-text="Drag and drop or browse files">
        <input name="file-upload-field" type="file" class="file-upload-field" value="">
      </div>
                  </div>
                  <a href="#" class="but-01  blue-but">Submit</a>
               </li>
            </ul>
   </form>
         </div>
      </div>
   </div>
</section>
<?php get_footer('inner'); ?>