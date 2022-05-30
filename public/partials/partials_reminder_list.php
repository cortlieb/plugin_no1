<?php
/**
 * Output of reminder entries (custom post type).
 */

?>	

<tr>
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
	<td>
		<?php
		echo esc_html(
			get_post_meta(
				get_the_ID(),
				'no1_reminder_date',
				true
			)
		);
		?>
	</td>
</tr>
