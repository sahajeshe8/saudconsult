<?php
/**
 * ACF Home Page: render flexible content sections.
 * All output strings use esc_html__ / esc_html_e / esc_attr__ with 'tasheel' for WPML.
 * Empty sections are hidden.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if a home section has content (hide when empty).
 *
 * @param string $layout_name Layout key.
 * @param array  $section     ACF layout data.
 * @return bool
 */
function tasheel_home_section_has_content( $layout_name, $section ) {
	if ( empty( $section ) || ! is_array( $section ) ) {
		return false;
	}
	switch ( $layout_name ) {
		case 'home_banner':
			return ! empty( $section['slides'] ) && is_array( $section['slides'] );
		case 'home_about':
			$has_stats      = ! empty( $section['stats'] ) && is_array( $section['stats'] );
			$has_title      = ! empty( trim( (string) ( $section['title'] ?? '' ) ) );
			$has_title_span = ! empty( trim( (string) ( $section['title_span'] ?? '' ) ) );
			return $has_stats || $has_title || $has_title_span || ! empty( trim( (string) ( $section['label'] ?? '' ) ) );
		case 'home_services':
			if ( ( $section['services_source'] ?? '' ) === 'manual' ) {
				return ! empty( $section['service_categories'] ) && is_array( $section['service_categories'] );
			}
			return true;
		case 'home_projects':
			if ( ( $section['projects_source'] ?? '' ) === 'manual' ) {
				return ! empty( $section['projects_manual'] ) && is_array( $section['projects_manual'] );
			}
			return true;
		case 'home_partners':
			if ( ( $section['partners_source'] ?? '' ) === 'manual' ) {
				return ! empty( $section['partners_manual'] ) && is_array( $section['partners_manual'] );
			}
			return true;
		case 'home_banner_add':
			return ! empty( $section['title'] ) || ! empty( $section['subtitle'] ) || ! empty( $section['description'] ) || ( ! empty( $section['button_text'] ) && ! empty( $section['button_link'] ) );
		case 'home_insights':
			if ( ( $section['insights_source'] ?? '' ) === 'manual' ) {
				return ! empty( $section['insights_manual'] ) && is_array( $section['insights_manual'] );
			}
			return true;
		default:
			return true;
	}
}

/**
 * Get projects data for home section (auto or manual).
 *
 * @param array $section ACF layout.
 * @return array
 */
function tasheel_home_get_projects_data( $section ) {
	$label_text   = isset( $section['label'] ) ? $section['label'] : esc_html__( 'Our Projects', 'tasheel' );
	$label_icon   = get_template_directory_uri() . '/assets/images/dot-02.svg';
	$title        = isset( $section['title'] ) ? $section['title'] : esc_html__( 'Our Work,', 'tasheel' );
	$title_span   = isset( $section['title_span'] ) ? $section['title_span'] : esc_html__( 'Across Industries', 'tasheel' );
	$description  = isset( $section['description'] ) ? $section['description'] : esc_html__( 'Where Our Expertise Makes an Impact.', 'tasheel' );
	$button_text  = isset( $section['button_text'] ) ? $section['button_text'] : esc_html__( 'Explore More', 'tasheel' );
	$button_link  = isset( $section['button_link'] ) ? esc_url( $section['button_link'] ) : esc_url( home_url( '/contact' ) );

	$projects = array();
	$source   = isset( $section['projects_source'] ) ? $section['projects_source'] : 'auto';

	if ( 'manual' === $source && ! empty( $section['projects_manual'] ) && is_array( $section['projects_manual'] ) ) {
		foreach ( $section['projects_manual'] as $pid ) {
			$post = get_post( is_object( $pid ) ? $pid->ID : $pid );
			if ( ! $post || 'project' !== $post->post_type || 'publish' !== $post->post_status ) {
				continue;
			}
			$proj = tasheel_build_project_home_item( $post->ID );
			if ( $proj ) {
				$projects[] = $proj;
			}
		}
	} else {
		$limit = isset( $section['items_count'] ) ? max( 1, min( 24, (int) $section['items_count'] ) ) : 6;
		$q = new WP_Query( array(
			'post_type'      => 'project',
			'posts_per_page' => $limit,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );
		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();
				$proj = tasheel_build_project_home_item( get_the_ID() );
				if ( $proj ) {
					$projects[] = $proj;
				}
			}
			wp_reset_postdata();
		}
	}

	return array(
		'label_text'           => $label_text,
		'label_icon'           => $label_icon,
		'title'                => $title,
		'title_span'           => $title_span,
		'description'          => $description,
		'button_text'          => $button_text,
		'button_link'          => $button_link,
		'section_wrapper_class' => array(),
		'section_class'        => '',
		'projects'             => $projects,
	);
}

