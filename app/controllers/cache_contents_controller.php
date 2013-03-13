<?php
class CacheContentsController extends AppController {

	var $name = 'CacheContents';
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
		$this->CacheContent->recursive = 0;
		$this->set('cacheContents', $this->paginate());
                $this->set('menu_left', $this->Xplico->leftmenuarray(9) );
	}

	function view($id = null)
	{
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		if (!$id) {
			$this->Session->setFlash(__('Invalid cache content', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->data = $this->CacheContent->read(null, $id);
		$this->set('cacheContent', $this->CacheContent->read(null, $id));
	}

	function clear()
	{
		$this->set('menu_left', $this->Xplico->leftmenuarray(9) );
		// deleteAll is a method of AppModel which is extended by CacheContent
		$this->CacheContent->deleteAll(array('1 = 1'), false); 
		$this->redirect(array('action' => 'index'));
	}
}
?>