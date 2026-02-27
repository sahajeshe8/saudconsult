<?php
/**
 * ACF Contact Us + shared About: render flexible content.
 * All strings use esc_html__, esc_html_e, esc_attr__ with 'tasheel' for WPML.
 * About layouts are delegated to tasheel_render_about_flexible_section.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout names that use the Home renderer (home-specific sections, also in About flexible).
 *
 * @return string[]
 */
function tasheel_contact_shared_home_layouts() {
	return array(
		'home_banner',
		'home_about',
		'home_services',
		'home_projects',
		'home_partners',
		'home_banner_add',
		'home_insights',
	);
}

/**
 * Layout names that use the About renderer (same structure as About flexible).
 *
 * @return string[]
 */
function tasheel_contact_shared_about_layouts() {
	return array(
		'inner_banner',
		'image_text_block',
		'image_text_block_row_reverse',
		'mission_vision',
		'core_values',
		'visionary_leadership_page_style',
		'visionary_leadership_home_style',
		'executive_team_page_style',
		'executive_team_home_style',
		'our_journey',
		'timeline',
		'awards_slider',
		'awards_gallery',
	);
}

/**
 * Layout names that use the Media Center renderer (News, Events, Brochures, Gallery).
 * Used on Media Center page and anywhere the same flexible content is used.
 *
 * @return string[]
 */
function tasheel_contact_shared_media_center_layouts() {
	return array(
		'news_section',
		'events_section',
		'brochures_section',
		'gallery_section',
	);
}

/**
 * Normalize image fields to URL for inner_banner when delegating to About renderer.
 *
 * @param array $section Section data.
 * @return array
 */
function tasheel_contact_normalize_inner_banner_section( $section ) {
	$normalized = $section;
	foreach ( array( 'background_image', 'background_image_mobile' ) as $key ) {
		if ( ! isset( $normalized[ $key ] ) ) {
			continue;
		}
		$val = $normalized[ $key ];
		if ( is_array( $val ) && isset( $val['url'] ) ) {
			$normalized[ $key ] = $val['url'];
		} elseif ( is_array( $val ) && isset( $val['ID'] ) ) {
			$normalized[ $key ] = wp_get_attachment_url( (int) $val['ID'] ) ?: '';
		} elseif ( is_numeric( $val ) ) {
			$normalized[ $key ] = wp_get_attachment_url( (int) $val ) ?: '';
		}
	}
	return $normalized;
}

/**
 * Check if a contact-only section has content (hide empty).
 *
 * @param string $layout_name Layout key.
 * @param array  $layout      Layout values.
 * @return bool
 */
function tasheel_contact_section_has_content( $layout_name, $layout ) {
	if ( empty( $layout ) || ! is_array( $layout ) ) {
		return false;
	}
	switch ( $layout_name ) {
		case 'contact_section':
			return true;
		case 'contact_map':
			return true;
		case 'faq':
			return ! empty( $layout['faq_items'] ) && is_array( $layout['faq_items'] );
		default:
			return true;
	}
}

/**
 * Render one flexible section. About layouts → About renderer; Contact layouts → here.
 *
 * @param array $section ACF flexible row (acf_fc_layout + fields).
 */
