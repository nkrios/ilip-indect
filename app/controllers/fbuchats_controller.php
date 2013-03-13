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
   * Portions created by the Initial Developer are Copyright (C) 2009
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


class FbuchatsController extends AppController {
        var $name = 'Fbuchats';
        var $uses = array('Fbuchat', 'Fbchat');
        var $helpers = array('Html', 'Form', 'Javascript');
        var $components = array('Xml2Pcap', 'Xplico');
        var $paginate = array('limit' => 16, 'order' => array('Fbuchat.user' => 'asc'));

        function beforeFilter() {
                $groupid = $this->Session->read('group');
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                if (!$groupid || !$polid || !$solid) {
                    $this->redirect('/users/login');
                }
        }

        function index() {
            $this->Session->delete('srch_fbchat');
            $solid = $this->Session->read('sol');
            $this->Fbuchat->recursive = -1;
            $filter = array('Fbuchat.sol_id' => $solid);
            // host selezionato
            $host_id = $this->Session->read('host_id');
            if (!empty($host_id) && $host_id["host"] != 0) {
                $filter['Fbuchat.source_id'] = $host_id["host"];
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
                $filter[0]['OR']['Fbuchat.user LIKE'] = "%$srch%";
                $filter[0]['OR']['Fbuchat.comments LIKE'] = "%$srch%";
            }

	    if (!empty($rel)) {
		    $filter[1]['OR']['Fbuchat.relevance >='] = $rel;
		    $filter[1]['OR']['Fbuchat.relevance =='] = '0';
		    $filter[1]['OR']['Fbuchat.relevance'] = null;
	    }

		//check if we are coming from the actual view after changing a value
	    if (!empty($this->data['Edit'])) {
                  $fbu = $this->Fbuchat->read(null, $this->data['Edit']['id']);
                  $fbu['Fbuchat']['relevance']=$this->data['Edit']['relevance'];
                  $fbu['Fbuchat']['comments']=$this->data['Edit']['comments'];
                  $this->Fbuchat->save($fbu);
            }
		$this->data = null;

	    //set parameters for the view
            $msgs = $this->paginate('Fbuchat', $filter);
            $this->set('fb_users', $msgs);
            $this->set('srchd', $srch);
	    $this->set('relevance', $rel);
            $this->set('menu_left', $this->Xplico->leftmenuarray(6) );
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
        }
        
        function user($id = null) {
            if (!$id) {
                $this->redirect('/fbuchats/index');
                die();
            }
            $this->Session->write('fb_user_id', $id);
            $this->redirect('/fbuchats/chats');
            die();
        }
        
        function chats($id = null) {
            $fb_user_id = $this->Session->read('fb_user_id');
            if (empty($fb_user_id)) {
                $this->redirect('/fbuchats/index');
                die();
            }
            $solid = $this->Session->read('sol');
            $this->Fbchat->recursive = -1;
            $filter = array('Fbchat.sol_id' => $solid);
            // host
            $host_id = $this->Session->read('host_id');
            $host_srch = "";
            if (!empty($host_id) && $host_id["host"] != 0) {
                $filter['Fbchat.source_id'] = $host_id["host"];
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
                $filter[0]['OR']['Fbuchat.friend LIKE'] = "%$srch%";
                $filter[0]['OR']['Fbuchat.comments LIKE'] = "%$srch%";
            }

	    if (!empty($rel)) {
		    $filter[1]['OR']['Fbuchat.relevance >='] = $rel;
		    $filter[1]['OR']['Fbuchat.relevance =='] = '0';
		    $filter[1]['OR']['Fbuchat.relevance'] = null;
	    }

		//check if we are coming from the actual view after changing a value
	    if (!empty($this->data['Edit'])) {
                  $fbchat = $this->Fbchat->read(null, $this->data['Edit']['id']);
                  $fbchat['Fbchat']['relevance']=$this->data['Edit']['relevance'];
                  $fbchat['Fbchat']['comments']=$this->data['Edit']['comments'];
                  $this->Fbchat->save($fbchat);

	            $fbu = $this->Fbuchat->read(null, $fb_user_id);
		if($fbu['Fbuchat']['relevance'] < $fbchat['Fbchat']['relevance']){
			$fbu['Fbuchat']['relevance'] = $fbchat['Fbchat']['relevance'];
	                $this->Fbuchat->save($fbu);
		}
            }
		$this->data = null;

            $filter['Fbchat.fbuchat_id'] = $fb_user_id;
            $this->paginate['order'] =  array('Fbchat.capture_date' => 'desc');
            $msgs = $this->paginate('Fbchat', $filter);
            $this->Session->write('srch_fbchat', $srch);
            $this->set('chats', $msgs);
            $this->set('srchd', $srch);
	    $this->set('relevance', $rel);
            $this->set('menu_left', $this->Xplico->leftmenuarray(6) );
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
	}

	function view($id = null) {
                if (!$id) {
                    exit();
                }
                $this->Fbchat->recursive = -1;
                $chat = $this->Fbchat->read(null, $id);
                $this->layout = 'fbchat';
                $this->autoRender = TRUE;
                /* in the template there is a JavaScript */
                $this->set('user', $chat['Fbchat']['user']);
                $this->set('friend', $chat['Fbchat']['friend']);
                $this->set('ct', $chat['Fbchat']['capture_date']);
                $talk = '';
                $fp = fopen($chat['Fbchat']['chat'], 'r');
                while (false != ($line = fgets($fp, 4096))) {
                    $line = trim($line, "\r\n\0");
                    if (stripos($line, '[')  !== false) {
                        $talk = $talk.'<label> <script type="text/javascript"> var txt="'.$line.'"; document.write(txt); </script>'."</label>\n";
                    }
                    else {
                        $talk = $talk.'<p> <script type="text/javascript"> var txt="'.$line.'"; document.write(txt); </script>'."</p>\n";
                    }
                }
                fclose($fp);
                // register visualization
                if (!$chat['Fbchat']['first_visualization_user_id']) {
                    $uid = $this->Session->read('userid');
                    $chat['Fbchat']['first_visualization_user_id'] = $uid;
                    $chat['Fbchat']['viewed_date'] = date("Y-m-d H:i:s");
                    $this->Fbchat->save($chat);
                }
                
                $this->set('chat', $talk);
        }

        function info($id = null) {
            if (!$id) {
                $this->redirect('/users/login');
            }
            else {
                $this->Fbchat->recursive = -1;
                $article = $this->Fbchat->read(null, $id);
                $this->autoRender = false;
                header("Content-Disposition: filename=info".$id.".xml");
                header("Content-Type: application/xhtml+xml; charset=utf-8");
                header("Content-Length: " . filesize($article['Fbchat']['flow_info']));
                readfile($article['Fbchat']['flow_info']);
                exit();
            }
        }

        function pcap($id = null) {
            if (!$id) {
                $this->redirect('/users/login');
            }
            else {
                $this->Fbchat->recursive = -1;
                $article = $this->Fbchat->read(null, $id);
                $file_pcap = "/tmp/fbchat_".time()."_".$id.".pcap";
                $this->Xml2Pcap->doPcap($file_pcap, $article['Fbchat']['flow_info']);
                $this->autoRender = false;
                header("Content-Disposition: filename=fbchat_".$id.".pcap");
                header("Content-Type: binary");
                header("Content-Length: " . filesize($file_pcap));
                @readfile($file_pcap);
                unlink($file_pcap);
                exit();
            }
        }
}
?>
