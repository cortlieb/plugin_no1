<?php

/**
 * The form to input remember-email data
 */


// Generate a custom nonce value.
$no1_remember_form_nonce = wp_create_nonce( 'no1_submit_remember_form' ); 

?>		


<h2>Kontaktieren Sie uns:</h2>
<form action="<?php echo esc_attr( admin_url( 'admin-post.php' ) ); ?>" method="post">
<input type="text" id="name" name="name" placeholder="Name" required>
<input type="email" id="email" name="email" placeholder="E-Mail Adresse" required>
<!-- <input type="text" id="subject" name="subject" placeholder="Betreff" required>
<textarea name="message" type="text" id="message" placeholder="Nachricht" required>
</textarea> -->
<input type="submit" value="Senden" id="submit">
<input type="hidden" name="action" value="no1_remember_form_response">
<input type="hidden" name="no1_remember_form_nonce" value="<?php echo $no1_remember_form_nonce; ?>">

<?php
// create hidden field for nonce to verify submission.
// wp_nonce_field( 'submit_remember_form', 'submit_remember_form_nonce' );  //TODO: mit wp_nonce_field das Gleiche erreichen wie jetzt 
?>
<div id="wait">
</div>
<div id="response"> 
</div>
</form>