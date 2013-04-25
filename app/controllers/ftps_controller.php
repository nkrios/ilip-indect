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



class FtpsController extends AppController {

        var $name = 'Ftps';
        var $uses = array('Ftp', 'Ftp_file');
        var $helpers = array('Html', 'Form', 'Javascript');
        var $components = array('Xml2Pcap', 'Xplico');
        var $paginate = array('limit' => 16, 'order' => array('Ftp.capture_date' => 'desc'));

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
            $this->Ftp->recursive = -1;
            $filter = array('Ftp.sol_id' => $solid);
            // host selezionato
            $host_id = $this->Session->read('host_id');
            if (!empty($host_id) && $host_id["host"] != 0) {
                $filter['Ftp.source_id'] = $host_id["host"];
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
                $filter[0]['OR']['Ftp.url LIKE'] = "%$srch%";
                $filter[0]['OR']['Ftp.username LIKE'] = "%$srch%";
                $filter[0]['OR']['Ftp.comments LIKE'] = "%$srch%";
            }
	    if (!empty($rel)) {
		    $filter[1]['OR']['Ftp.relevance >='] = $rel;
		    $filter[1]['OR']['Ftp.relevance =='] = '0';
		    $filter[1]['OR']['Ftp.relevance'] = null;
	    }

/*
		//check if we are coming from the actual index after changing a value
	    if (!empty($this->data['Edit'])) {
                  $ftp = $this->Ftp->read(null, $this->data['Edit']['id']);
                  $ftp['Ftp']['relevance']=$this->data['Edit']['relevance'];
                  $ftp['Ftp']['comments']=$this->data['Edit']['comments'];
                  $this->Ftp->save($ftp);
            }
		$this->data = null;
*/
	    //set parameters for the view
            $msgs = $this->paginate('Ftp', $filter);
            $this->set('ftps', $msgs);
            $this->set('srchd', $srch);
	    $this->set('relevance', $rel);
            $this->set('menu_left', $this->Xplico->leftmenuarray(5) );
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
        }

        function view($id = null) {
            if (!$id) {
                if (!$this->Session->check('ftpid'))
                    $this->redirect('/users/login');
                else
                    $id = $this->Session->read('ftpid');
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            
            $this->set('menu_left', $this->Xplico->leftmenuarray(5) );

            $this->Ftp->recursive = -1;
            $ftp = $this->Ftp->read(null, $id);
            if ($polid != $ftp['Ftp']['pol_id'] || $solid != $ftp['Ftp']['sol_id']) {
                $this->redirect('/users/login');
            }
            $this->Session->write('ftpid', $id);

            /* files */
            $this->Ftp_file->recursive = -1;
            $filter = array('Ftp_file.sol_id' => $solid);
            $filter['Ftp_file.ftp_id'] = $id;

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


	    //check if we are coming from the actual view after changing a value
	    if (!empty($this->data['EditRel'])) {
            $ftp_file = $this->Ftp_file->read(null, $this->data['EditRel']['id']);
            $ftp_file['Ftp_file']['relevance']=$this->data['EditRel']['relevance'];
            $this->Ftp_file->save($ftp_file);

    		if($ftp['Ftp']['relevance'] < $ftp_file['Ftp_file']['relevance']){
    	       $ftp['Ftp']['relevance'] = $ftp_file['Ftp_file']['relevance'];
    	       $this->Ftp->save($ftp);
    		}
    		else if($ftp['Ftp']['relevance'] > $ftp_file['Ftp_file']['relevance']){
    			$ftp['Ftp']['relevance'] = $ftp_file['Ftp_file']['relevance'];
    			//check all the relevances to update the parent ftp relevance to the maximum
                $ftp_files = $this->Ftp_file->find('all', array('conditions' => $filter));
    			foreach($ftp_files as $aux){
    				if($aux['Ftp_file']['relevance'] > $ftp['Ftp']['relevance']){
    					$ftp['Ftp']['relevance'] = $aux['Ftp_file']['relevance'];
    				}
    			}
                $this->Ftp->save($ftp);
    		}
        }else if(!empty($this->data['EditCom'])){
            $ftp_file = $this->Ftp_file->read(null, $this->data['EditCom']['id']);
            $ftp_file['Ftp_file']['comments']=$this->data['EditCom']['comments'];
            $this->Ftp_file->save($ftp_file);
        }



	    if (!empty($this->data['Edit_Ftp'])) {
                  $ftp['Ftp']['comments']=$this->data['Edit_Ftp']['comments'];
                  $this->Ftp->save($ftp);
	    }
	    $this->data = null;

	    //prepare the filter with the searching conditions
            if (!empty($srch)) {
                $filter[0]['OR']['Ftp_file.filename LIKE'] = "%$srch%";
                $filter[0]['OR']['Ftp_file.file_path LIKE'] = "%$srch%";
                $filter[0]['OR']['Ftp_file.comments LIKE'] = "%$srch%";
            }

	    if (!empty($rel)) {
		    $filter[1]['OR']['Ftp_file.relevance >='] = $rel;
		    $filter[1]['OR']['Ftp_file.relevance =='] = '0';
		    $filter[1]['OR']['Ftp_file.relevance'] = null;
	    }

            // register visualization
            if (!$ftp['Ftp']['first_visualization_user_id']) {
                $uid = $this->Session->read('userid');
                $ftp['Ftp']['first_visualization_user_id'] = $uid;
                $ftp['Ftp']['viewed_date'] = date("Y-m-d H:i:s");
                $this->Ftp->save($ftp);
            }
						

            $this->paginate['order'] = array('Ftp_file.capture_date' => 'desc');
            $ftp_files = $this->paginate('Ftp_file', $filter);
            
            $this->set('ftp', $ftp);
            $this->set('ftp_file', $ftp_files);
	    $this->set('ftp_id',$id);
            $this->set('srchd', $srch);
	    $this->set('relevance', $rel);
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
        }
        
        function cmd() {
            $id = $this->Session->read('ftpid');
            if (!$id) {
                $this->redirect('/users/login');
            }
            else {
                $this->Ftp->recursive = -1;
                $ftp = $this->Ftp->read(null, $id);
                $this->autoRender = false;
                header("Content-Disposition: filename=ftp_cmd".$id.".txt");
                header("Content-Type: text");
                header("Content-Length: " . filesize($ftp['Ftp']['cmd_path']));
                readfile($ftp['Ftp']['cmd_path']);
                exit();
            }
        }

        function info() {
            $id = $this->Session->read('ftpid');
            if (!$id) {
                $this->redirect('/users/login');
            }
            else {
                $this->Ftp->recursive = -1;
                $ftp = $this->Ftp->read(null, $id);
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                if ($polid != $ftp['Ftp']['pol_id'] || $solid != $ftp['Ftp']['sol_id']) {
                    $this->redirect('/users/login');
                }
                $this->autoRender = false;
                header("Content-Disposition: filename=info".$id.".xml");
                header("Content-Type: application/xhtml+xml; charset=utf-8");
                header("Content-Length: " . filesize($ftp['Ftp']['flow_info']));
                readfile($ftp['Ftp']['flow_info']);
                exit();
            }
        }

        function info_data($id_data = null) {
            $id = $this->Session->read('ftpid');
            if (!$id || !$id_data) {
                die();
            }
            else {
                $this->Ftp_file->recursive = -1;
                $ftp_file = $this->Ftp_file->read(null, $id_data);
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                if ($polid != $ftp_file['Ftp_file']['pol_id'] || $solid != $ftp_file['Ftp_file']['sol_id']) {
                    die();
                }
                $this->autoRender = false;
                header("Content-Disposition: filename=info_data".$id_data.".xml");
                header("Content-Type: application/xhtml+xml; charset=utf-8");
                header("Content-Length: " . filesize($ftp_file['Ftp_file']['flow_info']));
                readfile($ftp_file['Ftp_file']['flow_info']);
                exit();
            }
        }

        function data_file($id_data = null) {
            $id = $this->Session->read('ftpid');
            if (!$id || !$id_data) {
                $this->redirect('/users/login');
            }
            else {
                $this->Ftp_file->recursive = -1;
                $ftp_data = $this->Ftp_file->read(null, $id_data);
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                if ($polid != $ftp_data['Ftp_file']['pol_id'] || $solid != $ftp_data['Ftp_file']['sol_id']) {
                    die();
                }
                $this->autoRender = false;
                header('Content-Disposition: filename="' . $ftp_data['Ftp_file']['filename'].'"');
                header("Content-Type: bin");
                header("Content-Length: " . filesize($ftp_data['Ftp_file']['file_path']));
                readfile($ftp_data['Ftp_file']['file_path']);
                //print_r($ftp_data);
                exit();
            }
        }

        function pcap($id = null) {
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            if (!$id) {
                $id = $this->Session->read('ftpid');
                if (!$id)
                    die();
                $this->Ftp->recursive = -1;
                $ftp = $this->Ftp->read(null, $id);
                if ($polid != $ftp['Ftp']['pol_id'] || $solid != $ftp['Ftp']['sol_id']) {
                    die();
                }
                $flow_info = $ftp['Ftp']['flow_info'];
            }
            else {
                $this->Ftp_file->recursive = -1;
                $ftp_file = $this->Ftp_file->read(null, $id);
                if ($polid != $ftp_file['Ftp_file']['pol_id'] || $solid != $ftp_file['Ftp_file']['sol_id']) {
                    die();
                }
                $flow_info = $ftp_file['Ftp_file']['flow_info'];
            }
            $file_pcap = "/tmp/ftp_".time()."_".$id.".pcap";
            $this->Xml2Pcap->doPcap($file_pcap, $flow_info);
            $this->autoRender = false;
            header("Content-Disposition: filename=ftp_".$id.".pcap");
            header("Content-Type: binary");
            header("Content-Length: " . filesize($file_pcap));
            @readfile($file_pcap);
            unlink($file_pcap);
            exit();
       }
}
?>
