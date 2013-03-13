<?php
class Conversation extends AppModel {
	var $name = 'Conversation';
	var $hasMany = array('Stream' => array('className' => 'Stream', 'foreignKey' => 'conversation_id', 'dependent' => true));
	var $hasOne = array(
		'Sip' => array('className' => 'Sip', 'foreignKey' => 'conversation_id', 'dependent' => true),
		'Rtp' => array('className' => 'Rtp', 'foreignKey' => 'conversation_id', 'dependent' => true)
	);
}
?>
