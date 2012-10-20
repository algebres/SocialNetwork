<div id="image profile-pic">

<?php echo $this->Form->create('Image', array('action' => 'upload_profile', 'type' => 'file')); ?>

<h3>Profile photo</h3>

<?php echo $this->Session->flash(); ?>

<div class="profilepic-element">
    <?php echo $this->Html->image($imageLocation, array('alt'=> __("profile picture", true), 'border'=>"0")); ?>
</div>

<?php echo $this->Form->input('User.avatar', array('label'=>false, 'type'=>'file')); ?>

<?php echo $this->Form->submit('Upload'); ?>

<?php echo $this->Form->end(); ?>

</div>