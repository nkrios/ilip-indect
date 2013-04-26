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
			<td><?php echo $chat['Fbchat']['capture_date']; ?></td>
			<td><?php echo unicode2html($chats[0]['Fbchat']['user']); ?></td>
			<td><a href="#" onclick="popupVetrina('/fbuchats/view/<?php echo $chat['Fbchat']['id']; ?>','scrollbar=auto'); return false"><?php echo $friend; ?></a></td>
			<td><?php echo $h.":".$m.":".$s; ?></td>
			<td><?php echo $chat['Fbchat']['data_size']; ?></td>
			<td><?php 
				echo $this->Form->create('EditRel',array('url' => '/fbuchats/chats/'.$chat['Fbchat']['fbuchat_id']));
				echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$chat['Fbchat']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
				echo $form->hidden('id', array('value' => $chat['Fbchat']['id']));
				echo $this->Form->end();
				?>	    	
		    </td>
			<td><?php 
				echo $this->Form->create('EditCom',array('url' => '/fbuchats/chats/'.$chat['Fbchat']['fbuchat_id']));	
				echo $this->Form->textarea('comments',array('type'=>'string','rows'=>'2','default' => $chat['Fbchat']['comments'],'label' => false));
				echo $form->hidden('id', array('value' => $chat['Fbchat']['id']));
				echo $this->Form->end();
				?>
			</td>

	    	<td class="pinfo"><a href="#" onclick="popupVetrina('/fbuchats/info/<?php echo $chat['Fbchat']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $chat['']['id']); ?></div></td>
	  </tr>
	 <?php else : ?>
	  <tr>
	        <td><?php echo $chat['Fbchat']['capture_date']; ?></td>
	        <td><?php echo unicode2html($chats[0]['Fbchat']['user']); ?></td>
	        <td><a href="#" onclick="popupVetrina('/fbuchats/view/<?php echo $chat['Fbchat']['id']; ?>','scrollbar=auto'); return false"><?php echo $friend; ?></a></td>
	        <td><?php echo $h.":".$m.":".$s; ?></td>
	        <td><?php echo $chat['Fbchat']['data_size']; ?></td>

			<td><?php 
				echo $this->Form->create('EditRel',array('url' => '/fbuchats/chats/'.$chat['Fbchat']['fbuchat_id']));
				echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$chat['Fbchat']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
				echo $form->hidden('id', array('value' => $chat['Fbchat']['id']));
				echo $this->Form->end();
				?>	    	
		    </td>
			<td><?php 
				echo $this->Form->create('EditCom',array('url' => '/fbuchats/chats/'.$chat['Fbchat']['fbuchat_id']));	
				echo $this->Form->textarea('comments',array('type'=>'string','rows'=>'2','default' => $chat['Fbchat']['comments'],'label' => false));
				echo $form->hidden('id', array('value' => $chat['Fbchat']['id']));
				echo $this->Form->end();
				?>
			</td>

		    <td class="pinfo"><a href="#" onclick="popupVetrina('/fbuchats/info/<?php echo $chat['Fbchat']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $chat['Fbchat']['id']); ?></div>
			</td>
	  </tr>
	 <?php endif ?>
	<?php endforeach; ?>
	</table>
<?php echo $this->element('paginator'); ?>
</div>
