
<div class="generic_form boxstyle_white shadow-box-bottom">
	<h2><?php __('Edit Rule #'. $this->data['TypesPlugin']['ruleID']); ?></h2>

	<div class="types_plugins view_2 form">
		<?php 
		echo $this->Form->create('TypesPlugin');
		echo $this->Form->input('pluginID', array('options'=>$plugins, 'label'=>__('Plugin',true), 'empty'=>' -- Choose plugin -- '));
		echo $this->Form->input('type', array('type'=>'text', 'label' => __('MIME type',true)));
		echo $this->Form->input('pluginOrder', array('options' => $order_options, 'label' => __('Order',true), "empty" => " ... ",));
		echo $this->Form->end(__('Submit', true));
		?>
	</div>
</div>
