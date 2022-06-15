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
	<td><?php 
		echo get_post_meta(	get_the_ID(), 'no1_reminder_sent', true	) ? 'X' : '/';
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
		// TODO: escapen.
		echo 'rem_date_' . $reminder_date_state; // class to color date-field.
		echo '>';
		// output reminder date hen it is valid.
		if ( 'invalid' !== $reminder_date_state ) {
			echo esc_html( $reminder_date->format( get_option( 'date_format' ) ) );
		} else {
			echo esc_html( '- - -' );
		}
		?>
	</td>
</tr>
