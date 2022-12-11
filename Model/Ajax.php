<?php 
namespace MdBooks\Model;

class Ajax {


	//ajax callback function to filter result
	public function md_filter_books()
	{	
		if ( ! wp_verify_nonce( $_POST['nonce'], 'md_search_books_nonce' ) ) {
		    die ( 'Busted!');
		}

		$args = array(
			'posts_per_page'	=> -1,
			'post_type' 		=> 'md_books',
			'post_status' 		=> 'publish',
			'orderby' 			=> 'title',
			'order' 			=> 'asc',
			'search_prod_title' => $_REQUEST['md_book_name'],
		);

		$args['meta_query'] = array(
			'relation' => 'AND'
		);

		if( !empty($_REQUEST['md_book_rating']) ) {

			$args['meta_query'][] = array(
            	'key'   => 'md_book_rating',
            	'value'	=> $_REQUEST['md_book_rating'],
        	);
		}

		//if( !empty($_REQUEST['md_book_price']) ) {

			$args['meta_query'][] = array(
            	'key'   	=> 'md_book_price',
            	'value'		=> $_REQUEST['min_price'],
            	'type' 		=> 'NUMERIC',
         		'compare' 	=> '>='   
        	);

        	$args['meta_query'][] = array(
            	'key'   	=> 'md_book_price',
            	'value'		=> $_REQUEST['max_price'],
            	'type' 		=> 'NUMERIC',
         		'compare' 	=> '<='   
        	);
			
		//}

		$args['tax_query'] = array(
			'relation' => 'AND'
		);

		if( !empty($_REQUEST['md_book_author']) ) {

			$args['tax_query'][] = array(
            	'taxonomy'  => 'md-author',
            	'field'		=> 'slug',
            	'terms'		=> $_REQUEST['md_book_author'],
        	);
		}

		if( !empty($_REQUEST['md_book_publisher']) ) {

			$args['tax_query'][] = array(
            	'taxonomy'  => 'publisher',
            	'field'		=> 'slug',
            	'terms'		=> $_REQUEST['md_book_publisher'],
        	);
			
		}

		add_filter( 'posts_where', array('\MdBooks\Model\Ajax', 'title_filter'), 10, 2);

		$md_query = new \WP_Query($args );
		
		remove_filter( 'posts_where', array('\MdBooks\Model\Ajax', 'title_filter'), 10, 2);
		
		ob_start();

		$i = 1;
		if( $md_query->have_posts()) :
			while( $md_query->have_posts() ):
				$md_query->the_post();
				require MDBOOKS_PLUGIN_PATH.'Views'.DIRECTORY_SEPARATOR.'result.php';
				$i++;
			endwhile;
			wp_reset_postdata();
		else :
			echo 'No books found';

		endif;

		$html = ob_get_clean();

		wp_send_json_success(['result'=>$html]);
	}

	//callback function to add like to post title
	public static function title_filter( $where, $wp_query )
	{
	    global $wpdb;
	    
	    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
	        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
	    }

	    return $where;
	}

}

