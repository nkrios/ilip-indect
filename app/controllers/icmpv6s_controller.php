<?php

class Icmpv6sController extends AppController {
        var $name = 'Icmpv6s';
        var $helpers = array('Html', 'Form', 'Javascript');
        var $components = array('Xml2Pcap', 'Xplico');
        var $paginate = array('limit' => 16, 'order' => array('Icmpv6.capture_date' => 'desc'));

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
            $this->Icmpv6->recursive = -1;
            $filter = array('Icmpv6.sol_id' => $solid);
            // host selezionato
            $host_id = $this->Session->read('host_id');
            if (!empty($host_id) && $host_id["host"] != 0) {
                $filter['Icmpv6.source_id'] = $host_id["host"];
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
            if (!empty($this->data['Search'])) {
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
                $filter['OR']['Icmpv6.mac LIKE'] = "%$srch%";
                $filter['OR']['Icmpv6.ip LIKE'] = "%$srch%";
            }

	    //set parameters for the view
            $icmpv6_msgs = $this->paginate('Icmpv6', $filter);
            $this->set('icmpv6_msgs', $icmpv6_msgs);
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
                $this->Icmpv6->recursive = -1;
                $icmpv6_message = $this->Icmpv6->read(null, $id);
                if ($polid != $icmpv6_message['Icmpv6']['pol_id'] || $solid != $icmpv6_message['Icmpv6']['sol_id']) {
                    $this->redirect('/users/login');
                }
                else {
                    $this->autoRender = false;
                    header("Content-Disposition: filename=info".$id.".xml");
                    header("Content-Type: application/xhtml+xml; charset=utf-8");
                    header("Content-Length: " . filesize($icmpv6_message['Icmpv6']['flow_info']));
                    readfile($icmpv6_message['Icmpv6']['flow_info']);
                    exit();
                }
        }
}
?>
