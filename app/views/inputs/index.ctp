
<div class="generic boxstyle_white">
	<h2><?php __('Input files list'); ?></h2>
	<table class="shadow-box-bottom">
	<tr>
		<th><?php __('File name'); ?></th>
		<th><?php __('MD5 & SHA1'); ?></th>
		<th><?php __('Size'); ?></th>
	</tr>
	<?php foreach ($inputs as $input): ?>
	<tr>
		<td><?php echo $input['Input']['filename']; ?></td>
		<td><?php echo 'MD5:'.$input['Input']['md5'].' SHA1:'.$input['Input']['sha1']; ?></td>
		<td><?php echo $input['Input']['data_size']; ?></td>
	</tr>

	<?php endforeach; ?>
	</table>
</div>
