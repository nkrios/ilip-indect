
<div class="generic_form boxstyle_white">

    <h2 class="shadow-box-bottom"><?php echo $this->Html->link(__('List Plugins', true), array('action' => 'index')); ?></h2>

	<div>

    	<h4 class="notice">Please, first provide the content to train the plugin.</h4>

    	<?php
                //contentPath, relevance and message are provided by the user
    	    echo $form->create('Train', array('enctype' => 'multipart/form-data', 'url' => array('controller' => 'plugins', 'action' => 'train/'.$plugin_id)));
                echo $form->input('content_file', array('type' => 'file', 'label' => __('Content to upload',true)));
                echo $form->input('case_category', array('readonly'=>'readonly', 'type'=>'text', 'label' => __('Case Category',true)));
                echo $form->input('case_id', array('readonly'=>'readonly', 'type'=>'text', 'label' => __('Case Id',true)));
                echo $form->input('capture_timestamp', array('readonly'=>'readonly', 'type'=>'text', 'label' => __('Capture Timestamp',true)));
                echo $form->input('process_relevance', array('type'=>'text', 'label' => __('Process Relevance',true)));
                echo $form->input('process_message', array('type'=>'text', 'label' => __('Process Message',true)));
    	    echo $form->end(__('Train',true));
    	?>

    </div>

</div>
