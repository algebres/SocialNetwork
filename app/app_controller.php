<?php
class AppController extends Controller {
    var $components = array('Acl', 'Auth', 'Session', 'PImage', 'Email');

    var $helpers = array('Html', 'Form', 'Session');

    var $relationship_statuses = array(
        "0" => "Single",
        "1" => "In a relationship",
        "2" => "Engaged",
        "3" => "Married",
        "4" => "It's complicated",
        "5" => "In an open relationship",
        "6" => "Widowed",
        "7" => "Separated",
        "8" => "Divorced"
    );
    
    function beforeFilter() {
        $this->set('relationship_statuses', $this->relationship_statuses);

        //Configure Email SMTP settings
        $this->Email->replyTo   = 'Tester <mytester2010@gmail.com>';
        $this->Email->from      = 'Tester <mytester2010@gmail.com>';
        $this->Email->sendAs    = 'both';
        $this->Email->smtpOptions = array(
            'port'      => '465',
            //'port'      => '587',
            'timeout'   => '30',
            'host'      => 'ssl://smtp.gmail.com',
            'username'  => 'mytester2010@gmail.com',
            'password'  => 'qwerty123',
        );
        $this->Email->delivery  = 'smtp';

        //Configure AuthComponent
        $this->Auth->autoRedirect   = false;
        $this->Auth->authorize      = 'actions';
        $this->Auth->loginAction    = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        //$this->Auth->loginRedirect  = array('controller' => 'users', 'action' => 'profile');
        $this->Auth->userScope      = array (
                                            'User.status' => USER_STATUS_ENABLED,
                                            //'User.group_id'=> ROLE_USER
        );
        $this->Auth->actionPath = 'controllers/';

        $this->Auth->allowedActions = array('display', 'build_acl');

    }


    function checkSignIn () {
        if ($this->Session->read('Auth.User.id') > 0) {
            
        } else {
            $message = "Please login to proceed.";
            $this->Session->setFlash(
                __($message, TRUE),
                "default",
                array("class" => "flash ui-state-error")
            );

            $this->redirect("/users/login");
        }
    }

/**
 * uploads files to the server
 * @params:
 *		$folder 	= the folder to upload the files e.g. 'img/files'
 *		$formdata 	= the array containing the form files
 *		$itemId 	= id of the item (optional) will create a new sub folder
 * @return:
 *		will return an array with the success of each file upload
 */
    function uploadFiles ($folder, $formdata, $itemId = null) {
            // setup dir names absolute and relative
            $folder_url = WWW_ROOT.$folder;
            $rel_url = $folder;

            // create the folder if it does not exist
            if(!is_dir($folder_url)) {
                mkdir($folder_url);
            }

            // if itemId is set create an item folder
            if($itemId) {
                // set new absolute folder
                $folder_url = WWW_ROOT.$folder.'/'.$itemId;
                // set new relative folder
                $rel_url = $folder.'/'.$itemId;
                // create directory
                if(!is_dir($folder_url)) {
                        mkdir($folder_url);
                }
            }

        // list of permitted file types, this is only images but documents can be added
        $permitted = array('image/gif','image/jpeg', 'image/png');

        // loop through and deal with the files
        foreach($formdata as $file) {
            // replace spaces with underscores
            $filename = str_replace(' ', '_', $file['name']);
            // assume filetype is false
            $typeOK = false;
            // check filetype is ok
            foreach($permitted as $type) {
                if($type == $file['type']) {
                    $typeOK = true;
                    break;
                }
            }

            // if file type ok upload the file
            if($typeOK) {
                // switch based on error code
                switch($file['error']) {
                    case 0:
                        // check filename already exists
                        if(!file_exists($folder_url.'/'.$filename)) {
                                // create full filename
                                $full_url = $folder_url.'/'.$filename;
                                $url = $rel_url.'/'.$filename;
                                // upload the file
                                $success = move_uploaded_file($file['tmp_name'], $url);
                        } else {
                                // create unique filename and upload file
                                ini_set('date.timezone', 'Asia/Singapore');
                                $now = date('Y-m-d-His');
                                $full_url = $folder_url.'/'.$now.$filename;
                                $url = $rel_url.'/'.$now.$filename;
                                $success = move_uploaded_file($file['tmp_name'], $url);
                        }
                        // if upload was successful
                        if($success) {
                                // save the url of the file
                                $result['urls'][] = $url;
                        } else {
                                $result['errors'][] = "Error uploaded $filename. Please try again.";
                        }
                        break;
                    case 3:
                        // an error occured
                        $result['errors'][] = "Error uploading $filename. Please try again.";
                        break;
                    default:
                        // an error occured
                        $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                        break;
                }
            } elseif($file['error'] == 4) {
                // no file was selected for upload
                $result['nofiles'][] = "No file Selected";
            } else {
                // unacceptable file type
                $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
            }
        }
        return $result;
    }


