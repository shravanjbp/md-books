<?php 
namespace MdBooks\Controller;

use \MdBooks;
use \MdBooks\Model\RegisterCPT as CPT;

class MdBooksApp {

	/**
	 * Constructor
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// Load Textdomain
		add_action( 'plugins_loaded', array( $this, 'language' ) );

		// Register Custom Post Type
        add_action( 'init', array( $this, 'register_custom_post_type' ) );

        // add metabox to register custom field
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

        /* Save post meta on the 'save_post' hook. */
  		add_action( 'save_post', array( $this, 'save_books_custom_field' ), 10, 2 );

  		add_action( 'wp_enqueue_scripts', array( $this, 'add_assets' ) );

  		/* add shortcode to display search form*/
  		add_shortcode('MD_BOOK_SEARCH', array( $this, 'display_shortcode' ) );

  		//ajax hook to search book
  		add_action( 'wp_ajax_md_search_book', array( '\MdBooks\Model\Ajax', 'md_filter_books' ) );
  		add_action( 'wp_ajax_nopriv_md_search_book', array( '\MdBooks\Model\Ajax', 'md_filter_books' ) );
        
        add_filter('singular_template', array($this, 'md_book_single_page'));
	}
	

	/**
	 * Load textdomain
	 * 
	 * @return void
	 */
	public function language() 
	{
	    // Internationalization
	    load_plugin_textdomain( 'md-books-library', false, plugin_basename( MDBOOKS_PLUGIN_PATH ).'/languages/' ); 
	}

	/**
	 * Register Book custom post type
	 * 
	 * @return void
	 */
	public function register_custom_post_type()
	{
		CPT::register_book();
		CPT::register_author();
		CPT::register_publisher();
	}

	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function add_meta_boxes() {

	  add_meta_box(
	  	'mb-books-meta-box',      // Unique ID
	    esc_html__( 'Custom Field', 'md-books-library' ),    // Title
	    array( $this, 'show_custom_fields' ),   // Callback function
	    'md_books',         // Admin page (or post type)
	    'normal',         // Context
	    'default'         // Priority
	  );
	}

	/* render the meta box custom field */
	public function show_custom_fields($post)
	{	
		$price = esc_attr( get_post_meta( $post->ID, 'md_book_price', true ) );
		$rating = esc_attr( get_post_meta( $post->ID, 'md_book_rating', true ) );

		$path = MDBOOKS_PLUGIN_PATH.'Views'.DIRECTORY_SEPARATOR.'metabox.php';
		require $path;
	}

	/* Save the meta box’s post metadata. */
	public function save_books_custom_field($post_id, $post)
	{
		/* Verify the nonce before proceeding. */
  		if ( !isset( $_POST['md_books_nonce'] ) || !wp_verify_nonce( $_POST['md_books_nonce'], 'asjdhsakdsamnbsjahd' ) ) {
    		return $post_id;
  		}

		/* Get the post type object. */
	  	$post_type = get_post_type_object( $post->post_type );
	  	
	  	/* Check if the current user has permission to edit the post. */
	  	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
	    	return $post_id;

	    update_post_meta( $post_id, 'md_book_price', $_POST['md-book-price'] );
	    update_post_meta( $post_id, 'md_book_rating', $_POST['md-book-rating'] );
	}

	//add shortcode css and js file
	public function add_assets()
	{
		wp_register_style( 
        	'mdbooks_css', 
        	plugins_url( 'md-books' ).'/assets/md-books.css' 
        );

		wp_register_script(
            'mdbooks_script',
            plugins_url( 'md-books' ).'/assets/md-books.js',
            array( 'jquery' ),
            MdBooks::$version
        );

        wp_register_style(
        	'slider',
        	'//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'
        );

    	wp_localize_script( 'mdbooks_script', 'md_books', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce("md_search_books_nonce")
		) );
	}

	// render the shortcode
	public function display_shortcode($atts)
	{
		ob_start();

		wp_enqueue_style( 'mdbooks_css' );
		wp_enqueue_style( 'slider' );
    	wp_enqueue_script( 'mdbooks_script' );
    	wp_enqueue_script( 'jquery-ui-slider' );

		$authors = CPT::get_terms('md-author');
		$publishers = CPT::get_terms('publisher');

		require MDBOOKS_PLUGIN_PATH.'Views'.DIRECTORY_SEPARATOR.'shortcode.php';

		$html = ob_get_clean();

		return $html;
	}

	//load sbook single page from plugin
	function md_book_single_page($template) {

	    global $post;

        if ( 'md_books' === $post->post_type && locate_template( array( 'single-md_books.php' ) ) !== $template ) {
            wp_enqueue_style( 'mdbooks_css' );
            return MDBOOKS_PLUGIN_PATH.'Views'.DIRECTORY_SEPARATOR.'single-md_books.php';
        }

        return $template;

	}
}