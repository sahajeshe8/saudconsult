<?php
/**
 * Register all Custom Post Types and Taxonomies in one place.
 * Add any new post type or taxonomy here so they are easy to find and maintain.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Custom Post Types
 */
function tasheel_register_all_post_types() {
	// --- Service ---
	register_post_type( 'service', array(
		'labels' => array(
			'name'               => __( 'Services', 'tasheel' ),
			'singular_name'      => __( 'Service', 'tasheel' ),
			'add_new'            => __( 'Add New', 'tasheel' ),
			'add_new_item'       => __( 'Add New Service', 'tasheel' ),
			'edit_item'          => __( 'Edit Service', 'tasheel' ),
			'new_item'            => __( 'New Service', 'tasheel' ),
			'view_item'          => __( 'View Service', 'tasheel' ),
			'search_items'       => __( 'Search Services', 'tasheel' ),
			'not_found'          => __( 'No services found', 'tasheel' ),
			'not_found_in_trash' => __( 'No services found in trash', 'tasheel' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'      => array( 'slug' => 'services', 'with_front' => false ),
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-admin-tools',
	) );

	// --- Project ---
	register_post_type( 'project', array(
		'labels' => array(
			'name'               => __( 'Projects', 'tasheel' ),
			'singular_name'      => __( 'Project', 'tasheel' ),
			'add_new'            => __( 'Add New', 'tasheel' ),
			'add_new_item'       => __( 'Add New Project', 'tasheel' ),
			'edit_item'          => __( 'Edit Project', 'tasheel' ),
			'new_item'           => __( 'New Project', 'tasheel' ),
			'view_item'          => __( 'View Project', 'tasheel' ),
			'search_items'       => __( 'Search Projects', 'tasheel' ),
			'not_found'          => __( 'No projects found', 'tasheel' ),
			'not_found_in_trash' => __( 'No projects found in trash', 'tasheel' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'      => array( 'slug' => 'projects', 'with_front' => false ),
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-portfolio',
	) );

	// --- Team Member ---
	register_post_type( 'team_member', array(
		'labels' => array(
			'name'                  => __( 'Team Members', 'tasheel' ),
			'singular_name'         => __( 'Team Member', 'tasheel' ),
			'menu_name'             => __( 'Team Members', 'tasheel' ),
			'all_items'             => __( 'All Team Members', 'tasheel' ),
			'add_new'               => __( 'Add New', 'tasheel' ),
			'add_new_item'          => __( 'Add New Team Member', 'tasheel' ),
			'edit_item'             => __( 'Edit Team Member', 'tasheel' ),
			'new_item'              => __( 'New Team Member', 'tasheel' ),
			'view_item'             => __( 'View Team Member', 'tasheel' ),
			'search_items'          => __( 'Search Team Members', 'tasheel' ),
			'not_found'             => __( 'No team members found.', 'tasheel' ),
			'not_found_in_trash'    => __( 'No team members found in Trash.', 'tasheel' ),
			'featured_image'        => __( 'Profile Image', 'tasheel' ),
			'set_featured_image'    => __( 'Set profile image', 'tasheel' ),
			'remove_featured_image' => __( 'Remove profile image', 'tasheel' ),
			'use_featured_image'    => __( 'Use as profile image', 'tasheel' ),
		),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_rest'       => true,
		'has_archive'        => false,
		'rewrite'            => false,
		'query_var'          => false,
		'capability_type'    => 'page',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'menu_icon'          => 'dashicons-groups',
	) );

	// --- Client ---
	register_post_type( 'client', array(
		'labels' => array(
			'name'               => __( 'Clients', 'tasheel' ),
			'singular_name'      => __( 'Client', 'tasheel' ),
			'add_new'            => __( 'Add New', 'tasheel' ),
			'add_new_item'       => __( 'Add New Client', 'tasheel' ),
			'edit_item'          => __( 'Edit Client', 'tasheel' ),
			'new_item'           => __( 'New Client', 'tasheel' ),
			'view_item'          => __( 'View Client', 'tasheel' ),
			'search_items'       => __( 'Search Clients', 'tasheel' ),
			'not_found'          => __( 'No clients found', 'tasheel' ),
			'not_found_in_trash' => __( 'No clients found in trash', 'tasheel' ),
		),
		'public'       => false,
		'show_ui'      => true,
		'has_archive'  => false,
		'supports'     => array( 'title', 'thumbnail' ),
		'menu_icon'    => 'dashicons-businessperson',
		'show_in_rest' => true,
	) );

	// --- News (Media Center) ---
	register_post_type( 'news', array(
		'labels' => array(
			'name'               => __( 'News', 'tasheel' ),
			'singular_name'      => __( 'News', 'tasheel' ),
			'add_new'            => __( 'Add New', 'tasheel' ),
			'add_new_item'       => __( 'Add New News', 'tasheel' ),
			'edit_item'          => __( 'Edit News', 'tasheel' ),
			'new_item'           => __( 'New News', 'tasheel' ),
			'view_item'          => __( 'View News', 'tasheel' ),
			'search_items'       => __( 'Search News', 'tasheel' ),
			'not_found'          => __( 'No news found', 'tasheel' ),
			'not_found_in_trash' => __( 'No news found in trash', 'tasheel' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'rewrite'      => array( 'slug' => 'news', 'with_front' => false ),
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-media-text',
	) );

	// --- Event (Media Center) ---
	register_post_type( 'event', array(
		'labels' => array(
			'name'               => __( 'Events', 'tasheel' ),
			'singular_name'      => __( 'Event', 'tasheel' ),
			'add_new'            => __( 'Add New', 'tasheel' ),
			'add_new_item'       => __( 'Add New Event', 'tasheel' ),
			'edit_item'          => __( 'Edit Event', 'tasheel' ),
			'new_item'           => __( 'New Event', 'tasheel' ),
			'view_item'          => __( 'View Event', 'tasheel' ),
			'search_items'       => __( 'Search Events', 'tasheel' ),
			'not_found'          => __( 'No events found', 'tasheel' ),
			'not_found_in_trash' => __( 'No events found in trash', 'tasheel' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'rewrite'      => array( 'slug' => 'events', 'with_front' => false ),
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-calendar-alt',
	) );

	// --- Brochure (Media Center: listing + download) ---
	register_post_type( 'brochure', array(
		'labels' => array(
			'name'               => __( 'Brochures', 'tasheel' ),
			'singular_name'      => __( 'Brochure', 'tasheel' ),
			'add_new'            => __( 'Add New', 'tasheel' ),
			'add_new_item'       => __( 'Add New Brochure', 'tasheel' ),
			'edit_item'          => __( 'Edit Brochure', 'tasheel' ),
			'new_item'           => __( 'New Brochure', 'tasheel' ),
			'view_item'          => __( 'View Brochure', 'tasheel' ),
			'search_items'       => __( 'Search Brochures', 'tasheel' ),
			'not_found'          => __( 'No brochures found', 'tasheel' ),
			'not_found_in_trash' => __( 'No brochures found in trash', 'tasheel' ),
		),
		'public'       => false,
		'show_ui'      => true,
		'has_archive'  => false,
		'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
		'menu_icon'    => 'dashicons-pdf',
		'show_in_rest' => true,
	) );

	// --- HR Engine: Jobs (single post type; use taxonomy job_type: career, corporate_training, academic) ---
	register_post_type( 'hr_job', array(
		'labels' => array(
			'name'               => __( 'Jobs', 'tasheel' ),
			'singular_name'      => __( 'Job', 'tasheel' ),
			'add_new'            => __( 'Add New', 'tasheel' ),
			'add_new_item'       => __( 'Add New Job', 'tasheel' ),
			'edit_item'          => __( 'Edit Job', 'tasheel' ),
			'new_item'           => __( 'New Job', 'tasheel' ),
			'view_item'          => __( 'View Job', 'tasheel' ),
			'search_items'       => __( 'Search Jobs', 'tasheel' ),
			'not_found'          => __( 'No jobs found', 'tasheel' ),
			'not_found_in_trash' => __( 'No jobs found in trash', 'tasheel' ),
		),
		'public'             => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_rest'        => true,
		'has_archive'         => false,
		'rewrite'             => array( 'slug' => 'jobs', 'with_front' => false ),
		'capability_type'     => 'hr_job',
		'map_meta_cap'        => true,
		'supports'             => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'menu_icon'            => 'dashicons-id',
	) );

	// --- HR Engine: Job Applications ---
	register_post_type( 'job_application', array(
		'labels' => array(
			'name'               => __( 'Job Applications', 'tasheel' ),
			'singular_name'      => __( 'Job Application', 'tasheel' ),
			'add_new'            => __( 'Add New', 'tasheel' ),
			'add_new_item'       => __( 'Add New Application', 'tasheel' ),
			'edit_item'          => __( 'Edit Application', 'tasheel' ),
			'new_item'           => __( 'New Application', 'tasheel' ),
			'view_item'          => __( 'View Application', 'tasheel' ),
			'search_items'       => __( 'Search Applications', 'tasheel' ),
			'not_found'          => __( 'No applications found', 'tasheel' ),
			'not_found_in_trash' => __( 'No applications found in trash', 'tasheel' ),
		),
		'public'             => false,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_rest'        => false,
		'has_archive'         => false,
		'rewrite'             => false,
		'capability_type'     => 'job_application',
		'map_meta_cap'        => true,
		'supports'             => array( 'title' ),
		'menu_icon'            => 'dashicons-clipboard',
	) );

	// Add more post types below as needed.
}
add_action( 'init', 'tasheel_register_all_post_types', 0 );

/**
 * Order News and Events by menu_order in admin list so backend order matches frontend.
 */
function tasheel_admin_order_news_events_by_menu_order( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || ! in_array( $screen->post_type, array( 'news', 'event' ), true ) ) {
		return;
	}
	$query->set( 'orderby', 'menu_order' );
	$query->set( 'order', 'ASC' );
}
add_action( 'pre_get_posts', 'tasheel_admin_order_news_events_by_menu_order' );

/**
 * Register Custom Taxonomies
 */
function tasheel_register_all_taxonomies() {
	// --- Service Category (for Services) ---
	register_taxonomy( 'service_category', 'service', array(
		'labels' => array(
			'name'              => __( 'Service Categories', 'tasheel' ),
			'singular_name'     => __( 'Service Category', 'tasheel' ),
			'search_items'      => __( 'Search Categories', 'tasheel' ),
			'all_items'         => __( 'All Categories', 'tasheel' ),
			'parent_item'       => __( 'Parent Category', 'tasheel' ),
			'parent_item_colon' => __( 'Parent Category:', 'tasheel' ),
			'edit_item'         => __( 'Edit Category', 'tasheel' ),
			'update_item'       => __( 'Update Category', 'tasheel' ),
			'add_new_item'      => __( 'Add New Category', 'tasheel' ),
			'new_item_name'     => __( 'New Category Name', 'tasheel' ),
			'menu_name'         => __( 'Categories', 'tasheel' ),
		),
		'hierarchical' => false,
		'public'       => true,
		'show_ui'      => true,
		'show_admin_column' => true,
		'query_var'    => true,
		'rewrite'      => array( 'slug' => 'service-category', 'with_front' => false ),
		'show_in_rest' => true,
	) );

	// --- Project Location ---
	register_taxonomy( 'project_location', 'project', array(
		'labels' => array(
			'name'              => __( 'Project Locations', 'tasheel' ),
			'singular_name'     => __( 'Location', 'tasheel' ),
			'search_items'      => __( 'Search Locations', 'tasheel' ),
			'all_items'         => __( 'All Locations', 'tasheel' ),
			'edit_item'         => __( 'Edit Location', 'tasheel' ),
			'update_item'       => __( 'Update Location', 'tasheel' ),
			'add_new_item'      => __( 'Add New Location', 'tasheel' ),
			'new_item_name'     => __( 'New Location Name', 'tasheel' ),
			'menu_name'         => __( 'Locations', 'tasheel' ),
		),
		'hierarchical' => false,
		'public'       => true,
		'show_ui'      => true,
		'show_admin_column' => true,
		'query_var'    => true,
		'rewrite'      => array( 'slug' => 'location', 'with_front' => false ),
		'show_in_rest' => true,
	) );

	// --- Team Category (for Team Members) ---
	register_taxonomy( 'team_category', array( 'team_member' ), array(
		'labels' => array(
			'name'              => __( 'Team Categories', 'tasheel' ),
			'singular_name'     => __( 'Team Category', 'tasheel' ),
			'search_items'      => __( 'Search Team Categories', 'tasheel' ),
			'all_items'         => __( 'All Team Categories', 'tasheel' ),
			'edit_item'         => __( 'Edit Team Category', 'tasheel' ),
			'update_item'       => __( 'Update Team Category', 'tasheel' ),
			'add_new_item'      => __( 'Add New Team Category', 'tasheel' ),
			'new_item_name'     => __( 'New Team Category Name', 'tasheel' ),
			'menu_name'         => __( 'Team Categories', 'tasheel' ),
		),
		'hierarchical'  => false,
		'public'        => false,
		'show_ui'       => true,
		'show_admin_column' => true,
		'show_in_rest'  => true,
		'rewrite'       => false,
		'query_var'     => false,
	) );

	// --- Client Category (for Clients page filter) ---
	register_taxonomy( 'client_category', 'client', array(
		'labels' => array(
			'name'              => __( 'Client Categories', 'tasheel' ),
			'singular_name'     => __( 'Client Category', 'tasheel' ),
			'search_items'      => __( 'Search Categories', 'tasheel' ),
			'all_items'         => __( 'All Categories', 'tasheel' ),
			'edit_item'         => __( 'Edit Category', 'tasheel' ),
			'update_item'       => __( 'Update Category', 'tasheel' ),
			'add_new_item'      => __( 'Add New Category', 'tasheel' ),
			'new_item_name'     => __( 'New Category Name', 'tasheel' ),
			'menu_name'         => __( 'Categories', 'tasheel' ),
		),
		'hierarchical'      => false,
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'client-category', 'with_front' => false ),
		'show_in_rest'      => true,
	) );

	// --- HR Engine: Job Type (Career / Corporate Training / Academic) ---
	register_taxonomy( 'job_type', 'hr_job', array(
		'labels' => array(
			'name'              => __( 'Job Types', 'tasheel' ),
			'singular_name'     => __( 'Job Type', 'tasheel' ),
			'search_items'      => __( 'Search Job Types', 'tasheel' ),
			'all_items'         => __( 'All Job Types', 'tasheel' ),
			'edit_item'         => __( 'Edit Job Type', 'tasheel' ),
			'update_item'       => __( 'Update Job Type', 'tasheel' ),
			'add_new_item'      => __( 'Add New Job Type', 'tasheel' ),
			'new_item_name'     => __( 'New Job Type Name', 'tasheel' ),
			'menu_name'         => __( 'Job Type', 'tasheel' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'            => array( 'slug' => 'job-type', 'with_front' => false ),
		'show_in_rest'      => true,
	) );

	// Add more taxonomies below as needed.
}
add_action( 'init', 'tasheel_register_all_taxonomies', 0 );

/**
 * Ensure default team categories exist (Leadership Team, Executive Team).
 */
function tasheel_ensure_default_team_categories() {
	$default_terms = array(
		'leadership-team' => __( 'Leadership Team', 'tasheel' ),
		'executive-team'  => __( 'Executive Team', 'tasheel' ),
	);
	foreach ( $default_terms as $slug => $label ) {
		if ( ! term_exists( $slug, 'team_category' ) ) {
			wp_insert_term( $label, 'team_category', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'init', 'tasheel_ensure_default_team_categories', 12 );

/**
 * Ensure default HR job types exist (Career, Corporate Training, Academic).
 */
function tasheel_ensure_default_job_types() {
	$defaults = array(
		'career'             => __( 'Career', 'tasheel' ),
		'corporate_training' => __( 'Corporate Training', 'tasheel' ),
		'academic'           => __( 'Academic Program', 'tasheel' ),
	);
	foreach ( $defaults as $slug => $label ) {
		if ( ! term_exists( $slug, 'job_type' ) ) {
			wp_insert_term( $label, 'job_type', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'init', 'tasheel_ensure_default_job_types', 12 );
