<?php get_header(''); 
   /*Template Name: HTML ra-manager*/
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
            <h2>Manager Regulatory affairs</h2>
         </div>
         <ul class="brud-career" >
            <li data-sr="wait 0.1s, enter right">Minimum industry experience of 8-10 years</li>
            <li data-sr="wait 0.1s, enter right">Drug Regulatory and affairs</li>
         </ul>
      </div>
      <ul class="career-block-ul">
         <li  >
            <h3>Job Roles & Responsibilities</h3>
            <ul>
               <li>Provide responses to regulatory agencies regarding product information or issues.</li>
               <li>Develop and maintain standard operating procedures or local working practices.</li>
               <li>Establish regulatory priorities or budgets and allocate resources and workloads.</li>
               <li>Maintain current knowledge of relevant regulations, including proposed and final rules.</li>
               <li>Manage activities such as audits, regulatory agency inspections, or product recalls.</li>
               <li>Participate in the development or implementation of clinical trial protocol</li>
               <li>Direct the preparation and submission of regulatory agency applications, reports, or correspondence</li>
               <li>Formulate or implement regulatory affairs policies and procedures to ensure that regulatory compliance is maintained or enhanced.</li>
               <li>Provide regulatory guidance to departments or development project teams regarding design, development, evaluation, or marketing of products</li>
               <li>Communicate regulatory information to multiple departments and ensure that information is interpreted correctly.</li>
               <li>Develop regulatory strategies and implementation plans for the preparation and submission of new products.</li>
               <li>Implement or monitor complaint processing systems to ensure effective and timely resolution of all complaint investigations.</li>
               <li>Investigate product complaints and prepare documentation and submissions to appropriate regulatory agencies as necessary.</li>
               <li>Monitor emerging trends regarding industry regulations to determine potential impacts on organizational processes.</li>
               <li>Oversee documentation efforts to ensure compliance with domestic and international regulations and standards.</li>
               <li>Represent organizations before domestic or international regulatory agencies on major policy matters or decisions regarding company products.</li>
               <li>Review all regulatory agency submission materials to ensure timeliness, accuracy, comprehensiveness, or compliance with regulatory standards.</li>
               <li>Review materials such as marketing literature or user manuals to ensure that regulatory agency requirements are met</li>
               <li>Contribute to the development or implementation of business unit strategic and operating plans.</li>
               <li>Establish procedures or systems for publishing document submissions either in hardcopy or electronic formats.</li>
               <li>Evaluate new software publishing systems and confer with regulatory agencies concerning news or updates related to electronic publishing of submissions.</li>
               
 
               
 
               
            </ul>
         </li>
         <li  >
            <h3>Skill Sets Required </h3>
            <ul>
               <li>Excellent command (Written and verbal) of English language and proficient knowledge of medical terminology. </li>
               <li>IT Literacy (MS Windows, MS Office)</li>
               <li>Solid understanding of drug development process, pharmaceutical legislation and scientific matter</li>
               <li>Familiar with ANDA, e-CTD, CTD and ACTD regulations.</li>
               <li>Ability to interact professionally with customers and work effectively within a team. /li>
               <li>Strong strategic thinking, analytical and problem-solving skills</li>
               <li>Excellent organizational, prioritizing and communications skills.</li>
               <li>Ability to manage multiple and varied tasks with attention to details</li>
               <li>Effective in time management to ensure project deadlines are met.</li>
               <li>Ability to work independently with regular oversight.</li>
             
                
            </ul>
         </li>
         <li  >
            <h3  >Qualifications</h3>
            <ul  >
               <li>Master's degree in Pharmacy or equivalent </li>
              
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