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
class UsersController extends AppController
{
    var $helpers = array('Html', 'Form', 'Javascript', 'Ajax' );
    var $components = array('RequestHandler', 'Security', 'Xplico');
    var $uses = array('Param', 'User', 'Group');
    
    function beforeFilter() {
        // data input
        if (!empty($this->data)) {
            $this->Security->requirePost('register');
            $this->Security->requirePost('login');
        }
        $this->Security->blackHoleCallback='invalid';
    }

    function invalid() {
        header('HTTP/x 400 Bad Request');
        echo('<h1>HTTP: 400 Bad Request</h1>');
        echo('<p>We\'re sorry - there has been a problem processing your request.  Please try submitting the form again.</p>');
        die();
    }

    function about() {
    }

    function licenses() {
    }

    function cc_by_nc_sa() {
        $this->layout = 'licenses';
    }

    function gpl() {
        $this->layout = 'licenses';
    }    

    function help() {
        $solid = $this->Session->read('sol');
        if (isset($solid)) {
            $this->set('menu_left', $this->Xplico->leftmenuarray(0));
        }
        else {
            $polid = $this->Session->read('pol');
            if (isset($polid)) {
                $this->set('menu_left', 
                           array('active' => '0', 'sections' => array(
                                     array('name' => __('Case', true), 'sub' => array(
                                               array('name' => __('Cases', true), 'link' => '/pols'),
                                               array('name' => __('Sessions', true), 'link' => '/sols/index')
                                               )
                                         )
                                     )
                               )
                    );
            }
            else {
                $this->set('menu_left', 
                           array('active' => '0', 'sections' => array(
                                     array('name' => __('Case', true), 'sub' => array(
                                               array('name' => __('Cases', true), 'link' => '/pols')
                                               )
                                         )
                                     )
                               )
                    );
            }
        }
        
    }

    function register() {
        if (!empty($this->data)) {
            $san = new Sanitize();
            $this->data['User']['userlogin'] = $san->paranoid($this->data['User']['userlogin']);
            $this->data['User']['email'] = $san->paranoid($this->data['User']['email'],
                                                               array('@', '.', '-', '+'));
            if (!isset($this->data['User']['first_name'])) {
                $this->data['User']['first_name'] = '';
                $this->data['User']['last_name'] = '';
            }
            else {
                $this->data['User']['first_name'] = $san->paranoid($this->data['User']['first_name'],
                                                                   array('\'', ' '));
                $this->data['User']['last_name'] = $san->paranoid($this->data['User']['last_name'],
                                                                  array('\'', ' '));
            }
            $this->User->set($this->data);
            if ($this->User->validates()) {
                if ($this->User->findByUsername($this->data['User']['userlogin'])) {
                    $this->User->invalidate('username', __('This user already exists.', true));
                }
                else {
                    if ($this->User->findByEmail($this->data['User']['email'])) {
                        $this->User->invalidate('email', __('Please, a valid email!', true));
                    }
                    else {
                        // create group
                        $this->data['Group']['name'] = $this->data['User']['userlogin'];
                        $this->Group->create();
                        if ($this->Group->save($this->data)) {
                            $this->data['User']['password'] = md5($this->data['User']['password']);
                            $this->data['User']['em_key'] = md5($this->data['User']['email'].$this->data['User']['password'].time());
                            $gid = $this->Group->getID();
                            $this->data['User']['group_id'] = $gid;
                            $this->User->create();
                            if ($this->User->save($this->data)) {
                                if (1) {
                                    // send email to confirm registration
                                    mail($this->data['User']['email'], "Xplico - Account Activation Request",
                                         "To confirm click the link below\n http://demo.xplico.org/users/registerConfirm/".$this->data['User']['em_key']."\n",
                                         "From: register@xplico.org");
                                    $this->Session->setFlash(__('To complete registration wait the email', true));
                                }
                                else {
                                    $this->Session->setFlash(__('Registration Completed', true));
                                    $this->User->saveField('em_checked', 1);
                                }
                                $this->redirect('/users/index');
                            }
                            else {
                                $this->Group->delete($gid);
                                $this->Session->setFlash(__('There was a problem saving this information', true));
                            }
                        }
                    }
                }
            }
            else {
                $this->Session->setFlash(__('Check the errors below.', true));
            }
        }
    }
    
