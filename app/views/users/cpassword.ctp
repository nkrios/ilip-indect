
<div class="generic_form boxstyle_white shadow-box-bottom">
    <h2><?php __('Change password'); ?></h2>

    <?php 
      echo $form->create('User', array('action'=>'cpassword'));
      echo $form->input('id', array('type' => 'hidden', 'value' => $id));
      echo $form->input('opassword', array('type'=>'password', 'maxlength' => 40, 'label' => __('Old password', true))); 
      echo $form->input('password', array('type'=>'password', 'maxlength' => 40, 'label' => __('New password', true))); 
      echo $form->input('rpassword', array('type'=>'password', 'maxlength' => 40, 'label' => __('Repeat new password', true))); 
      echo $form->submit(__('Ok', true), array('div' => false));
      echo $form->end();
      ?>
      
</div>