    function displayClean ($var, $nlbr = false) {
        if (get_magic_quotes_gpc()) {
            $var = stripslashes($var);
        }
        if ($nlbr) {
            $var = nl2br($var);
        }
        return $var;
    }


    function postClean ($var, $nlbr = false) {
        if (get_magic_quotes_gpc()) {
            $var = stripslashes($var);
        }
        if ($nlbr) {
            $var = nl2br($var);
        }
        return mysql_real_escape_string($var);
    }

    
/**
 * To remove it before putting the application into production
 * 
 * @return <type>
 */
	function build_acl() {
		if (!Configure::read('debug')) {
			return $this->_stop();
		}
		$log = array();

		$aco =& $this->Acl->Aco;
		$root = $aco->node('controllers');
		if (!$root) {
			$aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
			$root = $aco->save();
			$root['Aco']['id'] = $aco->id;
			$log[] = 'Created Aco node for controllers';
		} else {
			$root = $root[0];
		}

		App::import('Core', 'File');
		$Controllers = App::objects('controller');
		$appIndex = array_search('App', $Controllers);
		if ($appIndex !== false ) {
			unset($Controllers[$appIndex]);
		}
		$baseMethods = get_class_methods('Controller');
		$baseMethods[] = 'build_acl';

		$Plugins = $this->_getPluginControllerNames();
		$Controllers = array_merge($Controllers, $Plugins);

		// look at each controller in app/controllers
		foreach ($Controllers as $ctrlName) {
			$methods = $this->_getClassMethods($this->_getPluginControllerPath($ctrlName));

			// Do all Plugins First
			if ($this->_isPlugin($ctrlName)){
				$pluginNode = $aco->node('controllers/'.$this->_getPluginName($ctrlName));
				if (!$pluginNode) {
					$aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginName($ctrlName)));
					$pluginNode = $aco->save();
					$pluginNode['Aco']['id'] = $aco->id;
					$log[] = 'Created Aco node for ' . $this->_getPluginName($ctrlName) . ' Plugin';
				}
			}
			// find / make controller node
			$controllerNode = $aco->node('controllers/'.$ctrlName);
			if (!$controllerNode) {
				if ($this->_isPlugin($ctrlName)){
					$pluginNode = $aco->node('controllers/' . $this->_getPluginName($ctrlName));
					$aco->create(array('parent_id' => $pluginNode['0']['Aco']['id'], 'model' => null, 'alias' => $this->_getPluginControllerName($ctrlName)));
					$controllerNode = $aco->save();
					$controllerNode['Aco']['id'] = $aco->id;
					$log[] = 'Created Aco node for ' . $this->_getPluginControllerName($ctrlName) . ' ' . $this->_getPluginName($ctrlName) . ' Plugin Controller';
				} else {
					$aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName));
					$controllerNode = $aco->save();
					$controllerNode['Aco']['id'] = $aco->id;
					$log[] = 'Created Aco node for ' . $ctrlName;
				}
			} else {
				$controllerNode = $controllerNode[0];
			}

			//clean the methods. to remove those in Controller and private actions.
			foreach ($methods as $k => $method) {
				if (strpos($method, '_', 0) === 0) {
					unset($methods[$k]);
					continue;
				}
				if (in_array($method, $baseMethods)) {
					unset($methods[$k]);
					continue;
				}
				$methodNode = $aco->node('controllers/'.$ctrlName.'/'.$method);
				if (!$methodNode) {
					$aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method));
					$methodNode = $aco->save();
					$log[] = 'Created Aco node for '. $method;
				}
			}
		}
		if(count($log)>0) {
			debug($log);
		}
	}

	function _getClassMethods($ctrlName = null) {
		App::import('Controller', $ctrlName);
		if (strlen(strstr($ctrlName, '.')) > 0) {
			// plugin's controller
			$num = strpos($ctrlName, '.');
			$ctrlName = substr($ctrlName, $num+1);
		}
		$ctrlclass = $ctrlName . 'Controller';
		$methods = get_class_methods($ctrlclass);

		// Add scaffold defaults if scaffolds are being used
		$properties = get_class_vars($ctrlclass);
		if (array_key_exists('scaffold',$properties)) {
			if($properties['scaffold'] == 'admin') {
				$methods = array_merge($methods, array('admin_add', 'admin_edit', 'admin_index', 'admin_view', 'admin_delete'));
			} else {
				$methods = array_merge($methods, array('add', 'edit', 'index', 'view', 'delete'));
			}
		}
		return $methods;
	}

	function _isPlugin($ctrlName = null) {
		$arr = String::tokenize($ctrlName, '/');
		if (count($arr) > 1) {
			return true;
		} else {
			return false;
		}
	}

	function _getPluginControllerPath($ctrlName = null) {
		$arr = String::tokenize($ctrlName, '/');
		if (count($arr) == 2) {
			return $arr[0] . '.' . $arr[1];
		} else {
			return $arr[0];
		}
	}

	function _getPluginName($ctrlName = null) {
		$arr = String::tokenize($ctrlName, '/');
		if (count($arr) == 2) {
			return $arr[0];
		} else {
			return false;
		}
	}

	function _getPluginControllerName($ctrlName = null) {
		$arr = String::tokenize($ctrlName, '/');
		if (count($arr) == 2) {
			return $arr[1];
		} else {
			return false;
		}
	}

