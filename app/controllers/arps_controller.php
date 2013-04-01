<?php

class ArpsController extends AppController {
        var $name = 'Arps';
        var $helpers = array('Html', 'Form', 'Javascript');
        var $components = array('Xml2Pcap', 'Xplico');
        var $paginate = array('limit' => 16, 'order' => array('Arp.capture_date' => 'desc'));

        function beforeFilter() {
            $groupid = $this->Session->read('group');
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            if (!$groupid || !$polid || !$solid) {
                $this->redirect('/users/login');
            }
        }

        function index($id = null) {
            $solid = $this->Session->read('sol');
            $this->Arp->recursive = -1;
            $filter = array('Arp.sol_id' => $solid);
            // host selezionato
	    if ($this->Session->check('host_id')) {
	            $host_id = $this->Session->read('host_id');
            }

            if (!empty($host_id) && $host_id["host"] != 0) {
                $filter['Arp.source_id'] = $host_id["host"];
            }

	    //search data
            $srch = null;
            if ($this->Session->check('search')) {
                $srch = $this->Session->read('search');
            }
	    //relevance data
	    $rel=null;
            if ($this->Session->check('relevance')) {
                $rel = $this->Session->read('relevance');
            }
	    //check the form
            if (!empty($this->data)) {
		    if ($this->data['Search']['search'] != '')
		        $srch = $this->data['Search']['search'];
		    else
		        $srch = null;
		    $this->Session->write('search', $srch);

		    //using empty() considers '0' as empty and the value is lost!!!!
		    if($this->data['Search']['relevance'] != '')
			$rel = $this->data['Search']['relevance'];
		    else
			$rel = null;
		    $this->Session->write('relevance', $rel);
		}
	    //prepare the filter
            if (!empty($srch)) {
                $filter['OR']['Arp.mac LIKE'] = "%$srch%";
                $filter['OR']['Arp.ip LIKE'] = "%$srch%";
            }

	    //set parameters for the view
            $arp_msgs = $this->paginate('Arp', $filter);
            $this->set('arp_msgs', $arp_msgs);
            $this->set('srchd', $srch);
	    $this->set('relevance', $rel);
            $this->set('menu_left', $this->Xplico->leftmenuarray(1));
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
        }

        function info($id = null) {
                if (!$id) {
                    exit();
                }
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                $this->Arp->recursive = -1;
                $arp_message = $this->Arp->read(null, $id);
                if ($polid != $arp_message['Arp']['pol_id'] || $solid != $arp_message['Arp']['sol_id']) {
                    $this->redirect('/users/login');
                }
                else {
                    $this->autoRender = false;
                    header("Content-Disposition: filename=info".$id.".xml");
                    header("Content-Type: application/xhtml+xml; charset=utf-8");
                    header("Content-Length: " . filesize($arp_message['Arp']['flow_info']));
                    readfile($arp_message['Arp']['flow_info']);
                    exit();
                }
        }
}
?>
