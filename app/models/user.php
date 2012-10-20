<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'name';
	var $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			//'maxlength' => array(
			//	'rule' => array('maxlength'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		),
                'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'sex' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'dob' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

        var $actsAs = array('Acl' => array('type' => 'requester'));

        function parentNode() {
            if (!$this->id && empty($this->data)) {
                return null;
            }
            if (isset($this->data['User']['group_id'])) {
                $groupId = $this->data['User']['group_id'];
            } else {
                $groupId = $this->field('group_id');
            }
            if (!$groupId) {
                return null;
            } else {
                return array('Group' => array('id' => $groupId));
            }
        }


        function generateVerifyLink ($userId, $dateTime) {
            $code = md5($userId . "" . $dateTime);
            $codeLink = "http://" . $_SERVER["HTTP_HOST"] . "/users/verify/" . $userId . "/" . $code;

            return $codeLink;
        }

        function generateVerificationCode ($userId, $dateTime) {
            $code = md5($userId . "" . $dateTime);
            //$codeLink = "http://" . $_SERVER["HTTP_HOST"] . "/users/verify/" . $userId . "/" . $code;

            return $code;
        }

        function generateResetCode ($userId, $dateTime) {
            $code = md5($userId . "" . $dateTime);

            return $code;
        }

        function generateResetLink ($userId, $dateTime) {
            $code = $this->generateResetCode($userId, $dateTime);
            $codeLink = "http://" . $_SERVER["HTTP_HOST"] . "/users/reset_password/" . $userId . "/" . $code;

            return $codeLink;
        }


        function createRandomPassword () {
            $chars = "abcdefghijkmnopqrstuvwxyz023456789";

            srand((double)microtime()*1000000);

            $i = 0;

            $pass = '' ;

            while ($i <= 7) {

                $num = rand() % 33;

                $tmp = substr($chars, $num, 1);

                $pass = $pass . $tmp;

                $i++;

            }

            return $pass;
        }

}
?>