<?php
/**
 * ACF About Pages: render flexible content and helpers (Company Profile PDF, global Leadership/Team)
 * All output strings use esc_html__ / wp_kses_post with 'tasheel' text domain for WPML.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a normalized data array for a Team Member post.
 *
 * @param int $post_id Team Member post ID.
 * @return array|null
 */
function tasheel_get_team_member_data( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 || get_post_type( $post_id ) !== 'team_member' ) {
		return null;
	}

	$name      = get_the_title( $post_id );
	$position  = function_exists( 'get_field' ) ? get_field( 'position', $post_id ) : '';
	$linkedin  = function_exists( 'get_field' ) ? get_field( 'linkedin_url', $post_id ) : '';
	$image     = function_exists( 'get_field' ) ? get_field( 'profile_image', $post_id ) : '';
	$image_url = '';

	if ( is_array( $image ) && isset( $image['url'] ) ) {
		$image_url = $image['url'];
	} elseif ( is_numeric( $image ) ) {
		$image_url = wp_get_attachment_url( (int) $image );
	} elseif ( is_string( $image ) ) {
		$image_url = $image;
	}

	if ( ! $image_url ) {
		$image_url = get_the_post_thumbnail_url( $post_id, 'full' );
	}

	return array(
		'image'        => $image_url ? $image_url : '',
		'name'         => is_string( $name ) ? $name : '',
		'position'     => is_string( $position ) ? $position : '',
		'linkedin_url' => is_string( $linkedin ) ? $linkedin : '',
	);
}

/**
 * Normalize Team Member relationship field values into frontend-ready arrays.
 *
 * @param array $items Relationship field value (array of posts/IDs).
 * @return array[]
 */
function tasheel_get_team_members_from_posts( $items ) {
	$members = array();
	$seen_ids = array();
	if ( empty( $items ) || ! is_array( $items ) ) {
		return $members;
	}

	foreach ( $items as $item ) {
		$post = is_object( $item ) ? $item : get_post( $item );
		if ( ! $post || 'team_member' !== $post->post_type || 'publish' !== $post->post_status ) {
			continue;
		}
		if ( isset( $seen_ids[ $post->ID ] ) ) {
			continue;
		}
		$seen_ids[ $post->ID ] = true;
		$data = tasheel_get_team_member_data( $post->ID );
		if ( $data ) {
			$members[] = $data;
		}
	}

	return $members;
}

/**
 * Resolve a team category term ID from various field values.
 *
 * @param mixed  $value        Term value (ID, slug, WP_Term, etc).
 * @param string $default_slug Fallback slug when value is empty.
 * @return int Term ID or 0 when not found.
 */
function tasheel_resolve_team_term_id( $value, $default_slug = '' ) {
	$term = null;

	if ( $value instanceof WP_Term ) {
		$term = $value;
	} elseif ( is_numeric( $value ) ) {
		$term = get_term( (int) $value, 'team_category' );
	} elseif ( is_string( $value ) && '' !== $value ) {
		$term = get_term_by( 'slug', $value, 'team_category' );
		if ( ! $term ) {
			$term = get_term_by( 'name', $value, 'team_category' );
		}
	}

	if ( ! $term && $default_slug ) {
		$term = get_term_by( 'slug', $default_slug, 'team_category' );
	}

	return $term && ! is_wp_error( $term ) ? (int) $term->term_id : 0;
}

/**
 * Fetch Team Members assigned to a given category term.
 *
 * @param mixed  $term_value   Term value (ID/slug/WP_Term).
 * @param string $default_slug Fallback slug when value is empty.
 * @return array[]
 */
function tasheel_get_team_members_from_term( $term_value, $default_slug = '' ) {
	static $cache = array();

	$term_id = tasheel_resolve_team_term_id( $term_value, $default_slug );
	if ( ! $term_id ) {
		return array();
	}

	if ( isset( $cache[ $term_id ] ) ) {
		return $cache[ $term_id ];
	}

	$query = new WP_Query( array(
		'post_type'      => 'team_member',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
		'tax_query'      => array(
			array(
				'taxonomy' => 'team_category',
				'field'    => 'term_id',
				'terms'    => $term_id,
			),
		),
		'no_found_rows'  => true,
	) );

	$members = array();
	if ( $query->have_posts() ) {
		foreach ( $query->posts as $post ) {
			$data = tasheel_get_team_member_data( $post->ID );
			if ( $data ) {
				$members[] = $data;
			}
		}
		wp_reset_postdata();
	}

	$cache[ $term_id ] = $members;
	return $members;
}

