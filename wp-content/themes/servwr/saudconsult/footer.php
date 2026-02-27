<?php
/**
 * The template for displaying the footer
 *
 * Dynamic footer from ACF Options. Sections hidden when no content.
 * All strings use esc_html__ for WPML translation support.
 *
 * @package tasheel
 */

$footer_logo_url = function_exists( 'tasheel_get_footer_logo_url' ) ? tasheel_get_footer_logo_url() : null;
$footer_social   = function_exists( 'tasheel_get_footer_social_links' ) ? tasheel_get_footer_social_links() : array();
$footer_opts     = function_exists( 'tasheel_get_footer_options' ) ? tasheel_get_footer_options() : array();
$footer_opts     = wp_parse_args( $footer_opts, array(
	'quick_links_title'  => esc_html__( 'Quick Links', 'tasheel' ),
	'services_title'     => esc_html__( 'Services', 'tasheel' ),
	'newsletter_heading' => '',
	'contact_title'      => esc_html__( 'Contact us', 'tasheel' ),
	'contact_email'      => '',
	'contact_phone'      => '',
	'copyright_text'     => '© {year}, Saud Consult   |   All Rights Reserved',
	'legal_links'        => array(),
) );
$footer_cf7      = function_exists( 'tasheel_get_footer_contact_form_shortcode' ) ? tasheel_get_footer_contact_form_shortcode() : '';
$quick_links_id  = function_exists( 'tasheel_get_footer_quick_links_menu' ) ? tasheel_get_footer_quick_links_menu() : null;
$services_id     = function_exists( 'tasheel_get_footer_services_menu' ) ? tasheel_get_footer_services_menu() : null;
$has_newsletter  = ! empty( $footer_cf7 );
$has_contact     = ! empty( $footer_opts['contact_email'] ) || ! empty( $footer_opts['contact_phone'] );
$has_copyright   = ! empty( $footer_opts['copyright_text'] );
$has_legal       = ! empty( $footer_opts['legal_links'] ) && is_array( $footer_opts['legal_links'] ) && count( $footer_opts['legal_links'] ) > 0;
$has_quick_links = $quick_links_id && is_nav_menu( $quick_links_id );
$has_services    = $services_id && is_nav_menu( $services_id );
$show_footer_left = ! empty( $footer_logo_url ) || ! empty( $footer_social );
?>

