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

class MmsController extends AppController {
        var $name = 'Mms';
        var $uses = array('Mm', 'Mmscontent');
        var $helpers = array('Html', 'Form', 'Javascript');
        var $components = array('Xml2Pcap', 'Xplico');
        var $paginate = array('limit' => 16, 'order' => array('Mm.capture_date' => 'desc'));

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
            $this->Mm->recursive = -1;
            $filter = array('Mm.sol_id' => $solid);
            // host selezionato
            $host_id = $this->Session->read('host_id');
            if (!empty($host_id) && $host_id["host"] != 0) {
                $filter['Mm.source_id'] = $host_id["host"];
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
                $filter[0]['OR']['Mm.from_num LIKE'] = "%$srch%";
                $filter[0]['OR']['Mm.to_num LIKE'] = "%$srch%";
                $filter[0]['OR']['Mm.comments LIKE'] = "%$srch%";
            }
	    if (!empty($rel)) {
		    $filter[1]['OR']['Mm.relevance >='] = $rel;
		    $filter[1]['OR']['Mm.relevance =='] = '0';
		    $filter[1]['OR']['Mm.relevance'] = null;
	    }

		//check if we are coming from the actual index after changing a value
/*
	    if (!empty($this->data['Edit'])) {
                  $mm = $this->Mm->read(null, $this->data['Edit']['id']);
                  $mm['Mm']['relevance']=$this->data['Edit']['relevance'];
                  $mm['Mm']['comments']=$this->data['Edit']['comments'];
                  $this->Mm->save($feed);
            }
		$this->data = null;
*/
	    //set parameters for the view
            $msgs = $this->paginate('Mm', $filter);
            $this->set('mms', $msgs);
            $this->set('srchd', $srch);
	    $this->set('relevance', $rel);
            $this->set('menu_left', $this->Xplico->leftmenuarray(5) );
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
        }

        function view($id = null) {
                if (!$id) {
                    $this->redirect('/users/login');
                }

                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                $this->set('menu_left', $this->Xplico->leftmenuarray(5) );

                $this->Mm->recursive = -1;
                $mm = $this->Mm->read(null, $id);
                if ($polid != $mm['Mm']['pol_id'] || $solid != $mm['Mm']['sol_id']) {
                    $this->redirect('/users/login');
                }

                $this->Session->write('mmid', $id);

                /* files */
                $this->Mmscontent->recursive = -1;
                $filter = array('Mmscontent.sol_id' => $solid);
                $filter['Mmscontent.mm_id'] = $id;

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
        if (!empty($this->data['EditCom'])) {

            $mms_content = $this->Mmscontent->read(null, $this->data['EditCom']['id']);
            $mms_content['Mmscontent']['comments']=$this->data['EditCom']['comments'];
            $this->Mmscontent->save($mms_content);

        }else if (!empty($this->data['EditRel'])) {

            $mms_content = $this->Mmscontent->read(null, $this->data['EditRel']['id']);
            $mms_content['Mmscontent']['relevance']=$this->data['EditRel']['relevance'];
            $this->Mmscontent->save($mms_content);

            if($mm['Mm']['relevance'] < $mms_content['Mmscontent']['relevance']){
                $mm['Mm']['relevance'] = $mms_content['Mmscontent']['relevance'];
                $this->Mm->save($mm);
            }else if($mm['Mm']['relevance'] > $mms_content['Mmscontent']['relevance']){
                $mm['Mm']['relevance'] = $mms_content['Mmscontent']['relevance'];
                //check all the relevances to update the parent ftp relevance to the maximum
                $mms_contents = $this->Mmscontent->find('all', array('conditions' => $filter));
                foreach($mms_contents as $aux){
                    if($aux['Mmscontent']['relevance'] > $mm['Mm']['relevance']){
                        $mm['Mm']['relevance'] = $aux['Mmscontent']['relevance'];
                    }
                }
                $this->Mm->save($mm);
            }
        }


            if (!empty($this->data['Edit_Mm'])) {
                $mm['Mm']['comments']=$this->data['Edit_Mm']['comments'];
                $this->Mm->save($mm);
            }
//	        $this->data = null;

                //prepare the filter with the searching conditions
                if (!empty($srch)) {
                    $filter[0]['OR']['Mmscontent.filename LIKE'] = "%$srch%";
                    $filter[0]['OR']['Mmscontent.file_path LIKE'] = "%$srch%";
                    $filter[0]['OR']['Mmscontent.comments LIKE'] = "%$srch%";
                }
                if (!empty($rel)) {
		    $filter[1]['OR']['Mmscontent.relevance >='] = $rel;
		    $filter[1]['OR']['Mmscontent.relevance =='] = '0';
		    $filter[1]['OR']['Mmscontent.relevance'] = null;
                }

                // register visualization
                if (!$mm['Mm']['first_visualization_user_id']) {
                    $uid = $this->Session->read('userid');
                    $mm['Mm']['first_visualization_user_id'] = $uid;
                    $mm['Mm']['viewed_date'] = date("Y-m-d H:i:s");
                    $this->Mm->save($mm);
                }

                $this->paginate['order'] =  array('Mmscontent.id' => 'asc');
                $mms_contents = $this->paginate('Mmscontent', $filter);

                $this->set('mm', $mm);
                $this->set('mmscontent', $mms_contents);
                $this->set('srchd', $srch);
	        $this->set('relevance', $rel);
	        $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
        }

        function info($id = null) {
            if (!$id) {
                exit();
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Mm->recursive = -1;
            $mm = $this->Mm->read(null, $id);
            if ($polid != $mm['Mm']['pol_id'] || $solid != $mm['Mm']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $this->autoRender = false;
                header("Content-Disposition: filename=info".$id.".xml");
                header("Content-Type: application/xhtml+xml; charset=utf-8");
                header("Content-Length: " . filesize($mm['Mm']['flow_info']));
                readfile($mm['Mm']['flow_info']);
                exit();
            }
        }

        function data_file($id_data = null) {
            $id = $this->Session->read('mmid');
            if (!$id || !$id_data) {
                exit();
            }
            else {
                $this->Mmscontent->recursive = -1;
                $mm_data = $this->Mmscontent->read(null, $id_data);
                if ( $mm_data['Mmscontent']['mm_id'] == $id) {
                    $this->autoRender = false;
                    header("Content-Disposition: filename=" . $mm_data['Mmscontent']['filename']);
                    header("Content-Type: " . $mm_data['Mmscontent']['content_type']);
                    header("Content-Length: " . filesize($mm_data['Mmscontent']['file_path']));
                    readfile($mm_data['Mmscontent']['file_path']);
                    //print_r($mm_data);
                }
                exit();
            }
        }

        function pcap($id = null) {
            if (!$id) {
                $id = $this->Session->read('mmid');
            }
            $polid = $this->Session->read('pol');
            $solid = $this->Session->read('sol');
            $this->Mm->recursive = -1;
            $mm = $this->Mm->read(null, $id);
            if ($polid != $mm['Mm']['pol_id'] || $solid != $mm['Mm']['sol_id']) {
                $this->redirect('/users/login');
            }
            else {
                $file_pcap = "/tmp/mms_".time()."_".$id.".pcap";
                $this->Xml2Pcap->doPcap($file_pcap, $mm['Mm']['flow_info']);
                $this->autoRender = false;
                header("Content-Disposition: filename=mms_".$id.".pcap");
                header("Content-Type: binary");
                header("Content-Length: " . filesize($file_pcap));
                @readfile($file_pcap);
                unlink($file_pcap);
                exit();
            }
       }
}
?>
