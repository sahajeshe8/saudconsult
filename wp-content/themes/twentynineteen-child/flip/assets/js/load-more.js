jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
	$('#awards-load-more').click(function(){
 
		var button = $(this),
		    data = {
			'action': 'loadmore',
			'query': awards_loadmore_params.posts, // that's how we get params from wp_localize_script() function
			'page' : awards_loadmore_params.current_page,
			//'post_type':$(this).data('type')
		};
 
		$.ajax({ // you can also use $.post here
			url : awards_loadmore_params.ajaxurl, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...'); // change the button text, you can also add a preloader image
			},
			success : function( data ){
                console.log(data)
				if( data ) { 
					//button.text( 'More posts' ).prev().before(data); // insert new posts
                    $('#awardssec').append(data); 
					awards_loadmore_params.current_page++;
 
					if ( awards_loadmore_params.current_page == awards_loadmore_params.max_page ) 
						button.remove(); // if last page, remove the button
						else
						button.text('Load More');
		
					// you can also fire the "post-load" event here if you use a plugin that requires it
					// $( document.body ).trigger( 'post-load' );
				} else {
					button.remove(); // if no data, remove the button as well
				}
			}
		});
	});


/* Newletter Load more*/
	$('#nl-load-more').click(function(){
 
		var button = $(this),
		    data = {
			'action': 'nlloadmore',
			'query': nl_loadmore_params.posts, // that's how we get params from wp_localize_script() function
			'page' : nl_loadmore_params.current_page,
			//'post_type':$(this).data('type')
		};
 
		$.ajax({ // you can also use $.post here
			url : nl_loadmore_params.ajaxurl, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...'); // change the button text, you can also add a preloader image
			},
			success : function( data ){
                console.log(data)
				if( data ) { 
					//button.text( 'More posts' ).prev().before(data); // insert new posts
                    $('#nlsec').append(data); 
					nl_loadmore_params.current_page++;
 
					if ( nl_loadmore_params.current_page == nl_loadmore_params.max_page ) 
						button.remove(); // if last page, remove the button
						else
						button.text('Load More');
		
					// you can also fire the "post-load" event here if you use a plugin that requires it
					// $( document.body ).trigger( 'post-load' );
				} else {
					button.remove(); // if no data, remove the button as well
				}
			}
		});
	});

})




 