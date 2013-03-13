<?php
  /* ***** BEGIN LICENSE BLOCK *****
   * Version: MPL 1.1/GPL 2.0/LGPL 2.1
   *
   * The contents of this file are subject to the Mozilla Public License
   * Version 1.1 (the "MPL"); you may not use this file except in
   * compliance with the MPL. You may obtain a copy of the MPL at
   * http://www.mozilla.org/MPL/
   *
   * Software distributed under the MPL is distributed on an "AS IS" basis,
   * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the MPL
   * for the specific language governing rights and limitations under the
   * MPL.
   *
   * The Original Code is Xplico Interface (XI).
   *
   * The Initial Developer of the Original Code is
   * Gianluca Costa <g.costa@xplico.org>
   * Portions created by the Initial Developer are Copyright (C) 2007
   * the Initial Developer. All Rights Reserved.
   *
   * Contributor(s):
   *
   * Alternatively, the contents of this file may be used under the terms of
   * either the GNU General Public License Version 2 or later (the "GPL"), or
   * the GNU Lesser General Public License Version 2.1 or later (the "LGPL"),
   * in which case the provisions of the GPL or the LGPL are applicable instead
   * of those above. If you wish to allow use of your version of this file only
   * under the terms of either the GPL or the LGPL, and not to allow others to
   * use your version of this file under the terms of the MPL, indicate your
   * decision by deleting the provisions above and replace them with the notice
   * and other provisions required by the GPL or the LGPL. If you do not delete
   * the provisions above, a recipient may use your version of this file under
   * the terms of any one of the MPL, the GPL or the LGPL.
   *
   * ***** END LICENSE BLOCK ***** */

uses('sanitize');

class SipsController extends AppController {
        var $name = 'Sips';
        var $uses = array('Sip', 'Conversation');
        var $helpers = array('Html', 'Form', 'Javascript');
        var $components = array('Xml2Pcap', 'Xplico');
        var $paginate = array('limit' => 16, 'order' => array('Sip.capture_date' => 'desc'));

        function beforeFilter() {
                $groupid = $this->Session->read('group');
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                if (!$groupid || !$polid || !$solid) {
                    $this->redirect('/users/login');
                }
        }

        function index($id = null) {
	    //as user is checking all sips, there is no more sipid or rtpid
	    unset($_SESSION['sipid']);
	    unset($_SESSION['rtpid']);

            $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $filter = array('Sip.sol_id' => $solid);
            // host selezionato
            $host_id = $this->Session->read('host_id');
            if (!empty($host_id) && $host_id["host"] != 0) {
                $filter['Sip.source_id'] = $host_id["host"];
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
                $filter[0]['OR']['Sip.from_addr LIKE'] = "%$srch%";
                $filter[0]['OR']['Sip.to_addr LIKE'] = "%$srch%";
                $filter[0]['OR']['Sip.comments LIKE'] = "%$srch%";
            }
 	    if (!empty($rel)) {
		    $filter[1]['OR']['Sip.relevance >='] = $rel;
		    $filter[1]['OR']['Sip.relevance =='] = '0';
		    $filter[1]['OR']['Sip.relevance'] = null;
	    }

	    //set parameters for the view
            $msgs = $this->paginate('Sip', $filter);
            $this->set('sips', $msgs);
            $this->set('srchd', $srch);
	    $this->set('relevance', $rel);
            $this->set('menu_left', $this->Xplico->leftmenuarray(4) );
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
        }

