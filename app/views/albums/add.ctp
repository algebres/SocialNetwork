<div id="headline">
    <h2>Photo Albums</h2>
    <div class="nav">
        <ul>
            <li><a href="/albums"><img src="/img/album.png" alt="">&nbsp;Browse albums</a></li>
        </ul>
    </div>
    <div class="search-a">
        <img src="/img/search.png" alt="">
        <input type="text" value="">
    </div>
</div>

<div class="albums add">
    <?php echo $this->Form->create('Album', array('action' => 'add')); ?>

    <h3>New Album</h3>

    <?php echo $this->Session->flash(); ?>

    <?php echo $this->Form->input('Album.name', array('label'=>'Album Title')); ?>

    <?php echo $this->Form->input('Album.description', array('label'=>'Description', 'type'=>'textarea')); ?>

    <?php echo $this->Form->input('Album.status', array('label'=>'Privacy', 'type'=>'select', 'options'=>$privacies)); ?>

    <?php echo $this->Form->submit('Create'); ?>

    <?php echo $this->Form->end(); ?>
</div>

<?php /*
<div class="albums form">
<?php echo $this->Form->create('Album');?>
	<fieldset>
 		<legend><?php __('Add Album'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('user_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Albums', true), array('action' => 'index'));?></li>
	</ul>
</div>
 *
 */ ?>