/**
 * Build single project item for home Projects section.
 *
 * @param int $post_id Project post ID.
 * @return array|null
 */
function tasheel_build_project_home_item( $post_id ) {
	$img  = '';
	$alt  = get_the_title( $post_id );
	if ( function_exists( 'get_field' ) ) {
		$bg = get_field( 'project_listing_services_image_desktop', $post_id );
		if ( empty( $bg ) ) {
			$bg = get_field( 'project_listing_image', $post_id );
		}
		if ( ! empty( $bg ) ) {
			$img = is_array( $bg ) && isset( $bg['url'] ) ? $bg['url'] : $bg;
		}
	}
	if ( ! $img && has_post_thumbnail( $post_id ) ) {
		$img = get_the_post_thumbnail_url( $post_id, 'full' );
	}
	if ( ! $img ) {
		$img = get_template_directory_uri() . '/assets/images/pro-img.jpg';
	}

	$desc = function_exists( 'get_field' ) ? get_field( 'project_listing_description', $post_id ) : '';
	if ( ! is_string( $desc ) || $desc === '' ) {
		$desc = get_the_excerpt( $post_id );
	}

	$stats = array();
	if ( function_exists( 'tasheel_get_project_info_items' ) ) {
		$stats = tasheel_get_project_info_items( $post_id );
	}
	if ( empty( $stats ) ) {
		$stats[] = array( 'value' => '0', 'label' => esc_html__( 'Completion', 'tasheel' ) );
	}

	return array(
		'background_image'      => $img,
		'background_image_alt'  => $alt,
		'title'                 => get_the_title( $post_id ),
		'description'           => $desc,
		'button_text'           => esc_html__( 'Explore More', 'tasheel' ),
		'button_link'           => get_permalink( $post_id ),
		'stats'                 => $stats,
	);
}

/**
 * Get service categories data for home section (all or manual selection).
 *
 * @param array $section ACF layout.
 * @return array
 */
function tasheel_home_get_services_data( $section ) {
	$items = array();
	if ( ! taxonomy_exists( 'service_category' ) ) {
		return $items;
	}
	$source = isset( $section['services_source'] ) ? $section['services_source'] : 'all';
	$term_ids = array();
	if ( 'manual' === $source && ! empty( $section['service_categories'] ) && is_array( $section['service_categories'] ) ) {
		$term_ids = array_map( 'intval', $section['service_categories'] );
		$term_ids = array_filter( $term_ids );
	}
	if ( ! empty( $term_ids ) ) {
		foreach ( $term_ids as $tid ) {
			$term = get_term( $tid, 'service_category' );
			if ( $term && ! is_wp_error( $term ) ) {
				$item = tasheel_build_service_category_home_item( $term );
				if ( $item ) {
					$items[] = $item;
				}
			}
		}
	} else {
		$terms = get_terms( array(
			'taxonomy'   => 'service_category',
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		) );
		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return $items;
		}
		$limit = isset( $section['items_count'] ) ? max( 1, min( 24, (int) $section['items_count'] ) ) : 6;
		$terms = array_slice( $terms, 0, $limit );
		foreach ( $terms as $term ) {
			$item = tasheel_build_service_category_home_item( $term );
			if ( $item ) {
				$items[] = $item;
			}
		}
	}
	return $items;
}

/**
 * Build single service category item for home Services section.
 * Uses term's home_page_thumbnail, listing_description, listing_subtitle from ACF.
 *
 * @param WP_Term $term Service category term.
 * @return array|null
 */
