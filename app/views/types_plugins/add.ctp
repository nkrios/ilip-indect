<head>
<!-- 	<meta http-equiv="refresh" content="5" url="/pluginManager/pluginmanager" > -->
</head>

<div class="generic">
  <div class="search">
	<p>
	<?php echo $this->Html->link(__('List MIME Type / Plugin Rules', true), array('action' => 'index'));?>
	</p>
  </div>
  <br/>

  <div class="typesPlugins view_2 form">
	<?php echo $this->Form->create('TypesPlugin');?>
	<fieldset>
		<legend><?php __('Add a new rule to the execution list of plugins'); ?></legend>
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
