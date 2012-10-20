<div class="users register">
    
<?php echo $this->Form->create('User', array('action' => 'register')); ?>

<h3>Create Account</h3>

<?php echo $this->Session->flash(); ?>

<?php echo $this->Form->input('User.name', array('label'=>'Name')); ?>

<?php echo $this->Form->input('User.username', array('label'=>'Username')); ?>

<?php echo $this->Form->input('User.email', array('label'=>'Email Address')); ?>

<?php echo $this->Form->input('User.email2', array('label'=>'Re-enter Email Address')); ?>

<?php echo $this->Form->input('User.password', array('label'=>'Password')); ?>

<?php echo $this->Form->input('User.sex', array('label'=>'Sex', 'type'=>'select', 'options'=>array(
                                                                                        ''=>'select',
                                                                                        '0'=> 'Female',
                                                                                        '1'=> 'Male'
                                                                                ))); ?>

<?php echo $this->Form->input('User.dob', array(
                                        'label' => 'Birthday',
                                        'minYear' => date('Y') - 100,
                                        'maxYear' => date('Y')
                                    )); ?>

<?php echo $this->Form->end('Register'); ?>
    
</div>