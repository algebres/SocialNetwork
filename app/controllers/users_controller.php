<?php
class UsersController extends AppController {

	var $name = 'Users';
        //var $components = array('Email');
        //var $helpers    = array('Html', 'Form', 'Session');
        var $uses = array('User', 'Image', 'Post', 'Comment', 'Message', 'Friend', 'Album');

        
        function beforeFilter () {
            parent::beforeFilter();
            $this->Auth->allowedActions = array('profile', 'view', 'register', 'verify', 'logout', 'forgot_password', 'reset_password', 'show', 'contact', 'search', 'friends', 'display', 'updates', 'privacy');
        }

        
        function privacy () {
            
        }


        function updates ($username=null) {
            if ($username == null) {
                if (is_array($this->Session->read('Auth.User'))) {
                    $username = $this->Session->read('Auth.User.username');
                }
                else {
                    // error
                    $message = "Please login to view your profile.";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );

                    $this->redirect('/users/login');
                }
            }

            $user = $this->User->findByUsername($username);
            $userId = $this->Session->read('Auth.User.id');

            if ($user != FALSE) {
                if ($this->Session->read('Auth.User.username') != $user['User']['id']) {
                    $this->increaseView($user['User']['id']);
                }

                $user['User']['profile_pic'] = "/img/users/" . $user['User']['id'] . "/" . $user['User']['id'] . '_l.png';
//
                $results = $this->Friend->find(
                        'all',
                        array(
                            'fields' => array(
                                'Friend.user1_id',
                                'Friend.user2_id',
                                'Friend.created'
                                ),
                            'conditions' => array(
                                'OR' => array(
                                    'Friend.user1_id' => $user['User']['id'],
                                    'Friend.user2_id' => $user['User']['id']
                                )
                            )
                        )
                    );

                $posts = array();

                if (count($results) > 0) {
                    $tmp = array();
                    $tmp[] = "Post.user_id = " . $user['User']['id'];
                    
                    for ($i=0; $i<count($results); $i++) {
                        $tmp[] = ($results[$i]['Friend']['user1_id'] == $user['User']['id'])
                                ? "Post.user_id = " . $results[$i]['Friend']['user2_id']
                                : "Post.user_id = " . $results[$i]['Friend']['user1_id'];

                    }

                    $ids = implode(" OR ", $tmp);

                    $query = "SELECT `User`.`username`, `User`.`name`, `Post`.`id`, `Post`.`user_id`, `Post`.`text`, `Post`.`status`, `Post`.`created` "
                        . "FROM `posts` AS `Post` "
                        . "LEFT JOIN users AS `User` ON (`User`.`id` = `Post`.`user_id`) "
                        . "WHERE (" . $ids . ") "
                        . "AND `Post`.`status` = 1 "
                        . "ORDER BY `Post`.`created` DESC;";
                    $posts = $this->Post->Query($query);
                }


                $friends = $this->Friend->find(
                        'all',
                        array(
                            'fields' => array(
                                'Friend.user1_id',
                                'Friend.user2_id',
                                'Friend.created'
                                ),
                            'conditions' => array(
                                'OR' => array(
                                    'Friend.user1_id' => $userId,
                                    'Friend.user2_id' => $userId
                                )
                            )
                        )
                    );
                

                $comments = array();
                if (count($posts) > 0) {
                    for ($i=0; $i<count($posts); $i++) {
                        $results = $this->Comment->find(
                                    'all',
                                    array(
                                        'fields' => array(
                                            'Comment.id',
                                            'Comment.text',
                                            'Comment.user_id',
                                            'Comment.type',
                                            'Comment.parent_id',
                                            'Comment.status',
                                            'Comment.created',
                                            'User.id',
                                            'User.name',
                                            'User.username'
                                        ),
                                        'conditions' => array(
                                            'Comment.type' => POST,
                                            'Comment.parent_id' => $posts[$i]['Post']['id'],
                                            'Comment.status' => ENABLED
                                        ),
                                        'joins' => array(
                                            array(
                                                'alias' => 'User',
                                                'table' => 'users',
                                                'type' => 'LEFT',
                                                'conditions' => '`User`.`id` = `Comment`.`user_id`'
                                            )
                                        ),
                                        //'order' => 'Comment.created DESC'
                                    )
                                );
                        $comments[$posts[$i]['Post']['id']] = $results;
                    }
                }

                $this->set('loggedInUserId', $userId);
                $this->set('user', $user);
                $this->set('friends', $friends);
                $this->set('posts', $posts);
                $this->set('comments', $comments);
            }
            else {
                // error
            }
        }


        function display () {
            //get all users
            $users = $this->User->find(
                        'all',
                        array(
                            'fields' => array('User.id'),
                            'conditions' => array('User.status'=>USER_STATUS_ENABLED),
                            'order'=> 'User.id DESC'
                        )
                    );

            $members = $this->User->find('count');
            $posts = $this->Post->find('count');
            $albums = $this->Album->find('count');
            $images = $this->Image->find('count');

            $this->set('users', $users);
            $this->set('members', $members);
            $this->set('posts', $posts);
            $this->set('albums', $albums);
            $this->set('images', $images);
        }


        function friends ($id) {
            if ($id && is_numeric($id)) {
                // find friends
                $results = $this->Friend->find(
                        'all',
                        array(
                            'fields' => array(
                                'Friend.user1_id',
                                'Friend.user2_id',
                                'Friend.created'
                                ),
                            'conditions' => array(
                                'OR' => array(
                                    'Friend.user1_id' => $id,
                                    'Friend.user2_id' => $id
                                )
                            )
                        )
                    );

                $users = array();

                if (count($results) > 0) {
                    $tmp = array();
                    for ($i=0; $i<count($results); $i++) {
                        $tmp[] = ($results[$i]['Friend']['user1_id'] == $id)
                                ? "id = " . $results[$i]['Friend']['user2_id']
                                : "id = " . $results[$i]['Friend']['user1_id'];

                    }

                    $ids = implode(" OR ", $tmp);

                    $query = "SELECT id, username, name, created FROM users as User WHERE " . $ids . ";";
                    $users = $this->User->Query($query);
                }
                

                $owner = $this->User->findById($id);
                
                $this->set('users', $users);
                $this->set('owner', $owner);
            }
            else {
                $message = "invalid id.";
                $this->Session->setFlash(
                    __($message, TRUE),
                    "default",
                    array("class" => "flash ui-state-error")
                );
            }
        }

        
        function search () {
            if (isset($_GET['kw'])) {
                if (empty($_GET['kw'])) {
                    // error
                    $this->redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $keyword = addslashes($_GET['kw']);

                    $users = $this->User->find(
                        'all',
                        array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.name',
                                'User.created'
                                ),
                            'conditions' => array(
                                'OR' => array(
                                    'User.username LIKE' => "%" . $keyword . "%",
                                    'User.name LIKE' => "%" . $keyword . "%"
                                ),
                                'AND' => array(
                                    'User.status'  => USER_STATUS_ENABLED
                                )
                            ),
                            'order' => 'User.username'
                            )
                    );

                    $this->set('users', $users);
                    
                    //$users = $this->User->findAll("name LIKE '%" . $keyword . "%' OR username LIKE '%" . $keyword . "%'");
                    //debug($users);die;
                }
            } else {
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }


        function _getUseInfo ($id) {
            $user = $this->User->find(
                    'first',
                    array(
                        'fields' => array(
                                    'User.id',
                                    'User.username',
                                    'User.name',
                                    'User.created'
                                    ),
                        'conditions' => array(
                                    'User.id' => $id,
                                    'User.status'  => USER_STATUS_ENABLED
                                ),
                        )
                    );

            return $user;
        }

        function contact () {
            $isPost = isset($this->data) ? TRUE : FALSE;

            if ($isPost) {
                if (empty($this->data["User"]["name"]) || empty($this->data["User"]["body"])) {
                    $message = "All info are required.";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );
                }
                else if (!filter_var($this->data["User"]["email"], FILTER_VALIDATE_EMAIL)) {
                    $message = "Invalid email address.";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );
                }
                else {
                    //$this->Email->from      = $this->data["User"]["name"] . ' <' . $this->data["User"]["email"] . '>';
                    $this->Email->to        = SITE_NAME . ' <' . MAIL_INFO . '>';
                    $this->Email->subject   = SITE_NAME . ': Contact Us';

                    $body = $this->data["User"]["name"] . ' <' . $this->data["User"]["email"] . '>' . "\n" . $this->data["User"]["body"];

                    if ($this->Email->send($body)) {
                        $this->data = false;

                        $message = "Thank you for contacting us.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-highlight")
                        );
                    }
                    else {
                        $message = "Email cannot send out. Try again later.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                }
            }
        }

        
        function show () {
            $users = $this->User->find(
                    'all',
                    array(
                        'fields' => array(
                                    'User.id',
                                    'User.username',
                                    'User.name',
                                    'User.created'
                                    ),
                        'conditions' => array(
                                    'User.status'  => USER_STATUS_ENABLED
                                ),
                        'order' => 'User.created DESC'
                        )
                    );
            $this->set('users', $users);
        }

        
        function increaseView ($userId) {
            $query = "UPDATE users SET hits = hits + 1 WHERE id = " . $userId . " LIMIT 1;";
            $this->User->query($query);
        }


        function profile ($username=null) {
            if ($username == null) {
                if (is_array($this->Session->read('Auth.User'))) {
                    $username = $this->Session->read('Auth.User.username');
                }
                else {
                    // error
                    $message = "Please login to view your profile.";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );
                    
                    $this->redirect('/users/login');
                }                
            }

            $user = $this->User->findByUsername($username);
            $userId = $this->Session->read('Auth.User.id');

            if ($user != FALSE) {
                if ($this->Session->read('Auth.User.username') != $user['User']['id']) {
                    $this->increaseView($user['User']['id']);
                }
                
                $user['User']['profile_pic'] = "/img/users/" . $user['User']['id'] . "/" . $user['User']['id'] . '_l.png';

                // posts
                $posts = $this->Post->find(
                            'all',
                            array(
                                'fields' => array(
                                    'User.username',
                                    'User.name',
                                    'Post.id',
                                    'Post.user_id',
                                    'Post.text',
                                    'Post.status',
                                    'Post.created'
                                    ),
                                'conditions' => array(
                                    'Post.user_id' => $user['User']['id'],
                                    'Post.status'  => ENABLED
                                ),
                                'joins' => array(
                                    array(
                                        'alias' => 'User',
                                        'table' => 'users',
                                        'type' => 'LEFT',
                                        'conditions' => '`User`.`id` = `Post`.`user_id`'
                                    )
                                ),
                                'order' => 'Post.created DESC',
                            )
                        );

                $comments = array();
                if (count($posts) > 0) {
                    for ($i=0; $i<count($posts); $i++) {
                        $results = $this->Comment->find(
                                    'all',
                                    array(
                                        'fields' => array(
                                            'Comment.id',
                                            'Comment.text',
                                            'Comment.user_id',
                                            'Comment.type',
                                            'Comment.parent_id',
                                            'Comment.status',
                                            'Comment.created',
                                            'User.id',
                                            'User.name',
                                            'User.username'
                                        ),
                                        'conditions' => array(
                                            'Comment.type' => POST,
                                            'Comment.parent_id' => $posts[$i]['Post']['id'],
                                            'Comment.status' => ENABLED
                                        ),
                                        'joins' => array(
                                            array(
                                                'alias' => 'User',
                                                'table' => 'users',
                                                'type' => 'LEFT',
                                                'conditions' => '`User`.`id` = `Comment`.`user_id`'
                                            )
                                        ),
                                        //'order' => 'Comment.created DESC'
                                    )
                                );
                        $comments[$posts[$i]['Post']['id']] = $results;
                    }
                }

                // messages
                $results = $this->Message->find(
                    'all',
                    array(
                        'fields' => array(
                            'Message.id',
                            'Message.user_id',
                            'Message.object_id',
                            'Message.text',
                            'Message.created'
                        ),
                        'conditions' => array(
                            'OR' => array(
                                'Message.user_id' => $user['User']['id'],
                                'Message.object_id' => $user['User']['id']
                            ),
                            'OR' => array(
                                'Message.master_id' => 0,
                                'Message.master_id !=' => $user['User']['id'],
                            ),
                            'AND' => array(
                                'Message.status' => ENABLED
                            )
                        ),
                        'order' => 'Message.created'
                    )
                );

                $messages = array();
                $users = array();
                if (count($results) > 0) {
                    for ($i=0; $i<count($results); $i++) {
                        $results[$i]['Message']['text'] = stripslashes($results[$i]['Message']['text']);
                        if ($results[$i]['Message']['user_id'] == $user['User']['id']) {
                            if (!array_key_exists($results[$i]['Message']['object_id'], $users)) {
                                $tmp = $this->_getUseInfo($results[$i]['Message']['object_id']);
                                $users[$results[$i]['Message']['object_id']] = $tmp['User'];
                            }
                            $messages[$results[$i]['Message']['object_id']][] = $results[$i];
                        } else if ($results[$i]['Message']['object_id'] == $user['User']['id']) {
                            if (!array_key_exists($results[$i]['Message']['user_id'], $users)) {
                                $tmp = $this->_getUseInfo($results[$i]['Message']['user_id']);
                                $users[$results[$i]['Message']['user_id']] = $tmp['User'];
                            }
                            $messages[$results[$i]['Message']['user_id']][] = $results[$i];
                        }
                    }
                }

                // friends
                $friends = $this->Friend->find(
                        'all',
                        array(
                            'fields' => array(
                                'Friend.user1_id',
                                'Friend.user2_id',
                                'Friend.created'
                                ),
                            'conditions' => array(
                                'OR' => array(
                                    'Friend.user1_id' => $userId,
                                    'Friend.user2_id' => $userId
                                )
                            )
                        )
                    );

                // tab
                if (isset($this->params['named']['tab'])) {
                    $showTab = $this->params['named']['tab'];
                } else {
                    $showTab = "wall";
                }

                $this->set('showTab', $showTab);
                $this->set('loggedInUserId', $userId);
                $this->set('user', $user);
                $this->set('users', $users);
                $this->set('posts', $posts);
                $this->set('friends', $friends);
                $this->set('messages', $messages);
                $this->set('comments', $comments);
            }
            else {
                // error
            }
            
        }


        function reset_password ($id, $resetCode) {
            $query = "SELECT id, email, name, last_login_time "
                    . "FROM users "
                    . "WHERE id = " . $id . " "
                    . "LIMIT 1;";
            $user = $this->User->query($query);

            if($user != FALSE) {
                if ($resetCode == $this->User->generateResetCode($user[0]["users"]["id"], $user[0]["users"]["last_login_time"])) {
                    $newPassword = $this->User->createRandomPassword();
                    $newEncryptedPassword = $this->Auth->password($newPassword);
                    $loginLink = "http://" . $_SERVER["HTTP_HOST"] . "/users/login";

                    $query = "UPDATE users "
                            . "SET password = '" . $newEncryptedPassword . "' "
                            . "WHERE id = " . $id . " "
                            . "LIMIT 1;";
                    $this->User->query($query);

                    // email new password to user
                    $this->Email->to        = $user[0]["users"]["name"] . ' <' . $user[0]["users"]["email"] . '>';
                    //$this->Email->bcc     = array('secret@example.com');
                    $this->Email->subject   = SITE_NAME . ': Reset Password';
                    $this->Email->template  = 'reset';

                    $this->set("user", $user[0]["users"]);
                    $this->set("newPassword", $newPassword);
                    $this->set("loginLink", $loginLink);

                    $this->data = FALSE;

                    if (!$this->Email->send()) {
                        // Handle send failure
                        $message = "For some reasons, the email does not go out.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                    else {
                        $message = "Your password has been successfully reset and new password has been emailed to you.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-highlight")
                        );
                    }
                }
            }
            else {
                $message = "Invalid link to reset password.";
                $this->Session->setFlash(
                    __($message, TRUE),
                    "default",
                    array("class" => "flash ui-state-error")
                );
            }
        }

        
        function forgot_password () {
            $this->User->unbindValidation('remove', array('email', 'username', 'password', 'name', 'sex', 'dob'), true);

            $isPost = isset($this->data) ? TRUE : FALSE;

            if ($isPost) {
                if (!filter_var($this->data["User"]["email"], FILTER_VALIDATE_EMAIL)) {
                    $message = "Invalid email address.";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );
                }
                else {
                    $query = "SELECT id, name, email, last_login_time "
                            . "FROM users "
                            . "WHERE email = '" . $this->data["User"]["email"] . "' "
                            . "LIMIT 1;";
                    $user = $this->User->query($query);

                    if ($user != FALSE) {
                        $resetLink = $this->User->generateResetLink($user[0]["users"]["id"], $user[0]["users"]["last_login_time"]);

                        // send reset link
                        $this->Email->to        = $user[0]["users"]["name"] . ' <' . $user[0]["users"]["email"] . '>';
                        //$this->Email->bcc     = array('secret@example.com');
                        $this->Email->subject   = SITE_NAME . ': Forgot Password';
                        $this->Email->template  = 'forgot';

                        $this->set("user", $user[0]["users"]);
                        $this->set("resetLink", $resetLink);

                        $this->data = FALSE;

                        if (!$this->Email->send()) {
                            // Handle send failure
                            $message = "For some reasons, the email does not go out.";
                            $this->Session->setFlash(
                                __($message, TRUE),
                                "default",
                                array("class" => "flash ui-state-error")
                            );
                        }
                        else {
                            $message = "A link to reset your password has been emailed to you.";
                            $this->Session->setFlash(
                                __($message, TRUE),
                                "default",
                                array("class" => "flash ui-state-highlight")
                            );
                        }
                    }
                    else {
                        $message = "Email does not exist.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                    
                }
            }
        }


        function verify ($userId, $code) {
            $query = "SELECT id, status, modified "
                    . "FROM users "
                    . "WHERE id = " . $userId . " "
                    . "LIMIT 1;";
            $user = $this->User->Query($query);

            if ($user != FALSE) {
                $verificationCode = $this->User->generateVerificationCode($userId, $user[0]["users"]["modified"]);
                if ($user[0]["users"]["status"] == USER_STATUS_ENABLED) {
                    // user already verified
                    $message = "User already verified";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );
                }
                else if ($verificationCode != $code) {
                    // invalid verification code
                    $message = "Wrong verification code";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );
                }
                else {
                    $query = "UPDATE users "
                            . "SET status = " . USER_STATUS_ENABLED . " "
                            . "WHERE id = " . $userId . " "
                            . "LIMIT 1;";
                    $this->User->Query($query);

                    $message = "Thank you for your time to verify the account. Please proceed to login.";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-highlight")
                    );
                }
                
            }
            else {
                // invalid user
                $message = "Invalid User";
                $this->Session->setFlash(
                    __($message, TRUE),
                    "default",
                    array("class" => "flash ui-state-error")
                );
            }
        }

        function register () {
            $this->User->unbindValidation('remove', array('email', 'username', 'password', 'name', 'sex', 'dob'), true);
            
            $isPost = isset($this->data) ? TRUE : FALSE;

            if ($isPost) {
                $query = "SELECT    username,
                                    email
                            FROM    users
                            WHERE   email = '" . $this->data["User"]["email"] . "'
                            OR      username = '" . $this->data["User"]["username"] . "'
                            LIMIT 1;";
                $users = $this->User->Query($query);

                if ($users != FALSE) {
                    $this->data["User"]["password"] = FALSE;
                    
                    if ($users[0]["users"]["username"] == $this->data["User"]["username"]) {
                        // has existing user
                        $message = "Username `" . $this->data["User"]["username"] ."` is not available. Please choose another.";
                        
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                    else if ($users[0]["users"]["email"] == $this->data["User"]["email"]) {
                        $message = "Email address is already registered.";

                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                }
                else {
                    if (strlen($this->data["User"]["name"]) < 3 || strlen($this->data["User"]["name"]) > 20) {
                        $this->data["User"]["password"] = FALSE;
                        $message = "Name should consist of alpha-numeric, and has within 3 to 20 characters.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                    else if (!preg_match('/^[a-z\d_]{3,20}$/i', $this->data["User"]["username"])) {
                        $this->data["User"]["password"] = FALSE;
                        $message = "Username should consist of alpha-numeric, and has within 3 to 20 characters.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                    else if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $this->data["User"]["email"])) {
                        $this->data["User"]["password"] = FALSE;
                        $message = "Invalid email address.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                    else if ($this->data["User"]["email"] != $this->data["User"]["email2"]) {
                        $this->data["User"]["password"] = FALSE;
                        $message = "Email check does not match.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                    else if (strlen($this->data["User"]["password"]) == 0) {
                        $this->data["User"]["password"] = FALSE;
                        $message = "Password is required.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                    else if (!in_array($this->data["User"]["sex"], array(0, 1))) {
                        $this->data["User"]["password"] = FALSE;
                        $message = "Gender is required.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                    else {
                        // save new user
                        $currentDt = date("Y-m-d H:i:s");
                        $defaults = array(
                                    "status"        => USER_STATUS_DISABLED,
                                    "group_id"      => ROLE_USER,
                                    "last_login_ip" => getClientIP(),
                                    "created"       => $currentDt,
                                    "modified"      => $currentDt
                        );

                        $this->data["User"] = array_merge($this->data["User"], $defaults);

                        $this->User->save($this->data["User"]);
                        $userId = $this->User->getLastInsertId();

                        // create default profile images
                        if ($this->data["User"]["sex"] == 0) { // female
                            $thisImage = "user_female";
                        } else { // male
                            $thisImage = "user_male";
                        }

                        $folder_url = WWW_ROOT . 'img/users/' . $userId;

                        if(!is_dir($folder_url)) {
                            mkdir($folder_url);
                        }
                        
                        $command = "cp " . WWW_ROOT . "img/" . $thisImage . "_l.png " . $folder_url . "/" . $userId . "_l.png";
                        exec($command);

                        $command = "cp " . WWW_ROOT . "img/" . $thisImage . "_a.png " . $folder_url . "/" . $userId . "_a.png";
                        exec($command);
                        
                        $command = "cp " . WWW_ROOT . "img/" . $thisImage . "_p.png " . $folder_url . "/" . $userId . "_p.png";
                        exec($command);


                        // generate verification link
                        $verificationCode = $this->User->generateVerifyLink($userId, $currentDt);

                        
                        // send verification link
                        $this->Email->to        = $this->data["User"]["name"] . ' <' . $this->data["User"]['email'] . '>';
                        //$this->Email->bcc     = array('secret@example.com');
                        $this->Email->subject   = 'Welcome to our social network';
                        $this->Email->template  = 'register';

                        $this->set("user", $this->data);
                        $this->set("verifyLink", $verificationCode);

                        $this->data = FALSE;
                        
                        if (!$this->Email->send()) {
                            // Handle send failure
                            $message = "For some reasons, the email does not go out.";
                            $this->Session->setFlash(
                                __($message, TRUE),
                                "default",
                                array("class" => "flash ui-state-error")
                            );
                        }
                        else {
                            $message = "Registration is success! Please check your email for the verification link.";
                            $this->Session->setFlash(
                                __($message, TRUE),
                                "default",
                                array("class" => "flash ui-state-highlight")
                            );
                        }
                        
                    }
                }
            }
        }


        function login () {
            if ($this->Session->read('Auth.User')) {
                $this->User->id = $this->Session->read('Auth.User.id');
                
                $this->User->saveField('last_login_ip', getClientIP());
                $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));

                //$this->Session->setFlash('You are logged in!');
                $this->redirect('/users/profile', null, false);
            }
        }


        function logout () {
            //$this->Session->setFlash('Good-Bye');
            $this->redirect($this->Auth->logout());
        }


	function index () {
            $this->User->recursive = 0;
            $this->set('users', $this->paginate());
	}


	function view ($id = null) {
            if (!$id) {
                    $this->Session->setFlash(__('Invalid user', true));
                    $this->redirect(array('action' => 'index'));
            }
            $this->set('user', $this->User->read(null, $id));
	}


	function add () {
            if (!empty($this->data)) {
                $this->User->create();
                if ($this->User->save($this->data)) {
                    $this->Session->setFlash(__('The user has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
                }
            }
            $groups = $this->User->Group->find('list');
            $this->set(compact('groups'));
	}

        
	function edit ($id = null) {
            if (!$id && empty($this->data)) {
                $this->Session->setFlash(__('Invalid user', true));
                $this->redirect(array('action' => 'index'));
            }
            if (!empty($this->data)) {
                $this->data["User"]["id"] = $id;
                if (isset($this->data["User"]["opassword"])) {
                    $user = $this->User->findById($id);
                    if ($user["User"]["password"] == $this->Auth->password($this->data["User"]["opassword"])) {
                        if ($this->data["User"]["npassword"] == $this->data["User"]["cpassword"]) {
                            $err = 0;

                            $update["User"]["id"] = $id;
                            $update["User"]["password"] = $this->Auth->password($this->data["User"]["npassword"]);
                            $this->User->save($update);

                            $message = "new password has been saved";
                            $this->Session->setFlash(
                                __($message, TRUE),
                                "default",
                                array("class" => "flash ui-state-highlight")
                            );
                        }
                        else {
                            $message = "passwords do not match.";
                            $this->Session->setFlash(
                                __($message, TRUE),
                                "default",
                                array("class" => "flash ui-state-error")
                            );
                        }
                    }
                    else {
                        $message = "Incorrect password.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                }
                else {
                    if ($this->User->save($this->data)) {
                        $message = "The user has been saved";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-highlight")
                        );
                        //$this->redirect(array('action' => 'index'));
                    } else {
                        $message = "The user could not be saved. Please, try again.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                        //$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
                    }
                }
            }
            if (empty($this->data)) {
                $this->data = $this->User->read(null, $id);
            }
            $groups = $this->User->Group->find('list');
            $this->set(compact('groups'));
	}


	function delete ($id = null) {
            if (!$id) {
                $this->Session->setFlash(__('Invalid id for user', true));
                $this->redirect(array('action'=>'index'));
            }
            if ($this->User->delete($id)) {
                $this->Session->setFlash(__('User deleted', true));
                $this->redirect(array('action'=>'index'));
            }
            $this->Session->setFlash(__('User was not deleted', true));
            $this->redirect(array('action' => 'index'));
	}


	function admin_index () {
            $this->User->recursive = 0;
            $this->set('users', $this->paginate());
	}


	function admin_view($id = null) {
            if (!$id) {
                $this->Session->setFlash(__('Invalid user', true));
                $this->redirect(array('action' => 'index'));
            }
            $this->set('user', $this->User->read(null, $id));
	}


	function admin_add() {
            if (!empty($this->data)) {
                $this->User->create();
                if ($this->User->save($this->data)) {
                    $this->Session->setFlash(__('The user has been saved', true));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
                }
            }
            $groups = $this->User->Group->find('list');
            $this->set(compact('groups'));
	}


	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}


	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

        
function initDB() {
    $group =& $this->User->Group;
    //Allow admins to everything
    $group->id = 1;
    $this->Acl->allow($group, 'controllers');

    //allow managers to posts and widgets
    $group->id = 2;
    $this->Acl->allow($group, 'controllers');
    //$this->Acl->deny($group, 'controllers');
    //$this->Acl->allow($group, 'controllers/Posts');
    //$this->Acl->allow($group, 'controllers/Widgets');

    //allow users to only add and edit on posts and widgets
    $group->id = 3;
    $this->Acl->deny($group, 'controllers');
    $this->Acl->allow($group, 'controllers/Users/edit');
    $this->Acl->allow($group, 'controllers/Albums');
    $this->Acl->allow($group, 'controllers/Images');
    //we add an exit to avoid an ugly "missing views" error message
    echo "all done";
    exit;
}

}
?>