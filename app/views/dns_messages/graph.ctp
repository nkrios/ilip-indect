<script type="text/javascript">
  swfobject.embedSWF("/files/open-flash-chart.swf", "my_chart", "750", "340", "9.0.0",
      "",
      {"data-file":"/dns_messages/gdata"}
  );
  function go_gpage(id) { //funzione con il link alla pagina che si desidera raggiungere
    window.location.href = '<?php echo $dns_gpage_url?>';
  }
</script>

<div class="graph generic boxstyle_white">
  <h2 class="shadow-box-bottom"><?php __('DNS Statistics'); ?></h2>
  
  <div id="my_chart"></div> 

  <div class="search shadow-box-bottom">
    <?php echo $form->create('formtime' ,array( 'url' => array('controller' => 'dns_messages','action' => 'graph')));
          echo $form->radio('timeinterval', $time_list , array('separator' => '','legend' => false ));
          echo $form->end(__('Change', true)); ?>
  </div>

</div>