/**
 * Get team members for a single leadership/executive section (fixed category: leadership-team or executive-team).
 *
 * @param array  $section   Layout values (members_source, members_manual).
 * @param string $term_slug Either 'leadership-team' or 'executive-team'.
 * @return array[]
 */
function tasheel_get_section_members( $section, $term_slug ) {
	$source = isset( $section['members_source'] ) ? $section['members_source'] : 'all';
	$manual = isset( $section['members_manual'] ) && is_array( $section['members_manual'] ) ? $section['members_manual'] : array();

	// When "Select members" is chosen but none selected, show no one (do not fall back to "all").
	if ( 'manual' === $source && empty( $manual ) ) {
		return array();
	}
	if ( 'manual' === $source && ! empty( $manual ) ) {
		$manual = array_values( array_unique( array_map( function ( $item ) {
			$post = is_object( $item ) ? $item : get_post( $item );
			return $post && $post->ID ? $post->ID : 0;
		}, $manual ) ) );
		$manual = array_filter( $manual );
		$term = get_term_by( 'slug', $term_slug, 'team_category' );
		if ( $term && ! is_wp_error( $term ) ) {
			$filtered = array();
			foreach ( $manual as $post_id ) {
				$post = get_post( $post_id );
				if ( ! $post || 'team_member' !== $post->post_type ) {
					continue;
				}
				$terms = get_the_terms( $post->ID, 'team_category' );
				if ( ! is_array( $terms ) ) {
					continue;
				}
				foreach ( $terms as $t ) {
					if ( (int) $t->term_id === (int) $term->term_id ) {
						$data = tasheel_get_team_member_data( $post->ID );
						if ( $data ) {
							$filtered[] = $data;
						}
						break;
					}
				}
			}
			return $filtered;
		}
		return tasheel_get_team_members_from_posts( array_filter( array_map( 'get_post', $manual ) ) );
	}

	$members = tasheel_get_team_members_from_term( $term_slug, $term_slug );
	$limit   = isset( $section['items_count'] ) ? max( 1, min( 48, (int) $section['items_count'] ) ) : 0;
	if ( $limit > 0 ) {
		$members = array_slice( $members, 0, $limit );
	}
	return $members;
}

/**
 * Return empty visionary/executive structures (no longer from Company Options).
 * Kept for backward compatibility if any code still calls these.
 */
function tasheel_get_global_visionary_leadership() {
	return array( 'label' => '', 'title' => '', 'title_span' => '', 'leadership_members' => array() );
}

function tasheel_get_global_executive_team() {
	return array( 'title' => '', 'title_span' => '', 'team_members' => array() );
}

/**
 * About section page templates – pages using these templates appear in the tab nav.
 * Add new template filenames here or via filter when you create new About sub-pages.
 *
 * @return string[] Template filenames.
 */
function tasheel_about_section_templates() {
	$templates = array(
		'page-template-about.php',
		'page-template-vision-mission-values.php',
		'page-template-leadership.php',
		'page-template-our-team.php',
		'page-template-journey-legacy.php',
		'page-template-company-milestones.php',
		'page-template-awards.php',
	);
	return apply_filters( 'tasheel_about_section_templates', $templates );
}

/**
 * Return tab configuration for About sub-pages.
 * Uses "Pages in About Tabs" from Company Options if set; otherwise auto-detects from page templates.
 *
 * @return array[] Array of tab arrays with id, title, link.
 */
function tasheel_about_subpage_tabs() {
	$tabs = array();

	// Priority 1: Use ACF Relationship field from Company Options (admin-selected pages).
	if ( function_exists( 'get_field' ) ) {
		$selected = get_field( 'about_tab_pages', 'option' );
		if ( ! empty( $selected ) && is_array( $selected ) ) {
			foreach ( $selected as $item ) {
				$page = is_object( $item ) ? $item : get_post( $item );
				if ( $page && $page->post_type === 'page' && $page->post_status === 'publish' ) {
					$tabs[] = array(
						'id'      => $page->post_name,
						'page_id' => (int) $page->ID,
						'title'   => get_the_title( $page ),
						'link'    => get_permalink( $page ),
					);
				}
			}
			if ( ! empty( $tabs ) ) {
				return apply_filters( 'tasheel_about_subpage_tabs', $tabs );
			}
		}
	}

	// Priority 2: Fallback – auto-detect from pages using About section templates.
	$templates = tasheel_about_section_templates();
	if ( empty( $templates ) ) {
		return apply_filters( 'tasheel_about_subpage_tabs', $tabs );
	}

	$query = new WP_Query( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => '_wp_page_template',
				'value'   => $templates,
				'compare' => 'IN',
			),
		),
	) );

	if ( $query->have_posts() ) {
		foreach ( $query->posts as $page ) {
			$tabs[] = array(
				'id'      => $page->post_name,
				'page_id' => (int) $page->ID,
				'title'   => get_the_title( $page ),
				'link'    => get_permalink( $page ),
			);
		}
		wp_reset_postdata();
	}

	return apply_filters( 'tasheel_about_subpage_tabs', $tabs );
}

