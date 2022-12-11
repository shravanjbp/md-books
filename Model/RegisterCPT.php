<?php 
namespace MdBooks\Model;

class RegisterCPT {

	private static $instance;

	public function __construct() {

		//if($instance == null) {
			self::$instance = new RegisterCPT;
		//}

	}

	//Register CPT book and taxonomy author 
	public static function register_book()
	{
		
		$supports = array(
			'title', // post title
			'editor', // post content
			'author', // post author
			'thumbnail', // featured images
		);

		$labels = array(
			'name' => _x('Books', 'plural'),
			'singular_name' => _x('Book', 'singular'),
			'menu_name' => _x('Books', 'admin menu'),
			'name_admin_bar' => _x('Dooks', 'admin bar'),
			'add_new' => _x('Add New', 'add new'),
			'add_new_item' => __('Add New books'),
			'new_item' => __('New book'),
			'edit_item' => __('Edit book'),
			'view_item' => __('View book'),
			'all_items' => __('All books'),
			'search_items' => __('Search books'),
			'not_found' => __('No book found.'),
		);

		$args = array(
			'supports' => $supports,
			'labels' => $labels,
			'public' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'md-books'),
			'has_archive' => false, //we don't need to show in frontend
			'hierarchical' => false,
			'menu_position' => 40
		);

		
		register_post_type('md_books', $args);

		flush_rewrite_rules();
	}

	//Register Author Taxonomy for Books CPT
	public static function register_author($value='')
	{
		register_taxonomy('md-author', 'md_books', array(
		    // Hierarchical taxonomy (like categories)
		    'hierarchical' => true,
		    'show_admin_column' => true,
		    'publicly_queryable' => true, // don't need to show in frontend
		    // This array of options controls the labels displayed in the WordPress Admin UI
		    'labels' => array(
		      'name' => _x( 'Book Authors', 'taxonomy general name' ),
		      'singular_name' => _x( 'Author', 'taxonomy singular name' ),
		      'search_items' =>  __( 'Search Authors' ),
		      'all_items' => __( 'All Authors' ),
		      'parent_item' => __( 'Parent Author' ),
		      'parent_item_colon' => __( 'Parent Author:' ),
		      'edit_item' => __( 'Edit Author' ),
		      'update_item' => __( 'Update Author' ),
		      'add_new_item' => __( 'Add New Author' ),
		      'new_item_name' => __( 'New Author Name' ),
		      'menu_name' => __( 'Authors' ),
		    ),
		    // Control the slugs used for this taxonomy
		    /*'rewrite' => array(
		      'slug' => 'md-author', // This controls the base slug that will display before each term
		      'with_front' => false, // Don't display the category base before "/locations/"
		      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		    ),*/
		  ));

		flush_rewrite_rules();
	}

	//Register Publisher Taxonomy for Books CPT
	public static function register_publisher($value='')
	{
		register_taxonomy('publisher', 'md_books', array(
		    // Hierarchical taxonomy (like categories)
		    'hierarchical' => true,
		    'show_admin_column' => true,
		    'publicly_queryable' => true, // don't need to show in frontend
		    // This array of options controls the labels displayed in the WordPress Admin UI
		    'labels' => array(
		      'name' => _x( 'Book Publishers', 'taxonomy general name' ),
		      'singular_name' => _x( 'Publisher', 'taxonomy singular name' ),
		      'search_items' =>  __( 'Search Publishers' ),
		      'all_items' => __( 'All Publishers' ),
		      'parent_item' => __( 'Parent Publisher' ),
		      'parent_item_colon' => __( 'Parent Publisher:' ),
		      'edit_item' => __( 'Edit Publisher' ),
		      'update_item' => __( 'Update Publisher' ),
		      'add_new_item' => __( 'Add New Publisher' ),
		      'new_item_name' => __( 'New Publisher Name' ),
		      'menu_name' => __( 'Publishers' ),
		    ),
		    // Control the slugs used for this taxonomy
		    /*'rewrite' => array(
		      'slug' => 'publisher', // This controls the base slug that will display before each term
		      'with_front' => false, // Don't display the category base before "/locations/"
		      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		    ),*/
		  ));

		flush_rewrite_rules();
	}

	//get all the authors and publishers
	public static function get_terms($taxonomy)
	{
		$terms = get_terms(array(
			'taxonomy' => $taxonomy,
    		'hide_empty' => false,
		));

		return $terms;
	}
	
}



