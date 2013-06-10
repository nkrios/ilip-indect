<div class="generic boxstyle_white">

	<h2 class="shadow-box-bottom"><?php echo 'Transcriptions - Update conversation: '.$conversation['Conversation']['name']; ?></h2>

	<?php

	$image_relative_path = "/app/webroot/img/";

	echo $form->create('Conversation', array('action'=>'update'));

		echo $form->input('name', array( 'type'=>'text', 'label'=>__('Name: ', true), 'default' => $conversation['Conversation']['name']));
		echo $form->input('description', array( 'type'=>'text', 'label'=>__('Description: ', true), 'default' => $conversation['Conversation']['description']));
		echo $form->input('id', array('type'=>'hidden', 'value'=>$conversation['Conversation']['id']));
		echo $form->input('nameHidden', array('type'=>'hidden', 'value'=>$conversation['Conversation']['name'])); 
		echo $form->submit($image_relative_path."update.png");

	echo $form->end(); 

	?>

</div>