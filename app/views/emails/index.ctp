
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('Emails'); ?></h2>

	<div class="search shadow-box-bottom">

		<?php echo $form->create('Search', array( 'url' => array('controller' => 'emails', 'action' => 'index')));
		      echo $form->input('search', array( 'type'=>'text','size' => '30', 'label'=>__('Search:', true), 'default' => $srchd));
		      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
		 echo $form->end(__('Go', true));?>

	</div>


	<table class="shadow-box-bottom">
		<tr>
			<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
			<th class="subject"><?php echo $paginator->sort(__('Subject', true), 'subject'); ?></th>
			<th class="from"><?php echo $paginator->sort(__('Sender', true), 'sender'); ?></th>
			<th class="to"><?php echo $paginator->sort(__('Receivers', true), 'receivers'); ?></th>
			<th class="size"><?php echo $paginator->sort(__('Size', true), 'data_size'); ?></th>
			<th  class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
			<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
			<th class="actions"><?php __('Actions');?></th>
			<!--	<th class="relevance"><?php echo $paginator->sort('relevance'); ?></th>
				<a href="/relevance.html" 
				onclick="window.open('/relevance.html','popup','width=500,height=500,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); 
				return false">(?)</a>
			</th>
			-->
		</tr>
		<?php foreach ($emails as $email): ?>
		<?php if ($email['Email']['first_visualization_user_id']) : ?>
		<tr>
		<td><?php echo $email['Email']['capture_date']; ?></td>
		    <?php if ($email['Email']['subject'] == '' || $email['Email']['subject'] == ' ') : ?>
		    <td><?php echo $html->link("--",'/emails/view/' . $email['Email']['id']); ?></td>
		    <?php else : ?>
		    <?php if (strpos($email['Email']['subject'], '=?') != 0): ?>
		<td><?php echo $html->link(htmlentities($email['Email']['subject']), '/emails/view/' . $email['Email']['id']); ?></td>
		    <?php else : ?>
		    <td><?php echo $html->link($email['Email']['subject'], '/emails/view/' . $email['Email']['id']); ?></td>
		    <?php endif; ?>
		    <?php endif; ?>
		<td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Email']['sender'])); ?></td>
		<td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Email']['receivers'])); ?></td>
		<td><?php echo $email['Email']['data_size']; ?></td>
		<td><?php 
			if ( $email['Email']['relevance'] > 0) {
				echo $email['Email']['relevance'];
			}
			?></td>
		<td><?php echo $email['Email']['comments']; ?></td>
		</tr>
		<?php else : ?>
		<tr>
		<td><?php echo $email['Email']['capture_date']; ?></td>
		    <?php if ($email['Email']['subject'] == '' || $email['Email']['subject'] == ' ') : ?>
		    <td><?php echo $html->link("--",'/emails/view/' . $email['Email']['id']); ?></td>
		    <?php else : ?>
		    <?php if (strpos($email['Email']['subject'], '=?') != 0): ?>
		<td><?php echo $html->link(htmlentities($email['Email']['subject']), '/emails/view/' . $email['Email']['id']); ?></td>
		    <?php else : ?>
		<td><?php echo $html->link($email['Email']['subject'], '/emails/view/' . $email['Email']['id']); ?></td>
		    <?php endif; ?>
		    <?php endif; ?>
		<td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Email']['sender'])); ?></td>
		<td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Email']['receivers'])); ?></td>
		<td><?php echo $email['Email']['data_size']; ?></td>

		<td>
			<?php if ( $email['Email']['relevance'] > 0 ) {
				echo $email['Email']['relevance'];
			}?>
		</td>
		<td><?php echo $email['Email']['comments']; ?></td>
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

	<!--Export to .csv-->
<?php
   echo $form->create('ParserCSV',array( 'url' => array('controller' => 'emails', 'action' => 'export')));
   echo $form->end(__('Export to .csv file', true));
?>

</div>
