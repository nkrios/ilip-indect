<head>
<!-- 	<meta http-equiv="refresh" content="5" url="/pluginManager/pluginmanager" > -->
</head>

<div class="generic">
    <div class="search">
	<p/>
	<?php echo $this->Html->link(__('Delete this content', true), array('action' => 'delete', $this->data['Content']['contentID']), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->data['Content']['contentID'])); ?>
	<p/>
	<?php echo $this->Html->link(__('Edit this content', true), array('action' => 'edit', $this->data['Content']['contentID'])); ?>
	<p/>
	<?php echo $this->Html->link(__('Analyze this content', true), array('action' => 'analyze', $this->data['Content']['contentID'])); ?>
    </div>
    <br/>

    <div class="contentsInfo view_2">
	<fieldset>
	   <legend><?php __('Edit Relevance and Description to train content #'. $this->data['Content']['contentID']); ?></legend>
	   <center>
	   <?php echo $this->Form->create('Content'); ?>
	     <?php
		echo '<p>'.$this->Form->input('contentName', array('type'=>'text', 'label'=>'Name', 'style' => 'width:700px','readonly'=>'readonly')).'</p>';
		echo '<br>';
		echo '<p>'.$this->Form->input('contentPath', array('type'=>'text', 'label' => 'Path', 'style' => 'width:700px','readonly'=>'readonly')).'</p>';
		echo '<br>';
		echo '<p>'.$this->Form->input('contentType', array('type'=>'text', 'label'=>'MIME Type', 'style' => 'width:700px','readonly'=>'readonly')).'</p>';
		echo '<br>';
		echo '<p>'.$this->Form->input('description', array('type'=>'string', 'label'=>'Description', 'style' => 'width:700px')).'</p>';
		echo '<br>';
		echo '<p>'.$this->Form->input('priorityAssociated', array('options' => $relevanceoptions, 'label'=>'Relevance')).'</p>';
	     ?>
	   </center>
	</fieldset>
	<br/>
	<?php echo $form->end('Train content'); ?>
    </div> 
</div>
