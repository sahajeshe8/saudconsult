<?php
/**
 * Custom Walker for Header Mega Menu
 *
 * Outputs mega menu HTML structure with sub_menu_block, left block (title+description), right block (links).
 * WordPress adds current-menu-item, current-menu-parent automatically.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Tasheel_Header_Mega_Menu_Walker
 */
class Tasheel_Header_Mega_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Store parent item for mega submenu (title, url, description).
	 *
	 * @var object|null
	 */
	private $mega_parent = null;

	/**
	 * Menu arrow icon URL.
	 *
	 * @var string
	 */
	private $arrow_url;

	/**
	 * Menu arrow icon URL (submenu).
	 *
	 * @var string
	 */
	private $arrow_sub_url;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->arrow_url     = get_template_directory_uri() . '/assets/images/menu-arrow-01.svg';
		$this->arrow_sub_url = get_template_directory_uri() . '/assets/images/menu-arrow.svg';
		$this->company_arrow = get_template_directory_uri() . '/assets/images/company-arrow.svg';
	}

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( ! isset( $args ) ) {
			$args = new stdClass();
		}
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$classes[] = 'nav-item';

		$active_classes = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' );
		$has_active = array_intersect( $active_classes, $classes );
		$link_class = $args->link_before ? $args->link_before : '';
		if ( $has_active ) {
			$classes[] = 'active';
			$link_class .= ' active';
		}

		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );

		if ( 0 === $depth ) {
			$output .= $indent . '<li class="' . esc_attr( $class_names ) . '">';

			$link_class = 'nav-link' . ( $has_active ? ' active' : '' );
			$atts = array(
				'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
				'href'   => ! empty( $item->url ) ? $item->url : '#',
				'class'  => $link_class,
			);
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$title = apply_filters( 'the_title', $item->title, $item->ID );
			$item_output = $args->before ?? '';
			$item_output .= '<a' . $attributes . '>';
			$item_output .= ( $args->link_before ?? '' ) . $title . ( $args->link_after ?? '' );
			if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
				$item_output .= ' <img src="' . esc_url( $this->arrow_url ) . '" alt="">';
			}
			$item_output .= '</a>';
			$item_output .= $args->after ?? '';

			if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
				$this->mega_parent = $item;
			}

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		} else {
			$link_class = in_array( 'current-menu-item', $classes, true ) ? 'active' : '';
			$li_class   = in_array( 'current-menu-item', $classes, true ) ? 'active' : '';
			$url        = ! empty( $item->url ) ? $item->url : '#';
			$title      = apply_filters( 'the_title', $item->title, $item->ID );
			$output    .= '<li class="' . esc_attr( $li_class ) . '">';
			$output    .= '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $link_class ) . '">';
			$output    .= $title . ' <img src="' . esc_url( $this->arrow_sub_url ) . '" alt="">';
			$output    .= '</a></li>';
		}
	}

	/**
	 * Ends the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= "</li>\n";
			$this->mega_parent = null;
		}
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 !== $depth ) {
			return;
		}
		$parent = $this->mega_parent;
		if ( ! $parent ) {
			return;
		}
		$parent_url   = ! empty( $parent->url ) ? $parent->url : '#';
		$parent_title = apply_filters( 'the_title', $parent->title, $parent->ID );
		$description  = ! empty( $parent->description ) ? $parent->description : '';

		$children_count  = 0;
		$menu_id = null;
		if ( isset( $args->menu ) && $args->menu ) {
			$menu_id = is_object( $args->menu ) ? ( isset( $args->menu->term_id ) ? $args->menu->term_id : null ) : (int) $args->menu;
		}
		if ( $menu_id ) {
			$menu_items = wp_get_nav_menu_items( $menu_id );
			if ( is_array( $menu_items ) ) {
				foreach ( $menu_items as $item ) {
					if ( (int) $item->menu_item_parent === (int) $parent->ID ) {
						$children_count++;
					}
				}
			}
		}
		$list_class = 'list-submenu' . ( $children_count >= 5 ? ' colom-2' : '' );

		$output .= '<div class="sub_menu_block">';
		$output .= '<div class="sub_menu_block_inner">';
		$output .= '<div class="sub_menu_block_left_block">';
		$output .= '<h3>' . esc_html( $parent_title ) . ' <a href="' . esc_url( $parent_url ) . '"><img src="' . esc_url( $this->company_arrow ) . '" alt=""></a></h3>';
		if ( $description ) {
			$output .= '<p>' . esc_html( $description ) . '</p>';
		}
		$output .= '</div>';
		$output .= '<div class="sub_menu_block_right_block">';
		$output .= '<ul class="' . esc_attr( $list_class ) . '">';
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 !== $depth ) {
			return;
		}
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	}
}
