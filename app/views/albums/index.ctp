<div id="headline">
    <h2>Photo Albums</h2>
    <div class="nav">
        <ul>
            <li><a href="/albums/add"><img src="/img/album-new.png" alt="">&nbsp;Add new album</a></li>
        </ul>
    </div>
    <div class="search-a">
        <form method="get" action="/albums/search" id="f-search">
            <img src="/img/search.png" alt="">
            <input type="text" name="kw" value="search album" onfocus="if ($(this).val() == 'search album') {$(this).val('');}">
        </form>
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="albums index">
    <?php if (count($albums) > 0) : ?>
    <ul class="thumbs">
        <?php foreach ($albums as $album) : ?>
        <li>
            <a class="thumb-a" href="/images/album/<?php echo $album['Album']['id']; ?>">
                <span style='background-image: url("<?php echo $album['Album']['cover']; ?>");'></span>
            </a>
            <p class="thumb-info">
                <span class="title-a">
                    <?php echo $album['Album']['name']; ?>
                    <a onclick="return confirm('Are you sure?')" href="/images/del/<?php echo $album['Album']['id']; ?>/0/1" style="float:right;">
                        <img src="/img/bin_closed.png" alt="delete">
                    </a>
                </span>
                <span class="owner-a">By <?php echo $album['Album']['username']; ?></span>
                <span class="total-a">[<?php echo $album['Album']['images']; ?> photos]</span>
            </p>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>

<?php /*
<div class="albums index">
	<h2><?php __('Albums');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($albums as $album):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $album['Album']['id']; ?>&nbsp;</td>
		<td><?php echo $album['Album']['name']; ?>&nbsp;</td>
		<td><?php echo $album['Album']['description']; ?>&nbsp;</td>
		<td><?php echo $album['Album']['user_id']; ?>&nbsp;</td>
		<td><?php echo $album['Album']['status']; ?>&nbsp;</td>
		<td><?php echo $album['Album']['created']; ?>&nbsp;</td>
		<td><?php echo $album['Album']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $album['Album']['id'], Inflector::slug($album['Album']['name']))); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $album['Album']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $album['Album']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $album['Album']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Album', true), array('action' => 'add')); ?></li>
	</ul>
</div>
 *
 */?>