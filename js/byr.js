jQuery( document ).ready(function($){
	var $grid = $('.grid');
	
	$grid.on( 'hover', '.book-wrapper', function(e) {
		$(e.currentTarget).children('.book-image').toggleClass('book-image-hover');	
		$(e.currentTarget).children('.book-title').toggleClass('book-title-hover');
	});
	
	$('.book-wrapper').height(function(){
		return $(this).children('.book-image').height(); 		
	});
	
	$( window ).resize(function() {
	  $('.book-wrapper').height(function(){
			return $(this).children('.book-image').height(); 		
		});
	});
	
});