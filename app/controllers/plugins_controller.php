<?php
class PluginsController extends AppController {

	var $name = 'Plugins';
        var $components = array('Xplico');
	var $paginate = array('limit' => 20);

	function beforeFilter() {
                $groupid = $this->Session->read('group');
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                if (!$groupid || !$polid || !$solid) {
                    $this->redirect('/users/login');
                }
	}

	function index() {
		$this->Plugin->recursive = 0;
		$this->set('plugins', $this->paginate());
                $this->set('menu_left', $this->Xplico->leftmenuarray(9) );
	}

	function view($id = null) {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		if (!$id) {
			$this->Session->setFlash(__('Invalid plugin', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('plugin', $this->Plugin->read(null, $id));
		$this->data = $this->Plugin->read(null, $id);
	}

	function add() {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		if (!empty($this->data)) {
			$this->Plugin->create();
			if ($this->Plugin->save($this->data)) {
				$this->Session->setFlash(__('The plugin has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The plugin could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid plugin', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Plugin->save($this->data)) {
				$this->Session->setFlash(__('The plugin has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The plugin could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Plugin->read(null, $id);
		}
	}

	function delete($id = null) {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for plugin', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Plugin->delete($id)) {
			$this->Session->setFlash(__('Plugin deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Plugin was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function train($id = null)
	{
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		$this->set('plugin_id', $id);
		$this->Plugin->recursive = 0;
		$plugin_data = $this->Plugin->read('pluginURI', $id);
		$sol_id = $this->Session->read('sol');
		$pol_id = $this->Session->read('pol');
		$this->Pol->recursive = 0;
		$this->Sol->recursive = 0;
		$case_category = $this->Pol->read('external_ref', $pol_id);
		$content_timestamp = $this->Sol->read('start_time', $sol_id);
		//fill up form
		$this->data['Train']['case_category'] = $case_category['Pol']['external_ref'];
		$this->data['Train']['case_id'] = $pol_id;
		$this->data['Train']['capture_timestamp'] = $content_timestamp['Sol']['start_time'];
		//contentPath, relevance and message will be provided by the user

		//if there is data to be uploaded
		if(isset($this->data['Train']['content_file']['tmp_name']) && is_uploaded_file($this->data['Train']['content_file']['tmp_name']))
		{

		    $content_file = "/opt/xplico/resources/".$this->data['Train']['content_file']['name'];
		    if(move_uploaded_file($this->data['Train']['content_file']['tmp_name'], $content_file))
		    {
			$relevance = $this->data['Train']['process_relevance'];
			$message = $this->data['Train']['process_message'];
			$plugin_path = $plugin_data['Plugin']['pluginURI'];
			$this->set('plugin_path', $plugin_path);
			$content_type = "";
			$content_name = "";
			//  /usr/local/bin/app_plugin_manager -p 'file:///home/ilip/plugins/local_plugins/bin/hello_world_plugin' $REQUEST_COMMAND_arg $CASE_CATEGORY_arg $CASE_ID_arg $CONTENT_URI_arg $CONTENT_NAME_arg $CONTENT_TIMESTAMP_arg $CONTENT_TYPE_arg

			$log_file = "/opt/pluginManager.log";
			//we need to redirect the output so that php doesn't wait for the return
			$cmd = "/usr/local/bin/app_plugin_manager -p '".$plugin_path."' training '".$this->data['Train']['case_category']."' '".$pol_id."' '".$content_file."' '".$content_name."' '".$this->data['Train']['capture_timestamp']."' '".$content_type."' '".$relevance."' '".$message."' >> ".$log_file." 2>&1";
//$cmd = 'echo $APACHE_RUN_USER $PWD $USER $AXIS2C_HOME >> '.$log_file.' 2>&1';
			//as there is redirection $res_str is empty
		
			$res_str = System($cmd, $res_int);

			if($res_int == 0)
				$this->Session->setFlash(__('Content is being trained', true));
			else
				$this->Session->setFlash(__('Content could not been trained (error '.$res_int.'). Check log file '.$log_file.'.', true));
		    }
		}
		else
		{
			$this->Session->setFlash(__('To train the plugin, a file must be provided', true));
		}
	}
}
?>
