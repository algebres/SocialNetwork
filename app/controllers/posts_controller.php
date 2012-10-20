<?php
class PostsController extends AppController {

    var $name = 'Posts';
    var $uses = array('Post');

    function beforeFilter () {
        parent::beforeFilter();
        $this->Auth->allowedActions = array('add', 'delete');
    }


    function add () {
        $this->checkSignIn();

        $userId = $this->Session->read('Auth.User.id');

        $isPost = isset($this->data) ? TRUE : FALSE;

        if ($isPost) {
            // add to wall
            $this->_postToWall($this->data["Post"]["text"], $userId);
        }

        $this->redirect($_SERVER['HTTP_REFERER']);
    }


    function _postToWall ($msg, $userId) {
        $query = "INSERT INTO posts "
                . "SET text = '" . addslashes($msg). "', "
                    . "user_id = " . $userId . ", "
                    . "created = NOW(), "
                    . "modified = NOW();";
        $this->Post->Query($query);
    }


    function delete ($id) {
        $this->checkSignIn();

        $query = "UPDATE posts "
                . "SET status = " . DELETED . " "
                . "WHERE id = " . $id . " "
                . "LIMIT 1;";
        $this->Post->Query($query);

        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
?>