<footer id="colophon" class="site-footer footer">
	<div class="wrap">
		<div class="footer_main">
			<?php if ( $show_footer_left ) : ?>
			<div class="footer_left">
				<?php if ( ! empty( $footer_logo_url ) ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url( $footer_logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				</a>
				<?php endif; ?>

				<?php if ( ! empty( $footer_social ) ) : ?>
				<ul class="footer_social_ul mobile_show">
					<?php foreach ( $footer_social as $social ) : ?>
						<?php
						$url   = ! empty( $social['url'] ) ? $social['url'] : '#';
						$icon  = ! empty( $social['icon'] ) && is_array( $social['icon'] ) && ! empty( $social['icon']['url'] ) ? $social['icon']['url'] : get_template_directory_uri() . '/assets/images/in-f.svg';
						$alt   = ! empty( $social['platform'] ) ? $social['platform'] : esc_attr__( 'Social', 'tasheel' );
						?>
					<li>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $alt ); ?>">
							<img src="<?php echo esc_url( $icon ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="footer_right">
				<div class="footer_row_01">
					<?php if ( ! empty( $footer_social ) ) : ?>
					<ul class="footer_social_ul mobile_hide">
						<?php foreach ( $footer_social as $social ) : ?>
							<?php
							$url   = ! empty( $social['url'] ) ? $social['url'] : '#';
							$icon  = ! empty( $social['icon'] ) && is_array( $social['icon'] ) && ! empty( $social['icon']['url'] ) ? $social['icon']['url'] : get_template_directory_uri() . '/assets/images/in-f.svg';
							$alt   = ! empty( $social['platform'] ) ? $social['platform'] : esc_attr__( 'Social', 'tasheel' );
							?>
						<li>
							<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $alt ); ?>">
								<img src="<?php echo esc_url( $icon ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>

					<?php if ( $has_newsletter ) : ?>
					<div class="footer_row_02">
						<?php if ( ! empty( $footer_opts['newsletter_heading'] ) ) : ?>
						<div class="footer_row_02_left">
							<h3><?php echo wp_kses_post( $footer_opts['newsletter_heading'] ); ?></h3>
						</div>
						<?php endif; ?>
						<div class="footer_row_02_right">
							<?php echo do_shortcode( $footer_cf7 ); ?>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $has_quick_links || $has_services || $has_contact ) : ?>
					<div class="footer_row_03">
						<ul class="footer_row_03_ul">
							<?php if ( $has_quick_links ) : ?>
							<li>
								<h3><?php echo esc_html( $footer_opts['quick_links_title'] ); ?></h3>
								<?php
								wp_nav_menu( array(
									'menu'       => $quick_links_id,
									'container'  => false,
									'menu_class' => 'footer_link_ul',
									'depth'      => 1,
								) );
								?>
							</li>
							<?php endif; ?>
							<?php if ( $has_services ) : ?>
							<li>
								<h3><?php echo esc_html( $footer_opts['services_title'] ); ?></h3>
								<?php
								wp_nav_menu( array(
									'menu'       => $services_id,
									'container'  => false,
									'menu_class' => 'footer_link_ul',
									'depth'      => 1,
								) );
								?>
							</li>
							<?php endif; ?>
							<?php if ( $has_contact ) : ?>
							<li>
								<h3><?php echo esc_html( $footer_opts['contact_title'] ); ?></h3>
								<?php if ( ! empty( $footer_opts['contact_email'] ) ) : ?>
								<h4><?php echo esc_html__( 'Email:', 'tasheel' ); ?></h4>
								<p><a href="mailto:<?php echo esc_attr( antispambot( $footer_opts['contact_email'] ) ); ?>"><?php echo esc_html( antispambot( $footer_opts['contact_email'] ) ); ?></a></p>
								<?php endif; ?>
								<?php if ( ! empty( $footer_opts['contact_phone'] ) ) : ?>
								<h4><?php echo esc_html__( 'Phone:', 'tasheel' ); ?></h4>
								<p><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $footer_opts['contact_phone'] ) ); ?>"><?php echo esc_html( $footer_opts['contact_phone'] ); ?></a></p>
								<?php endif; ?>
							</li>
							<?php endif; ?>
						</ul>
					</div>
					<?php endif; ?>

					<?php if ( $has_copyright || $has_legal ) : ?>
					<div class="footer_row_04">
						<?php if ( $has_copyright ) : ?>
						<div class="footer_row_04_left">
							<p><?php echo esc_html( str_replace( '{year}', (string) date( 'Y' ), $footer_opts['copyright_text'] ) ); ?></p>
						</div>
						<?php endif; ?>
						<?php if ( $has_legal ) : ?>
						<div class="footer_row_04_right">
							<ul>
								<?php foreach ( $footer_opts['legal_links'] as $legal ) : ?>
									<?php if ( ! empty( $legal['link_text'] ) ) : ?>
								<li><a href="<?php echo esc_url( ! empty( $legal['link_url'] ) ? $legal['link_url'] : '#' ); ?>"><?php echo esc_html( $legal['link_text'] ); ?></a></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
<!-- Hide the success message after few second CF7  -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('wpcf7mailsent', function () {

        setTimeout(function () {
            const response = document.querySelector('.wpcf7-response-output');

            if (response) {
                response.style.display = 'none';
            }
        }, 4000); // 4000 = 4 seconds

    }, false);

});
</script>

</body>
</html>
