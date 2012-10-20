<div id="headline">
    <h2>Photo Albums</h2>
    <div class="nav">
        <ul>
            <li><?php echo count($albums); ?> albums found.</li>
        </ul>
    </div>
    <div class="search-a">
        <form method="get" action="/albums/search" id="f-search">
            <img src="/img/search.png" alt="">
            <input type="text" name="kw">
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
                    <?php if ($album['Album']['user_id'] == $this->Session->read('Auth.User.id')) : ?>
                    <a onclick="return confirm('Are you sure?')" href="/images/del/<?php echo $album['Album']['id']; ?>/0/1" style="float:right;">
                        <img src="/img/bin_closed.png" alt="delete">
                    </a>
                    <?php endif; ?>
                </span>
                <span class="owner-a">By <?php echo $album['User']['name']; ?></span>
                <span class="total-a">[<?php echo $album['Album']['images']; ?> photos]</span>
            </p>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>