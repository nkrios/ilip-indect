
<div class="generic">

<?php 
//inicio del formulario que redirige al metodo del controlador edit, pasandole el id de la conversacion
echo $this->Form->create('Conversation', array('action'=>'edit/'.$conversation['Conversation']['id'].'/1')); 

//rutas absoluta y relativa a los ficheros de audio y texto de las conversaciones
$voip_absolute_path = $_SERVER['DOCUMENT_ROOT']."/app/webroot/voip_data/";
$voip_relative_path = "/app/webroot/voip_data/";
$image_relative_path = "/app/webroot/img/";

$flag = 1;
?>

<!--
Cada conversación tiene 4 streams asociados:
* fichero audio del usuario 1
* fichero audio del usuario 2
* fichero audio de la conversación
* fichero texto de la transcripcion

La tabla streams (archivos de audio y texto) tiene 7 campos:
* id del stream
* id de la conversacion a la que pertenece
* nombre del stream (usuario, conversación)
* tipo del stream (audio/texto)
* alias para el stream (usuario, conversación)
* nombre del fichero
* ruta del fichero
-->

<!--tabla que contendra el audio, nombre y alias de la conversacion-->

<table>
	<tr>
		<th ><?php echo __('Audio',true); ?></th>
		<th ><?php echo __('Conversation name',true); ?></th>
		<th ><?php echo __('Conversation Alias',true); ?></th>
	</tr>
	<tr>
		<td>
			<audio src="<?php echo $voip_relative_path.$streams[2]['Stream']['filename'] ?>" controls="controls" caching="safe" onClick="IniciarCrono()"/>

		</td> <!--WAV-->
		<td><?php echo $streams[3]['Stream']['name'] ?></td><!--ID SIP-->
		<td><?php echo $streams[3]['Stream']['alias'] ?></td><!--ALIAS-->
	</tr>
</table>
<br/>
<!--tabla que contendra el audio, identificador sip y alias de cada interlocutor-->
<table>
	<tr>
		<th ><?php echo __('Audio',true); ?></th>
		<th ><?php echo __('Speaker',true); ?></th>
		<th ><?php echo __('Alias',true); ?></th>
	</tr>
	<!--AUDIO-->
	<tr>
		<td>
			<audio src="<?php echo $voip_relative_path.$streams[0]['Stream']['filename'] ?>" controls="controls" caching="safe"/>
		</td> <!--WAV-->
		<td><?php echo $streams[0]['Stream']['name'] ?></td><!--ID SIP-->
		<td><?php echo $streams[0]['Stream']['alias'] ?></td><!--ALIAS-->
	</tr>
	<tr>
		<td>
			<audio src="<?php echo $voip_relative_path.$streams[1]['Stream']['filename'] ?>" controls="controls" caching="safe"/>
		</td> <!--WAV-->
		<td><?php echo $streams[1]['Stream']['name'] ?></td><!--ID SIP-->
		<td><?php echo $streams[1]['Stream']['alias'] ?></td><!--ALIAS-->
	</tr>
</table>
<br/>

<!--TRANSCRIPCION DE LA CONVERSACION-->
<?php
	$url = $voip_absolute_path.$streams[3]['Stream']['filename'];
	$file = file($url);
	$lines = count($file);  
?>

<!--tabla que contendra la transcripcion de la conversacion desglosada frase por frase, indicando: interlocutor, timestamps de inicio y de final, texto-->
<table>
	<th><?php echo __('Speaker',true); ?></th>
	<th><?php echo __('Start',true); ?></th>
	<th><?php echo __('End',true); ?></th>
	<th><?php echo __('Text',true); ?></th>

	<!--guardo cada parte de cada frase para poder pasarselo luego al controlador-->
	<?php for($i=0; $i < $lines; $i++){ 				
		$time1 = substr($file[$i], 0, strpos($file[$i],' '));
		$time2 = substr($file[$i], strpos($file[$i],' ')+1, strpos($file[$i],'#')-(strpos($file[$i],' ')+1));
		$text = substr($file[$i], strrpos($file[$i], '#')+2); 	
		$speaker = substr($file[$i], strpos($file[$i],'#')+2, strrpos($file[$i],'#')-(strpos($file[$i],'#')+3)); ?>		

	<tr>	
		<td><?php echo $speaker; ?></td>	
		<td><?php echo $time1; ?></td>
		<td><?php echo $time2; ?></td>
		<td><?php echo $text; ?></td>
		<input type="hidden" name="speakers[]" value="<?php echo $speaker; ?>">
		<input type="hidden" name="time1[]" value="<?php echo $time1; ?>">
		<input type="hidden" name="time2[]" value="<?php echo $time2; ?>">
		<input type="hidden" name="text[]" value="<?php echo $text; ?>">
	</tr>	
	<?php }?>
</table>	

<input type="hidden" name="lines" value="<?php echo $lines; ?>">
<input type="hidden" name="flag" value="<?php echo $flag; ?>">

<table>
	<tr>
		<td><?php echo $form->submit("Edit conversation"); 
		echo $form->end(); ?></td>
		<!--boton de vuelta-->
		<?php echo $form->create('Conversation', array('controller'=>'Conversations', 'action'=>'index')); ?>
		<td><?php
			echo $form->submit("Go to conversations index"); 
			echo $form->end();
		?></td>
		<?php if($this->Session->check('sipid')){ ?>
		<td><?php
			echo $form->create('Sip', array('controller'=>'Sips', 'action'=>'view/'.$this->Session->read('sipid')));
			echo $form->submit("Go to sip view"); 
			echo $form->end();
		?></td>
		<?php } ?>
		<?php if($this->Session->check('rtpid')){ ?>
		<td><?php
			echo $form->create('Rtp', array('controller'=>'Rtps', 'action'=>'view/'.$this->Session->read('rtpid')));
			echo $form->submit("Go to rtp view"); 
			echo $form->end();
		?></td>
		<?php } ?>

	</tr>
</table>
</div>
