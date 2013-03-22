
<script language="text/javascript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic">
	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search', array( 'url' => array('controller' => 'dns_messages', 'action' => 'index')));
	      echo $form->input('search', array( 'type'=>'text','size' => '30', 'label'=>__('Search:', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	 echo $form->end(__('Go', true));?>

	  	<div class="src_first">
		    <a href="/dns_messages/graph">   
		       <img alt="DNS Statistics" title="<?php __('DNS Statistics'); ?>" src="/img/statistics.png" />
		    </a>
	  	</div>

	</div>

	<!-- to-do : download these data in XLS format (or ODS) -->
	<table id="messagelist" class="shadow-box-bottom">
		<tr>
			<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
			<th><?php echo $paginator->sort(__('Host', true), 'hostname'); ?></th>
			<th><?php echo $paginator->sort(__('CName', true), 'cname'); ?></th>
			<th class="ip"><?php echo $paginator->sort(__('IP', true), 'ip'); ?></th>
			<th class="info"><?php __('Info'); ?></th>
		</tr>
		<?php foreach ($dns_msgs as $dns_msg): ?>
		<?php if ($dns_msg['DnsMessage']['first_visualization_user_id']) : ?>
		  <tr>
			<td><?php echo $dns_msg['DnsMessage']['capture_date']; ?></td>
			<td><?php echo $dns_msg['DnsMessage']['hostname']; ?></td>
			<td><?php echo $dns_msg['DnsMessage']['cname']; ?></td>
			<td><?php echo $dns_msg['DnsMessage']['ip']; ?></td>
		        <td class="pinfo"><a href="#" onclick="popupVetrina('/dns_messages/info/<?php echo $dns_msg['DnsMessage']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $dns_msg['DnsMessage']['id']); ?></div></td>

		  </tr>
		<?php else : ?>
		 <tr>
			<td><?php echo $dns_msg['DnsMessage']['capture_date']; ?></td>
		        <td><?php echo $dns_msg['DnsMessage']['hostname']; ?></td>
		        <td><?php echo $dns_msg['DnsMessage']['cname']; ?></td>
			<td><?php echo $dns_msg['DnsMessage']['ip']; ?></td>
		        <td class="pinfo"><a href="#" onclick="popupVetrina('/dns_messages/info/<?php echo $dns_msg['DnsMessage']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $dns_msg['DnsMessage']['id']); ?></div></td>
		  </tr>
		<?php endif ?>
		<?php endforeach; ?>
	</table>

	<table id="listpage" class="shadow-box-bottom">
		<tr>
			<th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
		       	<th><?php echo $paginator->numbers(); echo ' ('.$paginator->counter().')';?></th>
			<th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
		</tr>
	</table>
</div>
