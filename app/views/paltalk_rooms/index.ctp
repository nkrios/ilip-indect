
<div class="generic boxstyle_white">
	<div class="search shadow-box-bottom">
	<?php echo $form->create('Search',array( 'url' => array('controller' => 'msn_chats', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	     echo $form->end(__('Go', true));?>
	</div>

	<table class="shadow-box-bottom">
		
	<tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="date"><?php echo $paginator->sort(__('End', true), 'end_date'); ?></th>
		<th class="room"><?php echo $paginator->sort(__('Room name', true), 'room'); ?></th>
	    <th class="size"><?php echo $paginator->sort(__('Duration', true), 'duration'); ?></th>
		<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
		<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
		<th class="info"><?php __('Info'); ?></th>

	</tr>
	<?php foreach ($paltalk_rooms as $paltalk): 
	   $dh = (int)($paltalk['Paltalk_room']['duration']/3600);
	   $dm = (int)(($paltalk['Paltalk_room']['duration'] - $dh*3600)/60);
	   $ds = (int)(($paltalk['Paltalk_room']['duration'] - $dh*3600) - $dm*60);
	   $duration = $dh.':'.$dm.':'.$ds;
	?>
	<?php if ($paltalk['Paltalk_room']['first_visualization_user_id']) : ?>
	  <tr>
		<td><?php echo $paltalk['Paltalk_room']['capture_date']; ?></td>
		<td><?php echo $paltalk['Paltalk_room']['end_date']; ?></td>
	    <td>
			<a href="#" onclick="popupVetrina('/paltalk_rooms/room/<?php echo $paltalk['Paltalk_room']['id']; ?>','scrollbar=auto'); return false"><?php echo $paltalk['Paltalk_room']['room']; ?></a>
		</td>
	   	<td><?php echo $duration; ?></td>
		<td><?php 
			echo $this->Form->create('EditRel',array( 'url' => '/paltalk_rooms/index'));
			echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$paltalk['Paltalk_room']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
			echo $form->hidden('id', array('value' => $paltalk['Paltalk_room']['id']));
			echo $this->Form->end();
			?>	    	
	    </td>
		<td><?php 
			echo $this->Form->create('EditCom',array( 'url' => '/paltalk_rooms/index'));	
			echo $this->Form->textarea('comments',array('type'=>'string','rows'=>'2','default' => $paltalk['Paltalk_room']['comments'],'label' => false));
			echo $form->hidden('id', array('value' => $paltalk['Paltalk_room']['id']));
			echo $this->Form->end();
			?>
		</td>
	    <td class="pinfo"><a href="#" onclick="popupVetrina('/paltalk_rooms/info/<?php echo $paltalk['Paltalk_room']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
		<div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $paltalk['Paltalk_room']['id']); ?></div>
		</td>
	  </tr>
	<?php else : ?>
	 <tr>
		<td><?php echo $paltalk['Paltalk_room']['capture_date']; ?></td>
	    <td><?php echo $paltalk['Paltalk_room']['end_date']; ?></td>
	    <td><a href="#" onclick="popupVetrina('/paltalk_rooms/room/<?php echo $paltalk['Paltalk_room']['id']; ?>','scrollbar=auto'); return false"><?php echo $paltalk['Paltalk_room']['room']; ?></a></td>
	    <td><?php echo $duration; ?></td>

		<td><?php 
			echo $this->Form->create('EditRel',array( 'url' => '/paltalk_rooms/index'));
			echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$paltalk['Paltalk_room']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
			echo $form->hidden('id', array('value' => $paltalk['Paltalk_room']['id']));
			echo $this->Form->end();
			?>	    	
	    </td>
		<td><?php 
			echo $this->Form->create('EditCom',array( 'url' => '/paltalk_rooms/index'));	
			echo $this->Form->textarea('comments',array('type'=>'string','rows'=>'2','default' => $paltalk['Paltalk_room']['comments'],'label' => false));
			echo $form->hidden('id', array('value' => $paltalk['Paltalk_room']['id']));
			echo $this->Form->end();
			?>
		</td>

		<td class="pinfo"><a href="#" onclick="popupVetrina('/paltalk_rooms/info/<?php echo $paltalk['Paltalk_room']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $paltalk['Paltalk_room']['id']); ?></div>
		</td>

	  </tr>

	<?php endif ?>
	<?php endforeach; ?>
	</table>

<?php echo $this->element('paginator'); ?>
</div>
