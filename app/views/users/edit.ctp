<script type="text/javascript">
    $(document).ready(function() {
        $('#UserOpassword').val('');
        $('#UserNpassword').val('');
        $('#UserCpassword').val('');
    });
</script>

<div class="users edit">
    <?php echo $this->Session->flash(); ?>


    <?php echo $this->Form->create('User');?>

    <h3>Edit Profile Info</h3>

    <?php echo $this->Form->input('User.name', array('label'=>'Name')); ?>

    <?php echo $this->Form->input('User.email', array('label'=>'Email Address')); ?>

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

    <?php echo $this->Form->input('User.relationship_status_id', array('type'=>'select', 'options'=>$relationship_statuses)); ?>

    <?php echo $this->Form->input('User.country', array('label'=>'Country')); ?>

    <?php echo $this->Form->end(__('Submit', true));?>


    <?php echo $this->Form->create('User');?>

    <h3>Change Password</h3>

    <?php echo $this->Form->input('User.opassword', array('label'=>'Current Password', 'value'=>'', 'type'=>'password')); ?>

    <?php echo $this->Form->input('User.npassword', array('label'=>'New Password', 'value'=>'', 'type'=>'password')); ?>

    <?php echo $this->Form->input('User.cpassword', array('label'=>'Confirm Password', 'value'=>'', 'type'=>'password')); ?>

    <?php echo $this->Session->flash(); ?>

    

    <?php echo $this->Form->end(__('Submit', true));?>
</div>

<?php /*
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('email');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('name');
		echo $this->Form->input('dob');
		echo $this->Form->input('avatar_id');
		echo $this->Form->input('country');
		echo $this->Form->input('relationship_status_id', array('type'=>'select', 'options'=>$relationship_statuses));
		echo $this->Form->input('group_id');
		echo $this->Form->input('last_login_ip');
		echo $this->Form->input('last_login_time');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
 *
 */?>