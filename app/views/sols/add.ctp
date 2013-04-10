
<div class="generic_form boxstyle_white">
	<h2><?php __('New listening session'); ?></h2>

	<?php 
		echo $form->create('Sol', array('class' =>'shadow-box-bottom'));
	    echo $form->input('Sol.name',  array('maxlength'=> 50, 'size' => '50', 'label' => __('Session name', true)));
		echo $form->end(__('Create', true));
	?>
</div>