function tasheel_build_service_category_home_item( $term ) {
	if ( ! $term || is_wp_error( $term ) ) {
		return null;
	}
	$term_id = (int) $term->term_id;
	$img     = '';
	$desc    = $term->description;
	$sub     = '';
	if ( function_exists( 'get_field' ) ) {
		$thumb = get_field( 'home_page_thumbnail', 'service_category_' . $term_id );
		if ( ! empty( $thumb ) ) {
			$img = is_array( $thumb ) && isset( $thumb['url'] ) ? $thumb['url'] : $thumb;
		}
		$listing_desc = get_field( 'listing_description', 'service_category_' . $term_id );
		if ( ! empty( $listing_desc ) ) {
			$desc = $listing_desc;
		}
		$listing_sub = get_field( 'listing_subtitle', 'service_category_' . $term_id );
		if ( ! empty( $listing_sub ) ) {
			$sub = $listing_sub;
		}
	}
	$desc = preg_replace( '/<p>\s*<\/p>/i', '', $desc );
	$desc = trim( $desc );
	if ( ! $img ) {
		$img = get_template_directory_uri() . '/assets/images/service-01.jpg';
	}
	$term_link = get_term_link( $term );
	$term_link = is_wp_error( $term_link ) ? '#' : esc_url( $term_link );
	$title     = $term->name;

	return array(
		'image'       => $img,
		'title'       => $title,
		'title_span'  => $sub,
		'subtitle'    => $sub,
		'description' => $desc,
		'button_text' => esc_html__( 'View More', 'tasheel' ),
		'button_link' => $term_link,
	);
}

/**
 * Get partners (clients) for home section.
 *
 * @param array $section ACF layout.
 * @return array
 */
function tasheel_home_get_partners_data( $section ) {
	$source = isset( $section['partners_source'] ) ? $section['partners_source'] : 'auto';
	$limit  = isset( $section['items_count'] ) ? max( 1, min( 48, (int) $section['items_count'] ) ) : 24;
	$args   = array(
		'post_type'              => 'client',
		'posts_per_page'         => $limit,
		'post_status'            => 'publish',
		'orderby'                => 'menu_order title',
		'order'                  => 'ASC',
		'no_found_rows'          => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	);
	if ( 'category' === $source && ! empty( $section['partners_category'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'client_category',
				'field'    => 'term_id',
				'terms'    => (int) $section['partners_category'],
			),
		);
	}
	if ( 'manual' === $source && ! empty( $section['partners_manual'] ) && is_array( $section['partners_manual'] ) ) {
		$ids = array_map( function ( $p ) {
			return is_object( $p ) ? (int) $p->ID : (int) $p;
		}, $section['partners_manual'] );
		$ids = array_unique( array_filter( $ids ) );
		$ids = array_slice( $ids, 0, 50 );
		$args['post__in'] = $ids;
		$args['orderby']  = 'post__in';
	}

	$items = array();
	$q     = new WP_Query( $args );
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			$items[] = tasheel_build_client_item_data( get_the_ID() );
		}
		wp_reset_postdata();
	}
	return $items;
}

/**
 * Get insights data (auto from post/news or manual).
 *
 * @param array $section ACF layout.
 * @return array
 */
function tasheel_home_get_insights_data( $section ) {
	$source = isset( $section['insights_source'] ) ? $section['insights_source'] : 'manual';
	if ( 'manual' === $source && ! empty( $section['insights_manual'] ) ) {
		// Manual: select from News posts (relationship field returns array of post IDs).
		if ( function_exists( 'tasheel_news_items_from_post_ids' ) ) {
			$ids = isset( $section['insights_manual'] ) ? $section['insights_manual'] : array();
			return tasheel_news_items_from_post_ids( $ids, 'media_center' );
		}
		return array();
	}

	// Auto: fetch only from News post type (no fallback to regular posts).
	if ( ! post_type_exists( 'news' ) ) {
		return array();
	}
	$limit = isset( $section['items_count'] ) ? max( 1, min( 24, (int) $section['items_count'] ) ) : 6;
	if ( function_exists( 'tasheel_get_media_center_news' ) ) {
		return tasheel_get_media_center_news( $limit, 'media_center' );
	}
	$q = new WP_Query( array(
		'post_type'      => 'news',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		'order'          => 'DESC',
	) );
	$items = array();
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			$img = function_exists( 'tasheel_get_listing_page_image' ) ? tasheel_get_listing_page_image( get_the_ID(), 'news' ) : get_the_post_thumbnail_url( get_the_ID(), 'full' );
			$items[] = array(
				'image'          => $img ?: get_template_directory_uri() . '/assets/images/news-01.jpg',
				'date_label'     => get_the_date(),
				'title'          => get_the_title(),
				'category_label' => esc_html__( 'Latest News', 'tasheel' ),
				'link'           => get_permalink(),
			);
		}
		wp_reset_postdata();
	}
	return $items;
}

/**
 * Map ACF layout keys to canonical layout names (avoids home_about matching inside home_services).
 *
 * @return array
 */
