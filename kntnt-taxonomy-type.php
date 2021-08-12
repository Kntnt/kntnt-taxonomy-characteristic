<?php


/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Taxonomy Types
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Provides the `type` taxonomy whose terms are used to indicate the character of a post (e.g. feature, review, or tutorial). 
 * Version:           1.0.3
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


namespace Kntnt\Type;


defined( 'ABSPATH' ) && new Taxonomy;


class Taxonomy {

	public function __construct() {
		add_action( 'init', [ $this, 'run' ] );
	}

	public function run() {

		$slug = apply_filters( 'kntnt-taxonomy-type-slug', 'type' );
		$post_types = apply_filters( 'kntnt-taxonomy-type-objects', [ 'post' ] );

		register_taxonomy( $slug, null, $this->taxonomy( $slug ) );

		foreach ( $post_types as $post_type ) {
			register_taxonomy_for_object_type( $slug, $post_type );
		}

		add_filter( 'term_updated_messages', [ $this, 'term_updated_messages' ] );

	}

	private function taxonomy() {
		return [

			// A short descriptive summary of what the taxonomy is for.
			'description' => _x( 'Types is a taxonomy used as post metadata. Its terms describe different types of content. For example, Feature Article, Column, Review and Tutorial.', 'Description', 'kntnt-taxonomy-type' ),

			// Whether the taxonomy is hierarchical.
			'hierarchical' => false,

			// Whether a taxonomy is intended for use publicly either via
			// the admin interface or by front-end users.
			'public' => true,

			// Whether the taxonomy is publicly queryable.
			'publicly_queryable' => true,

			// Whether to generate and allow a UI for managing terms in this
			// taxonomy in the admin.
			'show_ui' => true,

			// Whether to show the taxonomy in the admin menu.
			'show_in_menu' => true,

			// Makes this taxonomy available for selection in navigation menus.
			'show_in_nav_menus' => true,

			// Whether to list the taxonomy in the Tag Cloud Widget controls.
			'show_tagcloud' => false,

			// Whether to show the taxonomy in the quick/bulk edit panel.
			'show_in_quick_edit' => true,

			// Whether to display a column for the taxonomy on its post
			// type listing screens.
			'show_admin_column' => false,

			// Metabox to show on edit. If a callable, it is called to render
			// the metabox. If `null` the default metabox is used. If `false`,
			// no metabox is shown.
			'meta_box_cb' => false,

			// Array of capabilities for this taxonomy.
			'capabilities' => [
				'manage_terms' => 'edit_posts',
				'edit_terms' => 'edit_posts',
				'delete_terms' => 'edit_posts',
				'assign_terms' => 'edit_posts',
			],

			// Sets the query var key for this taxonomy. Default $taxonomy key.
			// If false, a taxonomy cannot be loaded
			// at ?{query_var}={term_slug}. If a string,
			// the query ?{query_var}={term_slug} will be valid.
			'query_var' => true,

			// Triggers the handling of rewrites for this taxonomy.
			// Replace the array with false to prevent handling of rewrites.
			'rewrite' => [

				// Customize the permastruct slug.
				'slug' => 'type',

				// Whether the permastruct should be prepended
				// with WP_Rewrite::$front.
				'with_front' => true,

				// Either hierarchical rewrite tag or not.
				'hierarchical' => false,

				// Endpoint mask to assign. If null and permalink_epmask
				// is set inherits from $permalink_epmask. If null and
				// permalink_epmask is not set, defaults to EP_PERMALINK.
				'ep_mask' => null,

			],

			// Default term to be used for the taxonomy.
			'default_term' => null,

			// An array of labels for this taxonomy.
			'labels' => [
				'name' => _x( 'Types', 'Plural name', 'kntnt-taxonomy-type' ),
				'singular_name' => _x( 'Type', 'Singular name', 'kntnt-taxonomy-type' ),
				'search_items' => _x( 'Search types', 'Search items', 'kntnt-taxonomy-type' ),
				'popular_items' => _x( 'Search types', 'Search items', 'kntnt-taxonomy-type' ),
				'all_items' => _x( 'All types', 'All items', 'kntnt-taxonomy-type' ),
				'parent_item' => _x( 'Parent type', 'Parent item', 'kntnt-taxonomy-type' ),
				'parent_item_colon' => _x( 'Parent type colon', 'Parent item colon', 'kntnt-taxonomy-type' ),
				'edit_item' => _x( 'Edit type', 'Edit item', 'kntnt-taxonomy-type' ),
				'view_item' => _x( 'View type', 'View item', 'kntnt-taxonomy-type' ),
				'update_item' => _x( 'Update type', 'Update item', 'kntnt-taxonomy-type' ),
				'add_new_item' => _x( 'Add new type', 'Add new item', 'kntnt-taxonomy-type' ),
				'new_item_name' => _x( 'New type name', 'New item name', 'kntnt-taxonomy-type' ),
				'separate_items_with_commas' => _x( 'Separate types with commas', 'Separate items with commas', 'kntnt-taxonomy-type' ),
				'add_or_remove_items' => _x( 'Add or remove types', 'Add or remove items', 'kntnt-taxonomy-type' ),
				'choose_from_most_used' => _x( 'Choose from most used', 'Choose from most used', 'kntnt-taxonomy-type' ),
				'not_found' => _x( 'Not found', 'Not found', 'kntnt-taxonomy-type' ),
				'no_terms' => _x( 'No terms', 'No terms', 'kntnt-taxonomy-type' ),
				'items_list_navigation' => _x( 'Types list navigation', 'Items list navigation', 'kntnt-taxonomy-type' ),
				'items_list' => _x( 'Items list', 'Types list', 'kntnt-taxonomy-type' ),
				'most_used' => _x( 'Most used', 'Most used', 'kntnt-taxonomy-type' ),
				'back_to_items' => _x( 'Back to types', 'Back to items', 'kntnt-taxonomy-type' ),
			],

		];
	}

	public function term_updated_messages( $messages ) {
		$messages['type'] = [
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Type added.', 'kntnt-taxonomy-type' ),
			2 => __( 'Type deleted.', 'kntnt-taxonomy-type' ),
			3 => __( 'Type updated.', 'kntnt-taxonomy-type' ),
			4 => __( 'Type not added.', 'kntnt-taxonomy-type' ),
			5 => __( 'Type not updated.', 'kntnt-taxonomy-type' ),
			6 => __( 'Types deleted.', 'kntnt-taxonomy-type' ),
		];
		return $messages;
	}

}