    function registerConfirm($key = null) {
        if ($key != null) {
            $san = new Sanitize();
            $em_key = $key;
            $em_key = $san->paranoid($em_key);
            $results = $this->User->findByEm_key($em_key);
            if (!empty($results)) {
                $results['User']['em_checked'] = 1;
                $this->User->save($results);
                $this->Session->setFlash(__('Registration Completed.', true));
            }
            else {
                $this->redirect('/users/login');
            }
        }
        else {
            $this->redirect('/users/login');
        }
    }
    
    function resend_reg() {
        // resend registration
        if (!empty($this->data)) {
            $user = $this->User->findByEmail($this->data['User']['email']);
            if (!empty($user)) {
                $em_key = $user['User']['em_key'];
                // send email to confirm registration
                mail($this->data['User']['email'], "Xplico - Account Activation Request",
                     "To confirm click your personal link below\n http://demo.xplico.org/users/registerConfirm/".$em_key."\n",
                     "From: register@xplico.org");
                $this->Session->setFlash(__('To complete registration wait the email', true));
            }
            $this->redirect('/users/index');
        }
    }
/*
    function login_admins(){
            if (!empty ($this->data['User']['userlogin']) && !empty ($this->data['User']['password'])) {
            if ($results && $results['User']['password'] == md5($this->data['User']['password']) && $results['User']['em_checked'] == 1) {
            // admin privilages
            $this->Session->write('admin', 1);
            $this->redirect('/admins');
    }
*/

    function login($lan = NULL) {
        $this->Session->delete('certificate_error');
        $this->Session->delete('profile_error');

        if ($lan != NULL) {
            $this->Session->write('Config.language', $lan);
        }

        if (!is_writable("/opt/xplico/xi/app/tmp/cache")) {
            $this->Session->setFlash(__("Error, /opt/xplico/xi/app/tmp/cache path is not writable, please fix permissions and reload", true));
             $register = $this->Param->findByName('register');
             $this->Session->write('register', $register['Param']['nvalue']);
             $this->set('ParamStartXplico', 'no');
             $this->set('isXplicoRunning', false);
             $this->set('register', $register['Param']['nvalue']);
             
             return;
        }
        
        $isXplicoRunning = $this->Xplico->checkXplicoStatus();
///////////////////
$isXplicoRunning=1;
///////////////////
	if ($isXplicoRunning == 0) {
            $this->Session->setFlash(__('Xplico is not running!<br/><br/>
		For starting Xplico, please choose <u>one</u> of these options <u>as root</u>: <br /><br />
		a) If you are using the Ubuntu/Debian package, run: "/etc/init.d/xplico start" <br />
		b) Run: "/opt/xplico/script/sqlite_demo.sh" <br />', true));      
        }
	else {
          if ($this->Session->check('user')) {
              $this->redirect('/pols/index');
          }
          $this->set('error', false);

          //check if certificate is valid and it has our login field
          if(isset($_SERVER['SSL_CLIENT_VERIFY']) && $_SERVER['SSL_CLIENT_VERIFY'] != 'NONE'){
            if( $_SERVER['SSL_CLIENT_VERIFY'] == 'SUCCESS' && isset($_SERVER['SSL_CLIENT_S_DN_Email'])){ $user_login = $_SERVER['SSL_CLIENT_S_DN_Email']; }
            else{
                $this->Session->write('certificate_error', 1);
                $this->redirect('/users/certificate_error/');
            }
          }
          else if (!empty ($this->data['User']['userlogin']) && !empty ($this->data['User']['password'])) { $user_login = $this->data['User']['userlogin']; }
          else if ( (empty ($this->data['User']['userlogin']) && !empty ($this->data['User']['password']) ) || (!empty ($this->data['User']['userlogin']) && empty ($this->data['User']['password'])) ) {
              unset($this->data['User']['password']);
              $this->Session->setFlash(__('Please, fill up both fields', true));
          }
//          else{ unset($this->data['User']['password']); }

          if(isset($user_login)){
                //email and userlogin have the same value (this allows to change the userlogin easily in the future)
                $results = $this->User->findByUserlogin($user_login);
                if($results){
                    $this->Session->write('userid', $results['User']['id']);
                    $this->Session->write('user', $user_login);
                    $this->Session->write('username', $results['User']['username']);
                    $this->Session->write('last_login', $results['User']['last_login']);
                    $this->Session->write('group', $results['User']['group_id']);
                    $this->Session->write('help', 1);
                    $this->User->id = $results['User']['id'];
                    $this->User->saveField('last_login', date("Y-m-d H:i:s"));
                    $this->User->saveField('login_num', $results['User']['login_num'] + 1);

                    if ($results['User']['group_id'] == 1) {
                        // admin privilages
                        $this->Session->write('admin', 1);
                        $this->redirect('/admins');
                    }
                    else {
                        $this->redirect('/pols/index');
                    }
                }//user is in the application
                else{
                    $this->Session->write('profile_error', 1);
                    $this->redirect('/users/profile_error/');
                }
          }//if(isset($user_login))
	}//else if ($isXplicoRunning == 0) {

        $register = $this->Param->findByName('register');
        $this->Session->write('register', $register['Param']['nvalue']);
	$this->set('ParamStartXplico', 'no');
        $this->set('isXplicoRunning', $isXplicoRunning);
        $this->set('register', $register['Param']['nvalue']);
    }

