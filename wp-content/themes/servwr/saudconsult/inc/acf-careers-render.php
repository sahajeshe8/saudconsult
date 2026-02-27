<?php
/**
 * ACF Careers pages: render flexible content (Careers hub, Careers Page, Corporate Training, Academic Program).
 * All output strings use esc_html__ / wp_kses_post with 'tasheel' text domain for WPML.
 * Empty sections are not rendered.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return tab configuration for Careers sub-pages (Jobs, Corporate Training, Academic Program).
 * When Careers Options → "Careers sub-navigation tabs" is set, those pages are used; otherwise fallback to template-based pages.
 * Each tab has id, title, link, and page_id (for active state). WPML-ready.
 *
 * @return array[] Array of tab arrays with id, title, link, page_id.
 */
function tasheel_careers_subpage_tabs() {
	$tabs = array();

	// Dynamic: from Careers Options (ACF Options → Careers Options → Careers sub-navigation tabs).
	if ( function_exists( 'get_field' ) ) {
		$rows = get_field( 'careers_tab_pages', 'option' );
		if ( ! empty( $rows ) && is_array( $rows ) ) {
			foreach ( $rows as $row ) {
				$page = isset( $row['tab_page'] ) ? $row['tab_page'] : null;
				if ( ! $page || ! is_object( $page ) || empty( $page->ID ) ) {
					continue;
				}
				$page_id = (int) $page->ID;
				$title  = isset( $row['tab_label'] ) && is_string( $row['tab_label'] ) && trim( $row['tab_label'] ) !== ''
					? trim( $row['tab_label'] )
					: get_the_title( $page_id );
				$tabs[] = array(
					'id'      => $page->post_name,
					'title'   => $title,
					'link'    => get_permalink( $page_id ),
					'page_id' => $page_id,
				);
			}
		}
	}

	// Fallback: discover pages by template (Careers Page, Corporate Training, Academic Program).
	if ( empty( $tabs ) ) {
		$careers_page   = get_posts( array( 'post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-template-careers-page.php', 'numberposts' => 1, 'post_status' => 'publish' ) );
		$corporate_page = get_posts( array( 'post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-template-corporate-training.php', 'numberposts' => 1, 'post_status' => 'publish' ) );
		$academic_page  = get_posts( array( 'post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-template-academic-program.php', 'numberposts' => 1, 'post_status' => 'publish' ) );
		if ( ! empty( $careers_page ) ) {
			$p = $careers_page[0];
			$tabs[] = array( 'id' => 'careers', 'title' => get_the_title( $p->ID ), 'link' => get_permalink( $p->ID ), 'page_id' => (int) $p->ID );
		} else {
			$tabs[] = array( 'id' => 'careers', 'title' => esc_html__( 'Careers', 'tasheel' ), 'link' => esc_url( home_url( '/careers-page' ) ), 'page_id' => 0 );
		}
		if ( ! empty( $corporate_page ) ) {
			$p = $corporate_page[0];
			$tabs[] = array( 'id' => 'corporate-training', 'title' => get_the_title( $p->ID ), 'link' => get_permalink( $p->ID ), 'page_id' => (int) $p->ID );
		} else {
			$tabs[] = array( 'id' => 'corporate-training', 'title' => esc_html__( 'Corporate Training', 'tasheel' ), 'link' => esc_url( home_url( '/corporate-training' ) ), 'page_id' => 0 );
		}
		if ( ! empty( $academic_page ) ) {
			$p = $academic_page[0];
			$tabs[] = array( 'id' => 'academic-program', 'title' => get_the_title( $p->ID ), 'link' => get_permalink( $p->ID ), 'page_id' => (int) $p->ID );
		} else {
			$tabs[] = array( 'id' => 'academic-program', 'title' => esc_html__( 'Academic Program', 'tasheel' ), 'link' => esc_url( home_url( '/academic-program' ) ), 'page_id' => 0 );
		}
	}

	return apply_filters( 'tasheel_careers_subpage_tabs', $tabs );
}

/**
 * Check if a careers flexible section has any visible content (hide empty sections).
 *
 * @param string $layout_name Layout key (e.g. inner_banner, image_text_block).
 * @param array  $layout      ACF layout array with sub_fields / values.
 * @return bool
 */
