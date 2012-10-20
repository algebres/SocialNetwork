Hi <?php echo $user["name"]; ?>,

Your password reset is successful.
And your new password is: <?php echo $newPassword; ?>
Please copy and paste the following URL in your browser address bar to login.
<?php echo $loginLink; ?>