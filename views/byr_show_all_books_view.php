<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<?php wp_enqueue_script( 'byr-js' ); ?>

<div class="grid">
	<!-- I'm using a basic count to determine whether or not to add the 
			book-clear class to a book. This will clear: both to reset 
			the rows. -->
	<?php $count = 0; ?>
	
	<!-- Begin foreach loop for all books -->
	<?php foreach($books_array as $book): ?>
		<div class="book-wrapper <?php if($count == 4){echo("book-clear"); } ?>">
			<div class="book-title"><a href="<?php echo $book->guid; ?>"><h2><?php echo $book->post_title; ?></h2></a></div>
			
			<!-- Displaying the book's featured image -->
			<?php if (has_post_thumbnail( $book->ID ) ): ?>
				<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $book->ID ), 'single-post-thumbnail' ); ?>
				<div class="book-image"><img src="<?php echo $image[0]; ?>"></div>
			<?php endif; ?>
		</div>
		
		<!-- If the count is 4 then reset the count, otherwise
				we want to increment the count. -->
		<?php $count == 4 ? $count = 1 : $count++ ?>
		
	<?php endforeach; ?>
	<!-- END foreach loop for all books -->
</div>