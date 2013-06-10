
<!-- <script type="text/javascript" src="/path/to/jquery.tablesorter.js"></script>  -->

<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('Transcriptions'); ?></h2>

	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search',array( 'url' => array('controller' => 'conversations', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text', 'label'=> __('Search: ', true), 'default' => $srchd));
	      //echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	      echo $form->end(__('Go', true));?>

	</div>

	<table class="shadow-box-bottom">
		<tr>	
			<th class="number"><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
			<th class="username"><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
			<th class="date"><?php echo $paginator->sort(__('Transcription Date', true),
	 'transcription_date'); ?></th>	
			<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
			<th class="actions"><?php echo $paginator->sort(__('Actions',true), 'actions'); ?></th>
		</tr>
		
		<?php foreach($conversations as $conversation):  ?> 
			<tr>
				<td><?php echo $conversation['Conversation']['id']; ?></td>
				<td><?php echo $conversation['Conversation']['name']; ?></td>
				<td><?php echo $conversation['Conversation']['transcription_date']; ?>
				<td title="<?php echo htmlentities($conversation['Conversation']['description']) ?>">
				<?php
				if( strlen(htmlentities($conversation['Conversation']['description'])) > 50 ){
				 	echo substr(htmlentities($conversation['Conversation']['description']),0,50).'...'; 
				}else{
					echo htmlentities($conversation['Conversation']['description']); 
				}
				?>
				</td>
				<td><?php 

				    echo $this->Html->link(
				      $html->image('/img/view.png',array('class'=>'button','alt'=>'View/Edit','title'=>'View/Edit')), 
				      array('action' => 'view', $conversation['Conversation']['id']),
				      array('escape'=>false)
				      );
				      
				   echo $this->Html->link(
				      $html->image('/img/update_action.png',array('class'=>'button','alt'=>'Update','title'=>'Update')), 
				      array('action' => 'update', $conversation['Conversation']['id']),
				      array('escape'=>false)
				      );
				     
				   echo $this->Html->link(
				      $html->image('/img/delete2.png',array('class'=>'button','alt'=>'Delete','title'=>'Delete')),
				      array('action' => 'delete', $conversation['Conversation']['id']),
				      array('escape'=>false),
				      // array('class'=>'button','alt'=>'Delete','title'=>'Delete'), 
				      sprintf(__('Are you sure you want to delete %s?', true), $conversation['Conversation']['name']) 
				      ); 
				?></td>

			</tr>

		<?php endforeach; ?>
	</table>

<?php echo $this->element('paginator'); ?>

</div>

<script type="text/javascript">
	// $(document).ready(function(){$("#conversations").tablesorter();});
</script>