function tasheel_render_contact_flexible_section( $section ) {
	if ( empty( $section ) || empty( $section['acf_fc_layout'] ) ) {
		return;
	}
	$layout_name = $section['acf_fc_layout'];

	// Home layouts → Home renderer. Use key map so layout_about_home_services never matches home_about.
	$home_key_map = array(
		'layout_about_home_about'      => 'home_about',
		'layout_about_home_services'   => 'home_services',
		'layout_about_home_projects'   => 'home_projects',
		'layout_about_home_partners'   => 'home_partners',
		'layout_about_home_banner_add' => 'home_banner_add',
		'layout_about_home_insights'   => 'home_insights',
		'layout_about_home_banner'     => 'home_banner',
	);
	$is_home_layout = in_array( $layout_name, tasheel_contact_shared_home_layouts(), true );
	if ( ! $is_home_layout && isset( $home_key_map[ $layout_name ] ) ) {
		$is_home_layout = true;
	}
	if ( ! $is_home_layout ) {
		foreach ( tasheel_contact_shared_home_layouts() as $home_layout ) {
			if ( strpos( $layout_name, $home_layout ) !== false ) {
				$is_home_layout = true;
				break;
			}
		}
	}
	if ( $is_home_layout && function_exists( 'tasheel_render_home_flexible_section' ) ) {
		tasheel_render_home_flexible_section( $section );
		return;
	}

	if ( in_array( $layout_name, tasheel_contact_shared_about_layouts(), true ) && function_exists( 'tasheel_render_about_flexible_section' ) ) {
		$normalized = $layout_name === 'inner_banner' ? tasheel_contact_normalize_inner_banner_section( $section ) : $section;
		if ( function_exists( 'tasheel_about_section_has_content' ) && ! tasheel_about_section_has_content( $layout_name, $normalized ) ) {
			return;
		}
		tasheel_render_about_flexible_section( $normalized );
		return;
	}

	// Media Center sections (News, Events, Brochures, Gallery) – delegate to media center renderer.
	$mc_layouts = tasheel_contact_shared_media_center_layouts();
	$is_mc_layout = in_array( $layout_name, $mc_layouts, true );
	if ( ! $is_mc_layout ) {
		foreach ( $mc_layouts as $mc_layout ) {
			if ( strpos( $layout_name, $mc_layout ) !== false ) {
				$is_mc_layout = true;
				break;
			}
		}
	}
	if ( $is_mc_layout && function_exists( 'tasheel_render_media_center_section' ) ) {
		tasheel_render_media_center_section( $section );
		return;
	}

	// Vendor Form (Contact Form 7 shortcode) – used on About and other pages using this flexible content.
	if ( ( $layout_name === 'vendor_form' || $layout_name === 'layout_vendor_form' ) && function_exists( 'tasheel_vendor_section_has_content' ) && function_exists( 'tasheel_render_vendor_flexible_section' ) ) {
		if ( tasheel_vendor_section_has_content( $layout_name, $section ) ) {
			tasheel_render_vendor_flexible_section( $section );
		}
		return;
	}

	// Normalize layout key for contact-specific switch (e.g. layout_about_faq → faq).
	if ( strpos( $layout_name, 'layout_about_' ) === 0 ) {
		$layout_name = str_replace( 'layout_about_', '', $layout_name );
	}

	if ( ! tasheel_contact_section_has_content( $layout_name, $section ) ) {
		return;
	}

	switch ( $layout_name ) {
		case 'contact_section':
			$args = array(
				'heading_title'           => isset( $section['heading_title'] ) ? trim( (string) $section['heading_title'] ) : '',
				'heading_title_span'      => isset( $section['heading_title_span'] ) ? trim( (string) $section['heading_title_span'] ) : '',
				'description'             => isset( $section['description'] ) ? $section['description'] : '',
				'contact_info_items'      => isset( $section['contact_info_items'] ) && is_array( $section['contact_info_items'] ) ? $section['contact_info_items'] : array(),
				'social_links'            => isset( $section['social_links'] ) && is_array( $section['social_links'] ) ? $section['social_links'] : array(),
				'contact_form_shortcode'  => isset( $section['contact_form_shortcode'] ) ? trim( (string) $section['contact_form_shortcode'] ) : '',
			);
			get_template_part( 'template-parts/Contact-Section', null, $args );
			break;

		case 'contact_map':
			$markers = array();
			if ( ! empty( $section['map_markers'] ) && is_array( $section['map_markers'] ) ) {
				foreach ( $section['map_markers'] as $row ) {
					$lat = isset( $row['latitude'] ) ? trim( (string) $row['latitude'] ) : '';
					$lng = isset( $row['longitude'] ) ? trim( (string) $row['longitude'] ) : '';
					if ( $lat === '' && $lng === '' ) {
						continue;
					}
					$markers[] = array(
						'latitude'  => $lat,
						'longitude' => $lng,
						'title'     => isset( $row['title'] ) ? trim( (string) $row['title'] ) : '',
						'address'   => isset( $row['address'] ) ? trim( (string) $row['address'] ) : '',
					);
				}
			}
			$zoom = isset( $section['zoom'] ) && is_numeric( $section['zoom'] ) ? (int) $section['zoom'] : 0;
			if ( $zoom < 1 || $zoom > 20 ) {
				$zoom = 0;
			}
			get_template_part( 'template-parts/Contact-Map', null, array(
				'section_wrapper_class' => array( 'contact_map_section', 'pt_80', 'pb_80' ),
				'section_class'          => '',
				'markers'                => $markers,
				'zoom'                   => $zoom,
			) );
			break;

		case 'faq':
			$raw_items = isset( $section['faq_items'] ) && is_array( $section['faq_items'] ) ? $section['faq_items'] : array();
			$faq_items = array();
			foreach ( $raw_items as $idx => $item ) {
				$q = isset( $item['question'] ) ? trim( (string) $item['question'] ) : '';
				$a = isset( $item['answer'] ) ? $item['answer'] : '';
				if ( $q === '' && $a === '' ) {
					continue;
				}
				$faq_items[] = array(
					'question' => $q,
					'answer'   => $a,
					'is_open'  => ! empty( $item['is_open'] ),
				);
			}
			$classes = array( 'pt_80', 'pb_80' );
			get_template_part( 'template-parts/FAQ', null, array(
				'section_wrapper_class' => $classes,
				'section_class'         => '',
				'faq_items'             => $faq_items,
				'faq_heading_first'      => isset( $section['faq_heading_first'] ) && trim( (string) $section['faq_heading_first'] ) !== '' ? $section['faq_heading_first'] : esc_html__( 'Frequently', 'tasheel' ),
				'faq_heading_span'      => isset( $section['faq_heading_span'] ) && trim( (string) $section['faq_heading_span'] ) !== '' ? $section['faq_heading_span'] : esc_html__( 'Asked Questions', 'tasheel' ),
			) );
			break;

		default:
			do_action( 'tasheel_render_contact_flexible_section', $layout_name, $section );
			break;
	}
}
