(function($) {
  	
	$( document ).ready(function() {

		$('#search_book').on('click', function(){

			let data = $(this).closest('form').serializeArray();
			let button = $(this);
			let text = button.val();
			let min_price = $('#slider').slider("values")[0];
			let max_price = $('#slider').slider("values")[1];

			data.push(
				{name: 'min_price', value: min_price},
				{name: 'max_price', value: max_price},
				{name: 'action', value: 'md_search_book'}, 
				{name: 'nonce', value: md_books.nonce},
			);

			$.ajax({
			   	type : 'post',
			   	dataType : 'json',
			   	url : md_books.ajaxurl,
			   	data : data,
			   	beforeSend: function() {
			   		button.val('Loading');
			   	},
			   	success: function(response) {
			   		console.log()
			      	button.val(text)
			      	$('table.list tbody').html(response.data.result);
			   	}
			})
		});

		$( "#slider" ).slider({
	      	range: true,
	      	min: 1,
	      	max: 3000,
	      	values: [ 100, 3000 ],
			slide: function( event, ui ) {
        		$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      		}
	    });

	    $( "#amount" ).val( "$" + $( "#slider" ).slider( "values", 0 ) +
	          " - $" + $( "#slider" ).slider( "values", 1 ) );

	});

})(jQuery);

