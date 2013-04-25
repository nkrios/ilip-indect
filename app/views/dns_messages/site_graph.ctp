<script>
  	swfobject.embedSWF("/files/open-flash-chart.swf", "my_chart", "750", "380", "9.0.0","expressInstall.swf",{"data-file":"/dns_messages/gsitedata"});

  	function go_gpage(id) {
    	window.location.href = '<?php echo $dns_gpage_url?>';
  	}
</script>

<div class="generic">
   <div class="graph">
        <div id="my_chart"></div>
   </div>
</div>
