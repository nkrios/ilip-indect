
<div class="generic boxstyle_white">

	<h2 class="shadow-box-bottom"><?php __('TFTP Files'); ?></h2>

	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search',array( 'url' => array('controller' => 'tftps', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text', 'label'=>__('Search: ', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	      echo $form->end(__('Go', true));?>

	</div>

	<table class="shadow-box-bottom">
		<tr>
			<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
			<th class="url"><?php echo $paginator->sort(__('Url', true), 'url'); ?></th>
			<th class="number"><?php echo $paginator->sort(__('Download', true), 'download_num'); ?></th>
			<th class="number"><?php echo $paginator->sort(__('Upload', true), 'upload_num'); ?></th>
			<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
			<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
		</tr>
		<?php foreach ($tftps as $tftp): ?>
		<?php if ($tftp['Tftp']['first_visualization_user_id']) : ?>
		 <tr>
			<td><?php echo $html->link($tftp['Tftp']['capture_date'],'/tftps/view/' . $tftp['Tftp']['id']); ?></td>
			<td><?php echo $html->link($tftp['Tftp']['url'],'/tftps/view/' . $tftp['Tftp']['id']); ?></td>
			<td><?php echo $tftp['Tftp']['download_num']; ?></td>
			<td><?php echo $tftp['Tftp']['upload_num']; ?></td>
		 	<td><?php if ((0 < $tftp['Tftp']['relevance']) && ($tftp['Tftp']['relevance'] <= max($relevanceoptions))){
				  echo $tftp['Tftp']['relevance'];
				}?>
			</td>
			<td title="<?php echo htmlentities($tftp['Tftp']['comments']) ?>">
			<?php
			if( strlen(htmlentities($tftp['Tftp']['comments'])) > 50 ){
			 	echo substr(htmlentities($tftp['Tftp']['comments']),0,50).'...'; 
			}else{
				echo htmlentities($tftp['Tftp']['comments']); 
			}
			?>
		</tr>
		<?php else : ?>
		<tr>
			<td><?php echo $html->link($tftp['Tftp']['capture_date'],'/tftps/view/' . $tftp['Tftp']['id']); ?></td>
			<td><?php echo $html->link($tftp['Tftp']['url'],'/tftps/view/' . $tftp['Tftp']['id']); ?></td>
			<td><?php echo $tftp['Tftp']['download_num']; ?></td>
			<td><?php echo $tftp['Tftp']['upload_num']; ?></td>
		    <td><?php if((0 < $tftp['Tftp']['relevance']) && ($tftp['Tftp']['relevance'] <= max($relevanceoptions))){
				  echo $tftp['Tftp']['relevance'];
				}?>
			</td>
			<td title="<?php echo htmlentities($tftp['Tftp']['comments']) ?>">
			<?php
			if( strlen(htmlentities($tftp['Tftp']['comments'])) > 50 ){
			 	echo substr(htmlentities($tftp['Tftp']['comments']),0,50).'...'; 
			}else{
				echo htmlentities($tftp['Tftp']['comments']); 
			}
			?>
		  </tr>
		<?php endif ?>
		<?php endforeach; ?>
	</table>

<?php echo $this->element('paginator'); ?>

</div>
