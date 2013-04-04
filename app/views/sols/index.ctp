<div class="sols boxstyle_white">

	<h2 class="shadow-box-bottom"><?php __('List of listening sessions of case: '); ?><span class="mark"><?php echo $pol_name; ?></span></h2>

	<table class="shadow-box-bottom">
	<tr>
		<th><?php __('Name');?></th>
		<th><?php __('Start Time');?></th>
		<th><?php __('End Time');?></th>
		<th><?php __('Status');?></th>
		<th><?php __('Actions');?></th>
	</tr>
	<?php $i = 0; ?>
	<?php foreach ($sols as $sol): ?>
	<tr>
		<td><?php echo $html->link($sol['Sol']['name'],'/sols/view/' . $sol['Sol']['id']); ?></td>
		<td><?php echo $sol['Sol']['start_time']; ?></td>
		<td><?php echo $sol['Sol']['end_time']; ?></td>
		<td><?php echo $sol['Sol']['status']; ?></td>
		<td class="actions">
		<?php
	    	$i++;
	        if ($i != 1)
	        	echo $html->link(__('Delete', true),'/sols/delete/' . $sol['Sol']['id'], null, 'Are you sure you want to delete \'' . $sol['Sol']['name'] . '\'')
		?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>

</div>