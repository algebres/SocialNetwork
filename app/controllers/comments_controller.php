<?php
class CommentsController extends AppController {

    var $name = 'Comments';
    var $uses = array('Comment');

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
            $this->_addComment($this->data["Comment"]["text"], $userId, $this->data["Comment"]["type"], $this->data["Comment"]["parentId"]);
        }

        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    
    function _addComment ($msg, $userId, $type=POST, $parentId=0) {
        $query = "INSERT INTO comments "
                . "SET text = '" . addslashes($msg) . "', "
                    . "user_id = " . $userId . ", "
                    . "type = " . $type . ", "
                    . "parent_id = " . $parentId . ", "
                    . "status = " . ENABLED . ", "
                    . "created = NOW(), "
                    . "modified = NOW();";
        $this->Comment->Query($query);
    }


    function delete ($id) {
        $this->checkSignIn();

        $query = "UPDATE comments "
                . "SET status = " . DELETED . " "
                . "WHERE id = " . $id . " "
                . "LIMIT 1;";
        $this->Comment->Query($query);

        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
?>