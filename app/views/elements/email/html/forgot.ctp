Hi <?php echo $user["name"]; ?>,
<br><br>
<p>This email contains a link to reset your password.</p>
<p>Please click <a href="<?php echo $resetLink; ?>">here</a> to verify or copy and paste the following URL in your browser address bar.</p>
<p><?php echo $resetLink; ?></p>