
<div class="pols">
  <h2 class="shadow-box-bottom"><?php __('New Case'); ?></h2>
  <div class="search shadow-box-bottom">
    <?php echo $form->create('Pol');
      if ($register == 0) {
        echo '<h2>'.__('DATA ACQUISITION', true).'</h2>';
        echo $form->radio('Capture.Type',array(
          __('Uploading PCAP capture file/s', true), 
          __('Live acquisition', true)
          ),array('separator' => '', 'legend' => false, 'default' => 0 ));
      }
      echo "<br>";
      echo $form->input('Pol.name',  array('maxlength'=> 50, 'size' => '50', 'label' => __('Case name', true)));
      echo $form->input('Pol.external_ref',  array('maxlength'=> 50, 'size' => '50', 'label' => __('Category', true)));
      echo $form->end(__('Create', true)); ?>
  </div>
</div>
