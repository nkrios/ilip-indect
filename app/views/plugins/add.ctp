<div class="generic_form boxstyle_white shadow-box-bottom">
	<h2><?php __('Add a new Plugin'); ?></h2>
   	<?php 
   		echo $this->Form->create('Plugin');
		echo $this->Form->input('pluginName', array('type'=>'text', 'label' => __('Plugin Name',true)));
		echo $this->Form->input('pluginType', array('type'=>'text', 'label' => __('MIME type',true)));
		echo $this->Form->input('pluginURI', array('type'=>'text', 'label' => __('URI',true)));
		echo $this->Form->input('pluginDescription', array('type'=>'text', 'label' => __('Description',true)));
		echo $this->Form->end(__('Submit', true));
	?>

</div>
