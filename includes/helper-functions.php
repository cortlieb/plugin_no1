<?php


/**
 *
 */

function no1_send_remember_mail() {
	$body    = 'Hallo lieber Empfänger, hier die gewünschte Erinnerungs-Mail, die mittel WordPress WP_mail gesendet wurde. Man kann sogar <b>html</b> Tags benutzen.<br><br>Viele Grüße,<br>Christian Ortlieb<br>';
	$to      = 'info@cortlieb.de';
	$subject = 'Erinnerung';
	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: Christian Ortlieb <info@ortliebweb.com>' );
	return wp_mail( $to, $subject, $body, $headers );
}

// TODO Kommentar
/**
 *
 */
function no1_send_cronjob_mail( $mail, $name, $message, $reminder_date ) {
	$body  = 'Hallo ' . $name . ',<br>';
	$body .= 'hier die gewünschte Erinnerung.<br>';
	$body .= 'Du hattest dir gewünscht, dass ich dich am ' . $reminder_date . ' daran erinnere, über eine eigene Website nachzudenken.<br> ';
	$body .= 'Du hattest dazu noch diese Gedanken:<br>';
	$body .= $message . '<br>';
	$body .= '<br>Gruß Christian';

	$to      = $mail;
	$subject = 'Eine eigene Website?';
	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: Christian Ortlieb < info@ortliebweb.com > ' );

	return wp_mail( $to, $subject, $body, $headers );
}

// TODO Kommentar
/**
 *
 */
if ( ! function_exists( 'write_log' ) ) {

	function write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}
