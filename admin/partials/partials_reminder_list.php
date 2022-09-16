<?php
/**
 * Output of reminder entries (custom post type).
 */

// get reminder date (post meta data) of current post (type: reminder).
$post_meta_date = get_post_meta( get_the_ID(), 'no1_reminder_date', true );

// if post meta reminder date is not existent.
if ( empty( $post_meta_date ) ) {
	$reminder_date_state = 'invalid';
} else {
	// create DateTime object from stored reminder date.
	$reminder_date = new DateTime( $post_meta_date );

	// create DateTime object from current date.
	$current_date = new DateTime( 'today' );

	// Check if reminder date is reached or overdue.
	if ( $current_date >= $reminder_date ) {
		$reminder_date_state = 'due';
	} else {
		$reminder_date_state = 'future';
	}
}

// Output current reminder data in a table row.
?>	
<tr>
	<td><?php echo get_the_date(); ?></td>		
	<td><?php the_ID(); ?></td>
	<td>
	<?php
	switch ( get_post_meta( get_the_ID(), 'no1_reminder_sent', true ) ) {
		case 'not_sent':
			echo '<span class="dashicons dashicons-clock"></span>';
			break;
		case 'sent':
			echo '<span class="dashicons dashicons-email-alt2"></span>';
			break;
		case 'failed':
			echo '<span class="dashicons dashicons-no-alt"></span>';
			break;
		case 'perm_failed':
			echo '<span class="dashicons dashicons-dismiss"></span>';
			break;	
		default:
			echo '<span class="dashicons dashicons-warning"></span>';
	}
	?>
	</td>
	<td><?php the_title(); ?></td>
	<td>
		<?php
		echo esc_html(
			get_post_meta(
				get_the_ID(),
				'no1_reminder_name',
				true
			)
		);
		?>
	</td>
	<td class=
		<?php
		echo 'rem_date_' . esc_attr( $reminder_date_state ); // class to color date-field.
		echo '>';
		// output reminder date when it is valid.
		if ( 'invalid' !== $reminder_date_state ) {
			echo esc_html( $reminder_date->format( get_option( 'date_format' ) ) );
		} else {
			echo esc_html( '- - -' );
		}
		?>
	</td>
</tr>
