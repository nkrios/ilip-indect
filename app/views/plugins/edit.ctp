<head>
<!-- 	<meta http-equiv="refresh" content="5" url="/pluginManager/pluginmanager" > -->
</head>

<div class="generic">
    <div class="search">
	<p>
	<?php echo $this->Html->link(__('Delete this Plugin', true), array('action' => 'delete', $this->Form->value('Plugin.pluginID')), null, sprintf(__('Are you sure you want to delete %s?', true), $this->Form->value('Plugin.pluginName'))); ?>
	</p>
	<p>
	<?php echo $this->Html->link(__('New Plugin', true), array('action' => 'add')); ?>
	</p>
    </div>
    <br/>
    <div class="pluginsInfo view_2 form">
	<?php echo $this->Form->create('Plugin');?>
		<fieldset>
			<legend><?php __('Edit Plugin #'. $this->data['Plugin']['pluginID']); ?></legend>
		<?php
			echo '<p>'.$this->Form->input('pluginName', array('type'=>'text', 'label' => __('Name',true), 'style' => 'width:700px')).'</p>';
			echo '<br>';
			echo '<p>'.$this->Form->input('pluginType', array('type'=>'text', 'label' => __('MIME Type',true), 'style' => 'width:700px')).'</p>';
			echo '<br>';
			echo '<p>'.$this->Form->input('pluginURI', array('type'=>'text', 'label' => __('URI',true), 'style' => 'width:700px')).'</p>';
			echo '<br>';
			echo '<p>'.$this->Form->input('pluginDescription', array('type'=>'text', 'label' => __('Description',true), 'style' => 'width:700px')).'</p>';
		?> <br>
		</fieldset>
	<?php echo $this->Form->end(__('Submit', true));?>
    </div>
</div>
