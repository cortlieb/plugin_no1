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
					//TODO: response ist immer leer - prüfen, was in Beispielprojekt anders ist (nds-admin-form-demo-master)
					var html_response = "<span class=\"dashicons dashicons-saved\"></span>";
					html_response += "<h3>Das hat geklappt.</h3>";
					//TODO: Namen und Emailadresse einfügen (s. direkte Serverübertragung)
					html_response += "<p>Wir schicken dir zur gewünschten Zeit eine Erinnerung!</p>";
					$("#no1_remember_form_feedback").html(html_response);
					console.log(response);
				})

				// something went wrong  
				.fail(function () {
					$("#no1_remember_form_feedback").html("<h2>Something went wrong.</h2><br>");
				})

				// called in each case (success or fail)
				.always(function () {
					$("#no1_remember_form").hide(1000); //hide form (with animation)
					event.target.reset();
				});

		});

	});

})(jQuery);
