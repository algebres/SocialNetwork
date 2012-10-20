<div class="users forgot">
    
<?php echo $this->Form->create('User', array('action' => 'forgot_password')); ?>

<h3>Forgot Password</h3>

<p>Please enter your email address to reset your password.</p>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->input('User.email', array('label'=>'Email address')); ?>

<?php echo $this->Form->submit('Submit'); ?>

<?php echo $this->Form->end(); ?>

</div>