function tasheel_careers_section_has_content( $layout_name, $layout ) {
	if ( empty( $layout ) || ! is_array( $layout ) ) {
		return false;
	}
	switch ( $layout_name ) {
		case 'inner_banner':
			$has_title = isset( $layout['title'] ) && trim( (string) $layout['title'] ) !== '';
			$has_bg   = ! empty( $layout['background_image'] );
			return $has_title || $has_bg || ( function_exists( 'get_the_title' ) && get_the_ID() );
		case 'image_text_block':
		case 'image_text_block_row_reverse':
			$has_img     = ! empty( $layout['image'] );
			$has_title   = isset( $layout['title'] ) && trim( (string) $layout['title'] ) !== '';
			$has_span    = isset( $layout['title_span'] ) && trim( (string) $layout['title_span'] ) !== '';
			$has_content = isset( $layout['content'] ) && trim( (string) $layout['content'] ) !== '';
			return $has_img || $has_title || $has_span || $has_content;
		case 'why_build_career':
			$has_title   = ! empty( $layout['title'] ) || ! empty( $layout['title_span'] );
			$has_hero    = ! empty( $layout['hero_image'] );
			$has_features = ! empty( $layout['features'] ) && is_array( $layout['features'] );
			return $has_title || $has_hero || $has_features;
		case 'what_to_expect':
			$has_title = ! empty( $layout['title'] ) || ! empty( $layout['title_span'] );
			$has_desc  = ! empty( $layout['description'] );
			$has_items = ! empty( $layout['items'] ) && is_array( $layout['items'] );
			return $has_title || $has_desc || $has_items;
		case 'latest_openings':
			return ! empty( $layout['title'] ) || ! empty( $layout['title_span'] );
		default:
			return true;
	}
}

/**
 * Get latest openings for careers listing. Plugins (e.g. HR Engine) can filter to provide real job data.
 *
 * @param string $listing_type   One of: career, corporate_training, academic.
 * @param int    $page_id        Current page ID.
 * @param int    $initial_count  Number of jobs to show on first load (used for first page and for has_more).
 * @return array{openings: array, has_more: bool} Keys: openings (array of items), has_more (bool).
 */
function tasheel_careers_get_latest_openings( $listing_type, $page_id = 0, $initial_count = 12 ) {
	$page_id = $page_id ? (int) $page_id : (int) get_queried_object_id();
	$initial_count = max( 1, min( 50, (int) $initial_count ) );
	$result = apply_filters( 'tasheel_careers_latest_openings', array(), $listing_type, $page_id, $initial_count );
	if ( isset( $result['openings'] ) && isset( $result['has_more'] ) ) {
		return array(
			'openings' => is_array( $result['openings'] ) ? $result['openings'] : array(),
			'has_more' => (bool) $result['has_more'],
		);
	}
	// Back compat: filter returned flat array of openings.
	$openings = is_array( $result ) ? $result : array();
	return array( 'openings' => $openings, 'has_more' => false );
}

/**
 * Render one careers flexible content section.
 *
 * @param array      $section     ACF flexible layout row (has 'acf_fc_layout' and layout fields).
 * @param array|null $next_section Optional. Next section in the loop (used for pb_0 on normal block).
 */
