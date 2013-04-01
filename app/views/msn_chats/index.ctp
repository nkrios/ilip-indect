<script language="text/javascript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=620,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic">
	<div class="search shadow-box-bottom">
	<?php echo $form->create('Search',array( 'url' => array('controller' => 'msn_chats', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text','size' => '40', 'label' => __('Search:', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	     echo $form->end(__('Go', true));?>
	</div>

	<table id="messagelist" class="shadow-box-bottom">
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
		<td rowspan='2'><?php echo $msn['Msn_chat']['capture_date']; ?></td>
		<td rowspan='2'><?php echo $msn['Msn_chat']['end_date']; ?></td>
	        <td rowspan='2'><a href="#" title="<?php echo htmlentities($msn['Msn_chat']['chat']); ?>" onclick="popupVetrina('/msn_chats/chat/<?php echo $msn['Msn_chat']['id']; ?>','scrollbar=auto'); return false"><?php echo htmlentities($msn['Msn_chat']['chat']); ?></a></td>
	        <td rowspan='2'><?php echo $duration; ?></td>
		<td><?php 
			echo $form->create('Edit',array( 'url' => '/msns/index'));
			echo $form->select('relevance', $relevanceoptions, $msn['Msn_chat']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true)));
		?>
		</td><td><?php
			echo $form->hidden('id', array('value' => $msn['Msn_chat']['id']));
			echo $form->input('comments', array ('default' => $msn['Msn_chat']['comments'],'label' => false, 'size' => '90%'));
		?></td>
	        <td class="pinfo" rowspan='2'><a href="#" onclick="popupVetrina('/msn_chats/info/<?php echo $msn['Msn_chat']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $msn['Msn_chat']['id']); ?></div></td>
	  </tr>
	<tr>
		<td colspan='2'><?php echo $form->end(__('Save', true)); ?>
		</td>
	 </tr>
	<?php else : ?>
	 <tr>
		<td rowspan='2'><b><?php echo $msn['Msn_chat']['capture_date']; ?></b></td>
	        <td rowspan='2'><b><?php echo $msn['Msn_chat']['end_date']; ?></b></td>
	        <td rowspan='2'><b><a href="#" title="<?php echo htmlentities($msn['Msn_chat']['chat']); ?>" onclick="popupVetrina('/msn_chats/chat/<?php echo $msn['Msn_chat']['id']; ?>','scrollbar=auto'); return false"><?php echo htmlentities($msn['Msn_chat']['chat']); ?></a></b></td>
	        <td rowspan='2'><b><?php echo $duration; ?></b></td>
		<td><?php 
			echo $form->create('Edit',array( 'url' => '/msns/index'));
			echo $form->select('relevance', $relevanceoptions, $msn['Msn_chat']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true)));
		?>
		</td><td><?php
			echo $form->hidden('id', array('value' => $msn['Msn_chat']['id']));
			echo $form->input('comments', array ('default' => $msn['Msn_chat']['comments'],'label' => false, 'size' => '90%'));
		?></td>
	        <td class="pinfo" rowspan='2'><b><a href="#" onclick="popupVetrina('/msn_chats/info/<?php echo $msn['Msn_chat']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $msn['Msn_chat']['id']); ?></div></b></td>
	</tr>
	<tr>
		<td colspan='2'><?php echo $form->end(__('Save', true)); ?>
		</td>
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
