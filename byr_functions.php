<?php 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function byr_show_all_books(){
	$args = array(
		'posts_per_page'   => 5,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'book',
		'post_status'      => 'publish',
		'suppress_filters' => true
	);
	$books_array = get_posts( $args );
	
	ob_start();
	include('views/byr_show_all_books_view.php');
	$buffer = ob_get_contents();
	ob_end_clean();

	return $buffer;
}

/* In case we want to use a custom template later on.
// Setup the custom template 
function get_book_post_template($single_template) {
     global $post;

     if ($post->post_type == 'book') {
          $single_template = dirname( __FILE__ ) . '/book-template.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_book_post_template' );
*/

?>