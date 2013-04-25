
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php echo 'MMS' ?></h2>

	<div class="search shadow-box-bottom">
		<?php echo $form->create('Search',array( 'url' => array('controller' => 'mms', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text', 'label'=> __('Search: ', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	      echo $form->end(__('Go', true));?>
	</div>

	<table class="shadow-box-bottom">
	<tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="from"><?php echo $paginator->sort(__('From', true), 'from_num'); ?></th>
	    <th class="to"><?php echo $paginator->sort(__('To', true), 'to_num'); ?></th>
		<th class="number"><?php echo $paginator->sort(__('Contents', true), 'contents'); ?></th>
		<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
		<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	    <th class="info">Info</th>
	</tr>
	<?php foreach ($mms as $mm): ?>
	<?php if ($mm['Mm']['first_visualization_user_id']) : ?>
	  <tr>
		<td><?php $html->link($mm['Mm']['capture_date'],'/mms/view/' . $mm['Mm']['id']);?></td>
	    <td><?php echo $mm['Mm']['from_num']; ?></td>
	    <td><?php echo $mm['Mm']['to_num']; ?></td>
		<td><?php echo $html->link($mm['Mm']['contents'],'/mms/view/' . $mm['Mm']['id']); ?></td>
	    <td><?php if((0 < $mm['Mm']['relevance']) && ($mm['Mm']['relevance'] <= max($relevanceoptions)) ){echo $mm['Mm']['relevance'];}?>
		</td>
		<td title="<?php echo htmlentities($mm['Mm']['comments']) ?>">
			<?php
			if( strlen(htmlentities($mm['Mm']['comments'])) > 50 ){
			 	echo substr(htmlentities($mm['Mm']['comments']),0,50).'...'; 
			}else{
				echo htmlentities($mm['Mm']['comments']); 
			}
			?>
		</td>
	    <td class="pinfo"><a href="#" onclick="popupVetrina('/mms/info/<?php echo $mm['Mm']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $mm['Mm']['id']); ?></div></td>
	</tr>
	<?php else : ?>
		<tr>
		<td><?php $html->link($mm['Mm']['capture_date'],'/mms/view/' . $mm['Mm']['id']);?></td>
		    <td><?php echo $mm['Mm']['from_num']; ?></td>
		    <td><?php echo $mm['Mm']['to_num']; ?></td>
			<td><?php echo $html->link($mm['Mm']['contents'],'/mms/view/' . $mm['Mm']['id']); ?></td>
		    <td><?php 
				if ((0 < $mm['Mm']['relevance']) && ($mm['Mm']['relevance'] <= max($relevanceoptions)) ) {
				  echo $mm['Mm']['relevance'];
				}?>
			</td>
			<td title="<?php echo htmlentities($mm['Mm']['comments']) ?>">
			<?php
			if( strlen(htmlentities($mm['Mm']['comments'])) > 50 ){
			 	echo substr(htmlentities($mm['Mm']['comments']),0,50).'...'; 
			}else{
				echo htmlentities($mm['Mm']['comments']); 
			}
			?>
			</td>
		    <td class="pinfo"><a href="#" onclick="popupVetrina('/mms/info/<?php echo $mm['Mm']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $mm['Mm']['id']); ?></div></td>
		</tr>
	<?php endif ?>
	<?php endforeach; ?>
	</table>

<?php echo $this->element('paginator'); ?>
</div>
