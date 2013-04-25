
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('ARP'); ?></h2>

	<div class="search shadow-box-bottom">
		<?php 
		echo $form->create('Search', array( 'url' => array('controller' => 'arps', 'action' => 'index')));
		echo $form->input('search', array( 'type'=>'text', 'label'=>__('Search: ', true), 'default' => $srchd));
		// echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance, 'label'=>__('Relevance: ', true)));
		echo $form->end(__('Go', true));
		?>
	</div>

	<!-- to-do : download these data in XLS format (or ODS) -->
	<table class="shadow-box-bottom">
		<tr>
			<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
			<th class="username"><?php echo $paginator->sort(__('MAC', true), 'mac'); ?></th>
			<th class="ip"><?php echo $paginator->sort(__('IP', true), 'ip'); ?></th>
			<th class="info"><?php __('Info'); ?></th>
		</tr>
		<?php foreach ($arp_msgs as $arp_msg): ?>
		<?php if ($arp_msg['Arp']['first_visualization_user_id']) : ?>
		  <tr>
			<td><?php echo $arp_msg['Arp']['capture_date']; ?></td>
			<td><?php echo $arp_msg['Arp']['mac']; ?></td>
			<td><?php echo $arp_msg['Arp']['ip']; ?></td>
		    <td class="pinfo"><a href="#" onclick="popupVetrina('/arps/info/<?php echo $arp_msg['Arp']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
		    </td>

		  </tr>
		<?php else : ?>
		 <tr>
			<td><?php echo $arp_msg['Arp']['capture_date']; ?></td>
		    <td><?php echo $arp_msg['Arp']['mac']; ?></td>
			<td><?php echo $arp_msg['Arp']['ip']; ?></td>
		    <td class="pinfo"><a href="#" onclick="popupVetrina('/arps/info/<?php echo $arp_msg['Arp']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
		    </td>
		  </tr>
		<?php endif ?>
		<?php endforeach; ?>
	</table>

<?php echo $this->element('paginator'); ?>

</div>
