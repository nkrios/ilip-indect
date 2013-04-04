<div class="generic_form boxstyle_white shadow-box-bottom">
	<h2><?php __('Edit Plugin #'. $this->data['Plugin']['pluginID']); ?></h2>
	<?php 
		echo $this->Form->create('Plugin');
		echo $this->Form->input('pluginName', array('type'=>'text', 'label' => __('Name',true)));
		echo $this->Form->input('pluginType', array('type'=>'text', 'label' => __('MIME Type',true)));
		echo $this->Form->input('pluginURI', array('type'=>'text', 'label' => __('URI',true)));
		echo $this->Form->input('pluginDescription', array('type'=>'text', 'label' => __('Description',true)));
		echo $this->Form->end(__('Submit', true));
	?>
</div>