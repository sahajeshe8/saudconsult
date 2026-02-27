<?php
/**
 * Contact Section: heading, description, contact info, social links, form.
 * All strings use esc_html_e / esc_attr__ with 'tasheel' for WPML.
 *
 * @package tasheel
 */

$args = isset( $args ) ? $args : array();
$heading_title           = isset( $args['heading_title'] ) ? $args['heading_title'] : '';
$heading_title_span      = isset( $args['heading_title_span'] ) ? $args['heading_title_span'] : '';
$description             = isset( $args['description'] ) ? $args['description'] : '';
$contact_info_items      = isset( $args['contact_info_items'] ) && is_array( $args['contact_info_items'] ) ? $args['contact_info_items'] : array();
$social_links            = isset( $args['social_links'] ) && is_array( $args['social_links'] ) ? $args['social_links'] : array();
$contact_form_shortcode  = isset( $args['contact_form_shortcode'] ) ? trim( (string) $args['contact_form_shortcode'] ) : '';

$default_heading   = esc_html__( 'Get in touch', 'tasheel' );
$default_span      = esc_html__( 'with us', 'tasheel' );
$default_desc      = esc_html__( "Questions, comments, or suggestions? Simply fill in the form and we'll be in touch shortly.", 'tasheel' );
if ( $heading_title === '' ) {
	$heading_title = $default_heading;
}
if ( $heading_title_span === '' ) {
	$heading_title_span = $default_span;
}
if ( $description === '' ) {
	$description = $default_desc;
}
?>