function tasheel_home_layout_key_to_name() {
	return array(
		'layout_about_home_about'      => 'home_about',
		'layout_about_home_services'   => 'home_services',
		'layout_about_home_projects'   => 'home_projects',
		'layout_about_home_partners'   => 'home_partners',
		'layout_about_home_banner_add' => 'home_banner_add',
		'layout_about_home_insights'   => 'home_insights',
		'layout_about_home_banner'     => 'home_banner',
	);
}

function tasheel_render_home_flexible_section( $section ) {
	if ( empty( $section ) || empty( $section['acf_fc_layout'] ) ) {
		return;
	}
	$layout_name = $section['acf_fc_layout'];
	$key_map     = tasheel_home_layout_key_to_name();
	if ( isset( $key_map[ $layout_name ] ) ) {
		$layout_name = $key_map[ $layout_name ];
	} else {
		// Fallback: normalize by substring (check home_services before home_about to avoid false match).
		if ( strpos( $layout_name, 'home_services' ) !== false ) {
			$layout_name = 'home_services';
		} elseif ( strpos( $layout_name, 'home_about' ) !== false ) {
			$layout_name = 'home_about';
		} elseif ( strpos( $layout_name, 'home_partners' ) !== false ) {
			$layout_name = 'home_partners';
		} elseif ( strpos( $layout_name, 'home_projects' ) !== false ) {
			$layout_name = 'home_projects';
		} elseif ( strpos( $layout_name, 'home_banner_add' ) !== false ) {
			$layout_name = 'home_banner_add';
		} elseif ( strpos( $layout_name, 'home_insights' ) !== false ) {
			$layout_name = 'home_insights';
		} elseif ( strpos( $layout_name, 'home_banner' ) !== false ) {
			$layout_name = 'home_banner';
		}
	}
	if ( ! tasheel_home_section_has_content( $layout_name, $section ) ) {
		return;
	}

	switch ( $layout_name ) {
		case 'home_banner':
			tasheel_render_home_banner( $section );
			break;
		case 'home_about':
			tasheel_render_home_about( $section );
			break;
		case 'home_services':
			tasheel_render_home_services( $section );
			break;
		case 'home_projects':
			tasheel_render_home_projects( $section );
			break;
		case 'home_partners':
			tasheel_render_home_partners( $section );
			break;
		case 'home_banner_add':
			tasheel_render_home_banner_add( $section );
			break;
		case 'home_insights':
			tasheel_render_home_insights( $section );
			break;
		default:
			do_action( 'tasheel_render_home_flexible_section', $layout_name, $section );
			break;
	}
}

/**
 * Render home banner slider.
 */
function tasheel_render_home_banner( $section ) {
	$slides = isset( $section['slides'] ) && is_array( $section['slides'] ) ? $section['slides'] : array();
	if ( empty( $slides ) ) {
		return;
	}
	$default_bg = get_template_directory_uri() . '/assets/images/banner-img.jpg';
	$default_mobile = get_template_directory_uri() . '/assets/images/banner-img-mobile.jpg';
	get_template_part( 'template-parts/Banner', null, array(
		'slides'         => $slides,
		'default_bg'     => $default_bg,
		'default_mobile' => $default_mobile,
	) );
}

/**
 * Render home about section.
 */
function tasheel_render_home_about( $section ) {
	$label       = isset( $section['label'] ) ? $section['label'] : esc_html__( 'About Us', 'tasheel' );
	$title       = isset( $section['title'] ) ? trim( (string) $section['title'] ) : '';
	$title_span  = isset( $section['title_span'] ) ? trim( (string) $section['title_span'] ) : '';
	if ( $title_span === '' && isset( $section['field_about_ha_title_span'] ) ) {
		$title_span = trim( (string) $section['field_about_ha_title_span'] );
	}
	$subtitle    = isset( $section['subtitle'] ) ? $section['subtitle'] : '';
	$description = isset( $section['description'] ) ? $section['description'] : '';
	$button_text = isset( $section['button_text'] ) ? $section['button_text'] : esc_html__( 'Learn more about us', 'tasheel' );
	$button_link = isset( $section['button_link'] ) ? esc_url( $section['button_link'] ) : esc_url( home_url( '/about' ) );
	$stats       = isset( $section['stats'] ) && is_array( $section['stats'] ) ? $section['stats'] : array();
	get_template_part( 'template-parts/About', null, array(
		'label'       => $label,
		'title'       => $title,
		'title_span'  => $title_span,
		'subtitle'    => $subtitle,
		'description' => $description,
		'button_text' => $button_text,
		'button_link' => $button_link,
		'stats'       => $stats,
	) );
}

