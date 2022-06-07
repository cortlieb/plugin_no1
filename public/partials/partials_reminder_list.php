<?php
/**
 * Output of reminder entries (custom post type).
 */

// create DateTime object from reminder date.
$reminder_date = new DateTime( get_post_meta( get_the_ID(), 'no1_reminder_date', true ) );

// create DateTime object from current date.
$current_date = current_datetime();

// Check if reminder date is reached.
$reminder_date_expired = $current_date >= $reminder_date;

?>	

<!-- Output current reminder data in a table row -->
<tr>
	<td><?php echo get_the_date(); ?></td>	
	<td><?php the_ID(); ?></td>
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
		echo $reminder_date_expired ? 'rem_date_exp' : 'rem_date_future';//TODO: escapen.
		echo '>';
		echo esc_html( $reminder_date->format( get_option( 'date_format' ) ) );
		?>
	</td>
</tr>
