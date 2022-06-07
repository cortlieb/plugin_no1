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
function no1_send_cronjob_mail() {
	$time    = date( 'd.m.Y - H:i' );
	$body    = 'Hallo Christian,<br>hier kommr eine Mail, die durch einen Cronjob ausgelöst wurde.<br><br>';
	$body   .= 'Zeit für die Mail: ' . $time . '<br>';
	$body   .= 'Zeitzone für die Mail: ' . wp_timezone_string() . '<br>';
	$to      = 'info@ortliebweb.com';
	$subject = 'Mail vom Cronjob';
	$headers = array( 'Content-Type: text/html; charset=UTF-8', 'From: Christian Ortlieb <info@ortliebweb.com>' );
	return wp_mail( $to, $subject, $body, $headers );
}
