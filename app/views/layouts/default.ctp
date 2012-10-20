<?php header('Content-type: text/html; charset=UTF-8') ;?>
<html>
    <head>
        <?php echo $html->charset('utf-8'); ?>
        <title>
            <?php __('SocialNetwork:'); ?>
            <?php echo $title_for_layout;?>
        </title>

        <link rel="icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon" />

        <?php echo $this->Html->css('default'); ?>
        <?php echo $this->Html->css('jquery-ui-1.8.5.custom'); ?>

	<?php //echo $this->Html->css('cake.generic');?>
        
        <?php echo $scripts_for_layout; ?>
        <?php echo $this->Html->script("jquery-1.4.2.min.js"); ?>
        <?php echo $this->Html->script("jquery-ui-1.8.5.custom.min.js"); ?>
        <?php echo $this->Html->script("default.js"); ?>
    </head>

    <body>
        <div id="main-header">
            <div class="layout-header">
                <div class="wrap-mini-menu">
                    <div id="mini-menu">
                        <ul>
                        <?php if ($this->Session->read('Auth.User')) : ?>
                            <li><a href="/users/profile/<?php echo $this->Session->read('Auth.User.username'); ?>"><?php echo $this->Session->read('Auth.User.name'); ?></a></li>
                            <li><a href="/users/profile/<?php echo $this->Session->read('Auth.User.username'); ?>/tab:msg">Message</a></li>
                            <li><a href="/users/logout">Log out</a></li>
                        <?php else : ?>
                            <li><a href="/users/login">Log In</a></li>
                            <li><a href="/users/register">Register</a></li>
                        <?php endif; ?>
                            <li>
                                <form method="get" action="/users/search" id="f-search">
                                    <input value="search user" type="text" alt="Search" maxlength="100" size="20" id="search" name="kw" class="text suggested" onfocus="if ($('#search').val() == 'search user') {$(this).val('');}">
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="layout-logo-main">
                    <a href="/"><?php echo SITE_NAME; ?></a>
                </div>
                <div class="layout-menu-main">
                    <ul class="navigation">
                    <?php if ($this->Session->read('Auth.User')) : ?>
                        <li>
                            <a href="/users/updates/<?php echo $this->Session->read('Auth.User.username'); ?>">Home</a>
                        </li>
                        <li>
                            <a href="/users/profile/<?php echo $this->Session->read('Auth.User.username'); ?>">Profile</a>
                        </li>
                        <li>
                            <a href="/users/friends/<?php echo $this->Session->read('Auth.User.id'); ?>">Friends</a>
                        </li>
                    <?php else : ?>
                        <li>
                            <a href="/">Home</a>
                        </li>
                    <?php endif; ?>
                        <li>
                            <a href="/users/show">Members</a>
                        </li>
                        <li>
                            <a href="/albums/index/<?php echo $this->Session->read('Auth.User') ? $this->Session->read('Auth.User.id') : 0 ; ?>">Albums</a>
                        </li>
                        <li>
                            <a href="/users/contact">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        
        <div id="main-container">
            <div id="main-content">
                <?php echo $content_for_layout;?>
            </div>
        </div>

        <div id="main-footer">
            <div id="main-footer-content">
                <div class="copyright">
                    Copyright &copy; <?php echo date("Y"); ?> &nbsp;-&nbsp;
                    <a href="/users/privacy">Privacy</a> &nbsp;-&nbsp;
                    <a href="/users/contact">Contact</a>
                    <span style="float:right;">page loaded in <?php echo round((getMicrotime() - $_SERVER["REQUEST_TIME"]) * 1000); ?> ms</span>
                </div>
            </div>
        </div>
    </body>
</html>
        
<?php //echo $this->Html->link(__('CakePHP: the rapid development php framework', true), 'http://cakephp.org');?>
<?php
/*
    echo $this->Html->link(
                                $this->Html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0")),
                                'http://www.cakephp.org/',
                                array('target'=>'_blank'), null, false
                        );
 * 
 */
?>