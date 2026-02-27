<?php
/**
 * Custom Walker for Header Mobile Menu
 *
 * Outputs mobile menu HTML structure (mobile_menu_list, mobile_menu_item_has_submenu, etc.)
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Tasheel_Header_Mobile_Menu_Walker
 */
class Tasheel_Header_Mobile_Menu_Walker extends Walker_Nav_Menu {

	private $arrow_url     = '';
	private $current_item  = null;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->arrow_url = get_template_directory_uri() . '/assets/images/menu-arrow-01.svg';
	}

	/**
	 * Starts the element output.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( ! isset( $args ) ) {
			$args = new stdClass();
		}
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$active_classes = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' );
		$is_active = (bool) array_intersect( $active_classes, $classes );

		$url   = ! empty( $item->url ) ? $item->url : '#';
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$link_class = $is_active ? 'active' : '';

		$arrow_sub = get_template_directory_uri() . '/assets/images/menu-arrow.svg';

		if ( 1 === $depth ) {
			$output .= '<li><a href="' . esc_url( $url ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html( $title ) . ' <img src="' . esc_url( $arrow_sub ) . '" alt=""></a></li>';
			return;
		}

		$classes[] = 'mobile_menu_item';
		if ( $has_children ) {
			$classes[] = 'mobile_menu_item_has_submenu';
		}
		if ( $is_active ) {
			$classes[] = 'active';
		}
		$class_names = implode( ' ', array_filter( $classes ) );

		$output .= '<li class="' . esc_attr( $class_names ) . '">';
		$output .= '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $link_class ) . '">' . esc_html( $title ) . '</a>';

		if ( $has_children ) {
			$this->current_item = $item;
			$sub_id = 'mobile-submenu-' . $item->ID;
			$output .= '<span class="mobile_menu_submenu_toggle" data-submenu="' . esc_attr( $sub_id ) . '">';
			$output .= '<img src="' . esc_url( $this->arrow_url ) . '" alt="">';
			$output .= '</span>';
		}
	}

	/**
	 * Ends the element output.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( 1 !== $depth ) {
			$output .= "</li>\n";
		}
	}

	/**
	 * Starts the list before the elements are added.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 !== $depth ) {
			return;
		}
		$parent_id = 0;
		if ( isset( $this->current_item ) && isset( $this->current_item->ID ) ) {
			$parent_id = $this->current_item->ID;
		}
		$sub_id = 'mobile-submenu-' . $parent_id;
		$output .= '<div class="mobile_menu_submenu" id="' . esc_attr( $sub_id ) . '">';
		$output .= '<div class="mobile_submenu_content">';
		$output .= '<ul class="mobile_submenu_list">';
	}

	/**
	 * Ends the list of after the elements are added.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 !== $depth ) {
			return;
		}
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '</div>';
	}
}
