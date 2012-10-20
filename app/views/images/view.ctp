<div id="headline">
    <h2>Photo Albums >></h2>
    <div class="nav">
        <ul>
            <li><a href="/images/album/<?php echo $image[0]['Album']['id']; ?>"><?php echo $image[0]['Album']['name']; ?></a></li>
        </ul>
    </div>
    <div class="search-a">
        <img src="/img/search.png" alt="">
        <input type="text" value="">
    </div>
</div>

<?php echo $this->Session->flash(); ?>

<div class="image view">
    <div id="image-view">
        <img alt="<?php echo $image[0]['Image']['name']; ?>" src="<?php echo "/" . $image[0]['Image']['path'] . $image[0]['Image']['id'] . '_l.png'; ?>" />

        <div><?php echo $image[0]['Image']['name']; ?></div>

        <div style="margin:10px 0;">
            <span class="i">uploaded by</span>: <a href='/users/profile/<?php echo $user['User']['id']; ?>'><?php echo $user['User']['username']; ?></a>
            <a onclick="return confirm('Are you sure?')" href="/images/del/<?php echo $image[0]['Image']['id']; ?>/<?php echo $image[0]['Album']['id']; ?>" style="float:right;">
                <img src="/img/bin_closed.png" alt="delete">
            </a>
        </div>
        
        <div style="margin:10px 0;">
            <?php if (is_array($neighbors['prev'])) : ?>
            <a class="btn-nav-image left" href="/images/view/<?php echo $neighbors['prev']['Image']['id']; ?>">&laquo; prev</a>
            <?php endif; ?>
            <?php if (is_array($neighbors['next'])) : ?>
            <a class="btn-nav-image right" href="/images/view/<?php echo $neighbors['next']['Image']['id']; ?>">next &raquo;</a>
            <?php endif; ?>
            
            <div style="clear:both;"></div>
        </div>
    </div>

    <div style="clear:both;"></div>

    <div class="comments">
        <?php echo count($comments); ?> comments - <a href="javascript:void(0);" onclick="toggleCommentBox(<?php echo $image[0]['Image']['id']; ?>);">Post Comment</a>
        <?php if (count($comments) > 0) : ?>
        <ul>
        <?php for($i=0; $i<count($comments); $i++) : ?>
            <li>
                <div class="commenter-photo">
                    <a href="">
                        <img src="/img/users/<?php echo $comments[$i]["User"]["id"]; ?>/<?php echo $comments[$i]["User"]["id"]; ?>_p.png" alt="">
                    </a>
                </div>

                <div class="comment-info">
                    <span class="commenter">
                        <a href="#"><?php echo $comments[$i]["User"]["name"]; ?></a>
                    </span>

                    <?php echo $comments[$i]["Comment"]["text"]; ?>

                    <div class="comment-tools">
                        <ul>
                            <li><?php echo date("M j, H:i", strtotime($comments[$i]["Comment"]["created"])); ?></li>
                            <?php if ($loggedInUserId == $comments[$i]["User"]["id"]) : ?>
                            <li>
                                <span> - </span>
                                <a href="/comments/delete/<?php echo $comments[$i]["Comment"]["id"]; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </li>
        <?php endfor ; ?>
        </ul>
        <?php endif; ?>

        <div class="wrap-comment-<?php echo $image[0]['Image']['id']; ?> wrap-comments">
        <?php echo $this->Form->create('Comment', array('action' => 'add')); ?>
        <?php echo $this->Form->input('Comment.text', array('label'=>false, 'rows'=>2)); ?>
        <?php echo $this->Form->input('Comment.type', array('label'=>false, 'type'=>'hidden', 'value'=>IMAGE)); ?>
        <?php echo $this->Form->input('Comment.parentId', array('label'=>false, 'type'=>'hidden', 'value'=>$image[0]['Image']['id'])); ?>
        <?php echo $this->Form->submit('Post'); ?>
        <?php echo $this->Form->end(); ?>
        </div>
    </div>

</div>