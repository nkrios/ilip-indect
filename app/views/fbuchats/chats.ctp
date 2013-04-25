<?php 
function unicode2html($string) {
    return preg_replace('/\\\\u([0-9a-z]{4})/', '&#x$1;', $string);
} ?>

<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php echo 'Facebook chat: '.unicode2html($chats[0]['Fbchat']['user']) ?></h2>

	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search', array( 'url' => array('controller' => 'fbuchats', 'action' => 'chats')));
	      echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	      echo $form->end(__('Go', true));
	 ?>
	</div>

	<table class="shadow-box-bottom">
		<tr>
			<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
			<th class="subject"><?php echo $paginator->sort(__('User', true), 'user'); ?></th>
			<th class="subject"><?php echo $paginator->sort(__('Friend', true), 'friend'); ?></th>
			<th class="subject"><?php echo $paginator->sort(__('Duration [hh:mm:ss]', true), 'duration'); ?></th>
			<th class="size"><?php echo $paginator->sort(__('Size', true), 'data_size'); ?></th>
			<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
			<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
		    <th class="info"><?php __('Info'); ?></th>
		 </tr>
	 <?php foreach ($chats as $chat): 
	   		$h = (int)($chat['Fbchat']['duration']/3600);
	        $m = (int)($chat['Fbchat']['duration']/60 - $h*60);
	        $s = (int)$chat['Fbchat']['duration']%60;
	        $friend = unicode2html($chats[0]['Fbchat']['friend']);
	   
	  if ($chat['Fbchat']['first_visualization_user_id']) :

	  	?>
	  <tr>
		<td rowspan='2'><?php echo $chat['Fbchat']['capture_date']; ?></td>
		<td rowspan='2'><?php echo unicode2html($chats[0]['Fbchat']['user']); ?></td>
		<td rowspan='2'><a href="#" onclick="popupVetrina('/fbuchats/view/<?php echo $chat['Fbchat']['id']; ?>','scrollbar=auto'); return false"><?php echo $friend; ?></a></td>
		<td rowspan='2'><?php echo $h.":".$m.":".$s; ?></td>
		<td rowspan='2'><?php echo $chat['Fbchat']['data_size']; ?></td>
		<td>
		<?php 
			echo $form->create('Edit',array( 'url' => '/fbuchats/chats/'.$chat['Fbchat']['fbuchat_id']));
			echo $form->select('relevance', $relevanceoptions, $chat['Fbchat']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
		</td>
		<td><?php
				echo $form->hidden('id', array('value' => $chat['Fbchat']['id']));
				echo $form->input ('comments', array ('default' => $chat['Fbchat']['comments'],'label' => false));
			?>
		</td>

	    <td class="pinfo" rowspan='2'><a href="#" onclick="popupVetrina('/fbuchats/info/<?php echo $chat['Fbchat']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $chat['']['id']); ?></div></td>
	  </tr>
	  <tr>
		<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
	  </tr>
	 <?php else : ?>
	  <tr>
	        <td rowspan='2'><?php echo $chat['Fbchat']['capture_date']; ?></td>
	        <td rowspan='2'><?php echo unicode2html($chats[0]['Fbchat']['user']); ?></td>
	        <td rowspan='2'><a href="#" onclick="popupVetrina('/fbuchats/view/<?php echo $chat['Fbchat']['id']; ?>','scrollbar=auto'); return false"><?php echo $friend; ?></a></td>
	        <td rowspan='2'><?php echo $h.":".$m.":".$s; ?></td>
	        <td rowspan='2'><?php echo $chat['Fbchat']['data_size']; ?></td>
		<td>
		<?php 
			echo $form->create('Edit',array( 'url' => '/fbuchats/chats/'.$chat['Fbchat']['fbuchat_id']));
			echo $form->select('relevance', $relevanceoptions, $chat['Fbchat']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
		</td>
		<td><?php
				echo $form->hidden('id', array('value' => $chat['Fbchat']['id']));
				echo $form->input ('comments', array ('default' => $chat['Fbchat']['comments'],'label' => false));
			?>
		</td>
	    <td class="pinfo" rowspan='2'><a href="#" onclick="popupVetrina('/fbuchats/info/<?php echo $chat['Fbchat']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $chat['Fbchat']['id']); ?></div>
		</td>
	  </tr>
	  <tr>
		<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
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
