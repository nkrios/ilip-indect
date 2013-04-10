<script type="text/javascript" src="/path/to/jquery-latest.js"></script> 
<script type="text/javascript" src="/path/to/jquery.tablesorter.js"></script> 

<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('Transcriptions'); ?></h2>

	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search',array( 'url' => array('controller' => 'conversations', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text', 'label'=> __('Search:', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	      echo $form->end(__('Go', true));?>

	</div>

	<table class="shadow-box-bottom">
		<tr>	
			<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
			<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
			<th><?php echo $paginator->sort(__('Transcription Date', true),
	 'transcription_date'); ?></th>	
			<th><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
			<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
		</tr>
		
		<?php foreach($conversations as $conversation): 

			$url1 = array('controller'=>'Conversations', 'action'=>'view', $conversation['Conversation']['id'], null);
			$url2 = array('controller'=>'Conversations', 'action'=>'update', $conversation['Conversation']['id'], null);
			$url3 = array('controller'=>'Conversations', 'action'=>'index', $conversation['Conversation']['id'], $conversation['Conversation']['id']); ?> 
			<tr>
				<td><?php 
				echo $form->button('VIEW', array('onclick' => "location.href='".$this->Html->url($url1)."'")); 
				echo $form->button('UPDATE', array('onclick' => "location.href='".$this->Html->url($url2)."'"));
				echo $form->button('DELETE', array('onclick' => "location.href='".$this->Html->url($url3)."'"));
				?></td>
				<td><?php echo $conversation['Conversation']['id']; ?></td>
				<td><?php echo $conversation['Conversation']['name']; ?></td>
				<td><?php echo $conversation['Conversation']['transcription_date']; ?>
				<td><?php
					if($conversation['Conversation']['relevance'] > 0){
						echo $conversation['Conversation']['relevance'];
					}
				 ?></td>
				<td><?php echo $conversation['Conversation']['comments']; ?></td>
			</tr>

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

<script type="text/javascript">
	$(document).ready(function(){$("#conversations").tablesorter();});
</script>
