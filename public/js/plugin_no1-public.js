(function ($) {
	'use strict';

	$(document).ready(function () {
		$('#no1_remember_form').submit(function (event) {
			console.log( 'hier beginnt das Script' );	
			event.preventDefault(); // Prevent the default form submit.            

			// serialize the form data
			var ajax_form_data = $("#no1_remember_form").serialize();

			//add our own ajax check as X-Requested-With is not always reliable
			ajax_form_data = ajax_form_data + '&ajaxrequest=true&submit=Submit+Form';
			console.log(params.ajaxurl);

			$.ajax({
				url: params.ajaxurl, // domain/wp-admin/admin-ajax.php
				type: 'post',
				data: ajax_form_data
			})

				.done(function (response) { // response from the PHP action
					$("#no1_remember_form_feedback").html("<h2>The request was successful </h2><br>" + response);
				})

				// something went wrong  
				.fail(function () {
					$("#no1_remember_form_feedback").html("<h2>Something went wrong.</h2><br>");
				})

				// after all this time?
				.always(function () {
					event.target.reset();
				});

		});

	});

})(jQuery);
