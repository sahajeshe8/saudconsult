<?php
/**
 * Team Member custom post type and taxonomy.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Team Member custom post type.
 */
function tasheel_register_team_member_cpt() {
	$labels = array(
		'name'                  => esc_html__( 'Team Members', 'tasheel' ),
		'singular_name'         => esc_html__( 'Team Member', 'tasheel' ),
		'menu_name'             => esc_html__( 'Team Members', 'tasheel' ),
		'all_items'             => esc_html__( 'All Team Members', 'tasheel' ),
		'add_new'               => esc_html__( 'Add New', 'tasheel' ),
		'add_new_item'          => esc_html__( 'Add New Team Member', 'tasheel' ),
		'edit_item'             => esc_html__( 'Edit Team Member', 'tasheel' ),
		'new_item'              => esc_html__( 'New Team Member', 'tasheel' ),
		'view_item'             => esc_html__( 'View Team Member', 'tasheel' ),
		'view_items'            => esc_html__( 'View Team Members', 'tasheel' ),
		'search_items'          => esc_html__( 'Search Team Members', 'tasheel' ),
		'not_found'             => esc_html__( 'No team members found.', 'tasheel' ),
		'not_found_in_trash'    => esc_html__( 'No team members found in Trash.', 'tasheel' ),
		'parent_item_colon'     => esc_html__( 'Parent Team Member:', 'tasheel' ),
		'featured_image'        => esc_html__( 'Profile Image', 'tasheel' ),
		'set_featured_image'    => esc_html__( 'Set profile image', 'tasheel' ),
		'remove_featured_image' => esc_html__( 'Remove profile image', 'tasheel' ),
		'use_featured_image'    => esc_html__( 'Use as profile image', 'tasheel' ),
		'items_list'            => esc_html__( 'Team member list', 'tasheel' ),
		'items_list_navigation' => esc_html__( 'Team member list navigation', 'tasheel' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_admin_bar'  => true,
		'show_in_rest'       => true,
		'exclude_from_search' => true,
		'has_archive'        => false,
		'rewrite'            => false,
		'query_var'          => false,
		'capability_type'    => 'page',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'menu_icon'          => 'dashicons-groups',
	);

	register_post_type( 'team_member', $args );
}
add_action( 'init', 'tasheel_register_team_member_cpt' );

/**
 * Register Team Category taxonomy.
 */
function tasheel_register_team_category_taxonomy() {
	$labels = array(
		'name'              => esc_html__( 'Team Categories', 'tasheel' ),
		'singular_name'     => esc_html__( 'Team Category', 'tasheel' ),
		'search_items'      => esc_html__( 'Search Team Categories', 'tasheel' ),
		'all_items'         => esc_html__( 'All Team Categories', 'tasheel' ),
		'parent_item'       => esc_html__( 'Parent Category', 'tasheel' ),
		'parent_item_colon' => esc_html__( 'Parent Category:', 'tasheel' ),
		'edit_item'         => esc_html__( 'Edit Team Category', 'tasheel' ),
		'update_item'       => esc_html__( 'Update Team Category', 'tasheel' ),
		'add_new_item'      => esc_html__( 'Add New Team Category', 'tasheel' ),
		'new_item_name'     => esc_html__( 'New Team Category Name', 'tasheel' ),
		'menu_name'         => esc_html__( 'Team Categories', 'tasheel' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'show_tagcloud'     => false,
		'rewrite'           => false,
		'query_var'         => false,
	);

	register_taxonomy( 'team_category', array( 'team_member' ), $args );
}
add_action( 'init', 'tasheel_register_team_category_taxonomy', 0 );

/**
 * Ensure default team categories exist.
 */
function tasheel_ensure_default_team_categories() {
	$default_terms = array(
		'leadership-team' => esc_html__( 'Leadership Team', 'tasheel' ),
		'executive-team'  => esc_html__( 'Executive Team', 'tasheel' ),
	);

	foreach ( $default_terms as $slug => $label ) {
		if ( ! term_exists( $slug, 'team_category' ) ) {
			wp_insert_term(
				$label,
				'team_category',
				array( 'slug' => $slug )
			);
		}
	}
}
add_action( 'init', 'tasheel_ensure_default_team_categories', 12 );
