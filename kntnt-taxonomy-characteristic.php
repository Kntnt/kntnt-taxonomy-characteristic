<?php


/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Taxonomy Characteristics
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Provides the `characteristic` taxonomy whose terms are used to indicate the character of a post (e.g. feature, review, or tutorial). 
 * Version:           1.0.2
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


namespace Kntnt\Characteristic;


defined( 'ABSPATH' ) && new Taxonomy;


class Taxonomy {

	public function __construct() {
		add_action( 'init', [ $this, 'run' ] );
	}

	public function run() {

		$slug = apply_filters( 'kntnt-taxonomy-characteristic-slug', 'characteristic' );
		$post_types = apply_filters( 'kntnt-taxonomy-characteristic-objects', [ 'post' ] );

		register_taxonomy( $slug, null, $this->taxonomy( $slug ) );

		foreach ( $post_types as $post_type ) {
			register_taxonomy_for_object_type( $slug, $post_type );
		}

		add_filter( 'term_updated_messages', [ $this, 'term_updated_messages' ] );

	}

	private function taxonomy() {
		return [

			// A short descriptive summary of what the taxonomy is for.
			'description' => _x( 'Characteristics is a taxonomy used as post metadata. Its terms describe different types of content. For example, Feature Article, Column, Review and Tutorial.', 'Description', 'kntnt-taxonomy-characteristic' ),

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
			'show_admin_column' => true,

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
				'slug' => 'characteristic',

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
				'name' => _x( 'Characteristics', 'Plural name', 'kntnt-taxonomy-characteristic' ),
				'singular_name' => _x( 'Characteristic', 'Singular name', 'kntnt-taxonomy-characteristic' ),
				'search_items' => _x( 'Search characteristics', 'Search items', 'kntnt-taxonomy-characteristic' ),
				'popular_items' => _x( 'Search characteristics', 'Search items', 'kntnt-taxonomy-characteristic' ),
				'all_items' => _x( 'All characteristics', 'All items', 'kntnt-taxonomy-characteristic' ),
				'parent_item' => _x( 'Parent characteristic', 'Parent item', 'kntnt-taxonomy-characteristic' ),
				'parent_item_colon' => _x( 'Parent characteristic colon', 'Parent item colon', 'kntnt-taxonomy-characteristic' ),
				'edit_item' => _x( 'Edit characteristic', 'Edit item', 'kntnt-taxonomy-characteristic' ),
				'view_item' => _x( 'View characteristic', 'View item', 'kntnt-taxonomy-characteristic' ),
				'update_item' => _x( 'Update characteristic', 'Update item', 'kntnt-taxonomy-characteristic' ),
				'add_new_item' => _x( 'Add new characteristic', 'Add new item', 'kntnt-taxonomy-characteristic' ),
				'new_item_name' => _x( 'New characteristic name', 'New item name', 'kntnt-taxonomy-characteristic' ),
				'separate_items_with_commas' => _x( 'Separate characteristics with commas', 'Separate items with commas', 'kntnt-taxonomy-characteristic' ),
				'add_or_remove_items' => _x( 'Add or remove characteristics', 'Add or remove items', 'kntnt-taxonomy-characteristic' ),
				'choose_from_most_used' => _x( 'Choose from most used', 'Choose from most used', 'kntnt-taxonomy-characteristic' ),
				'not_found' => _x( 'Not found', 'Not found', 'kntnt-taxonomy-characteristic' ),
				'no_terms' => _x( 'No terms', 'No terms', 'kntnt-taxonomy-characteristic' ),
				'items_list_navigation' => _x( 'Characteristics list navigation', 'Items list navigation', 'kntnt-taxonomy-characteristic' ),
				'items_list' => _x( 'Items list', 'Characteristics list', 'kntnt-taxonomy-characteristic' ),
				'most_used' => _x( 'Most used', 'Most used', 'kntnt-taxonomy-characteristic' ),
				'back_to_items' => _x( 'Back to characteristics', 'Back to items', 'kntnt-taxonomy-characteristic' ),
			],

		];
	}

	public function term_updated_messages( $messages ) {
		$messages['characteristic'] = [
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Characteristic added.', 'kntnt-taxonomy-characteristic' ),
			2 => __( 'Characteristic deleted.', 'kntnt-taxonomy-characteristic' ),
			3 => __( 'Characteristic updated.', 'kntnt-taxonomy-characteristic' ),
			4 => __( 'Characteristic not added.', 'kntnt-taxonomy-characteristic' ),
			5 => __( 'Characteristic not updated.', 'kntnt-taxonomy-characteristic' ),
			6 => __( 'Characteristics deleted.', 'kntnt-taxonomy-characteristic' ),
		];
		return $messages;
	}

}