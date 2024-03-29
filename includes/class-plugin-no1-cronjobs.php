<?php
/**
 * Cronjob functionality for the plugin
 *
 * @package Plugin_No1
 * @subpackage Plugin_No1/includes
 * @author Christian Ortlieb <info@ortliebweb.com>
 */

if ( ! class_exists( 'Plugin_No1_Cronjobs' ) ) {
	class Plugin_No1_Cronjobs {

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $plugin_name    The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of this plugin.
		 */
		private $version;    // TODO: Name nicht konsistent mit  $plugin_name

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param string $plugin_name       The name of the plugin.
		 * @param string $version    The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->version     = $version;
		}

		/**
		 * Checks all existing reminder CPTs for needed action
		 *
		 * @since    1.0.0
		 */
		public function no1_check_reminders() {

			$loop_args = array(
				'post_type'      => 'reminder',
				'post_status'    => array( 'draft' ),
				'posts_per_page' => -1,
			);

			$loop = new WP_Query( $loop_args );

			while ( $loop->have_posts() ) :
				$loop->the_post();
				$evaluation_result = $this->evaluate_reminder_date( get_the_ID() );
				switch ( $evaluation_result ) {
					case 'invalid':
						// mark reminder as permanently failed when no valid reminder date is avaialable.
						update_post_meta( get_the_ID(), 'no1_reminder_sent', 'perm_failed' );
						break;
					case 'duefuture':
						$log_entry = 'ID: ' . get_the_ID() . '- due only in the future.';
						write_log( $log_entry );
						break;
					case 'duedate':
					case 'due<7':
						// send reminder mail if it was not sent up to now or sending failed in previous attempt.
						if ( 'not_sent' === get_post_meta( get_the_ID(), 'no1_reminder_sent', true ) ||
						'failed' === get_post_meta( get_the_ID(), 'no1_reminder_sent', true ) ) {
							$send_mail_result = no1_send_cronjob_mail(
								the_title( '', '', false ),
								esc_html( get_post_meta( get_the_ID(), 'no1_reminder_name', true ) ),
								esc_html( get_post_meta( get_the_ID(), 'no1_reminder_message', true ) ),
								esc_html( get_post_meta( get_the_ID(), 'no1_reminder_date', true ) ) // TODO:Datumsformat anpassen.
							);
							// if sending reminder mail was successful
							if ( $send_mail_result ) {
								update_post_meta( get_the_ID(), 'no1_reminder_sent', 'sent' );
							} else {
								update_post_meta( get_the_ID(), 'no1_reminder_sent', 'failed' );
							}
							$log_entry = 'ID: ' . get_the_ID() . '- mail sent: ' . $send_mail_result;
							write_log( $log_entry );
						}
						break;
					case 'due+7':
						$reminder_sent_status = get_post_meta( get_the_ID(), 'no1_reminder_sent', true );
						// if mail for reminder is still not sent (after 7 days) status is set to 'permanently failed'
						if ( 'sent' !== $reminder_sent_status ) {
							update_post_meta( get_the_ID(), 'no1_reminder_sent', 'perm_failed' );
							$log_entry  = 'ID: ' . get_the_ID();
							$log_entry .= ' - after 7 days still in status: ' . $reminder_sent_status . ' --> sending permanently failed!';
							write_log( $log_entry );
						}
						break;
					default:
				}

				endwhile;

			/* Restore original post */
			wp_reset_postdata();
		}

		/**
		 * Evaluates the date of a reminder.
		 *
		 * @since    1.0.0
		 *
		 * @param    int $post_ID       ID of the post (type: reminder) where the reminder date (post meta data)
		 *                              shall be evaluated.
		 *
		 * @return   string             status of the reminder date compared to today's date.
		 */
		public function evaluate_reminder_date( $post_ID ) {
			// get reminder date (post meta data) of current post (type: reminder).
			$post_meta_date = get_post_meta( get_the_ID(), 'no1_reminder_date', true );

			// if post meta reminder date is not existent.
			if ( empty( $post_meta_date ) ) {
				$log_entry = 'ID: ' . $post_ID . ' - no reminder date available!';
				write_log( $log_entry );
				return 'invalid';
			} else {

				// create DateTime object from reminder date.
				$reminder_date = new DateTime( $post_meta_date );

				// create DateTime object from current date.
				$current_date = new DateTime( 'today' );

				$date_difference = $reminder_date->diff( $current_date );
				$log_entry       = 'ID: ' . $post_ID . ' - difference: ' . $date_difference->invert . ' / ' . $date_difference->days;
				write_log( $log_entry );

				// if reminder date is later than today.
				if ( $date_difference->invert ) {
					// reminder date is in the future.
					return 'duefuture';

				} else {
					// if reminder date is today.
					if ( '0' == $date_difference->days ) {
						return 'duedate';

						// if reminder date is more than 7 days in the past.
					} elseif ( $date_difference->days > 7 ) {
						return 'due+7';

						// reminder date in the past, but less (or exactly) than 7 days.
					} else {
						return 'due<7';
					}
				}
			}
		}

	}

}
