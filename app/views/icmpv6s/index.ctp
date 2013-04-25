
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('ICMPv6'); ?></h2>

	<div class="search shadow-box-bottom">		
		<?php echo $form->create('Search', array( 'url' => array('controller' => 'icmpv6s', 'action' => 'index')));
		      echo $form->input( 'search', array( 'type'=>'text', 'label'=> __('Search: ', true), 'default' => $srchd));      
		      // echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'label'=> __('Relevance: ', true),'default'=>$relevance));
		 echo $form->end(__('Go', true));?>
	</div>

	<!-- to-do : download these data in XLS format (or ODS) -->
	<table class="shadow-box-bottom">
		<tr>
			<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
			<th class="ip"><?php echo $paginator->sort(__('MAC', true), 'mac'); ?></th>
			<th class="ip"><?php echo $paginator->sort(__('IP', true), 'ip'); ?></th>
			<th class="info"><?php __('Info'); ?></th>
		</tr>
		<?php foreach ($icmpv6_msgs as $icmpv6_msg): ?>
		<?php if ($icmpv6_msg['Icmpv6']['first_visualization_user_id']) : ?>
		  <tr>
			<td><?php echo $icmpv6_msg['Icmpv6']['capture_date']; ?></td>
			<td><?php echo $icmpv6_msg['Icmpv6']['mac']; ?></td>
			<td><?php echo $icmpv6_msg['Icmpv6']['ip']; ?></td>
		    <td class="pinfo"><a href="#" onclick="popupVetrina('/icmpv6s/info/<?php echo $icmpv6_msg['Icmpv6']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a></td>

		  </tr>
		<?php else : ?>
		 <tr>
			<td><?php echo $icmpv6_msg['Icmpv6']['capture_date']; ?></td>
		    <td><?php echo $icmpv6_msg['Icmpv6']['mac']; ?></td>
			<td><?php echo $icmpv6_msg['Icmpv6']['ip']; ?></td>
		    <td class="pinfo"><a href="#" onclick="popupVetrina('/icmpv6s/info/<?php echo $icmpv6_msg['Icmpv6']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a></td>
		  </tr>
		<?php endif ?>
		<?php endforeach; ?>
	</table>

	<?php echo $this->element('paginator'); ?>

</div>
