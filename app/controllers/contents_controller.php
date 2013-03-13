<?php
class ContentsController extends AppController {

	var $name = 'Contents';
	var $helpers = array('Html', 'Form', 'Javascript');
	//var $priorityArray = array(0, 1, 2, 3, 4, 5);
        var $components = array('Xplico');
	var $paginate = array('limit' => 16);//, 'order' => array('Email.capture_date' => 'desc'));

	function beforeFilter() {
                $groupid = $this->Session->read('group');
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                if (!$groupid || !$polid || !$solid) {
                    $this->redirect('/users/login');
                }
        }

	function index() {
		$this->Content->recursive = 0;
		$this->set('contents', $this->paginate());
                $this->set('menu_left', $this->Xplico->leftmenuarray(9) );

		// Get contentsContainerServer path from conf.txt and build contentsContainerURI
		$confFile_path = "/usr/local/pluginManager/config/config.txt";
		$confFile = fopen($confFile_path, 'r');
		$contentsContainerPath = fgets($confFile);
		$contentsContainerPath = fgets($confFile);
		$contentsContainerPath = explode("\n", $contentsContainerPath);
		$contentsContainerRoot = "xplico/resources/";
		$contentsContainerURI = $contentsContainerPath[0] . $contentsContainerRoot; 
		$this->set('contentsContainerURI', $contentsContainerURI);
		fclose($confFile);
	}

	function view($id = null)
	{
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		$this->set('relevanceoptions',$this->Xplico->relevanceoptions());
		if (!$id) {
			$this->Session->setFlash(__('Invalid content', true));
			$this->redirect(array('action' => 'index'));
		}
		//if this->data is not empty, it means they have pressed again so we have to save the data
		if (!empty($this->data)) {
                        if ($this->Content->save($this->data)) {
//                              $this->flash(__('Changes saved succesfully.', true), array('action' => 'view/'.$id));
//                              $this->flash(__('Changes saved succesfully.', true));
				$this->redirect(array('action' => 'train'));

                        }
                }
		//if this->data is empty, it means that we are viewing the content for first time, so read it from the database
		if (empty($this->data)) {
			$this->data = $this->Content->read(null, $id);
		}

	}

	function add() {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
                $this->set('relevanceoptions',$this->Xplico->relevanceoptions());

		if (!empty($this->data)) {
			$this->Content->create();
			if ($this->Content->save($this->data)) {
				$this->Session->setFlash(__('The content has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.', true));
			}
		}
	}

	function add2 ($newEntry) {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
                $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
		if (!empty($newEntry)) {
			$this->Content->create();
			if ($this->Content->save($newEntry)) {
				$this->Session->setFlash(__('The content has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null)
	{
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		$this->set('relevanceoptions',$this->Xplico->relevanceoptions());
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid content', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Content->save($this->data)) {
				$this->Session->setFlash(__('The content has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Content->read(null, $id);
		}
	}

	function delete($id = null)
	{
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for content', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Content->delete($id)) {
			$this->Session->setFlash(__('Content deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Content was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function reset($id = null)
	{
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		$this->data = $this->Content->read(null, $id);
		$this->data['Content']['description'] = '';
		$this->data['Content']['priorityAssociated'] = '';
		$this->Content->save($this->data);
		$this->redirect(array('action' => 'index'));
	}

	function getContentName($filePath) {
		$fileName_withExtension = substr($filePath, strrpos($filePath,'/')+1,strlen($filePath)-strrpos($filePath,'/'));
	   return substr($fileName_withExtension, 0 , strrpos($fileName_withExtension,'.'));
	}

	function clearAll()
	{
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		// deleteAll is a method of AppModel which is extended by CacheContent
		$this->Content->deleteAll(array('1 = 1'), false); 
		$this->redirect(array('action' => 'index'));
	}

	function checkPluginManagerStatus()
	{
      //Check for PluginManager process status. 0=not running; 1=running.
		$isXplicoPMRunning = 0;

		$fop = popen('ps -ef | grep pluginManagerClient', 'r');

      if ($fop)
		{
			while (!feof($fop)) {
				$aux = fgets($fop, 200);
				if (strstr($aux, 'pluginManagerClient.sh')) $isXplicoPMRunning = 1;
         }
         pclose($fop);
      }

		return $isXplicoPMRunning;
	}

	function getContentType($filePath)
	{
		$result_command_execution = 0;
		$filePathLength = strlen($filePath);
		$fop = popen('file --mime-type '.$filePath, 'r');

      if ($fop) { $result_command_execution = fgets($fop, 200); }
      pclose($fop);

		//return substr($result_command_execution, $filePathLength+2, strlen($result_command_execution));
		return substr($result_command_execution, strrpos($result_command_execution,' ')+1, strrpos($result_command_execution,'  ')-1);
	}

	function update()
	{
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		// Get fields of the new Content table database entry	
		$contentPath = $_FILES['path']['tmp_name'];
		$contentName = $_FILES['path']['name']; 
		$contentType = $_FILES['path']['type'];

		// Move Content Uploaded to ftp directory
		$target_path = "/opt/xplico/resources/".$contentName;

		$newEntry = array('contentName' => $contentName, 'contentPath' => $target_path, 'contentType' => $contentType, 
								'description' => '', 'priorityAssociated' => '');

		if(move_uploaded_file($contentPath, $target_path))
		{
			// Update Database
			$this->add2($newEntry); 
			$this->redirect(array('action' => 'index'));
		}
		else { $this->Session->setFlash(__('There was an error uploading the file, please check /opt/xplico/resources permissions', true)); }

		$this->redirect(array('action' => 'index'));
	}

	function train()
	{	
		//$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		$newPriority = $this->data['relevance'];//$_POST['priorityAssociated'];
		$contentPath = $this->data['path'];
		$contentName = $this->data['name'];
		$contentType = $this->data['type'];
		$contentDescription = $this->data['description'];		

		if ($contentDescription == "") $contentDescription = "No description associated by the operator.";

//		echo $cmd = "/usr/local/pluginManager/bin/pluginManagerClient.sh 3 '".$newPriority."' '".$contentPath."' '".$contentName
//						."' '".$contentType."' '".$contentDescription."' > /usr/local/pluginManager/log/pluginManager.log &";
		echo $cmd = "/usr/local/pluginManager/bin/pluginManagerClient.sh 3 '".$newPriority."' '".$contentPath."' '".$contentName
						."' '".$contentType."' '".$contentDescription."' >> /opt/xplico/resources/pluginManager.log 2>&1";
		System($cmd, $ret);

		sleep(0.25);

		$this->redirect(array('action' => 'index'));
	}

	function analyze($id = null)
	{	
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		$this->data = $this->Content->read(null, $id);
		echo $contentName = $this->data['Content']['contentName'];
		echo $target_path = $this->data['Content']['contentPath'];
		echo $contentType = $this->data['Content']['contentType'];
		
//		$cmd = "/usr/local/pluginManager/bin/pluginManagerClient.sh 2 ".$contentName." ".$target_path." ".$contentType." > /usr/local/pluginManager/log/pluginManager.log &";
		$cmd = "/usr/local/pluginManager/bin/pluginManagerClient.sh 2 ".$contentName." ".$target_path." ".$contentType." >> /opt/xplico/resources/pluginManager.log 2>&1";
		System($cmd, $ret);

		sleep(0.25);

		$this->redirect(array('action' => 'index'));
	}

}
?>
