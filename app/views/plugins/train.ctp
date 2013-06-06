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

	<h4>Please, first provide the content to train the plugin</h4>
	<?php
            //contentPath, relevance and message are provided by the user
	    echo $form->create('Train', array('enctype' => 'multipart/form-data', 'url' => array('controller' => 'plugins', 'action' => 'train/'.$plugin_id)));
            echo '<p>'.$form->input('content_file', array('type' => 'file', 'label' => __('Content to upload',true))).'</p>';
            echo '<br/>';
            echo '<p>'.$form->input('case_category', array('readonly'=>'readonly', 'type'=>'text', 'label' => __('Case Category',true)));
            echo '<br/>';
            echo '<p>'.$form->input('case_id', array('readonly'=>'readonly', 'type'=>'text', 'label' => __('Case Id',true)));
            echo '<br/>';
            echo '<p>'.$form->input('capture_timestamp', array('readonly'=>'readonly', 'type'=>'text', 'label' => __('Capture Timestamp',true)));
            echo '<br/>';
            echo '<p>'.$form->input('process_relevance', array('type'=>'text', 'label' => __('Process Relevance',true)));

            echo '<br/>';
            echo '<p>'.$form->input('process_message', array('type'=>'text', 'label' => __('Process Message',true)));
            echo '<br/>';
	    echo '<p>'.$form->end(__('Train',true));
	?>
        </p>	</div>

</div>
