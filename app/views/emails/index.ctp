<!--
Copyright: Gianluca Costa & Andrea de Franceschi 2007-2010, http://www.xplico.org
 Version: MPL 1.1/GPL 2.0/LGPL 2.1
-->
<div class="generic">
<div class="search">


<center>
	<?php echo $form->create('Search', array( 'url' => array('controller' => 'emails', 'action' => 'index')));
	      echo $form->input('search', array( 'type'=>'text','size' => '30', 'label'=>__('Search:', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-- Choose relevance --',true),'default'=>$relevance));
	 echo $form->end(__('Go', true));?>
</center>
</div>
<br />
<!--
Export to .csv
-->
<?php
   echo $form->create('ParserCSV',array( 'url' => array('controller' => 'emails', 'action' => 'export')));
   echo $form->end(__('Export to .csv file', true));
?>

<br />
 <table id="messagelist" summary="Message list" cellspacing="0">
 <tr>
	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
	<th class="subject"><?php echo $paginator->sort(__('Subject', true), 'subject'); ?></th>
	<th class="from"><?php echo $paginator->sort(__('Sender', true), 'sender'); ?></th>
	<th class="to"><?php echo $paginator->sort(__('Receivers', true), 'receivers'); ?></th>
	<th class="size"><?php echo $paginator->sort(__('Size', true), 'data_size'); ?></th>
	<th width="80px"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
	<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	<th width="70px"><?php __('Actions');?></th>
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
	<td><b><?php echo $email['Email']['capture_date']; ?></b></td>
        <?php if ($email['Email']['subject'] == '' || $email['Email']['subject'] == ' ') : ?>
        <td><b><?php echo $html->link("--",'/emails/view/' . $email['Email']['id']); ?></b></td>
        <?php else : ?>
        <?php if (strpos($email['Email']['subject'], '=?') != 0): ?>
	<td><b><?php echo $html->link(htmlentities($email['Email']['subject']), '/emails/view/' . $email['Email']['id']); ?></b></td>
        <?php else : ?>
	<td><b><?php echo $html->link($email['Email']['subject'], '/emails/view/' . $email['Email']['id']); ?></b></td>
        <?php endif; ?>
        <?php endif; ?>
	<td><b><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Email']['sender'])); ?></b></td>
	<td><b><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $email['Email']['receivers'])); ?></b></td>
	<td><b><?php echo $email['Email']['data_size']; ?></b></td>

	<td><b>
		<?php 
		if ( $email['Email']['relevance'] > 0 ) {
			echo $email['Email']['relevance'];
		}
		?>
	</b></td>
	<td><b><?php echo $email['Email']['comments']; ?></b></td>
  </tr>
 <?php endif ?>
<?php endforeach; ?>
</table>
<table id="listpage" summary="Message list" cellspacing="0">
<tr>
<th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
<th><?php echo $paginator->numbers(); echo '<br/>'.$paginator->counter(); ?></th>
<th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
</tr>
</table>

</div>
