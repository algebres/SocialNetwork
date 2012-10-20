<?php
class MessagesController extends AppController {

	var $name = 'Messages';
        var $uses = array('User', 'Image', 'Post', 'Comment', 'Message', 'Friend');

        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allowedActions = array('view', 'send', 'addfriend');
            //$this->Auth->allow(array('*'));
        }


/**
 *
 * @param <type> $id requestor id
 * @param <type> $choice
 */
        function addfriend ($id, $choice=0) {
            $this->checkSignIn();

            if ($id && is_numeric($id)) {
                $userId = $this->Session->read('Auth.User.id');

                if ($id != $userId) {
                    if ($choice >= 1) {
                        // accept friend request

                        $query = "DELETE FROM messages WHERE (user_id = " . $userId . " OR object_id = " . $userId . ") AND master_id = " . $id . " AND text LIKE '%Friend Request:%' LIMIT 1;";
                        $this->Message->Query($query);

                        $friends["Friend"]["user1_id"] = $id;
                        $friends["Friend"]["user2_id"] = $userId;
                        
                        $this->Friend->create();
                        $this->Friend->save($friends);

                        $this->redirect($_SERVER['HTTP_REFERER']);
                    }
                    else if ($choice == 0) {
                        // request to add as friend

                        $a = $this->Message->find(
                                    'first',
                                    array(
                                        'fields' => array(
                                                    'Message.id'
                                                    ),
                                        'order' => 'Message.id DESC'
                                    )
                                );
                        if ($a) { $newMsgId = $a["Message"]["id"] + 1; }
                        else { $newMsgId = 1; }
                        
                        $options = array();
                        $options["Message"]["user_id"]  = $userId;
                        $options["Message"]["object_id"]= $id;
                        $options["Message"]["master_id"]= $userId;  // requestor id
                        $text = "Friend Request: <a href='/messages/addfriend/" . $userId ."/" . $newMsgId . "'>Accept</a> or <a href='/messages/addfriend/" . $userId ."/r'>Reject</a>";
                        $options["Message"]["text"]     = addslashes($text);

                        $this->_sendMsg($options);
                        
                        $this->redirect($_SERVER['HTTP_REFERER']);
                    }
                    else {
                        $query = "DELETE FROM messages WHERE (user_id = " . $userId . " OR object_id = " . $userId . ") AND master_id = " . $id . " AND text LIKE '%Friend Request:%' LIMIT 1;";
                        $this->Message->Query($query);

                        $this->redirect($_SERVER['HTTP_REFERER']);
                    }
                    
                }
            }
        }


        function send () {
            $this->checkSignIn();

            $isPost = isset($this->data) ? TRUE : FALSE;

            if ($isPost) {
//debug($this->data);die;
                $this->Message->create();
                $this->Message->save($this->data);

                $message = "Message sent.";
                $this->Session->setFlash(
                    __($message, TRUE),
                    "default",
                    array("class" => "flash ui-state-highlight")
                );
            }
            $this->redirect($_SERVER['HTTP_REFERER']);
        }


        function _sendMsg ($options=array()) {
            $this->Message->create();
            $this->Message->save($options);
        }
}
?>