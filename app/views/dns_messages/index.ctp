
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('DNS'); ?></h2>

	<div class="search shadow-box-bottom divamiddle">
		<?php 
		echo $form->create('Search', array( 'url' => array('controller' => 'dns_messages', 'action' => 'index')));
		echo $form->input('search', array( 'type'=>'text', 'label'=>__('Search: ', true), 'default' => $srchd));
		// echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance,'label'=>__('Relevance: ', true)));
		echo $form->end(__('Go', true));?>
	</div>

	<!-- DNS Statistics link -->
	<div class="src_first divamiddle shadow-box-bottom">
		<h3 class="divamiddle"><?php __('DNS Statistics:'); ?>
	    <a class="divamiddle" href="/dns_messages/graph">   
	       <img alt="DNS Statistics" title="<?php __('DNS Statistics'); ?>" src="/img/statistics.png" />
	    </a>
	    </h3>
  	</div>

	<!-- to-do : download these data in XLS format (or ODS) -->
	<table class="shadow-box-bottom">
		<tr>
			<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
			<th class="url"><?php echo $paginator->sort(__('Host', true), 'hostname'); ?></th>
			<th class="subject"><?php echo $paginator->sort(__('CName', true), 'cname'); ?></th>
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
		    <td class="pinfo">
		    	<a href="#" onclick="popupVetrina('/dns_messages/info/<?php echo $dns_msg['DnsMessage']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
		    	<div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $dns_msg['DnsMessage']['id']); ?></div>
		    </td>

		</tr>
		<?php else : ?>
		 <tr>
			<td><?php echo $dns_msg['DnsMessage']['capture_date']; ?></td>
		    <td><?php echo $dns_msg['DnsMessage']['hostname']; ?></td>
		    <td><?php echo $dns_msg['DnsMessage']['cname']; ?></td>
			<td><?php echo $dns_msg['DnsMessage']['ip']; ?></td>
		    <td class="pinfo">
		    	<a href="#" onclick="popupVetrina('/dns_messages/info/<?php echo $dns_msg['DnsMessage']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
		    	<div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $dns_msg['DnsMessage']['id']); ?></div>
		    </td>
		  </tr>
		<?php endif ?>
		<?php endforeach; ?>
	</table>

	<?php echo $this->element('paginator'); ?>
	
</div>
