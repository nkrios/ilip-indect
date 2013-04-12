
<div class="generic boxstyle_white">

	<h2 class="shadow-box-bottom"><?php __('FTP Files'); ?></h2>

	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search',array( 'url' => array('controller' => 'ftps', 'action' => 'index')));
      echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
      echo $form->end(__('Go', true));?>

	</div>

<table class="shadow-box-bottom">
	<tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="from"><?php echo $paginator->sort(__('Url', true), 'url'); ?></th>
	    <th class="username"><?php echo $paginator->sort(__('User', true), 'username'); ?></th>
		<th class="number"><?php echo $paginator->sort(__('Download', true), 'download_num'); ?></th>
		<th class="number"><?php echo $paginator->sort(__('Upload', true), 'upload_num'); ?></th>
		<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
		<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	</tr>
<?php foreach ($ftps as $ftp): ?>
<?php if ($ftp['Ftp']['first_visualization_user_id']) : ?>
  <tr>
	<td><?php echo $ftp['Ftp']['capture_date']; ?></td>
	<td><?php echo $html->link($ftp['Ftp']['url'],'/ftps/view/' . $ftp['Ftp']['id']); ?></td>
        <td><?php echo $ftp['Ftp']['username']; ?></td>
	<td><?php echo $ftp['Ftp']['download_num']; ?></td>
	<td><?php echo $ftp['Ftp']['upload_num']; ?></td>
    <td><?php 
		if((0 < $ftp['Ftp']['relevance']) && ($ftp['Ftp']['relevance'] <= max($relevanceoptions))){
		  echo $ftp['Ftp']['relevance'];
		}?>
	</td>
	<td><?php echo $ftp['Ftp']['comments'];	?></td>
  </tr>
<?php else : ?>
 <tr>
	<td><?php echo $ftp['Ftp']['capture_date']; ?></td>
	<td><?php echo $html->link($ftp['Ftp']['url'],'/ftps/view/' . $ftp['Ftp']['id']); ?></td>
    <td><?php echo $ftp['Ftp']['username']; ?></td>
	<td><?php echo $ftp['Ftp']['download_num']; ?></td>
	<td><?php echo $ftp['Ftp']['upload_num']; ?></td>
    <td><?php 
		if ((0 < $ftp['Ftp']['relevance']) && ($ftp['Ftp']['relevance'] <= max($relevanceoptions))){
		  echo $ftp['Ftp']['relevance'];
		}
	    ?>
	</td>
	<td><?php echo $ftp['Ftp']['comments']; ?></td>
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
