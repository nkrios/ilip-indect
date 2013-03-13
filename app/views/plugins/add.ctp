<div class="plugins">
	<div class="generic">
	    <div class="search">
		<p>
		<?php echo $this->Html->link(__('List Plugins', true), array('action' => 'index')); ?>
		</p>
	    </div>
	</div>
	<br/>
	<div>
	   <?php echo $this->Form->create('Plugin');?>
	   <fieldset>
	     <legend><?php __('Add a new Plugin'); ?></legend>
	     <?php
		echo '<p>'.$this->Form->input('pluginName', array('type'=>'text', 'label' => __('Plugin Name',true), 'style' => 'width:700px')).'</p>';
		echo '<br/>';
		echo '<p>'.$this->Form->input('pluginType', array('type'=>'text', 'label' => __('MIME type',true))).'</p>';
		echo '<br/>';
		echo '<p>'.$this->Form->input('pluginURI', array('type'=>'text', 'label' => __('URI',true), 'style' => 'width:700px')).'</p>';
		echo '<br/>';
		echo '<p>'.$this->Form->input('pluginDescription', array('type'=>'text', 'label' => __('Description',true), 'style' => 'width:700px'));
	     ?>
	  </fieldset>
	  <?php echo $this->Form->end(__('Submit', true));?>
	</div>
</div>
