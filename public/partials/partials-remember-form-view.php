<?php
/**
 * The form to input remember-email data
 */

?>		


<form action="<?php echo esc_attr( admin_url( 'admin-post.php' ) ); ?>" method="post">
<input type="text" id="name" name="name" placeholder="Name*" required>
<br>
<input type="email" id="email" name="email" placeholder="E-Mail Adresse*" required>
<br>
<textarea name="message" type="text" id="message" placeholder="Hier könnt ihr zusätzlichen Text eingeben, der in euer Einnerung erscheint.">
</textarea>
<label for="date">Erinnerungsdatum*</label>
<input type="date" id="date" name="remember_date" placeholder="Erinnerungsdatum" required>
<br>
<input type="submit" value="Senden" id="submit">
<input type="hidden" name="action" value="no1_remember_form_response">

<?php
// create hidden field for nonce to verify submission.
wp_nonce_field( 'no1_submit_remember_form', 'no1_remember_form_nonce' );
?>
<div id="wait">
</div>
<div id="response"> 
</div>
</form>
