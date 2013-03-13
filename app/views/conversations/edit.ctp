<!-- Jesús Vallinot Sánchez-->

<div class="generic">
<?php

$users_relative_path = "/app/webroot/users/";
$voip_relative_path = "/app/webroot/voip/";
$image_relative_path = "/app/webroot/img/";

$count1 = 1;
$count2 = 1;

//inicio del formulario. cuando se pulse el pulse el boton 'save' redirige a la vista principal, index.ctp
echo $form->create('Conversation', array('controller'=>'Conversations', 'action'=>'edit/'.$conversation['Conversation']['id'].'/2', 'type'=>'post')); ?>

<!--tabla que contendra el audio, nombre y alias de la conversacion-->
<br/>
<table>
	<tr>
		<th width="33%"><?php echo __('Audio',true); ?></th>
		<th width="33%"><?php echo __('Conversation name',true); ?></th>
		<th width="33%"><?php echo __('Conversation Alias',true); ?></th>
	</tr>
	<tr>
		<td>
			<audio src="<?php echo $voip_relative_path.$streams[2]['Stream']['filename']; ?>" controls="controls"/>

		</td> <!--WAV-->
		<td><?php echo $streams[2]['Stream']['name']; ?></td><!--ID SIP-->
		<td><input type="text" name="alias_conversation" size=40 value="<?php echo $streams[2]['Stream']['alias']; ?>"/></td><!--ALIAS-->
	</tr>
</table>
<br/>
<!--tabla que contendra el audio, identificador sip y alias de cada interlocutor-->
<table>
	<tr>
		<th width="33%"><?php echo __('Audio',true); ?></th>
		<th width="33%"><?php echo __('Speaker',true); ?></th>
		<th width="33%"><?php echo __('Alias',true); ?></th>
	</tr>
	<!--AUDIO-->
	<tr>
		<td><audio src="<?php echo $voip_relative_path.$streams[0]['Stream']['filename'] ?>" controls="controls""/></td> <!--WAV-->
		<td><?php echo $streams[0]['Stream']['name'] ?></td> <!--ID SIP-->
		<td><input type="text" name="alias1" size=40 value="<?php echo $streams[0]['Stream']['alias']; ?>"/></td> <!--ALIAS-->
	</tr>
	<tr>
		<td><audio src="<?php echo $voip_relative_path.$streams[1]['Stream']['filename'] ?>" controls="controls"/></td> <!--WAV-->
		<td><?php echo $streams[1]['Stream']['name'] ?></td> <!--ID SIP-->
		<td><input type="text" name="alias2" size=40 value="<?php echo $streams[1]['Stream']['alias']; ?>"/></td> <!--ALIAS-->
	</tr>
</table>
<br/>