/**
 * Check if a flexible section has any visible content (used to hide empty sections).
 *
 * @param string $layout_name Layout key (e.g. inner_banner, image_text_block).
 * @param array  $layout      ACF layout array with sub_fields / values.
 * @return bool
 */
function tasheel_about_section_has_content( $layout_name, $layout ) {
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
		case 'mission_vision':
			return ! empty( $layout['vision_content'] ) || ! empty( $layout['vision_title'] ) || ! empty( $layout['mission_content'] ) || ! empty( $layout['mission_title'] );
		case 'core_values':
			return ! empty( $layout['title'] ) || ! empty( $layout['title_span'] ) || ! empty( $layout['description'] ) || ( ! empty( $layout['values'] ) && is_array( $layout['values'] ) );
		case 'visionary_leadership_page_style':
			$members = tasheel_get_section_members( $layout, 'leadership-team' );
			return ! empty( $members ) || ! empty( $layout['title'] ) || ! empty( $layout['title_span'] ) || ! empty( $layout['label'] );
		case 'visionary_leadership_home_style':
		case 'executive_team_home_style': {
			// Home: combined block – show only if at least one of Visionary or Executive has members.
			$page_id = (int) get_queried_object_id();
			$sections = ( $page_id && function_exists( 'get_field' ) ) ? get_field( 'about_page_sections', $page_id ) : array();
			if ( ! is_array( $sections ) ) {
				$sections = array();
			}
			$has_any = false;
			foreach ( $sections as $s ) {
				$name = isset( $s['acf_fc_layout'] ) ? $s['acf_fc_layout'] : '';
				if ( $name === 'visionary_leadership_home_style' ) {
					if ( ! empty( tasheel_get_section_members( $s, 'leadership-team' ) ) ) {
						$has_any = true;
						break;
					}
				} elseif ( $name === 'executive_team_home_style' ) {
					if ( ! empty( tasheel_get_section_members( $s, 'executive-team' ) ) ) {
						$has_any = true;
						break;
					}
				}
			}
			return $has_any;
		}
		case 'executive_team_page_style':
			$members = tasheel_get_section_members( $layout, 'executive-team' );
			return ! empty( $members ) || ! empty( $layout['title'] ) || ! empty( $layout['title_span'] );
		case 'our_journey':
			return ! empty( $layout['journey_items'] ) && is_array( $layout['journey_items'] );
		case 'timeline':
			return ! empty( $layout['timeline_items'] ) && is_array( $layout['timeline_items'] );
		case 'awards_slider':
			return ! empty( $layout['awards'] ) && is_array( $layout['awards'] );
		case 'awards_gallery':
			return ! empty( $layout['slides'] ) && is_array( $layout['slides'] );
		default:
			return true;
	}
}

/**
 * Render one flexible content section for About pages.
 * Translates default strings with esc_html__ / wp_kses_post and 'tasheel'.
 *
 * @param array $section ACF flexible layout row (has 'acf_fc_layout' and layout fields).
 */
