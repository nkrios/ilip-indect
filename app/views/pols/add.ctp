
<div class="pols boxstyle_white generic_form">
  <h2 class="shadow-box-bottom"><?php __('New Case'); ?></h2>
  
    <?php echo $this->Form->create('Pol');

        if ($register == 0) {
          // echo $this->Form->input('Capture.Type',array(
          //     __('Uploading PCAP capture file/s', true), 
          //     __('Live acquisition', true)
          //     ),array('separator' => '', 'legend' => false, 'default' => 0 ));
          echo $this->Form->input('Capture.Type', array(
              'before' => '<p class="title">'.__('DATA ACQUISITION:', true).'</p>',
              'after' => '',
              'between' => '',
              'separator' => '<br>',
              'type'=>'radio','legend' => false,'default' => 0,
              'options' => array('Uploading PCAP capture file/s', 'Live acquisition')
          ));


        }

      echo $this->Form->input('Pol.name',  array('maxlength'=> 50, 'size' => '50', 'label' => __('Case name:', true)));
      echo $this->Form->input('Pol.external_ref',  array('maxlength'=> 50, 'size' => '50', 'label' => __('Category:', true)));
      echo $this->Form->end(__('Create', true)); ?>

</div>