/**
 * Get the names of the plugin controllers ...
 *
 * This function will get an array of the plugin controller names, and
 * also makes sure the controllers are available for us to get the
 * method names by doing an App::import for each plugin controller.
 *
 * @return array of plugin names.
 *
 */
	function _getPluginControllerNames() {
		App::import('Core', 'File', 'Folder');
		$paths = Configure::getInstance();
		$folder =& new Folder();
		$folder->cd(APP . 'plugins');

		// Get the list of plugins
		$Plugins = $folder->read();
		$Plugins = $Plugins[0];
		$arr = array();

		// Loop through the plugins
		foreach($Plugins as $pluginName) {
			// Change directory to the plugin
			$didCD = $folder->cd(APP . 'plugins'. DS . $pluginName . DS . 'controllers');
			// Get a list of the files that have a file name that ends
			// with controller.php
			$files = $folder->findRecursive('.*_controller\.php');

			// Loop through the controllers we found in the plugins directory
			foreach($files as $fileName) {
				// Get the base file name
				$file = basename($fileName);

				// Get the controller name
				$file = Inflector::camelize(substr($file, 0, strlen($file)-strlen('_controller.php')));
				if (!preg_match('/^'. Inflector::humanize($pluginName). 'App/', $file)) {
					if (!App::import('Controller', $pluginName.'.'.$file)) {
						debug('Error importing '.$file.' for plugin '.$pluginName);
					} else {
						/// Now prepend the Plugin name ...
						// This is required to allow us to fetch the method names.
						$arr[] = Inflector::humanize($pluginName) . "/" . $file;
					}
				}
			}
		}
		return $arr;
	}

}
?>