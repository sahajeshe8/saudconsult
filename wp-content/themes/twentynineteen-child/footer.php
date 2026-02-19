<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<!-- </main> -->




<section class="in-row pt-50 pb-50">
    <div class="wrap ">
        <di class="footer-bot-row">
            <div class="in-logo-footer" data-sr="wait 0.1s, enter right">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/in-icn.png">
                <h2>Linkedin</h2>
            </div>
            <a data-sr="wait 0.1s, enter right" class="but-01" taget="_blank" href="https://www.linkedin.com/in/regent-global-dmcc-83bb08272/">Connect with us on linkedin</a>
    </div>
    </div>
</section>
<footer class="pt-70 pb-70 bg-01">
    <div class="wrap">
        <ul class="footer-ul">



            <li class="f-col-03">
                <h3>Subscribe Now</h3>
                <p>
                    Stay updated with the latest <br>
                    happenings
                </p>

                <div class="subscribe-box">
                    <input class="sub-fld" type="text" placeholder="Your email address">
                    <input class="but-sub but-01 blue-but" type="button" value="Subscribe">
                </div>

                <ul class="social-icons mt-40">
                    <li><a target="_blank" href="https://www.facebook.com/regent200723"><span class="icon-facebook"></span></a></li>
                    <li><a href="#"><span class="icon-twitter"></span></a></li>
                    <li><a href="#"><span class="icon-instagram-logo"></span></a></li>
                </ul>
            </li>



            <li class="f-col-02">
                <h3>Contact Us</h3>
                <p>Regent Global DMCC<br>
                    1307, JBC-2<br>
                    Cluster-V, Jumeirah Lake Towers PO Box 943292 Dubai, UAE</p>
                <p>
                    <!-- Call Us: <a href="tel:+971 4 123456">+971 4 123456</a><br> -->
                    Call Us: <a href="tel:04 222 3922">04 222 3922</a><br>
                    Email Us: <a href="mailto:info@regent.com">info@regent.com</a>
                </p>
            </li>

            <li class="f-col-01">
                <h3>Other Links</h3>
                <div class="other-link">
                    <a href="<?php echo site_url('/'); ?>">Home</a>
                    <a href="<?php echo site_url('/csr2'); ?>">CSR</a>
                    <a href="<?php echo site_url('/about-us'); ?>">About Us</a>
                    <a href="<?php echo site_url('/media-center'); ?>">Media Center</a>
                    <a href="<?php echo site_url('/formulation'); ?>">R & D</a>
                    <a href="<?php echo site_url('/contact'); ?>">Contact us</a>
                    <a href="<?php echo site_url('/services'); ?>">Services & Products</a>
                    <!-- <a href="<?php //echo site_url('/');
                                    ?>">Employment</a> -->
                    <a href="<?php echo site_url('/manufacturing'); ?>">Facilities</a>
                    <a href="<?php echo site_url('/careers'); ?>">Careers</a>
                </div>

                <!-- <ul class="other-link">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">CSR</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Media Center</a></li>
                        <li><a href="#">R & D</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">Services & Products</a></li>
                        <li><a href="#">Employment</a></li>
                        <li><a href="#">Facilities</a></li>
                        <li><a href="#">Careers</a></li>
                     </ul> -->
                <p>© 2023 Regent. All Rights Reserved.</p>
            </li>




        </ul>
    </div>
    <div class="designed_by" style="text-align: right;
    font-size: 8px;
    color: #e9e4e4;
    margin-right: 319px;">
        Designed by <a href="https://www.element8.ae/" target="_blank" style="text-align: right;
    font-size: 8px;
    color: #e9e4e4;">E8</a>
    </div>
</footer>

<?php wp_footer(); ?>



<style>
    .f-cl-03 p a {
        color: #fff;
        text-decoration: none;
    }


    .f-cl-03 p a:hover {
        color: #b0ffed;
    }
</style>

</body>

</html>