        function export($id = null) {
	    $this->layout = 'csv';
	    //Configure::write('debug',0); 

	    $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $filter = array('Sip.sol_id' => $solid);
            // host selezionato
            $host_id = $this->Session->read('host_id');
            if (!empty($host_id) && $host_id["host"] != 0) {
                $filter['Sip.source_id'] = $host_id["host"];
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

            if (!empty($srch)) {
                $filter[0]['OR']['Sip.from_addr LIKE'] = "%$srch%";
                $filter[0]['OR']['Sip.to_addr LIKE'] = "%$srch%";
                $filter[0]['OR']['Sip.comments LIKE'] = "%$srch%";
            }
	    if (!empty($rel)) {
		    $filter[1]['OR']['Sip.relevance >='] = $rel;
		    $filter[1]['OR']['Sip.relevance =='] = '0';
		    $filter[1]['OR']['Sip.relevance'] = null;
	    }

	    // Add headers to data array
	    //end date is calculated from capture_date+duration
	     $headers = array('Phone call kind','Start date','End date','Number A','Number B');

	    $data = $this->Sip->find('all', array(
		'fields' => array('Sip.capture_date','Sip.duration','Sip.from_addr','Sip.to_addr'),
		'conditions' => $filter
		)//end array
	     );

 	     foreach ($data as &$row){
		$row['Sip'] = array_merge(array("Phone call kind"=>"VOIP"),$row['Sip']); 
	     }

	    $this->set(compact('headers'));
	    $this->set(compact('data'));
        }

        function view($id = null) {
                if (!$id) {
                    //exit();
                    $this->redirect('/users/login');
                }
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                $this->set('menu_left', $this->Xplico->leftmenuarray(4) );
                $this->Sip->recursive = -1;
                $sip = $this->Sip->read(null, $id);
                if ($polid != $sip['Sip']['pol_id'] || $solid != $sip['Sip']['sol_id']) {
                    $this->redirect('/users/login');
                }
                $this->Session->write('sipid', $id);

		//fetch conversation
                $this->Conversation->recursive = -1;
                $conversation = $this->Conversation->read(null, $sip['Sip']['conversation_id']);

                // register visualization
                if (!$sip['Sip']['first_visualization_user_id']) {
                    $uid = $this->Session->read('userid');
                    $sip['Sip']['first_visualization_user_id'] = $uid;
                    $sip['Sip']['viewed_date'] = date("Y-m-d H:i:s");
                    $this->Sip->save($sip);
                }

		//save changes
		//check if we are coming from the actual index after changing a value
	    if (!empty($this->data['Edit'])) {
                  $sip['Sip']['relevance']=$this->data['Edit']['relevance'];
                  $sip['Sip']['comments']=$this->data['Edit']['comments'];
                  $this->Sip->save($sip);
		  $this->data = null;
            }
            $this->set('sip', $sip);
            $this->set('conversation', $conversation);
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
        }

        function caller_play($id = null) {
            if (!$id) {
                exit();
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $sip = $this->Sip->read(null, $id);
            if ($polid != $sip['Sip']['pol_id'] || $solid != $sip['Sip']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $this->layout = 'voip';
                $this->autoRender = TRUE;
                $this->set('sip_id', $id);
            }
        }

        function called_play($id = null) {
            if (!$id) {
                exit();
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $sip = $this->Sip->read(null, $id);
            if ($polid != $sip['Sip']['pol_id'] || $solid != $sip['Sip']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $this->layout = 'voip';
                $this->autoRender = TRUE;
                $this->set('sip_id', $id);
            }
        }

        function info($id = null) {
            if (!$id) {
                exit();
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $sip = $this->Sip->read(null, $id);
            if ($polid != $sip['Sip']['pol_id'] || $solid != $sip['Sip']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $this->autoRender = false;
                header("Content-Disposition: filename=info".$id.".xml");
                header("Content-Type: application/xhtml+xml; charset=utf-8");
                header("Content-Length: " . filesize($sip['Sip']['flow_info']));
                readfile($sip['Sip']['flow_info']);
                exit();
            }
        }

        function caller($id = null) {
            if (!$id) {
                exit();
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $sip = $this->Sip->read(null, $id);
            if ($polid != $sip['Sip']['pol_id'] || $solid != $sip['Sip']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $this->autoRender = false;
                header("Content-Disposition: filename=caller".$id.".mp3");
                header("Content-Length: " . filesize($sip['Sip']['ucaller']));
                header("Content-Type: audio/mpeg");
                readfile($sip['Sip']['ucaller']);
                exit();
            }
        }

        function called($id = null) {
            if (!$id) {
                exit();
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $sip = $this->Sip->read(null, $id);
            if ($polid != $sip['Sip']['pol_id'] || $solid != $sip['Sip']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $this->autoRender = false;
                header("Content-Disposition: filename=called".$id.".mp3");
                header("Content-Length: " . filesize($sip['Sip']['ucalled']));
                header("Content-Type: audio/mpeg");
                readfile($sip['Sip']['ucalled']);
                exit();
            }
        }

        function mix($id = null) {
            if (!$id) {
                exit();
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $sip = $this->Sip->read(null, $id);
            if ($polid != $sip['Sip']['pol_id'] || $solid != $sip['Sip']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $this->autoRender = false;
                header("Content-Disposition: filename=mix".$id.".mp3");
                header("Content-Length: " . filesize($sip['Sip']['umix']));
                header("Content-Type: audio/mpeg");
                readfile($sip['Sip']['umix']);
                exit();
            }
        }

        function cmds($id = null) {
            if (!$id) {
                exit();
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $sip = $this->Sip->read(null, $id);
            if ($polid != $sip['Sip']['pol_id'] || $solid != $sip['Sip']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $this->autoRender = false;
                header("Content-Disposition: filename=sip_cmds".$id.".txt");
                header("Content-Length: " . filesize($sip['Sip']['commands']));
                header("Content-Type: text");
                readfile($sip['Sip']['commands']);
                exit();
            }
        }

        function pcap($id = null) {
            if (!$id) {
                $id = $this->Session->read('sipid');
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Sip->recursive = -1;
            $sip = $this->Sip->read(null, $id);
            if ($polid != $sip['Sip']['pol_id'] || $solid != $sip['Sip']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $file_pcap = "/tmp/sips_".time()."_".$id.".pcap";
                $this->Xml2Pcap->doPcap($file_pcap, $sip['Sip']['flow_info']);
                $this->autoRender = false;
                header("Content-Disposition: filename=sip_".$id.".pcap");
                header("Content-Type: binary");
                header("Content-Length: " . filesize($file_pcap));
                @readfile($file_pcap);
                unlink($file_pcap);
                exit();
            }
       }
}
?>
