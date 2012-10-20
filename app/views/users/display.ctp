<?php echo $this->Session->flash(); ?>

<div class="user profile">
    <div class="layout-left">
        <?php echo $this->Form->create('User', array('action' => 'login')); ?>

        <?php echo $this->Form->input('User.username', array('label'=>'Username')); ?>

        <?php echo $this->Form->input('User.password', array('label'=>'Password')); ?>

        <?php echo $this->Form->submit('Login'); ?>

        <?php echo $this->Form->end(); ?>
    </div>

    <div class="layout-mid">
        <div class="home-banner"></div>

        <div>
            <ul class="home-user-pic">
                <?php for ($i=0; $i<count($users); $i++) : ?>
                <li><span style="background-image: url('/img/users/<?php echo $users[$i]["User"]["id"]; ?>/<?php echo $users[$i]["User"]["id"]; ?>_p.png');"></span></li>
                <?php endfor; ?>
            </ul>
        </div>

        <div style="clear:both;"></div>

        <div class="stats">
            <span class="big"><?php echo $members; ?></span> registered
        </div>
        <div class="stats">
            <span class="big"><?php echo count($users); ?></span> active users
        </div>
        <div class="stats">
            <span class="big"><?php echo $posts; ?></span> posts
        </div>
        <div class="stats">
            <span class="big"><?php echo $albums; ?></span> albums
        </div>
        <div class="stats">
            <span class="big"><?php echo $images; ?></span> uploaded images
        </div>
    </div>
</div>