function tasheel_render_about_flexible_section( $section ) {
	if ( empty( $section ) || empty( $section['acf_fc_layout'] ) ) {
		return;
	}
	$layout_name = $section['acf_fc_layout'];
	if ( ! tasheel_about_section_has_content( $layout_name, $section ) ) {
		return;
	}

	$default_btn = esc_html__( 'Download Company Profile', 'tasheel' );

	switch ( $layout_name ) {
		case 'inner_banner':
			$bg    = isset( $section['background_image'] ) ? $section['background_image'] : '';
			$bg_m  = isset( $section['background_image_mobile'] ) ? $section['background_image_mobile'] : '';
			$title = isset( $section['title'] ) && trim( $section['title'] ) !== '' ? trim( $section['title'] ) : '';
			if ( ! $title && function_exists( 'get_the_title' ) ) {
				$title = get_the_title();
			}
			if ( ! $bg && ! $title ) {
				return;
			}
			if ( ! $bg && function_exists( 'get_the_post_thumbnail_url' ) ) {
				$bg = get_the_post_thumbnail_url( get_the_ID(), 'full' );
			}
			if ( ! $bg ) {
				$bg = get_template_directory_uri() . '/assets/images/banner-img.jpg';
			}
			$args = array(
				'background_image'        => $bg,
				'background_image_mobile'  => $bg_m,
				'title'                    => $title,
			);
			get_template_part( 'template-parts/inner-banner', null, $args );
			break;

		case 'image_text_block':
		case 'image_text_block_row_reverse':
			$image_raw  = isset( $section['image'] ) ? $section['image'] : '';
			$image      = is_array( $image_raw ) && isset( $image_raw['url'] ) ? $image_raw['url'] : ( is_string( $image_raw ) ? $image_raw : '' );
			$title_val  = isset( $section['title'] ) ? trim( (string) $section['title'] ) : '';
			$image_alt  = $title_val !== '' ? $title_val : esc_attr__( 'Image', 'tasheel' );
			$title      = isset( $section['title'] ) ? $section['title'] : '';
			$title_span = isset( $section['title_span'] ) ? $section['title_span'] : '';
			$content    = isset( $section['content'] ) ? $section['content'] : '';
			$show_dl    = ! empty( $section['show_download_company_profile'] );
			$btn_text   = isset( $section['button_text'] ) ? $section['button_text'] : $default_btn;
			$section_pdf = isset( $section['section_pdf'] ) ? $section['section_pdf'] : '';
			$section_pdf_url = is_string( $section_pdf ) ? $section_pdf : ( is_array( $section_pdf ) && isset( $section_pdf['url'] ) ? $section_pdf['url'] : '' );
			$btn_link   = ( $show_dl && $section_pdf_url ) ? $section_pdf_url : '';
			$is_reversed = ( $layout_name === 'image_text_block_row_reverse' );
			$section_class = $is_reversed ? 'row_reverse' : '';
			$bg_style    = $is_reversed ? 'bg-style' : '';
			$show_image_overlay = isset( $section['show_image_overlay'] ) ? (bool) $section['show_image_overlay'] : true;
			if ( ! $image ) {
				$image = get_template_directory_uri() . '/assets/images/about-img.jpg';
			}
			$args = array(
				'image'                => $image,
				'image_alt'            => $image_alt,
				'title'                => $title,
				'title_span'           => $title_span,
				'content'              => $content,
				'button_text'          => ( $show_dl && $btn_link ) ? $btn_text : '',
				'button_link'          => $btn_link,
				'show_download_company_profile' => $show_dl,
				'section_class'        => $section_class,
				'bg_style'             => $bg_style,
				'show_image_overlay'   => $show_image_overlay,
				'image_container_class' => '',
				'text_container_class'  => '',
			);
			get_template_part( 'template-parts/image-text-block', null, $args );
			break;

		case 'mission_vision':
			$args = array(
				'vision_title'       => isset( $section['vision_title'] ) ? $section['vision_title'] : '',
				'vision_title_span'  => isset( $section['vision_title_span'] ) ? $section['vision_title_span'] : '',
				'vision_content'     => isset( $section['vision_content'] ) ? $section['vision_content'] : '',
				'vision_icon'        => isset( $section['vision_icon'] ) ? $section['vision_icon'] : '',
				'vision_icon_hover'  => isset( $section['vision_icon_hover'] ) ? $section['vision_icon_hover'] : '',
				'mission_title'      => isset( $section['mission_title'] ) ? $section['mission_title'] : '',
				'mission_title_span' => isset( $section['mission_title_span'] ) ? $section['mission_title_span'] : '',
				'mission_content'    => isset( $section['mission_content'] ) ? $section['mission_content'] : '',
				'mission_icon'       => isset( $section['mission_icon'] ) ? $section['mission_icon'] : '',
				'mission_icon_hover' => isset( $section['mission_icon_hover'] ) ? $section['mission_icon_hover'] : '',
				'section_class'      => 'bg_color_01',
			);
			get_template_part( 'template-parts/Mission-Vision', null, $args );
			break;

		case 'core_values':
			$values = array();
			if ( ! empty( $section['values'] ) && is_array( $section['values'] ) ) {
				foreach ( $section['values'] as $v ) {
					$values[] = array(
						'icon'       => isset( $v['icon'] ) ? $v['icon'] : '',
						'icon_hover' => isset( $v['icon_hover'] ) ? $v['icon_hover'] : '',
						'title'      => isset( $v['title'] ) ? $v['title'] : '',
						'title_span' => isset( $v['title_span'] ) ? $v['title_span'] : '',
						'text'       => isset( $v['text'] ) ? $v['text'] : '',
					);
				}
			}
			$args = array(
				'title'       => isset( $section['title'] ) ? $section['title'] : '',
				'title_span'  => isset( $section['title_span'] ) ? $section['title_span'] : '',
				'description' => isset( $section['description'] ) ? $section['description'] : '',
				'values'      => $values,
			);
			get_template_part( 'template-parts/Core-Values', null, $args );
			break;

		case 'visionary_leadership_page_style':
			// Match Leadership page HTML: separate heading section then Visionary-Leadership with empty title (list only).
			$vl_title   = isset( $section['title'] ) ? $section['title'] : '';
			$vl_span    = isset( $section['title_span'] ) ? $section['title_span'] : '';
			$vl_members = tasheel_get_section_members( $section, 'leadership-team' );
			if ( $vl_title || $vl_span ) {
				echo '<section class="pt_120 pb_20"><div class="wrap"><h3 class="h3_title_50">';
				if ( $vl_title ) {
					echo esc_html( $vl_title ) . ' ';
				}
				if ( $vl_span ) {
					echo '<span>' . esc_html( $vl_span ) . '</span>';
				}
				echo '</h3></div></section>';
			}
			$vl_data = array(
				'label'              => '',
				'title'              => '',
				'title_span'         => '',
				'list_class'         => 'custom-leadership-list',
				'leadership_members' => $vl_members,
			);
			get_template_part( 'template-parts/Visionary-Leadership', null, $vl_data );
			break;

		case 'visionary_leadership_home_style':
		case 'executive_team_home_style':
			// Coalesce both blocks into one Leadership section (Visionary left + Executive right).
			static $leadership_home_rendered = false;
			if ( $leadership_home_rendered ) {
				break;
			}
			$vl_home = array(
				'label'              => '',
				'title'              => '',
				'title_span'         => '',
				'leadership_members' => array(),
			);
			$et_home = array(
				'title'        => '',
				'title_span'   => '',
				'team_members' => array(),
			);
			$sections = array();
			if ( function_exists( 'get_field' ) ) {
				$page_id = (int) get_queried_object_id();
				if ( $page_id ) {
					$sections = get_field( 'about_page_sections', $page_id );
					if ( ! is_array( $sections ) ) {
						$sections = array();
					}
				}
			}
			foreach ( $sections as $s ) {
				$name = isset( $s['acf_fc_layout'] ) ? $s['acf_fc_layout'] : '';
				if ( $name === 'visionary_leadership_home_style' ) {
					$vl_home = array(
						'label'              => isset( $s['label'] ) ? $s['label'] : '',
						'title'              => isset( $s['title'] ) ? $s['title'] : '',
						'title_span'         => isset( $s['title_span'] ) ? $s['title_span'] : '',
						'leadership_members' => tasheel_get_section_members( $s, 'leadership-team' ),
					);
				} elseif ( $name === 'executive_team_home_style' ) {
					$et_home = array(
						'title'        => isset( $s['title'] ) ? $s['title'] : '',
						'title_span'   => isset( $s['title_span'] ) ? $s['title_span'] : '',
						'team_members' => tasheel_get_section_members( $s, 'executive-team' ),
					);
				}
			}
			if ( empty( $sections ) ) {
				if ( $layout_name === 'visionary_leadership_home_style' ) {
					$vl_home = array(
						'label'              => isset( $section['label'] ) ? $section['label'] : '',
						'title'              => isset( $section['title'] ) ? $section['title'] : '',
						'title_span'         => isset( $section['title_span'] ) ? $section['title_span'] : '',
						'leadership_members' => tasheel_get_section_members( $section, 'leadership-team' ),
					);
				} else {
					$et_home = array(
						'title'        => isset( $section['title'] ) ? $section['title'] : '',
						'title_span'   => isset( $section['title_span'] ) ? $section['title_span'] : '',
						'team_members' => tasheel_get_section_members( $section, 'executive-team' ),
					);
				}
			}
			$leadership_home_rendered = true;
			get_template_part( 'template-parts/Leadership', null, array( 'visionary' => $vl_home, 'executive' => $et_home ) );
			break;

		case 'executive_team_page_style':
			$et_data = array(
				'title'        => isset( $section['title'] ) ? $section['title'] : '',
				'title_span'   => isset( $section['title_span'] ) ? $section['title_span'] : '',
				'team_members' => tasheel_get_section_members( $section, 'executive-team' ),
			);
			get_template_part( 'template-parts/Executive-Team', null, $et_data );
			break;

		case 'our_journey':
			$raw_items = isset( $section['journey_items'] ) && is_array( $section['journey_items'] ) ? $section['journey_items'] : array();
			$journey_items = array();
			foreach ( $raw_items as $item ) {
				$img = isset( $item['image'] ) ? $item['image'] : '';
				if ( is_array( $img ) && isset( $img['url'] ) ) {
					$img = $img['url'];
				} elseif ( is_numeric( $img ) ) {
					$img = wp_get_attachment_url( (int) $img );
				}
				$journey_items[] = array(
					'year'             => isset( $item['year'] ) ? $item['year'] : '',
					'image'            => is_string( $img ) ? $img : '',
					'year_range_label' => isset( $item['year_range_label'] ) ? $item['year_range_label'] : '',
					'title'            => isset( $item['title'] ) ? $item['title'] : '',
					'content'          => isset( $item['content'] ) ? $item['content'] : '',
				);
			}
			$args = array(
				'title'         => isset( $section['title'] ) ? $section['title'] : esc_html__( 'Our Journey &', 'tasheel' ),
				'title_span'    => isset( $section['title_span'] ) ? $section['title_span'] : esc_html__( 'Legacy', 'tasheel' ),
				'description'   => isset( $section['description'] ) ? $section['description'] : '',
				'journey_items' => $journey_items,
			);
			get_template_part( 'template-parts/Our-Journey', null, $args );
			break;

		case 'timeline':
			$intro = isset( $section['intro_text'] ) ? $section['intro_text'] : '';
			$items = isset( $section['timeline_items'] ) && is_array( $section['timeline_items'] ) ? $section['timeline_items'] : array();
			$args  = array(
				'section_class'   => '',
				'intro_text'      => $intro,
				'timeline_items'  => $items,
			);
			get_template_part( 'template-parts/Timeline', null, $args );
			break;

		case 'awards_slider':
			$awards = array();
			if ( ! empty( $section['awards'] ) && is_array( $section['awards'] ) ) {
				foreach ( $section['awards'] as $a ) {
					$image = isset( $a['image'] ) ? $a['image'] : '';
					if ( is_array( $image ) && isset( $image['url'] ) ) {
						$image = $image['url'];
					}
					$awards[] = array(
						'image'       => $image,
						'title'       => isset( $a['title'] ) ? $a['title'] : '',
						'description' => isset( $a['description'] ) ? $a['description'] : '',
					);
				}
			}
			$args = array(
				'title'       => isset( $section['title'] ) ? $section['title'] : '',
				'title_span'  => isset( $section['title_span'] ) ? $section['title_span'] : '',
				'description' => isset( $section['description'] ) ? $section['description'] : '',
				'awards'      => $awards,
				'section_class' => '',
			);
			get_template_part( 'template-parts/Awards-Slider', null, $args );
			break;

		case 'awards_gallery':
			$slides = array();
			if ( ! empty( $section['slides'] ) && is_array( $section['slides'] ) ) {
				foreach ( $section['slides'] as $slide ) {
					$thumb = isset( $slide['thumbnail_image'] ) ? $slide['thumbnail_image'] : '';
					$main  = isset( $slide['image'] ) ? $slide['image'] : '';
					if ( is_array( $thumb ) && isset( $thumb['url'] ) ) {
						$thumb = $thumb['url'];
					}
					if ( is_array( $main ) && isset( $main['url'] ) ) {
						$main = $main['url'];
					}
					$slides[] = array(
						'thumbnail_image' => is_string( $thumb ) ? $thumb : '',
						'image'           => is_string( $main ) ? $main : '',
						'heading'         => isset( $slide['heading'] ) ? $slide['heading'] : '',
						'content'         => isset( $slide['content'] ) ? $slide['content'] : '',
					);
				}
			}
			$args = array(
				'title'         => isset( $section['title'] ) ? $section['title'] : '',
				'description'   => isset( $section['description'] ) ? $section['description'] : '',
				'slides'        => $slides,
			);
			get_template_part( 'template-parts/Awards-Gallery', null, $args );
			break;

		default:
			// Allow themes to hook custom layouts.
			do_action( 'tasheel_render_about_flexible_section', $layout_name, $section );
			break;
	}
}