<section class="contact_us_section pt_120 pb_80">
	<div class="wrap">
		<div class="contact_us_container">
			<div class="contact_us_content">
				<div class="contact_us_info">
					<h3 class="h3_title_50"><?php echo esc_html( $heading_title ); ?> <span><?php echo esc_html( $heading_title_span ); ?></span></h3>
					<p class="contact_us_description"><?php echo wp_kses_post( $description ); ?></p>

					<div class="contact_info_section">
						<?php
						$default_icon = get_template_directory_uri() . '/assets/images/contact-icn-01.svg';
						foreach ( $contact_info_items as $item ) {
							$icon   = isset( $item['icon'] ) ? $item['icon'] : '';
							$text   = isset( $item['text'] ) ? trim( (string) $item['text'] ) : '';
							$is_link = ! empty( $item['is_link'] );
							if ( $text === '' ) {
								continue;
							}
							$icon_url = '';
							if ( is_string( $icon ) && $icon !== '' ) {
								$icon_url = esc_url_raw( $icon ) ?: '';
							} elseif ( is_array( $icon ) && isset( $icon['url'] ) ) {
								$icon_url = $icon['url'];
							} elseif ( is_array( $icon ) && isset( $icon['ID'] ) ) {
								$icon_url = wp_get_attachment_url( (int) $icon['ID'] ) ?: '';
							} elseif ( is_numeric( $icon ) ) {
								$icon_url = wp_get_attachment_url( (int) $icon ) ?: '';
							}
							if ( $icon_url === '' ) {
								$icon_url = $default_icon;
							}
							// Build link href when "Output as link?" is Yes (support plain phone/email text).
							$display_text = $text;
							$href = '';
							if ( $is_link ) {
								if ( strpos( $text, 'mailto:' ) === 0 || strpos( $text, 'tel:' ) === 0 ) {
									$href = $text;
									$display_text = preg_replace( '#^(mailto:|tel:)#', '', $text );
								} elseif ( strpos( $text, '@' ) !== false ) {
									$href = 'mailto:' . $text;
								} else {
									$href = 'tel:' . preg_replace( '/[^\d+]/', '', $text );
								}
							}
							?>
							<div class="contact_info_item">
								<div class="contact_info_icon">
									<img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php echo esc_attr__( 'Contact', 'tasheel' ); ?>">
								</div>
								<div class="contact_info_text">
									<?php if ( $is_link && $href !== '' ) : ?>
										<a href="<?php echo esc_url( $href ); ?>"><?php echo esc_html( $display_text ); ?></a>
									<?php else : ?>
										<p><?php echo esc_html( $text ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php } ?>

						<?php if ( ! empty( $social_links ) ) : ?>
							<div class="contact_social_links">
								<?php
								$allowed_svg = array(
									'svg'  => array( 'xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true, 'viewBox' => true, 'fill' => true, 'aria-hidden' => true, 'class' => true ),
									'path' => array( 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ),
									'circle' => array( 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true ),
									'use' => array( 'href' => true, 'xlink:href' => true ),
								);
								foreach ( $social_links as $social ) :
									$url = isset( $social['url'] ) ? esc_url( $social['url'] ) : '#';
									$icon_svg_raw = isset( $social['icon_svg'] ) ? trim( (string) $social['icon_svg'] ) : '';
									$icon_img = isset( $social['icon'] ) ? $social['icon'] : '';
									$icon_src = '';
									if ( is_string( $icon_img ) && $icon_img !== '' ) {
										$icon_src = esc_url_raw( $icon_img ) ?: '';
									} elseif ( is_array( $icon_img ) && isset( $icon_img['url'] ) ) {
										$icon_src = $icon_img['url'];
									} elseif ( is_array( $icon_img ) && isset( $icon_img['ID'] ) ) {
										$icon_src = wp_get_attachment_url( (int) $icon_img['ID'] ) ?: '';
									} elseif ( is_numeric( $icon_img ) ) {
										$icon_src = wp_get_attachment_url( (int) $icon_img ) ?: '';
									}
								?>
									<a href="<?php echo $url; ?>" class="contact_social_link"<?php if ( $url !== '#' ) { echo ' target="_blank" rel="noopener noreferrer"'; } ?>>
										<?php if ( $icon_svg_raw !== '' ) : ?>
											<?php echo wp_kses( $icon_svg_raw, $allowed_svg ); ?>
										<?php elseif ( $icon_src ) : ?>
											<img src="<?php echo esc_url( $icon_src ); ?>" alt="<?php echo esc_attr__( 'Social', 'tasheel' ); ?>">
										<?php else : ?>
											<svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none" aria-hidden="true"><path d="M2.88895 1.4452C2.88876 1.8283 2.73639 2.19563 2.46536 2.46638C2.19434 2.73714 1.82685 2.88914 1.44375 2.88895C1.06065 2.88876 0.693323 2.73639 0.422566 2.46536C0.15181 2.19434 -0.000191369 1.82685 1.80821e-07 1.44375C0.00019173 1.06065 0.152561 0.693323 0.423588 0.422566C0.694615 0.15181 1.0621 -0.000191369 1.4452 1.8082e-07C1.8283 0.00019173 2.19563 0.152561 2.46638 0.423588C2.73714 0.694615 2.88914 1.0621 2.88895 1.4452Z" fill="#136B37"/></svg>
										<?php endif; ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="contact_us_form_wrapper">
					<?php if ( $contact_form_shortcode !== '' ) : ?>
						<?php echo do_shortcode( $contact_form_shortcode ); ?>
					<?php else : ?>
						<form class="contact_form" id="contactForm" method="post" action="">
							<ul class="contact_form_list">
								<li class="form_row_item">
									<ul class="form_row">
										<li class="form_group">
											<input type="text" id="contact_first_name" name="contact_first_name" class="form_input" placeholder="<?php echo esc_attr__( 'First Name*', 'tasheel' ); ?>" required>
										</li>
										<li class="form_group">
											<input type="text" id="contact_last_name" name="contact_last_name" class="form_input" placeholder="<?php echo esc_attr__( 'Last Name*', 'tasheel' ); ?>" required>
										</li>
									</ul>
								</li>
								<li class="form_group">
									<input type="email" id="contact_email" name="contact_email" class="form_input" placeholder="<?php echo esc_attr__( 'Email*', 'tasheel' ); ?>" required>
								</li>
								<li class="form_group">
									<input type="tel" id="contact_phone" name="contact_phone" class="form_input" placeholder="<?php echo esc_attr__( 'Phone Number*', 'tasheel' ); ?>" required>
								</li>
								<li class="form_group">
									<textarea id="contact_message" name="contact_message" class="form_textarea" placeholder="<?php echo esc_attr__( 'Message', 'tasheel' ); ?>" rows="6"></textarea>
								</li>
								<li class="form_submit_wrapper">
									<button type="submit" class="btn_style but_black">
										<span><?php esc_html_e( 'Submit', 'tasheel' ); ?></span>
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="<?php echo esc_attr__( 'Arrow', 'tasheel' ); ?>">
									</button>
								</li>
							</ul>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
