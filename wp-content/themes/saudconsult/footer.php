<?php
/**
 * The template for displaying the footer
 *
 * @package tasheel
 */
?>

<footer id="colophon" class="site-footer footer">
	<div class="wrap">
		<div class="footer_main">
			<div class="footer_left">
				<img
					src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logo.svg"
					alt="Footer Logo"
				>

				<ul class="footer_social_ul mobile_show">
						<li>
							<a href="#">
								<img
									src="<?php echo get_template_directory_uri(); ?>/assets/images/in-f.svg"
									alt="Footer Icon"
								>
							</a>
						</li>
						<li>
							<a href="#">
								<img
									src="<?php echo get_template_directory_uri(); ?>/assets/images/x-f.svg"
									alt="Footer Icon"
								>
							</a>
						</li>
					</ul>
			</div>

			<div class="footer_right">
				<div class="footer_row_01">
					<ul class="footer_social_ul mobile_hide">
						<li>
							<a href="#">
								<img
									src="<?php echo get_template_directory_uri(); ?>/assets/images/in-f.svg"
									alt="Footer Icon"
								>
							</a>
						</li>
						<li>
							<a href="#">
								<img
									src="<?php echo get_template_directory_uri(); ?>/assets/images/x-f.svg"
									alt="Footer Icon"
								>
							</a>
						</li>
					</ul>

					<div class="footer_row_02">
						<div class="footer_row_02_left">
							<h3>
								Stay updated with <br>
								SAUD CONSULT
								<span>
									latest <br>
									insights and service updates.
								</span>
							</h3>
						</div>

						<div class="footer_row_02_right">
							<div class="subscribe_form">
								<input
									class="footer_email_input"
									type="text"
									placeholder="Email address"
								>

								<a class="btn_style btn_green" href="#">
									Subscribe
									<span>
										<img
											src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg"
											alt="Explore More"
										>
									</span>
								</a>
							</div>
						</div>
					</div> <!-- footer_row_02 -->

<div class="footer_row_03">
	 <ul class="footer_row_03_ul">
		<li>
			<h3>Quick Links</h3>
			<ul class="footer_link_ul">
				<li>
					<a href="#">Company</a>
				</li>
				<li>
					<a href="#">Projects</a>
				</li>
				<li>
					<a href="#">Clients</a>
				</li>
				<li>
					<a href="#">Media Center</a>
				</li>
				<li>
					<a href="#">Careers</a>
				</li>
			</ul>
		</li>
		<li>
		<h3>Services</h3>

		<ul class="footer_link_ul">
				<li>
					<a href="#">Engineering Design</a>
				</li>
				<li>
					<a href="#">Construction Supervision</a>
				</li>
				<li>
					<a href="#">Specialized Studies</a>
				</li>
				<li>
					<a href="#">Project Management</a>
				</li>
				 
			</ul>


		</li>
		<li>
		<h3>Contact us</h3>
		<h4>Email:</h4>
		 <p><a href="mailto:scc@saudconsult.com">scc@saudconsult.com</a></p>

		 <h4>Phone:</h4>
		 <p><a href="tel:+966114659975">+966 1146 59975</a></p>
		</li>

	 
	 </ul>
</div>


 <div class="footer_row_04">

 <div class="footer_row_04_left">
	 <p>© 2025, Saud Consult   |   All Rights Reserved</p>
</div>

<div class="footer_row_04_right">
	 <ul>
		<li><a href="#">Terms and Conditions</a></li>
		<li><a href="#">Privacy Policy</a></li>
	 </ul>
</div>
	</div>

				</div> <!-- footer_row_01 -->
			</div> <!-- footer_right -->
		</div> <!-- footer_main -->
	</div> <!-- wrap -->
</footer>

<?php wp_footer(); ?>

</body>
</html>
