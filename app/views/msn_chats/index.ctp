
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom">MSN Chats</h2>

	<div class="search shadow-box-bottom">
	<?php echo $form->create('Search',array( 'url' => array('controller' => 'msn_chats', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text','label' => __('Search: ', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	     echo $form->end(__('Go', true));?>
	</div>

	<table class="shadow-box-bottom">
	<tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="date"><?php echo $paginator->sort(__('End', true), 'end_date'); ?></th>
		<th class="email"><?php echo $paginator->sort(__('Chat', true), 'chat'); ?></th>
	    <th class="number"><?php echo $paginator->sort(__('Duration', true), 'duration'); ?></th>
		<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
		<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
		<th class="info"><?php __('Info'); ?></th>
	</tr>
	<?php foreach ($msn_chats as $msn): 
	   $dh = (int)($msn['Msn_chat']['duration']/3600);
	   $dm = (int)(($msn['Msn_chat']['duration'] - $dh*3600)/60);
	   $ds = (int)(($msn['Msn_chat']['duration'] - $dh*3600) - $dm*60);
	   $duration = $dh.':'.$dm.':'.$ds;
	?>
	<?php if ($msn['Msn_chat']['first_visualization_user_id']) : ?>
	  <tr>
		<td><?php echo $msn['Msn_chat']['capture_date']; ?></td>
		<td><?php echo $msn['Msn_chat']['end_date']; ?></td>
	        <td><a href="#" title="<?php echo htmlentities($msn['Msn_chat']['chat']); ?>" onclick="popupVetrina('/msn_chats/chat/<?php echo $msn['Msn_chat']['id']; ?>','scrollbar=auto'); return false"><?php echo htmlentities($msn['Msn_chat']['chat']); ?></a></td>
	        <td><?php echo $duration; ?></td>

			<td><?php 
				echo $this->Form->create('EditRel',array( 'url' => '/msns/index/'.$msn['Msn_chat']['id']));
				echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$msn['Msn_chat']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
				echo $form->hidden('id', array('value' => $msn['Msn_chat']['id']));
				echo $this->Form->end();
				?>	    	
		    </td>
			<td><?php 
				echo $this->Form->create('EditCom',array( 'url' => '/msns/index/'.$msn['Msn_chat']['id']));	
				echo $this->Form->textarea('comments',array('type'=>'string','rows'=>'2','default' => $msn['Msn_chat']['comments'],'label' => false));
				echo $form->hidden('id', array('value' => $msn['Msn_chat']['id']));
				echo $this->Form->end();
				?>
			</td>

	        <td class="pinfo"><a href="#" onclick="popupVetrina('/msn_chats/info/<?php echo $msn['Msn_chat']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $msn['Msn_chat']['id']); ?></div></td>
	  </tr>
	<?php else : ?>
	 <tr>
		<td><?php echo $msn['Msn_chat']['capture_date']; ?></td>
	        <td><?php echo $msn['Msn_chat']['end_date']; ?></td>
	        <td><a href="#" title="<?php echo htmlentities($msn['Msn_chat']['chat']); ?>" onclick="popupVetrina('/msn_chats/chat/<?php echo $msn['Msn_chat']['id']; ?>','scrollbar=auto'); return false"><?php echo htmlentities($msn['Msn_chat']['chat']); ?></a></td>
	        <td><?php echo $duration; ?></td>

			<td><?php 
				echo $this->Form->create('EditRel',array( 'url' => '/msns/index/'.$msn['Msn_chat']['id']));
				echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$msn['Msn_chat']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
				echo $form->hidden('id', array('value' => $msn['Msn_chat']['id']));
				echo $this->Form->end();
				?>	    	
		    </td>
			<td><?php 
				echo $this->Form->create('EditCom',array( 'url' => '/msns/index/'.$msn['Msn_chat']['id']));	
				echo $this->Form->textarea('comments',array('type'=>'string','rows'=>'2','default' => $msn['Msn_chat']['comments'],'label' => false));
				echo $form->hidden('id', array('value' => $msn['Msn_chat']['id']));
				echo $this->Form->end();
				?>
			</td>
			
	        <td class="pinfo"><a href="#" onclick="popupVetrina('/msn_chats/info/<?php echo $msn['Msn_chat']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $msn['Msn_chat']['id']); ?></div></td>
	</tr>
	<?php endif ?>
	<?php endforeach; ?>
	</table>

<?php echo $this->element('paginator'); ?>
</div>
