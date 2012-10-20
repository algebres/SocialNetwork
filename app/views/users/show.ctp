<div class="users members">

<h2>Browse Members</h2>

<?php if (count($users) > 0) : ?>
<ul class="thumbs">
    <?php for ($i=0; $i<count($users); $i++) : ?>
    <li>
        <a class="thumb-a" href="/users/profile/<?php echo $users[$i]["User"]["username"]; ?>">
            <span style="background-image: url('/img/users/<?php echo $users[$i]["User"]["id"]; ?>/<?php echo $users[$i]["User"]["id"]; ?>_a.png');"></span>
        </a>
        <p class="thumb-info">
            <span class="title-a"><a href="/users/profile/<?php echo $users[$i]["User"]["username"]; ?>"><?php echo $users[$i]["User"]["name"]; ?></a></span>
            <span class="join">joined at <?php echo date("F j Y", strtotime($users[$i]["User"]["created"])); ?></span>
        </p>
    </li>
    <?php endfor; ?>
</ul>
<?php endif; ?>

</div>