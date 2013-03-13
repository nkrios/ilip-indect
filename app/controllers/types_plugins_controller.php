<?php
class TypesPluginsController extends AppController {

	var $name = 'TypesPlugins';
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
		$this->TypesPlugin->recursive = 0;
// 		$this->set('joinTables', $this->TypesPlugin->find('all')); //Publicamos variable 'joinTables'
		$this->set('typesPlugins', $this->paginate());
                $this->set('menu_left', $this->Xplico->leftmenuarray(9) );
	}

	function view($id = null) {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		if (!$id) {
			$this->Session->setFlash(__('Invalid MIME type / Plugin Rule', true));
			$this->redirect(array('action' => 'index'));
		}
		if (empty($this->data)) {
			$this->data = $this->TypesPlugin->read(null, $id);
		}
		$this->set('typesPlugin', $this->TypesPlugin->read(null, $id));
	}

	function add() {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		$this->set('order_options', $this->Xplico->orderoptions() );
		if (!empty($this->data)) {
			$this->TypesPlugin->create();
			if ($this->TypesPlugin->save($this->data)) {
				$this->Session->setFlash(__('The MIME type / Plugin Rule has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The MIME type / Plugin Rule could not be saved. Please, try again.', true));
			}
		}
		
		//$pluginsAvailables = $this->TypesPlugin->Plugin->find('list', array('fields'=>'pluginName'));
		$plugins = $this->TypesPlugin->Plugin->find('list');
		$this->set(compact('plugins'));
		//not needed any more as the MIME type is just text
		$typesAvailables = $this->TypesPlugin->Plugin->find('list', array('fields'=>'pluginType'));
		$this->set(compact('typesAvailables'));
	}

	function edit($id = null) {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		$this->set('order_options', $this->Xplico->orderoptions() );
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid MIME type / Plugin Rule', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->TypesPlugin->save($this->data)) {
				$this->Session->setFlash(__('The MIME type / Plugin Rule has been saved', true));
				$this->redirect(array('action' => 'index'));				
			} else {
				$this->Session->setFlash(__('The MIME type / Plugin Rule could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TypesPlugin->read(null, $id);
		}

		$plugins = $this->TypesPlugin->Plugin->find('list');
		$this->set(compact('plugins'));
		//not needed any more as the MIME type is just text
		$typesAvailables = $this->TypesPlugin->Plugin->find('list', array('fields'=>'pluginType'));
		$this->set(compact('typesAvailables'));
	}

	function delete($id = null) {
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		if (!$id) {
			$this->Session->setFlash(__('Invalid id', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TypesPlugin->delete($id)) {
			$this->Session->setFlash(__('MIME type / Plugin Rule deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('MIME type / Plugin Rule was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
