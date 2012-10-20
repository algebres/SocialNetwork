Hi <?php echo $user["name"]; ?>,
<br><br>
<p>Your password reset is successful.</p>
<p>And your new password is: <b><?php echo $newPassword; ?></b></p>
<p>Please click <a href="<?php echo $loginLink; ?>">here</a> or copy and paste the following URL in your browser address bar to login.</p>
<p><?php echo $loginLink; ?></p>