/**
 * Render home services section.
 */
function tasheel_render_home_services( $section ) {
	$items       = tasheel_home_get_services_data( $section );
	$label       = isset( $section['label'] ) ? $section['label'] : esc_html__( 'Our Comprehensive Services', 'tasheel' );
	$title       = isset( $section['title'] ) ? trim( (string) $section['title'] ) : esc_html__( 'Explore Our Full Range', 'tasheel' );
	$title_span  = isset( $section['title_span'] ) ? trim( (string) $section['title_span'] ) : '';
	if ( $title_span === '' && isset( $section['field_about_hs_title_span'] ) ) {
		$title_span = trim( (string) $section['field_about_hs_title_span'] );
	}
	$description = isset( $section['description'] ) ? $section['description'] : '';
	get_template_part( 'template-parts/Services', null, array(
		'label'       => $label,
		'title'       => $title,
		'title_span'  => $title_span,
		'description' => $description,
		'services'    => $items,
	) );
}

/**
 * Render home projects section.
 */
function tasheel_render_home_projects( $section ) {
	$data = tasheel_home_get_projects_data( $section );
	get_template_part( 'template-parts/Projects-home', null, $data );
}

/**
 * Render home partners section.
 */
function tasheel_render_home_partners( $section ) {
	$partners = tasheel_home_get_partners_data( $section );
	$title    = isset( $section['title'] ) ? $section['title'] : esc_html__( 'Our Success', 'tasheel' );
	$title_span = isset( $section['title_span'] ) ? $section['title_span'] : esc_html__( 'Partners', 'tasheel' );
	get_template_part( 'template-parts/home-Partners', null, array(
		'title'      => $title,
		'title_span' => $title_span,
		'partners'   => $partners,
	) );
}

/**
 * Render home CTA banner.
 */
function tasheel_render_home_banner_add( $section ) {
	$bg    = isset( $section['background_image'] ) ? $section['background_image'] : get_template_directory_uri() . '/assets/images/ready-to-partner-one.jpg';
	$bg    = is_array( $bg ) && isset( $bg['url'] ) ? $bg['url'] : ( is_string( $bg ) ? $bg : '' );
	$mobile = isset( $section['mobile_image'] ) ? $section['mobile_image'] : '';
	$mobile = is_array( $mobile ) && isset( $mobile['url'] ) ? $mobile['url'] : ( is_string( $mobile ) ? $mobile : '' );
	$args = array(
		'background_image' => $bg ?: get_template_directory_uri() . '/assets/images/ready-to-partner-one.jpg',
		'mobile_image'     => $mobile,
		'title'            => isset( $section['title'] ) ? $section['title'] : esc_html__( 'Ready to Partner', 'tasheel' ),
		'subtitle'         => isset( $section['subtitle'] ) ? $section['subtitle'] : esc_html__( 'on Your Vision?', 'tasheel' ),
		'description'      => isset( $section['description'] ) ? strip_tags( $section['description'] ) : '',
		'button_text'      => isset( $section['button_text'] ) ? $section['button_text'] : esc_html__( 'Explore More', 'tasheel' ),
		'button_link'      => isset( $section['button_link'] ) ? esc_url( $section['button_link'] ) : '#',
	);
	get_template_part( 'template-parts/banner-add', null, $args );
}

/**
 * Render home insights section.
 */
function tasheel_render_home_insights( $section ) {
	$items  = tasheel_home_get_insights_data( $section );
	$label  = isset( $section['label'] ) ? $section['label'] : esc_html__( 'Insights & Resources', 'tasheel' );
	$title  = isset( $section['title'] ) ? $section['title'] : esc_html__( 'Elevate Your', 'tasheel' );
	$span   = isset( $section['title_span'] ) ? $section['title_span'] : esc_html__( 'Understanding', 'tasheel' );
	$view_url = isset( $section['view_all_url'] ) ? esc_url( $section['view_all_url'] ) : home_url( '/news' );
	get_template_part( 'template-parts/Insights-Resources', null, array(
		'label'                 => $label,
		'title'                 => $title,
		'title_span'            => $span,
		'show_view_all_button'  => false,
		'view_all_url'          => $view_url,
		'insights'              => $items,
	) );
}
