<?php
class ImagesController extends AppController {

	var $name = 'Images';
        var $uses = array('Album', 'Image', 'User', 'Comment', 'Post');
        
        function beforeFilter () {
            parent::beforeFilter();
            $this->Auth->allowedActions = array('album', 'add', 'upload_profile', 'view', 'del');
        }

        function del ($id, $albumId=0, $type=0) {
            $this->checkSignIn();
            $userId = $this->Session->read('Auth.User.id');

            if ($type == 0) {
                $result = $this->Image->find(
                                    'count',
                                    array(
                                        'conditions' => array(
                                            'Image.id' => $id,
                                            'Image.user_id' => $userId,
                                            'Image.status'  => ENABLED
                                        )
                                    )
                                );
                if ($result > 0) {
                    $image = array();
                    $image['Image']['id'] = $id;
                    $image['Image']['user_id'] = $userId;
                    $image['Image']['status'] = DELETED;

                    $this->Image->save($image);
                }

                $this->redirect("/images/album/" . $albumId);
            }
            // Album
            elseif ($type == 1) {
                $result = $this->Album->find(
                                    'count',
                                    array(
                                        'conditions' => array(
                                            'Album.id' => $id,
                                            'Album.user_id' => $userId,
                                            'Album.status'  => ENABLED
                                        )
                                    )
                                );
                if ($result > 0) {
                    $album = array();
                    $album['Album']['id'] = $id;
                    $album['Album']['user_id'] = $userId;
                    $album['Album']['status'] = DELETED;

                    $this->Album->save($album);
                }
                $this->redirect("/albums/index/" . $userId);
            }
            
        }



