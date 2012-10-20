<div class="users contact">

    <?php echo $this->Form->create('User', array('action' => 'contact')); ?>

    <h3>Contact Us</h3>

    <?php echo $this->Session->flash(); ?>

    <?php echo $this->Form->input('User.name', array('label'=>'Name')); ?>

    <?php echo $this->Form->input('User.email', array('label'=>'Email Address')); ?>

    <?php echo $this->Form->input('User.body', array('label'=>'Message', 'type'=>'textarea')); ?>

    <?php echo $this->Form->end('Send'); ?>

</div>