<!--EDITAR EL TEXTO-->
<?php echo __("Audio should be reloaded after changing any timestamp. If it does not, please change your browser",true); ?>
<br/>
<table>
	<tr>
		<th width="30%"><?php echo __("Speaker",true); ?></th>
 		<th width="5%"><?php echo __("Start",true); ?></th>
 		<th width="5%"><?php echo __("End",true); ?></th>
		<th width="60%"><?php echo __("Text",true); ?></th>
	</tr>

	<!--muestra cada componente de la tabla (timestamps, nombre y texto para cada fila)-->
	<input type="hidden" name="data_to_change"/>
	<?php for($i=0; $i < $lines; $i++){ 

		if($speakers[$i] == $streams[0]['Stream']['name']){ 
			//entra en la carpeta del interlocutor1 y accede a los wavs fragmentados
			$fragment[$i] = $streams[0]['Stream']['name']."/wav/".$streams[3]['Stream']['name']."-".$count1.".wav";
			$count1 = $count1+1;
		}else{
			$fragment[$i] = $streams[1]['Stream']['name']."/wav/".$streams[3]['Stream']['name']."-".$count2.".wav";
			$count2 = $count2+1;
		}?>

		<tr>
			<!--ALIAS-->
			<?php if($speakers[$i] == $streams[0]['Stream']['name']){
				$speakers[$i] = $streams[0]['Stream']['name']; 
				$temporal[$i] = $streams[0]['Stream']['alias']; ?>
				<input type="hidden" name="speakers[]" value="<?php echo $speakers[$i]; ?>"/>
			<?php }else{
				$speakers[$i] = $streams[1]['Stream']['name']; 
				$temporal[$i] = $streams[1]['Stream']['alias']; ?>
				<input type="hidden" name="speakers[]" value="<?php echo $speakers[$i]; ?>"/>
			<?php } ?>					

				<!--NOMBRE DEL LOCUTOR Y AUDIO DE LA FRASE-->
				<td>
					<br/>
					<input type="text" name="temporal[]" size=40 value="<?php echo $temporal[$i]; ?>"/><br/><br/>
					<audio src="<?php echo $users_relative_path.$fragment[$i] ?>" controls="controls"/>
				</td>
				
				<!--TIMESTAMP DE INICIO Y FLECHAS UP/DOWN-->
				<td>
					<input type="hidden" name="time1[]" size=40 value="<?php echo $time1[$i]; ?>"/>
					<?php echo $form->submit($image_relative_path."aumentar.gif",array('name' => 'T1UP', 'style'=>"width:20px;height:20px;font-size:small;", 'value' => $time1[$i]." #".$speakers[$i]."#".$fragment[$i], 'onclick'=>'this.form.data_to_change.value=this.value'));
					echo $time1[$i];
					echo $form->submit($image_relative_path."disminuir.gif", array('name' => 'T1DOWN', 'style'=>"width:20px;height:20px;font-size:small;", 'value'=>$time1[$i]." #".$speakers[$i]."#".$fragment[$i], 'onclick'=>'this.form.data_to_change.value=this.value')); ?>
				</td> 

				<!--TIMESTAMP DE FINAL Y FLECHAS UP/DOWN-->
				<td>
					<input type="hidden" name="time2[]" value="<?php echo $time2[$i]; ?>"/>
					<?php echo $form->submit($image_relative_path."aumentar.gif", array('name' => 'T2UP', 'style'=>"width:20px;height:20px;font-size:small;", 'value'=>$time2[$i]."#".$speakers[$i]."#".$fragment[$i], 'onclick'=>'this.form.data_to_change.value=this.value')); 
					echo $time2[$i];
					echo $form->submit($image_relative_path."disminuir.gif", array('name'=>'T2DOWN', 'style'=>"width:20px;height:20px;font-size:small;", 'value'=>$time2[$i]."#".$speakers[$i]."#".$fragment[$i], 'onclick'=>'this.form.data_to_change.value=this.value')); ?>
				</td>

			<!--TEXTO-->
			<td><textarea rows="5" cols="100" name="text[]"><?php echo $text[$i]; ?></textarea></td>			
		</tr>
	<?php } ?> <!--fin for-->
</table>

<br/>
<input type="hidden" name="lines" value="<?php echo $lines; ?>"/>

<?php
if($train_button==0){
	echo "Training buttons will be available once changes have been saved";
}
?>
<br/>

<table>
	<tr>
		<!-- save and train buttons -->
		<td><?php echo $form->submit(__("Save changes",true), array('name'=>'save', 'value'=>'save')); ?></td>
		<?php if($train_button==1){ ?>
			<td><center><?php echo $form->submit(__("Train ".$streams[0]['Stream']['alias'],true), array('name'=>'train1')); ?></center></td>
			<td><center><?php echo $form->submit(__("Train ".$streams[1]['Stream']['alias'],true), array('name'=>'train2')); ?></center></td>
		<?php } else{ ?>
			<td><center><?php echo $form->submit(__("Train ".$streams[0]['Stream']['alias'],true), array('name'=>'train1', 'disabled' => 'disabled')); ?></center></td>
			<td><center><?php echo $form->submit(__("Train ".$streams[1]['Stream']['alias'],true), array('name'=>'train2', 'disabled' => 'disabled')); ?></center></td>
		<?php } ?>

		<?php echo $form->end(); ?>

		<!-- boton de vuelta -->
		<td><center><?php
			echo $form->create('Conversation', array('controller'=>'Conversations', 'action'=>'view/'.$conversation['Conversation']['id']));
			echo $form->submit(__("Back to conversation view",true));
			echo $form->end();
		?></center></td>
	</tr>
</table>

</div>
