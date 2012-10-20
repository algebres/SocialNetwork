<div id="headline">
    <h2>Photo Albums</h2>
    <div class="nav">
        <ul>
            <li><a href="/albums"><img src="/img/album.png" alt="">&nbsp;Browse albums</a></li>
            <li><a href="/albums/add"><img src="/img/album-new.png" alt="">&nbsp;Add new album</a></li>
            <li><a href="/albums/delete/<?php echo $albumId; ?>" onclick="return confirm('Are you sure you want to delete this album?')"><img src="/img/album-delete.png" alt="">&nbsp;Delete this album</a></li>
            <li><a href="JavaScript:void(0);" onclick="toggleUpload();"><img src="/img/photo-new.png" alt="">&nbsp;Upload new photo</a></li>
        </ul>
    </div>
    <div class="search-a" style="display:none;">
        <img src="/img/search.png" alt="">
        <input type="text" value="">
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div id="upload-box">
    <?php echo $this->Form->create('Image', array('id' => 'ImageAddForm', 'action' => 'add', 'type' => 'file', 'url' => '/images/add/' . $albumId)); ?>

    <h3>Image upload</h3>

    <?php echo $this->Session->flash(); ?>

    <?php echo $this->Form->input('Image.file.0', array('label'=>false, 'type'=>'file')); ?>

    <?php echo $this->Form->input('Image.file.1', array('label'=>false, 'type'=>'file')); ?>

    <?php echo $this->Form->input('Image.file.2', array('label'=>false, 'type'=>'file')); ?>

    <?php echo $this->Form->input('Image.file.3', array('label'=>false, 'type'=>'file')); ?>

    <?php echo $this->Form->input('Image.file.4', array('label'=>false, 'type'=>'file')); ?>

    <?php echo $this->Form->submit('Upload'); ?>

    <?php echo $this->Form->end(); ?>

    <div style="clear:both"></div>
</div>


<div class="images album">
    <?php if (count($images) > 0) : ?>
    <ul class="thumbs">
        <?php foreach ($images as $image) : ?>
        <li>
            <a class="thumb-a" href="/images/view/<?php echo $image['Image']['id']; ?>">
                <span style='background-image: url("<?php echo "/" . $image['Image']['path'] . $image['Image']['id'] . '_a.png'; ?>");'></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <div style="clear:both"></div>
</div>