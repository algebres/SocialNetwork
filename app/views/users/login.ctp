
<?php echo $this->Form->create('User', array('action' => 'login')); ?>

<h3>Member Login</h3>

<p>If you have not created an account yet, please sign up here.</p>

<?php echo $this->Session->flash('auth'); ?>

<?php echo $this->Form->input('User.username', array('label'=>'Username')); ?>

<?php echo $this->Form->input('User.password', array('label'=>'Password')); ?>

<?php
    /*
    echo $this->Form->inputs(array(
        'legend' => __('Login', true),
        'username',
        'password'
    ));
     * 
     */
?>
<?php echo $this->Form->submit('Login'); ?>

<div class="forget-element"><a href="/users/forgot_password">Forgot Password?</a></div>

<?php echo $this->Form->end(); ?>

<?php //echo $this->Form->end('Login'); ?>