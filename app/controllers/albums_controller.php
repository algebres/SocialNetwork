<?php
class AlbumsController extends AppController {

	var $name = 'Albums';
        var $uses = array('Album', 'Image', 'User');


        function beforeFilter () {
            parent::beforeFilter();
            $this->Auth->allowedActions = array('search');
        }


        function search () {
            if (isset($_GET['kw'])) {
                if (empty($_GET['kw'])) {
                    // error
                    $this->redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $keyword = addslashes($_GET['kw']);

                    $albums = $this->Album->find(
                        'all',
                        array(
                            'fields' => array(
                                'Album.id',
                                'Album.name',
                                'Album.description',
                                'Album.description',
                                'Album.user_id',
                                'User.name',
                                'Album.created'
                                ),
                            'conditions' => array(
                                'OR' => array(
                                    'Album.name LIKE' => "%" . $keyword . "%",
                                    'Album.description LIKE' => "%" . $keyword . "%"
                                ),
                                'AND' => array(
                                    'Album.status'  => ENABLED
                                )
                            ),
                            'joins' => array(
                                array(
                                    'alias' => 'User',
                                    'table' => 'users',
                                    'type' => 'LEFT',
                                    'conditions' => '`Album`.`user_id` = `User`.`id`'
                                )
                            ),
                            'order' => 'Album.name'
                            )
                    );


                    for ($i=0; $i<count($albums); $i++) {
                        $albums[$i]["Album"]["images"] = $this->Image->find(
                                'count',
                                array(
                                    'conditions' => array(
                                        'Image.user_id' => $albums[$i]["Album"]["user_id"],
                                        'Image.album_id' => $albums[$i]["Album"]["id"],
                                        'Image.status'  => ENABLED
                                    )
                                )
                            );

                        $albumCover = $this->Image->find(
                                    'first',
                                    array(
                                        'fields' => array('Image.id', 'Image.path'),
                                        'conditions' => array(
                                            'Image.user_id' => $albums[$i]["Album"]["user_id"],
                                            'Image.album_id' => $albums[$i]["Album"]["id"],
                                            'Image.status'  => ENABLED
                                            ),
                                        'order' => array('Image.id DESC')
                                    )
                                );

                        $albums[$i]["Album"]["cover"]   = ($albumCover != FALSE)
                                                        ? "/" . $albumCover["Image"]["path"] . $albumCover["Image"]["id"] . "_a.png"
                                                        : "";
                    }

                    $this->set('albums', $albums);

                    //$users = $this->User->findAll("name LIKE '%" . $keyword . "%' OR username LIKE '%" . $keyword . "%'");
                    //debug($users);die;
                }
            } else {
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }


	function index ($userId=0) {
            if ($this->Session->read('Auth.User')) {
                // logged in
                    $query = "SELECT Album.id, Album.name, Album.user_id, User.name as username "
                            . "FROM albums AS Album, "
                                . "users AS User "
                            . "WHERE Album.user_id = User.id "
                            . "AND User.id = " . $this->Session->read('Auth.User.id') . " "
                            . "AND Album.status != " . DELETED . " "
                            . "ORDER BY Album.created DESC;";
                    $results = $this->Album->Query($query);

                    $albums = array();
                    if (count($results) > 0) {
                        foreach ($results as $arrayId => $arrayDesc) {
                            $i = count($albums);
                            $albums[$i]["Album"]["id"]      = $arrayDesc["Album"]["id"];
                            $albums[$i]["Album"]["name"]    = $arrayDesc["Album"]["name"];
                            $albums[$i]["Album"]["user_id"] = $arrayDesc["Album"]["user_id"];
                            $albums[$i]["Album"]["username"]= $arrayDesc["User"]["username"];
                            //$albums[$i]["Album"]["name"]    = $arrayDesc["User"]["name"];

                            $albums[$i]["Album"]["images"]  = $this->Image->find(
                                'count',
                                array(
                                    'conditions' => array(
                                        'Image.user_id' => $arrayDesc["Album"]["user_id"],
                                        'Image.album_id' => $arrayDesc["Album"]["id"],
                                        'Image.status'  => ENABLED
                                    )
                                )
                            );

                            $albumCover = $this->Image->find(
                                'first',
                                array(
                                    'fields' => array('Image.id', 'Image.path'),
                                    'conditions' => array(
                                        'Image.user_id' => $arrayDesc["Album"]["user_id"],
                                        'Image.album_id' => $arrayDesc["Album"]["id"],
                                        'Image.status'  => ENABLED
                                        ),
                                    'order' => array('Image.id DESC')
                                )
                            );

                            $albums[$i]["Album"]["cover"]   = ($albumCover != FALSE) 
                                                            ? "/" . $albumCover["Image"]["path"] . $albumCover["Image"]["id"] . "_a.png"
                                                            : "";
                        }
                    }
                    
                    $this->set('albums', $albums);

            }
            else {
                // show only public albums
            }
	}

        
	function view ($id = null) {
		if (!$id) {
                    $this->Session->setFlash(__('Invalid album', true));
                    $this->redirect(array('action' => 'index'));
		}
		$this->set('album', $this->Album->read(null, $id));
	}

        
	function add () {
            $privacies = array(
                ENABLED => "Everyone",
                FRIENDS => "Friends",
                DISABLED=> "Only me"
            );
            
            if (!empty($this->data)) {
                $this->data["Album"]["user_id"] = $this->Session->read('Auth.User.id');

                if (empty($this->data["Album"]["name"])) {
                    $message = "Album name is required.";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );
                }
                else {
                    $this->Album->create();
                    if ($this->Album->save($this->data)) {
                        //$this->Session->setFlash(__('The album has been saved', true));
                        $message = "The album has been saved";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-highlight")
                        );

                        $this->redirect(array('action' => 'add'));
                    } else {
                        //$this->Session->setFlash(__('The album could not be saved. Please, try again.', true));
                        $message = "The album could not be saved. Please, try again.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    }
                }

            }

            $this->set('privacies', $privacies);
	}


	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid album', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Album->save($this->data)) {
				$this->Session->setFlash(__('The album has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The album could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Album->read(null, $id);
		}
	}

        
	function delete($id = null) {
            if (!$id) {
                $message = "Invalid id for album";
                $this->Session->setFlash(
                    __($message, TRUE),
                    "default",
                    array("class" => "flash ui-state-error")
                );
                $this->redirect(array('action'=>'index'));
            }
            
            //if ($this->Album->delete($id)) {
            $query = "UPDATE albums "
                    . "SET status = " . DELETED . " "
                    . "WHERE id = " . $id . ";";
            $this->Album->Query($query);

            $query = "UPDATE images "
                    . "SET status = " . DELETED . " "
                    . "WHERE album_id = " . $id . " "
                    . "AND user_id = " . $this->Session->read('Auth.User.id') . ";";
            $this->Image->Query($query);

            $message = "Album along with images belonged to are deleted.";
            $this->Session->setFlash(
                __($message, TRUE),
                "default",
                array("class" => "flash ui-state-highlight")
            );
            $this->redirect(array('action'=>'index'));
	}


	function admin_index() {
		$this->Album->recursive = 0;
		$this->set('albums', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid album', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('album', $this->Album->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Album->create();
			if ($this->Album->save($this->data)) {
				$this->Session->setFlash(__('The album has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The album could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid album', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Album->save($this->data)) {
				$this->Session->setFlash(__('The album has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The album could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Album->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for album', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Album->delete($id)) {
			$this->Session->setFlash(__('Album deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Album was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>