function tasheel_render_careers_flexible_section( $section, $next_section = null ) {
	if ( empty( $section ) || empty( $section['acf_fc_layout'] ) ) {
		return;
	}
	$layout_name = $section['acf_fc_layout'];
	// ACF may return layout key (e.g. layout_careers_why_build_career); normalize to name (why_build_career).
	if ( strpos( $layout_name, 'layout_careers_' ) === 0 ) {
		$layout_name = str_replace( 'layout_careers_', '', $layout_name );
	}
	// Fallback: if layout still unknown but section has Why Build Your Career fields, treat as that layout.
	if ( ! in_array( $layout_name, array( 'inner_banner', 'image_text_block', 'image_text_block_row_reverse', 'why_build_career', 'what_to_expect', 'latest_openings' ), true ) ) {
		$has_wbc_hero   = ! empty( $section['hero_image'] );
		$has_wbc_features = ! empty( $section['features'] ) && is_array( $section['features'] );
		if ( $has_wbc_hero || $has_wbc_features ) {
			$layout_name = 'why_build_career';
		}
	}
	if ( ! tasheel_careers_section_has_content( $layout_name, $section ) ) {
		return;
	}

	switch ( $layout_name ) {
		case 'inner_banner':
			$bg    = isset( $section['background_image'] ) ? $section['background_image'] : '';
			$bg_m  = isset( $section['background_image_mobile'] ) ? $section['background_image_mobile'] : '';
			$title = isset( $section['title'] ) && trim( (string) $section['title'] ) !== '' ? trim( $section['title'] ) : '';
			if ( ! $title && function_exists( 'get_the_title' ) ) {
				$title = get_the_title();
			}
			if ( ! $bg && ! $title ) {
				return;
			}
			if ( is_array( $bg ) && isset( $bg['url'] ) ) {
				$bg = $bg['url'];
			} elseif ( is_numeric( $bg ) ) {
				$bg = wp_get_attachment_url( (int) $bg ) ?: '';
			}
			if ( is_array( $bg_m ) && isset( $bg_m['url'] ) ) {
				$bg_m = $bg_m['url'];
			} elseif ( is_numeric( $bg_m ) ) {
				$bg_m = wp_get_attachment_url( (int) $bg_m ) ?: '';
			}
			if ( ! $bg && function_exists( 'get_the_post_thumbnail_url' ) ) {
				$bg = get_the_post_thumbnail_url( get_the_ID(), 'full' );
			}
			if ( ! $bg ) {
				$bg = get_template_directory_uri() . '/assets/images/banner-img.jpg';
			}
			$args = array(
				'background_image'         => $bg,
				'background_image_mobile'   => $bg_m,
				'title'                     => $title,
			);
			get_template_part( 'template-parts/inner-banner', null, $args );
			break;

		case 'image_text_block':
		case 'image_text_block_row_reverse':
			$image_raw = isset( $section['image'] ) ? $section['image'] : '';
			$image     = is_array( $image_raw ) && isset( $image_raw['url'] ) ? $image_raw['url'] : ( is_string( $image_raw ) ? $image_raw : '' );
			if ( is_numeric( $image_raw ) ) {
				$image = wp_get_attachment_url( (int) $image_raw ) ?: '';
			}
			$title_val  = isset( $section['title'] ) ? trim( (string) $section['title'] ) : '';
			$image_alt  = $title_val !== '' ? $title_val : esc_attr__( 'Image', 'tasheel' );
			$title      = isset( $section['title'] ) ? $section['title'] : '';
			$title_span = isset( $section['title_span'] ) ? $section['title_span'] : '';
			$content    = isset( $section['content'] ) ? $section['content'] : '';
			$btn_text   = isset( $section['button_text'] ) ? $section['button_text'] : '';
			$btn_link   = isset( $section['button_link'] ) ? $section['button_link'] : '';
			// Classes from template HTML (row_reverse, bg-style for reversed layout).
			$section_class = ( $layout_name === 'image_text_block_row_reverse' ) ? 'row_reverse' : '';
			$toggle_on    = ! isset( $section['show_background'] ) || ! empty( $section['show_background'] );
			// Toggle ON: overlay + bg-style. Toggle OFF: overlay only, hide bg-style.
			$bg_style     = ( $layout_name === 'image_text_block_row_reverse' && $toggle_on ) ? 'bg-style' : '';
			$show_overlay = true;
			// When next block is reversed with toggle off: add pb_0 to normal section only (not to reverse).
			if ( $layout_name === 'image_text_block' && ! empty( $next_section['acf_fc_layout'] ) ) {
				$next_layout = $next_section['acf_fc_layout'];
				if ( strpos( $next_layout, 'layout_careers_' ) === 0 ) {
					$next_layout = str_replace( 'layout_careers_', '', $next_layout );
				}
				$next_toggle_off = isset( $next_section['show_background'] ) && empty( $next_section['show_background'] );
				if ( $next_layout === 'image_text_block_row_reverse' && $next_toggle_off ) {
					$section_class .= ( $section_class ? ' ' : '' ) . 'pb_0';
				}
			}
			if ( ! $image ) {
				$image = get_template_directory_uri() . '/assets/images/about-img.jpg';
			}
			$args = array(
				'image'                 => $image,
				'image_alt'             => $image_alt,
				'title'                 => $title,
				'title_span'            => $title_span,
				'content'               => $content,
				'button_text'           => $btn_text,
				'button_link'           => $btn_link,
				'section_class'         => $section_class,
				'bg_style'              => $bg_style,
				'show_image_overlay'    => $show_overlay,
				'image_container_class' => '',
				'text_container_class'  => '',
			);
			get_template_part( 'template-parts/image-text-block', null, $args );
			break;

		case 'why_build_career':
			$title   = isset( $section['title'] ) ? $section['title'] : esc_html__( 'Why Build Your Career', 'tasheel' );
			$title_span = isset( $section['title_span'] ) ? $section['title_span'] : esc_html__( 'With the Pioneers?', 'tasheel' );
			$hero_raw = isset( $section['hero_image'] ) ? $section['hero_image'] : '';
			$hero_image = is_array( $hero_raw ) && isset( $hero_raw['url'] ) ? $hero_raw['url'] : ( is_string( $hero_raw ) ? $hero_raw : '' );
			if ( is_numeric( $hero_raw ) ) {
				$hero_image = wp_get_attachment_url( (int) $hero_raw ) ?: '';
			}
			if ( ! $hero_image ) {
				$hero_image = get_template_directory_uri() . '/assets/images/why-build-img.jpg';
			}
			$features = array();
			if ( ! empty( $section['features'] ) && is_array( $section['features'] ) ) {
				foreach ( $section['features'] as $f ) {
					$icon = isset( $f['icon'] ) ? $f['icon'] : '';
					if ( is_array( $icon ) && isset( $icon['url'] ) ) {
						$icon = $icon['url'];
					} elseif ( is_numeric( $icon ) ) {
						$icon = wp_get_attachment_url( (int) $icon ) ?: '';
					}
					$features[] = array(
						'icon'       => $icon,
						'title'      => isset( $f['title'] ) ? $f['title'] : '',
						'title_span' => isset( $f['title_span'] ) ? $f['title_span'] : '',
						'content'    => isset( $f['content'] ) ? $f['content'] : '',
					);
				}
			}
			$args = array(
				'title'       => $title,
				'title_span'  => $title_span,
				'hero_image'  => $hero_image,
				'features'   => $features,
			);
			get_template_part( 'template-parts/Why-Build-Career', null, $args );
			break;

		case 'what_to_expect':
			$title       = isset( $section['title'] ) ? $section['title'] : esc_html__( 'What to', 'tasheel' );
			$title_span  = isset( $section['title_span'] ) ? $section['title_span'] : esc_html__( 'Expect', 'tasheel' );
			$description = isset( $section['description'] ) ? $section['description'] : '';
			$items = array();
			if ( ! empty( $section['items'] ) && is_array( $section['items'] ) ) {
				foreach ( $section['items'] as $item ) {
					$icon  = isset( $item['icon'] ) ? $item['icon'] : '';
					$ititle = isset( $item['title'] ) ? $item['title'] : '';
					if ( is_array( $icon ) && isset( $icon['url'] ) ) {
						$icon = $icon['url'];
					} elseif ( is_numeric( $icon ) ) {
						$icon = wp_get_attachment_url( (int) $icon ) ?: '';
					}
					$items[] = array(
						'icon'       => $icon,
						'icon_alt'   => $ititle,
						'title'      => $ititle,
						'content'    => isset( $item['content'] ) ? $item['content'] : '',
						'bg_class'   => '',
						'item_class' => '',
					);
				}
			}
			$args = array(
				'title'         => $title,
				'title_span'    => $title_span,
				'description'   => $description,
				'items'         => $items,
				'section_class' => '',
			);
			get_template_part( 'template-parts/What-to-Expect', null, $args );
			break;

		case 'latest_openings':
			$title   = isset( $section['title'] ) ? $section['title'] : esc_html__( 'Latest', 'tasheel' );
			$title_span = isset( $section['title_span'] ) ? $section['title_span'] : esc_html__( 'Openings', 'tasheel' );
			$listing_type = isset( $section['listing_type'] ) ? $section['listing_type'] : 'career';
			$show_load_more = ! isset( $section['show_load_more'] ) || ! empty( $section['show_load_more'] );
			$initial_count = isset( $section['initial_count'] ) ? max( 1, min( 50, (int) $section['initial_count'] ) ) : 12;
			$page_id = (int) get_queried_object_id();
			$data = tasheel_careers_get_latest_openings( $listing_type, $page_id, $initial_count );
			$openings = isset( $data['openings'] ) ? $data['openings'] : array();
			$has_more = isset( $data['has_more'] ) ? $data['has_more'] : false;
			$args = array(
				'title'           => $title,
				'title_span'      => $title_span,
				'openings'        => $openings,
				'show_load_more'  => $show_load_more,
				'listing_type'    => $listing_type,
				'initial_count'   => $initial_count,
				'has_more'        => $has_more,
			);
			get_template_part( 'template-parts/Latest-Openings', null, $args );
			break;

		default:
			do_action( 'tasheel_render_careers_flexible_section', $layout_name, $section );
			break;
	}
}
