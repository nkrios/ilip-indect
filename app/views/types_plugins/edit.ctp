<head>
<!-- 	<meta http-equiv="refresh" content="5" url="/pluginManager/pluginmanager" > -->
</head>

<div class="generic">
    <div class="search">
	<p>
	<?php echo $this->Html->link(__('Delete this MIME type / Plugin Rule', true), array('action' => 'delete', $this->Form->value('TypesPlugin.ruleID')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('TypesPlugin.ruleID'))); ?>
	</p>
	<p>
	<?php echo $this->Html->link(__('New MIME type / Plugin Rule', true), array('action' => 'add')); ?>
	</p>
    </div>
   <br/>

   <div class="types_plugins view_2 form">
	<?php echo $this->Form->create('TypesPlugin'); ?>
	<fieldset>
		<legend><?php __('Edit rule # '. $this->data['TypesPlugin']['ruleID']); ?></legend>
	<?php
		echo '<p>'.$form->input('pluginID', array('options'=>$plugins, 'label'=>__('Plugin',true), 'empty'=>' -- Choose plugin -- ')).'</p>';
		echo '<br/>';
		echo '<p>'.$form->input('type', array('type'=>'text', 'label' => __('MIME type',true))).'</p>';
		echo '<br/>';
		echo '<p>'.$form->input('pluginOrder', array('options' => $order_options, 'label' => __('Order',true), "empty" => " ... ",)).'</p>';
	?>
	</fieldset>
	<br/>
	<?php echo $this->Form->end(__('Submit', true));?>
  </div>
</div>