    function certificate_error() {
        if(!$this->Session->check('certificate_error')){
            $this->redirect('/users/login');
        }
        //at this point the certificate is not valid
        $this->Session->destroy();
        $this->Session->setFlash(__('The certificate provided is not valid', true));
    }

    function profile_error() {
        if(!$this->Session->check('profile_error')){
            $this->redirect('/users/login');
        }
        $this->Session->setFlash(__('The user provided does not have a profile in the application. Please, contact the administrator', true));
        $this->Session->destroy();
    }

    function cpassword($id = NULL) {
        $uid = $this->Session->read('userid');
        if ($id != NULL && !$this->Session->check('admin')) {
            $this->redirect('/users/login');
            die();
        }
        else if ($id == NULL)
            $id = $uid;
        if (!empty($this->data)) {
            $id = $this->data['User']['id'];
            $this->User->recursive = -1;
            $usr = $this->User->read(null, $id);
            if (!empty($usr) && $usr['User']['password'] == md5($this->data['User']['opassword'])) {
                if ($this->data['User']['password'] == $this->data['User']['rpassword']) {
                    if ($this->User->saveField('password', $this->data['User']['password'], true)) {
                        // salvo in formato md5
                        $this->User->saveField('password', md5($this->data['User']['password']), true);
                        $this->Session->setFlash(__('New password activated!', true));
                        $this->redirect(array('action' => 'login'));
                    }
                    else {
                        $this->Session->setFlash(__('You can not change the password', true));
                    }
                }
                else {
                    $this->Session->setFlash(__('New password error', true));
                }
            }
            else {           
                $this->Session->setFlash(__('Password wrong', true));
            }
        }
        $this->set('id', $id);
    }
    
    function logout() {
        $this->Session->destroy();
    }
    
    function index() {
        if ($this->Session->check('userid')) {
            /*
            $uid = $this->Session->read('userid');
            $this->User->recursive = -1;
            $usr = $this->User->read(null, $uid);
            $this->set('User', $usr['User']);
            */
            $this->redirect('/pols/index');
        }
        else{
            $this->redirect('/users/login');
        }
    }
}
?>
