<h2><br/><pre><strong><span style="color: black;">						UPDATE CONVERSATION: <?php echo $conversation['Conversation']['name']; ?></span></strong></pre></h2>

<?php

$image_relative_path = "/app/webroot/img/";

echo $form->create('Conversation', array('action'=>'update'));?>

<?php echo $form->input('name', array('value'=>$conversation['Conversation']['name'], 'rows'=>'1'));?>
<pre><?php echo $form->input('description', array('value'=>$conversation['Conversation']['description'], 'rows'=>'1'));?></pre>
<?php echo $form->input('id', array('type'=>'hidden', 'value'=>$conversation['Conversation']['id']));
echo $form->input('nameHidden', array('type'=>'hidden', 'value'=>$conversation['Conversation']['name'])); ?>

<table>
	<tr><td></td>
		<td><?php echo $form->submit($image_relative_path."update.png", array('style'=>"width:50px;height:50px;font-size:small;")); 
		echo $form->end(); ?></td>

		<!--boton de vuelta-->
		<?php echo $form->create('Conversation', array('controller'=>'Conversations', 'action'=>'index')); ?>	
		<td><?php echo $form->submit($image_relative_path."back.gif", array('style'=>"width:50px;height:50px;font-size:small;")); 
		echo $form->end(); ?></td>
	</tr>
</table>

