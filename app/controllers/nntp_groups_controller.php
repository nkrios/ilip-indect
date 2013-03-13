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
require_once 'rfc822_addresses.php';
require_once 'mime_parser.php';

function TmpDir() {
        $base = sys_get_temp_dir();
        if( substr( $base, -1 ) != '/' )
              $base .= '/';
        do {
              $path = $base.'mime-'.mt_rand();
        } while( !mkdir( $path, 0700 ) );
      
        return $path;
}

function AddressList($arr) {
        if (!isset($arr))
            return null;
        $list = null;
        foreach($arr as $data) {
            if ($list != null)
                $list = $list.", ";
            if (isset($data['name']))
                $list = $list." ".$data['name'];
            $list = $list." <".$data['address'].">";
        }
    
        return $list;
}

class NntpGroupsController extends AppController {
        var $name = 'NntpGroups';
        var $uses = 	  array('Nntp_group', 'Nntp_article');
        var $helpers = 	  array('Html', 'Form', 'Javascript');
        var $components = array('Xml2Pcap', 'Xplico');
        var $paginate =   array('limit' => 16, 'order' => array('Nntp_group.name' => 'asc'));

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
            $this->Nntp_group->recursive = -1;
            $filter = array('Nntp_group.sol_id' => $solid);

            // host 
            $host_id = $this->Session->read('host_id');
            if (!empty($host_id) && $host_id["host"] != 0) {
                $filter['Nntp_group.source_id'] = $host_id["host"];
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
                $filter[0]['OR']['Nntp_group.name LIKE'] = "%$srch%";
                $filter[0]['OR']['Nntp_group.comments LIKE'] = "%$srch%";
            }
	    if (!empty($rel)) {
		    $filter[1]['OR']['Nntp_group.relevance >='] = $rel;
		    $filter[1]['OR']['Nntp_group.relevance =='] = '0';
		    $filter[1]['OR']['Nntp_group.relevance'] = null;
	    }
/*
		//check if we are coming from the actual index after changing a value
	    if (!empty($this->data['Edit'])) {
                  $group = $this->Nntp_group->read(null, $this->data['Edit']['id']);
                  $group['Nntp_group']['relevance']=$this->data['Edit']['relevance'];
                  $group['Nntp_group']['comments']=$this->data['Edit']['comments'];
                  $this->Nntp_group->save($group);
            }
		$this->data = null;
*/
	    //set parameters for the view
            $msgs = $this->paginate('Nntp_group', $filter);
            $this->set('nntp_groups', $msgs);
            $this->set('srchd', $srch);
	    $this->set('relevance', $rel);
            $this->set('menu_left', $this->Xplico->leftmenuarray(6) );
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
        }
        
        function grp($id = null) {
            if (!$id) {
                $this->redirect('/nntp_groups/index');
                die();
            }
//            $this->Session->write('nntp_grp_id', $id);
            $this->redirect('/nntp_groups/alist/'.$id);
            die();
        }
        
        function alist($id = null) {
            //$nntp_grp_id = $this->Session->read('nntp_grp_id');
            if (empty($id)) {
                $this->redirect('/nntp_groups/index');
                die();
            }
            $solid = $this->Session->read('sol');
            $filter = array('Nntp_article.sol_id' => $solid);
            $filter['Nntp_article.nntp_group_id'] = $id;

            // host selezionato
            $host_id = $this->Session->read('host_id');
            if (!empty($host_id) && $host_id != 0) {
                $filter['Nntp_article.source_id'] = $host_id;
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

                $this->Nntp_group->recursive = -1;
		$group = $this->Nntp_group->read(null, $id);

		//check if we are coming from the actual view after changing a value
	    if (!empty($this->data['Edit'])) {
                  $article = $this->Nntp_article->read(null, $this->data['Edit']['id']);
                  $article['Nntp_article']['relevance']=$this->data['Edit']['relevance'];
                  $article['Nntp_article']['comments']=$this->data['Edit']['comments'];
                  $this->Nntp_article->save($article);

		if($group['Nntp_group']['relevance'] < $article['Nntp_article']['relevance']){
			$group['Nntp_group']['relevance'] = $article['Nntp_article']['relevance'];
	                $this->Nntp_group->save($group);
		}
		   else if($group['Nntp_group']['relevance'] > $article['Nntp_article']['relevance']){
			$group['Nntp_group']['relevance'] = $article['Nntp_article']['relevance'];
			//check all the relevances to update the parent  relevance to the maximum
                        $nntp_articles = $this->Nntp_article->find('all', array('conditions' => $filter));
			foreach($nntp_articles as $aux){
				if($aux['Nntp_article']['relevance'] > $group['Nntp_group']['relevance']){
					$group['Nntp_group']['relevance'] = $aux['Nntp_article']['relevance'];
				}
			}
	                $this->Nntp_group->save($group);
		   }
                }
                if (!empty($this->data['Edit_Nntp'])) {
                    $group['Nntp_group']['comments']=$this->data['Edit_Nntp']['comments'];
                    $this->Nntp_group->save($group);
                }
		$this->data = null;

            if (!empty($srch)) {
                $filter[0]['OR']['Nntp_article.subject LIKE'] = "%$srch%";
                $filter[0]['OR']['Nntp_article.sender LIKE'] = "%$srch%";
                $filter[0]['OR']['Nntp_article.comments LIKE'] = "%$srch%";
            }

	    if (!empty($rel)) {
		    $filter[1]['OR']['Nntp_article.relevance >='] = $rel;
		    $filter[1]['OR']['Nntp_article.relevance =='] = '0';
		    $filter[1]['OR']['Nntp_article.relevance'] = null;
	    }

            $this->Nntp_article->recursive = -1;
            $this->paginate['order'] =  array('Nntp_article.capture_date' => 'desc');
            $msgs = $this->paginate('Nntp_article', $filter);

            $this->set('nntp_articles', $msgs);
            $this->set('nntp_group', $group);
            $this->set('srchd', $srch);
            $this->set('menu_left', $this->Xplico->leftmenuarray(6) );
	        $this->set('relevance', $rel);
	        $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
	}

	function view($id = null) {
                if (!$id) {
                    exit();
                }
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                $this->set('menu_left', $this->Xplico->leftmenuarray(6) );
	        $this->set('relevanceoptions',$this->Xplico->relevanceoptions());

                $this->Nntp_article->recursive = -1;
                $article = $this->Nntp_article->read(null, $id);

                if ($polid != $article['Nntp_article']['pol_id'] || $solid != $article['Nntp_article']['sol_id']) {
                    $this->redirect('/users/login');
                }
                $this->Session->write('narticleid', $id);

		//save changes
		//check if we are coming from the actual index after changing a value
	    if (!empty($this->data['Edit'])) {
                  $article['Nntp_article']['relevance']=$this->data['Edit']['relevance'];
                  $article['Nntp_article']['comments']=$this->data['Edit']['comments'];
                  $this->Nntp_article->save($article);

                $this->Nntp_group->recursive = -1;
		$group = $this->Nntp_group->read(null, $article['Nntp_article']['nntp_group_id']);

		   if($group['Nntp_group']['relevance'] < $article['Nntp_article']['relevance']){
			$group['Nntp_group']['relevance'] = $article['Nntp_article']['relevance'];
	                $this->Nntp_group->save($group);
		   }
		   else if($group['Nntp_group']['relevance'] > $article['Nntp_article']['relevance']){
			$group['Nntp_group']['relevance'] = $article['Nntp_article']['relevance'];
			//check all the relevances to update the parent  relevance to the maximum
		        $filter['Nntp_article.nntp_group_id'] = $article['Nntp_article']['nntp_group_id'];
                        $nntp_articles = $this->Nntp_article->find('all', array('conditions' => $filter));
			foreach($nntp_articles as $aux){
				if($aux['Nntp_article']['relevance'] > $group['Nntp_group']['relevance']){
					$group['Nntp_group']['relevance'] = $aux['Nntp_article']['relevance'];
				}
			}
	                $this->Nntp_group->save($group);
		   }
            }
		  $this->data = null;

                $this->set('article', $article);
                
                /* destroy last tmp dir */
                $tmp_dir = $this->Session->read('mimedir');
                system('rm -rf '.$tmp_dir);
                /* create dir to put decoded data */
                $tmp_dir = TmpDir();
                $this->Session->write('mimedir', $tmp_dir);

                /* decode mime */
                $mime_parser = new mime_parser_class;
                $mime_parser->mbox = 0; // single message file
                $mime_parser->decode_bodies = 1; // decde bodies
                $mime_parser->ignore_syntax_errors = 1;
                $mime_parser->extract_addresses = 1;
                $parse_parameters = array(
                    'File' => $article['Nntp_article']['mime_path'],
                    'SaveBody' => $tmp_dir, // save the message body parts to a directory
                    'SkipBody' => 1, // Do not retrieve or save message body parts
                    );
                
                if (!$mime_parser->Decode($parse_parameters, $mime_decoded)) {
                    
                }
                elseif ($mime_parser->Analyze($mime_decoded[0], $mime_parsed)) {
                    /* add 'to' and 'from' string */
                    if (isset($mime_parsed['From']))
                        $mime_parsed['from'] = AddressList($mime_parsed['From']);
                    else
                        $mime_parsed['from'] = '---';
                    if (isset($mime_parsed['To']))
                        $mime_parsed['to'] = AddressList($mime_parsed['To']);
                    else
                        $mime_parsed['to'] = '---';
                            
                    $this->set('mailObj', $mime_parsed);
                    //print_r($mime_parsed);

                    // register visualization
                    if (!$article['Nntp_article']['first_visualization_user_id']) {
                        $uid = $this->Session->read('userid');
                        $article['Nntp_article']['first_visualization_user_id'] = $uid;
                        $article['Nntp_article']['viewed_date'] = date("Y-m-d H:i:s");
                        $this->Nntp_article->save($article);
                    }
                }
        }

        function eml() {
            $id = $this->Session->read('narticleid');
            if (!$id) {
                $this->redirect('/users/login');
            }
            else {
                $this->Nntp_article->recursive = -1;
                $article = $this->Nntp_article->read(null, $id);
                $this->autoRender = false;
                header("Content-Disposition: attachment; filename=mail".$id.".eml");
                header("Content-Type: message/rfc822");
                header("Content-Length: " . filesize($article['Nntp_article']['mime_path']));
                readfile($article['Nntp_article']['mime_path']);
                exit();
            }
        }

        function info() {
            $id = $this->Session->read('narticleid');
            if (!$id) {
                $this->redirect('/users/login');
            }
            else {
                $this->Nntp_article->recursive = -1;
                $article = $this->Nntp_article->read(null, $id);
                $this->autoRender = false;
                header("Content-Disposition: filename=info".$id.".xml");
                header("Content-Type: application/xhtml+xml; charset=utf-8");
                header("Content-Length: " . filesize($article['Nntp_article']['flow_info']));
                readfile($article['Nntp_article']['flow_info']);
                exit();
            }
        }

        function content($path=null) {
            $tmp_dir = $this->Session->read('mimedir');
            if (!$path || !$tmp_dir) {
                exit();
            }
            $this->autoRender = false;
            header("Content-Type: binary");
            readfile($tmp_dir."/".$path);
            //echo $path;
            exit();
        }

        function pcap() {
            $id = $this->Session->read('narticleid');
            if (!$id) {
                $this->redirect('/users/login');
            }
            else {
                $this->Nntp_article->recursive = -1;
                $article = $this->Nntp_article->read(null, $id);
                $file_pcap = "/tmp/nntp_".time()."_".$id.".pcap";
                $this->Xml2Pcap->doPcap($file_pcap, $article['Nntp_article']['flow_info']);
                $this->autoRender = false;
                header("Content-Disposition: filename=nntp_".$id.".pcap");
                header("Content-Type: binary");
                header("Content-Length: " . filesize($file_pcap));
                @readfile($file_pcap);
                unlink($file_pcap);
                exit();
            }
        }
}
?>
