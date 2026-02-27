<?php
/**
 * Why Build Your Career Section Component Template
 * Dynamic content from ACF: title, title_span, hero_image, features.
 *
 * @package tasheel
 */

$args      = isset( $args ) ? $args : array();
$title     = isset( $args['title'] ) ? $args['title'] : 'Why Build Your Career';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'With the Pioneers?';
$hero_image = isset( $args['hero_image'] ) ? $args['hero_image'] : get_template_directory_uri() . '/assets/images/why-build-img.jpg';
$features  = isset( $args['features'] ) && is_array( $args['features'] ) ? $args['features'] : array();

// Default features when none from ACF
if ( empty( $features ) ) {
	$features = array(
		array(
			'icon'       => get_template_directory_uri() . '/assets/images/why-icn-01.svg',
			'title'      => 'Unmatched',
			'title_span' => 'Project Impact.',
			'content'    => "Directly contribute to projects that are critical to the nation's infrastructure, urban development, and energy future—work that truly matters and leaves a lasting physical legacy.",
		),
		array(
			'icon'       => get_template_directory_uri() . '/assets/images/why-icn-02.svg',
			'title'      => 'Technical Mastery',
			'title_span' => '& Learning.',
			'content'    => 'Et imperdiet vitae diam ac eget non velit turpis viverra justo dol integer feugiat viverra tellus.',
		),
		array(
			'icon'       => get_template_directory_uri() . '/assets/images/why-icn-03.svg',
			'title'      => 'Structural',
			'title_span' => 'Engineering',
			'content'    => 'Design of all underpasses and bridges to ensure structural integrity and seismic resilience.',
		),
	);
}

?>

<section class="why_build_career_section pt_80 pb_80">
	<div class="wrap">
		<div class="why_build_career_inner">
			<h3 class="h3_title_50"><?php echo esc_html( $title ); ?> <br><span><?php echo esc_html( $title_span ); ?></span></h3>

			<div class="why_build_career_hero">
				<img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( $title ); ?>">
				<div class="why_build_career_hero_overlay"></div>
			</div>

			<ul class="why_build_career_features">
				<?php foreach ( $features as $f ) :
					$f_icon    = isset( $f['icon'] ) ? $f['icon'] : '';
					$f_title   = isset( $f['title'] ) ? $f['title'] : '';
					$f_span    = isset( $f['title_span'] ) ? $f['title_span'] : '';
					$f_content = isset( $f['content'] ) ? $f['content'] : '';
					$f_alt     = $f_title ? $f_title : 'Feature';
				?>
				<li class="why_build_career_feature_item">
					<div class="why_build_career_feature_icon">
						<img src="<?php echo esc_url( $f_icon ); ?>" alt="<?php echo esc_attr( $f_alt ); ?>">
					</div>
					<h4 class="h4_title_35"><?php echo esc_html( $f_title ); ?>  <br><span><?php echo esc_html( $f_span ); ?></span></h4>
					<div class="why_build_career_feature_content">
						<?php echo wp_kses_post( wpautop( $f_content ) ); ?>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>
