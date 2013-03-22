
<div class="generic">
	<div class="search shadow-box-bottom">
		<?php echo $form->create('Search', array( 'url' => array('controller' => 'webmails', 'action' => 'index')));
		      echo $form->input('search',  array( 'type'=>'text','size' => '40', __('Search', true), 'default' => $srchd));
		      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
		echo $form->end(__('Go', true));
		?>
	</div>

	 <table id="messagelist" class="shadow-box-bottom">
	 <tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="subject"><?php echo $paginator->sort(__('Subject', true), 'subject'); ?></th>
		<th class="from"><?php echo $paginator->sort(__('Sender', true), 'sender'); ?></th>
		<th class="to"><?php echo $paginator->sort(__('Receivers', true), 'receivers'); ?></th>
		<th class="size"><?php echo $paginator->sort(__('Service', true), 'service'); ?></th>
		<th class="size"><?php echo $paginator->sort(__('Size', true), 'data_size'); ?></th>
		<th class="relevance"><?php echo $paginator->sort(__('Rel.',true), 'relevance'); ?></th>
		<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	 </tr>
	 <?php foreach ($emails as $email): ?>
	 <?php if ($email['Webmail']['first_visualization_user_id']) : ?>
	  <tr>
		<td><?php echo $email['Webmail']['capture_date']; ?></td>
	        <?php if ($email['Webmail']['subject'] == "") : ?>
	        <td><?php echo $html->link("--",'/webmails/view/' . $email['Webmail']['id']); ?></td>
	        <?php else : ?>
		<td><?php echo $html->link(htmlentities($email['Webmail']['subject']), '/webmails/view/' . $email['Webmail']['id']); ?></td>
	        <?php endif; ?>
		<td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Webmail']['sender'])); ?></td>
		<td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Webmail']['receivers'])); ?></td>
		<td><?php echo $email['Webmail']['service']; ?></td>
		<td><?php echo $email['Webmail']['data_size']; ?></td>
		<td><?php if ((0<$email['Webmail']['relevance']) && ($email['Webmail']['relevance'] <= max($relevanceoptions))) {
			  echo $email['Webmail']['relevance'];
			}?>
		</td>
		<td><?php echo $email['Webmail']['comments']; ?></td>
	  </tr>
	 <?php else : ?>
	  <tr>
		<td><?php echo $email['Webmail']['capture_date']; ?></td>
	        <?php if ($email['Webmail']['subject'] == "") : ?>
	        <td><?php echo $html->link("--",'/webmails/view/' . $email['Webmail']['id']); ?></td>
	        <?php else : ?>
		<td><?php echo $html->link(htmlentities($email['Webmail']['subject']), '/webmails/view/' . $email['Webmail']['id']); ?></td>
	        <?php endif; ?>
		<td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Webmail']['sender'])); ?></td>
		<td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Webmail']['receivers'])); ?></td>
		<td><?php echo $email['Webmail']['service']; ?></td>
		<td><?php echo $email['Webmail']['data_size']; ?></td>
		<td><?php echo $email['Webmail']['relevance']; ?></td>
		<td><?php echo $email['Webmail']['comments']; ?></td>
	  </tr>
	 <?php endif; ?>
	<?php endforeach; ?>
	</table>
	<table id="listpage" class="shadow-box-bottom">
		<tr>
			<th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
		       	<th><?php echo $paginator->numbers(); echo ' ('.$paginator->counter().')';?></th>
			<th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
		</tr>
	</table>

<!--Export to .csv-->
<?php
   echo $form->create('ParserCSV',array( 'url' => array('controller' => 'webmails', 'action' => 'export')));
   echo $form->end(__('Export to .csv file', true));
?>

</div>
