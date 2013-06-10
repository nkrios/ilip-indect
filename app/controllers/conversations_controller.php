<?php

class ConversationsController extends AppController{

	var $name = 'Conversations';
        var $uses = array('Conversation', 'Stream');
	var $hasMany = 'Streams';
        var $components = array('Xml2Pcap', 'Xplico');

        function beforeFilter() {
                $groupid = $this->Session->read('group');
                $polid = $this->Session->read('pol');
                $solid = $this->Session->read('sol');
                if (!$groupid || !$polid || !$solid) {
                    $this->redirect('/users/login');
                }
        }

	function index($id = NULL, $delete = NULL){
	    //as user is checking all conversations, there is no more sipid or rtpid
	    unset($_SESSION['sipid']);
	    unset($_SESSION['rtpid']);

            $filter = null;
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
                $filter['Conversations.name LIKE'] = "%$srch%";
            }
            $this->set('conversations', $this->paginate('Conversation', $filter));
//		$this->set('conversations', $this->Conversation->find('all'));	
		if(!empty($delete)){
			$this->Conversation->delete($delete, true); 
		}
            $this->set('srchd', $srch);
	    $this->set('relevance', $rel);
            $this->set('menu_left', $this->Xplico->leftmenuarray(4) );
	    $this->set('relevanceoptions',$this->Xplico->relevanceoptions());
	}


	function view($id = NULL){
                if (!$id) {
                    //exit();
                    $this->redirect('/users/login');
                }
                $this->Conversation->recursive = -1;
		$this->set('conversation', $this->Conversation->read(NULL, $id));	
//		App::import('Model', 'Streams');
//		$stream = new Stream();
		$conditions = array('Stream.conversation_id' => $id);
        $this->Stream->recursive = -1;
		$streams = $this->Stream->find('all', array('conditions'=>$conditions));

		$this->set('streams', $streams);
		$this->set('menu_left', $this->Xplico->leftmenuarray(4) );
		$this->set('relevanceoptions',$this->Xplico->relevanceoptions());
	}


	function update($id = NULL){
		if(empty($this->data['Conversation'])){ //viene desde index.ctp
			$this->data = $this->Conversation->read(NULL, $id);
		}else{ //viene desde update.ctp
			if($this->Conversation->save($this->data)){
				$name = $this->data['Conversation']['nameHidden'];
				$this->Session->setFlash('The conversation has been updated');
				$this->redirect(array('controller'=>'Conversations', $this->set('name', $name)));
			}
		}
		$this->set('conversation', $this->Conversation->read(NULL, $id));
		$this->set('menu_left', $this->Xplico->leftmenuarray(4) );
		$this->set('relevanceoptions',$this->Xplico->relevanceoptions());
	}


	function edit($id = NULL, $option){

	        $this->set('menu_left', $this->Xplico->leftmenuarray(4) );
		$this->set('relevanceoptions',$this->Xplico->relevanceoptions());

		$voip_absolute_path = "/opt/voip/transcript/voip_data/";
		$bin_absolute_path = "/opt/voip/transcript/bin/";
		$users_absolute_path = "/opt/voip/transcript/user_data/";

		//App::import('Model', 'Streams');
		//$stream = new Stream();
                $this->Stream->recursive = -1;
		$conditions = array('Stream.conversation_id' => $id);
		$streams = $this->Stream->find('all', array('conditions'=>$conditions));
		$conversation = $this->Conversation->read(NULL, $id);

		//$lines = sizeof(any of these arrays) is the number of fragments
		$time1 = $_POST['time1'];
		$time2 = $_POST['time2'];
		$speakers = $_POST['speakers'];
		$text = $_POST['text'];
		$lines = $_POST['lines'];
		//there's no variable conversation_name, name1 or name2 any more as it's in the database
		//$conversation_name = $_POST['conversation_name'];

		//training buttons are not available until save button have been pressed (some files are required for the training)
		//below it will be set to 1 in case of save or train button pressed
		$train_button=0;

		 //si viene desde view.ctp
		if($option == 1){
			//in case the folder is not present suppress the error
			$ret1 = exec("ls ".$users_absolute_path.$streams[0]['Stream']['name']."/wav/*.wav 2>/dev/null | grep ".$streams[3]['Stream']['name']."- | wc -l");
			$ret2 = exec("ls ".$users_absolute_path.$streams[1]['Stream']['name']."/wav/*.wav 2>/dev/null | grep ".$streams[3]['Stream']['name']."- | wc -l");

			//if there are already some fragments, audiosplit with padding was already done, so do it with pad=0
			if( $ret1 > 0 || $ret2 > 0 )
			{
				//generate the fragments
				//audioSplit.sh: <conversation.txt> <pad> <user1_name> <user1.wav> [<user2.wav> <user2_name>]
				exec($bin_absolute_path."audioSplit.sh ".$streams[3]['Stream']['filepath']." 0 ".
							$streams[0]['Stream']['name']." ".$streams[0]['Stream']['filepath']." ".$streams[1]['Stream']['name']." ".$streams[1]['Stream']['filepath'].
							" > /opt/audioSplit_result.txt 2>&1");

			}
			//if there aren't any fragments, suppose audiosplit hasn't been done so do it with pad=0.5
			else{
				//generate the fragments
				exec($bin_absolute_path."audioSplit.sh ".$streams[3]['Stream']['filepath']." 0.5 ".
							$streams[0]['Stream']['name']." ".$streams[0]['Stream']['filepath']." ".$streams[1]['Stream']['name']." ".$streams[1]['Stream']['filepath'].
							" > /opt/audioSplit_result.txt 2>&1");
			}
			//read again the file with the new timestamps
			$file = fopen($streams[3]['Stream']['filepath'], 'r') or die("can't open file");
			//lee linea a linea el fichero de la transcripcion para obtener los timestamps modificados y enviarlos a la vista			
			for($i=0; $i < $lines; $i++){ 	
				$line = fgets($file);		
				$time1[$i] = substr($line, 0, strpos($line,' '));
				$time2[$i] = substr($line, strpos($line,' ')+1, strpos($line, '#')-(strpos($line,' ')+1));
			}
			fclose($file);
		}
		//si viene desde edit.ctp
		else if($option == 2){
			//cuando se ha pulsado el boton SAVE
			if(isset($_POST['save'])){
				//so training buttons become available
				$train_button=1;
				//modifica los alias en la base de datos
				$this->Stream->id=$streams[0]['Stream']['id'];
				$this->Stream->saveField('alias', $_POST['alias1']);
				$this->Stream->id=$streams[1]['Stream']['id'];
				$this->Stream->saveField('alias', $_POST['alias2']);
				$this->Stream->id=$streams[2]['Stream']['id'];
				$this->Stream->saveField('alias', $_POST['alias_conversation']);
				$this->Stream->id=$streams[3]['Stream']['id'];
				$this->Stream->saveField('alias', $_POST['alias_conversation']);

				//read again
				$streams = $this->Stream->find('all', array('conditions'=>$conditions));
		
				//abre el fichero de texto que contiene la conversacion (generada por sphinx) para actualizarla con los cambios hechos por el usuario
				//$file = fopen("/var/www/transcript/voip/".$conversation_name.".txt", 'w') or die("can't open file");
				$file = fopen($streams[3]['Stream']['filepath'], 'w') or die("can't open file");

				for($i=0; $i < $lines; $i++){
					fwrite($file, $time1[$i]." ".$time2[$i]."# ".$speakers[$i]." # ".$text[$i]);			
				}
				fclose($file);

				//audioSplit.sh: <conversation.txt> <pad> <user1_name> <user1.wav> [<user2.wav> <user2_name>]
				//generate the fragments again
				exec($bin_absolute_path."audioSplit.sh ".$streams[3]['Stream']['filepath']." 0 ".
							$streams[0]['Stream']['name']." ".$streams[0]['Stream']['filepath']." ".$streams[1]['Stream']['name']." ".$streams[1]['Stream']['filepath'].
							" > /opt/audioSplit_result.txt 2>&1");

				//ejecuta files.sh: <conversation.txt> <user1_name> [<user2_name>]
				//exec($bin_absolute_path."/./files.sh ".$voip_absolute_path."/".$_POST['name1'].".wav ".$voip_absolute_path."/".$_POST['name2'].".wav "
				//			.$voip_absolute_path."/".$_POST['conversation_name'].".txt");
//				exec($bin_absolute_path."files.sh ".$streams[0]['Stream']['name']." ".$streams[1]['Stream']['name'].
//								" ".$streams[3]['Stream']['filepath']." > /opt/files_result.txt 2>&1");
				//files.sh <conversation.txt> <user1_name> [<user2_name>]
				print_r($bin_absolute_path."files.sh ".$streams[3]['Stream']['filepath']." ".$streams[0]['Stream']['name']." ".$streams[1]['Stream']['name'].
								" > /opt/files_result.txt 2>&1");
				exec($bin_absolute_path."files.sh ".$streams[3]['Stream']['filepath']." ".$streams[0]['Stream']['name']." ".$streams[1]['Stream']['name'].
								" > /opt/files_result.txt 2>&1");
			}
			//si viene desde edit.ctp, cuando se ha pulsado el boton TRAIN -> save primero!!
			else if(isset($this->params['form']['train1']) || isset($this->params['form']['train2'])){
				//training buttons will still be available after this training until new changes are done
				$train_button=1;
				if(isset($this->params['form']['train1'])){
					//training.sh <user_name>
					print_r($bin_absolute_path."training.sh ".$streams[0]['Stream']['name']." > /opt/training1_result.txt 2>&1");
					exec($bin_absolute_path."training.sh ".$streams[0]['Stream']['name']." > /opt/training1_result.txt 2>&1");
					$this->Session->setFlash("Speaker ".$_POST['train1']." has been trained");
				}else{
					//training.sh <user_name>
					print_r($bin_absolute_path."training.sh ".$streams[1]['Stream']['name']." > /opt/training2_result.txt 2>&1");
					exec($bin_absolute_path."training.sh ".$streams[1]['Stream']['name']." > /opt/training2_result.txt 2>&1");
					$this->Session->setFlash("Speaker ".$_POST['train2']." has been trained");
				}		
				//no need to read again the file for the timestamps, they haven't changed
			}
			//si viene desde edit.ctp, cuando se ha pulsado algun boton de timestamps (como son imagenes devuelve las coordenadas x e y
			else if(isset($this->params['form']['T1UP_x']) || isset($this->params['form']['T1DOWN_x']) || isset($this->params['form']['T2UP_x']) || isset($this->params['form']['T2DOWN_x'])){

				if(isset($this->params['form']['T1UP_x'])){
					//$temp = $this->params['form']['T1UP'];
					$temp = $_POST['data_to_change'];
					$old_timestamp = substr($temp, 0, strpos($temp, '#'));
					$new_timestamp = $old_timestamp + 0.5;			

				}else if(isset($this->params['form']['T2UP_x'])){
					//$temp = $this->params['form']['T2UP'];
					$temp = $_POST['data_to_change'];
					$old_timestamp = substr($temp, 0, strpos($temp, '#'));
					$new_timestamp = $old_timestamp + 0.5;

				}else if(isset($this->params['form']['T1DOWN_x'])){
					//$temp = $this->params['form']['T1DOWN_x'];			
					$temp = $_POST['data_to_change'];
					$old_timestamp = substr($temp, 0, strpos($temp, '#'));
					$new_timestamp = $old_timestamp - 0.5;
					if($new_timestamp < 0){
						$new_timestamp = 0.01;
					}

				}else if(isset($this->params['form']['T2DOWN_x'])){
					//$temp = $this->params['form']['T2DOWN'];
					$temp = $_POST['data_to_change'];
					$old_timestamp = substr($temp, 0, strpos($temp, '#'));
					$new_timestamp = $old_timestamp - 0.5;
					if($new_timestamp < 0){
						$new_timestamp = 0.01;
					}
				}

				$speaker = substr($temp, strpos($temp, '#')+1, strrpos($temp, '#')-(strpos($temp, '#')+1));
				$fragment = substr($temp, strrpos($temp, '#')+1, strrpos($temp, 'v'));

				//$file = fopen($voip_absolute_path."/".$_POST['conversation_name'].".txt", 'r') or die("can't open file");
				$file = fopen($streams[3]['Stream']['filepath'], 'r') or die("can't open file");
				//lee linea a linea el fichero de la transcripcion para obtener los timestamps originales(antiguos) para asegurarse de que el nuevo timestamp no coincida con ninguno antiguo
				for($i=0; $i < $lines; $i++){ 
					$line = fgets($file);
					$time1[$i] = substr($line, 0, strpos($line,' '));
					$time2[$i] = substr($line, strpos($line,' ')+1, strpos($line, '#')-(strpos($line,' ')+1));

					if(($new_timestamp == $time1[$i]) || ($new_timestamp == $time2[$i])){
						$new_timestamp = $new_timestamp+0.01;
					}
				}
				fclose($file);	

				//exec($bin_absolute_path."/./timestamps.sh ".$voip_absolute_path."/".$speaker.".wav /var/www".$fragment." ".$voip_absolute_path."/".
				//		$_POST['conversation_name'].".txt ".$old_timestamp." ".$new_timestamp." ");
				//<user.wav> <user_name> <fragment.wav> <conversation.txt> <old_timestamp> <new_timestamp>"
				if($speaker == $streams[0]['Stream']['name']){
					//update timestamp in the file and generate new fragment
					exec($bin_absolute_path."timestamps.sh ".$streams[0]['Stream']['filepath']." ".$speaker." ".$users_absolute_path.$fragment." ".
						$streams[3]['Stream']['filepath']." ".$old_timestamp." ".$new_timestamp." "." > /opt/timestamps_result.txt 2>&1");

				}
				else if($speaker == $streams[1]['Stream']['name']){
					//update timestamp in the file and generate new fragment
					exec($bin_absolute_path."timestamps.sh ".$streams[1]['Stream']['filepath']." ".$speaker." ".$users_absolute_path.$fragment." ".
						$streams[3]['Stream']['filepath']." ".$old_timestamp." ".$new_timestamp." "." > /opt/timestamps_result.txt 2>&1");
				}

				//read again the file
				$file = fopen($streams[3]['Stream']['filepath'], 'r') or die("can't open file");
				//lee linea a linea el fichero de la transcripcion para obtener los timestamps modificados y enviarlos a la vista			
				for($i=0; $i < $lines; $i++){ 	
					$line = fgets($file);		
					$time1[$i] = substr($line, 0, strpos($line,' '));
					$time2[$i] = substr($line, strpos($line,' ')+1, strpos($line, '#')-(strpos($line,' ')+1));
				}
				fclose($file);
			}
		}

		$this->set(compact('streams','conversation','train_button'));
		$this->set('speakers', $_POST['speakers']);
		$this->set('time1', $time1);
		$this->set('time2', $time2);
		$this->set('text', $_POST['text']);
		$this->set('lines', $_POST['lines']);
/*
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
*/
//		$this->set('alias1', $_POST['alias1']);
//		$this->set('alias2', $_POST['alias2']);
	}

} ?>

