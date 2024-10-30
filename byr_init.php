<?php 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// First create our new post type
add_action( 'init', 'create_byr_post_type' );

// Then add our various meta boxes
add_action( 'add_meta_boxes', 'byr_add_date_box' );
add_action( 'add_meta_boxes', 'byr_add_summary_box' );
add_action( 'add_meta_boxes', 'byr_add_learn_box' );
add_action( 'add_meta_boxes', 'byr_add_final_box' );

// Add our new save action
add_action( 'save_post', 'byr_save_book_data' );

// Change the title placeholder text for the add new book page
add_filter( 'enter_title_here', 'byr_title_placeholder_text' );

// Register our custom CSS for the plugin
wp_register_style( 'book', plugins_url( '/byr/css/style.css', dirname(__FILE__) ) );
wp_register_script( 'byr-js', plugins_url( '/byr/js/byr.js', dirname(__FILE__) ) );

function byr_add_date_box(){
	add_meta_box(
		'byr_date',
		__( 'Date you finished the book', 'byr_date' ),
		'byr_date_box_callback',
		'book', 
		'normal', 
		'high'
	);
}

function byr_date_box_callback( $post ) {

	wp_nonce_field( 'byr_save_book_data', 'byr_date_nonce' );

	$value = get_post_meta( $post->ID, '_byr_date', true );

	echo '<label for="byr_date">';
	echo '</label> ';
	echo '<input type="text" id="byr_date" name="byr_date" value="' . esc_attr( $value ) . '" />';
	echo '<p>When did you finish reading the book?</p>';
}

function byr_add_summary_box(){
	add_meta_box(
		'byr_summary',
		__( 'Summary of the Book', 'byr_summary' ),
		'byr_summary_box_callback',
		'book', 
		'normal', 
		'high'
	);
}

function byr_summary_box_callback( $post ) {

	wp_nonce_field( 'byr_save_book_data', 'byr_summary_nonce' );

	$value = get_post_meta( $post->ID, '_byr_summary', true );
	echo '<label for="byr_summary">';
	echo '</label> ';
	echo '<textarea id="byr_summary" name="byr_summary" rows=1 cols=40>';
	echo esc_attr( $value );
	echo '</textarea>';
	echo '<p>Here\'s a description of some stuff...</p>';
}

function byr_add_learn_box(){
	add_meta_box(
		'byr_learn',
		__( 'What did you learn from the book?', 'byr_learn' ),
		'byr_learn_box_callback',
		'book', 
		'normal', 
		'high'
	);
}

function byr_learn_box_callback( $post ) {

	wp_nonce_field( 'byr_save_book_data', 'byr_learn_nonce' );

	$value = get_post_meta( $post->ID, '_byr_learn', true );
	echo '<label for="byr_learn">';
	echo '</label> ';
	echo '<textarea id="byr_learn" name="byr_learn" rows=1 cols=40>';
	echo esc_attr( $value );
	echo '</textarea>';
	echo '<p>Here\'s a description of some stuff...</p>';
}

function byr_add_final_box(){
	add_meta_box(
		'byr_final',
		__( 'Final thoughts on the book?', 'byr_final' ),
		'byr_final_box_callback',
		'book', 
		'normal', 
		'high'
	);
}

function byr_final_box_callback( $post ) {

	wp_nonce_field( 'byr_save_book_data', 'byr_final_nonce' );

	$value = get_post_meta( $post->ID, '_byr_final', true );
	echo '<label for="byr_final">';
	echo '</label> ';
	echo '<textarea id="byr_final" name="byr_final" rows=1 cols=40>';
	echo esc_attr( $value );
	echo '</textarea>';
	echo '<p>Here\'s a description of some stuff...</p>';
}


function byr_save_book_data( $post_id ) {
	
	$book_data_names = ['byr_date', 'byr_summary', 'byr_learn', 'byr_final'];
	$book_data_info = []; 
	
	foreach($book_data_names as $book_data){
		// Check if our nonce is set.
		if ( ! isset( $_POST[$book_data . '_nonce'] ) ) {
			return;
		}
		
		if ( ! wp_verify_nonce( $_POST[$book_data . '_nonce'], 'byr_save_book_data' ) ) {
			return;
		}
	
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		// Make sure that it is set.
		if ( ! isset( $_POST[$book_data] ) ) {
			return;
		}
	
		// Sanitize user input.
		$new_data = sanitize_text_field( $_POST[$book_data] );
	
		// Update the meta field in the database.
		update_post_meta( $post_id, '_' . $book_data, $new_data );
		$book_data_info[$book_data] = $new_data;	
	}
	
	$content_buffer = 	'<h3>Date Finished</h3>';
	$content_buffer .= 	'<p>' . $book_data_info['byr_date'] . '</p>';
	$content_buffer .=	'<h3>Book Summary</h3>';
	$content_buffer .= 	'<p>'. $book_data_info['byr_summary'] .'</p>';
	$content_buffer .=	'<h3>What Did You Learn from the Book?</h3>';
	$content_buffer .= 	'<p>'. $book_data_info['byr_learn'] .'</p>';
	$content_buffer .=	'<h3>Any Final Thoughts?</h3>';
	$content_buffer .= 	'<p>'. $book_data_info['byr_final'] .'</p>';
	
	$new_book_info = array(
		'ID' => $post_id,
		'post_content' => $content_buffer
	);
	
	// This blog post was a savior! https://tommcfarlin.com/update-post-in-save-post-action/
	remove_action( 'save_post', 'byr_save_book_data' );
	wp_update_post($new_book_info);
	add_action( 'save_post', 'byr_save_book_data' );
}


function byr_title_placeholder_text(){
	$screen = get_current_screen();
	
	if('book' == $screen->post_type){
		$title = 'Enter book title';	
	} else {
		$title = 'Enter title here';
	}
	
	return $title; 
}

function create_byr_post_type() {
	wp_enqueue_style('book');
	register_post_type( 'book',
		array(
		'labels' => array(
			'name' => __( 'Books Read' ),
			'singular_name' => __( 'Book' ), 
			'name_admin_bar' => __( 'Books Read' ),
			'add_new_item' => __( 'Add A New Book You\'ve Read' ),
			'not_found' => __( 'Sorry, no books were found!' ),
		),
		'description' => 'Add a new book that you\'ve read recently. We try to prompt you with meaningful questions so that you can get the most out of the books that you read',
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'has_archive' => true, 
		'menu_position' => 5, 
		'menu_icon' => 'dashicons-book-alt', 
		'supports' => array( 'title', 'author', 'thumbnail', 'comments', 'revisions'),
		)
	);
}

?>