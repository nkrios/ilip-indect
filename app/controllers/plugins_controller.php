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
}
?>