        function add ($albumId=0) {
            $this->checkSignIn();
            $userId = $this->Session->read('Auth.User.id');
            $isPost = isset($this->data) ? TRUE : FALSE;

            if ($isPost && $albumId > 0) {
                $imageUrl = 'img/albums';
                $fileUpload = $this->uploadFiles($imageUrl, $this->data["Image"]["file"], $albumId);

                // file upload ok
                if (array_key_exists('urls', $fileUpload)) {
                    $query = "SELECT id FROM albums WHERE id = " . $albumId . " AND user_id = " . $userId . ";";
                    $albumExist = $this->Album->query($query);

                    if ($albumExist == FALSE) {
                        $message = "Error occurred. Album cannot be found.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-error")
                        );
                    } else {
                        for ($i=0; $i<count($fileUpload["urls"]); $i++) {
                            $imageFilename = $this->data["Image"]["file"][$i]["name"];
                            
                            // insert image to table
                            $image = array(
                                "name"  => "",
                                "album_id"  => $albumId,
                                "user_id"  => $userId,
                                "filename"  => $fileUpload["urls"][$i],
                                "path"  => $imageUrl . "/" . $albumId . "/",
                                "status"  => ENABLED,
                                "created"   => date("Y-m-d H:i:s"),
                                "modified"  => date("Y-m-d H:i:s")
                            );
                            $this->Image->create();
                            $this->Image->save($image);
                            $imageId = $this->Image->getLastInsertId();
                            

                            // delete file if exists
                            $newImageFilePath = WWW_ROOT . DS . 'img' . DS . 'albums' . DS . $albumId . DS . $imageId . '_l.png';
                            if (file_exists($newImageFilePath)) { unlink($newImageFilePath); }

                            // for profile pic
                            $this->PImage->resizeImage('resize', $imageFilename, WWW_ROOT . DS . 'img' . DS . 'albums' . DS . $albumId . DS, $imageId . '_l.png', 400, 400, 100);

                            $newImageFilePath = WWW_ROOT . DS . 'img' . DS . 'albums' . DS . $albumId . DS . $imageId . '_a.png';
                            if (file_exists($newImageFilePath)) { unlink($newImageFilePath); }

                            // for album cover
                            $this->PImage->resizeImage('resizeCrop', $imageFilename, WWW_ROOT . DS . 'img' . DS . 'albums' . DS . $albumId . DS, $imageId . '_a.png', 140, 100, 90);
                        }

                        $msg = "uploaded a new <a href='/images/album/" . $albumId . "'>photo</a>";
                        //$msg = $this->postClean();
                        $this->Post->_postToWall($msg, $userId);
                        
                        $message = "Successfully uploaded.";
                        $this->Session->setFlash(
                            __($message, TRUE),
                            "default",
                            array("class" => "flash ui-state-highlight")
                        );
                    }
                }
                else {
                    $message = "";
                    for ($i=0; $i<count($fileUpload["errors"]); $i++) {
                        $message .= $fileUpload["errors"][$i] . "<br>";
                    }

                    
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );
                }
                $this->redirect("/images/album/".$albumId);
            }
        }


        function album ($albumId=0) {
            $this->checkSignIn();
            $userId = $this->Session->read('Auth.User.id');

            if ($albumId > 0) {
                // find images for this album
                if ($this->Session->read('Auth.User.group_id') == ROLE_ADMIN) {
                    $images = $this->Image->find(
                                    'all',
                                    array(
                                        'conditions' => array(
                                            'Image.album_id' => $albumId,
                                            'Image.status'  => ENABLED
                                        )
                                    )
                                );
                }
                else {
                    $images = $this->Image->find(
                                    'all',
                                    array(
                                        'conditions' => array(
                                            'Image.user_id' => $userId,
                                            'Image.album_id' => $albumId,
                                            'Image.status'  => ENABLED
                                        )
                                    )
                                );
                }

                $this->set('images', $images);
                $this->set('albumId', $albumId);
            }
            else {
                $message = "Invalid album";
                $this->Session->setFlash(
                    __($message, TRUE),
                    "default",
                    array("class" => "flash ui-state-error")
                );
            }
        }


	function upload_profile () {
            $userId = $this->Session->read('Auth.User.id');
            $isPost = isset($this->data) ? TRUE : FALSE;

            if ($isPost) {
                $imageUrl = 'img/users';
                $imageFilename = $this->data['User']['avatar']['name'];
                $fileUpload = $this->uploadFiles($imageUrl, $this->data['User'], $userId);

                // if file was uploaded ok
                if (array_key_exists('urls', $fileUpload)) {
                    $query = "SELECT id FROM albums WHERE name = 'profile pic' AND user_id = " . $userId . ";";
                    $albumExist = $this->Album->query($query);

                    if (!$albumExist) {
                        $album = array(
                            "name"  => "profile pic",
                            "description"   => "",
                            "user_id"   => $userId,
                            "status"    => DISABLED,
                            "created"   => date("Y-m-d H:i:s"),
                            "modified"  => date("Y-m-d H:i:s")
                        );

                        $this->Album->create();
                        $this->Album->save($album);
                        $albumId = $this->Album->getLastInsertId();
                    }
                    else {
                        $albumId = $albumExist[0]["albums"]["id"];
                    }

                    // delete file if exists
                    $newImageFilePath = WWW_ROOT . DS . 'img' . DS . 'users' . DS . $userId . DS . $userId . '_l.png';
                    if (file_exists($newImageFilePath)) { unlink($newImageFilePath); }

                    // for profile pic
                    $this->PImage->resizeImage('resize', $imageFilename, WWW_ROOT . DS . 'img' . DS . 'users' . DS . $userId . DS, $userId . '_l.png', 200, false, 90);

                    // for album cover
                    $this->PImage->resizeImage('resizeCrop', $imageFilename, WWW_ROOT . DS . 'img' . DS . 'users' . DS . $userId . DS, $userId . '_a.png', 140, 100, 90);

                    $newImageFilePath = WWW_ROOT . DS . 'img' . DS . 'users' . DS . $userId . DS . $userId . '_p.png';
                    if (file_exists($newImageFilePath)) { unlink($newImageFilePath); }

                    // for profile pic
                    $this->PImage->resizeImage('resizeCrop', $imageFilename, WWW_ROOT . DS . 'img' . DS . 'users' . DS . $userId . DS, $userId . '_p.png', 48, 48, 70);

                    // insert profile image to table
                    $image = array(
                        "name"  => "",
                        "album_id"  => $albumId,
                        "user_id"  => $userId,
                        "filename"  => $fileUpload["urls"][0],
                        "path"  => $imageUrl . "/" . $userId . "/",
                        "status"  => DISABLED,
                        "created"   => date("Y-m-d H:i:s"),
                        "modified"  => date("Y-m-d H:i:s")
                    );
                    $this->Image->create();
                    $this->Image->save($image);
                    $imageId = $this->Image->getLastInsertId();

                    $this->User->id = $userId;
                    $this->User->saveField('avatar_id', $imageId);


                    //$imageLocation = "/" . $image["filename"];
                    $imageLocation = DS . IMAGES_URL . 'users' . DS . $userId . DS . $userId . '_l.png?' . time();

                    $message = "Your profile picture has been changed successfully.";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-highlight")
                    );
                }
                else {
                    $message = $fileUpload["errors"][0];
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );
                }
                
                // upload profile image
                // - check default album 'profile pic', create if not found for this user
                // - upload 3 pic - 1 org, 1 for profile, 1 for thumbnail
                // - folder structure
                // - images table structure
            }
            else {
                if ($this->Session->read('Auth.User.avatar_id') == 0) {
                    $imageLocation = ($this->Session->read('Auth.User.sex') != 0) ? '/img/user_male.png' : '/img/user_female.png';
                }
                else {
                    /*
                    $query = "SELECT Image.filename "
                            . "FROM images AS Image, users AS User "
                            . "WHERE Image.id = User.avatar_id "
                            . "AND User.id = " . $userId . " "
                            . "LIMIT 1;";
                    $image = $this->Image->query($query);
                    $imageLocation = "/" . $image[0]["Image"]["filename"];
                     *
                     */
                    $imageLocation = DS . IMAGES_URL . 'users' . DS . $userId . DS . $userId . '_l.png';
                }
            }

                

            $this->set('imageLocation', $imageLocation);
	}


        function view ($id = null) {
            if (!$id) {
                $message = "Invalid Image.";
                $this->Session->setFlash(
                    __($message, TRUE),
                    "default",
                    array("class" => "flash ui-state-error")
                );

                $this->redirect(array('action' => 'index', 'controller' => 'albums'));
            }
            else {
                //$image = $this->Image->findById($id);
                $image = $this->Image->find('all', array(
                        'fields' => array('Image.id', 'Image.name', 'Image.user_id', 'Album.id', 'Album.name', 'Image.filename', 'Image.path'),
                        'conditions' => array('Image.id' => $id),
                        'joins' => array(
                            array(
                                'alias' => 'Album',
                                'table' => 'albums',
                                'type' => 'LEFT',
                                'conditions' => '`Album`.`id` = `Image`.`album_id`'
                            )
                        )
                ));

                $neighbors = $this->Image->find('neighbors', array('field' => 'id', 'value' => $id));

                if ($image) {
                    $user = $this->User->findById($image[0]['Image']['user_id']);

                    //find comments
                    $comments = array();
                    $comments = $this->Comment->find(
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
                                        'User.name'
                                    ),
                                    'conditions' => array(
                                        'Comment.type' => IMAGE,
                                        'Comment.parent_id' => $image[0]['Image']['id'],
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
                    
                    $this->set('loggedInUserId', $this->Session->read('Auth.User.id'));
                    $this->set('image', $image);
                    $this->set('neighbors', $neighbors);
                    $this->set('user', $user);
                    $this->set('comments', $comments);
                }
                else {
                    $message = "Invalid Image.";
                    $this->Session->setFlash(
                        __($message, TRUE),
                        "default",
                        array("class" => "flash ui-state-error")
                    );

                    $this->redirect(array('action' => 'index', 'controller' => 'albums'));
                }
            }

            //$this->set('image', $this->Image->read(null, $id));
	}

}
?>
