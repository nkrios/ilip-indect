
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('HTTP Files'); ?></h2>

	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search', array( 'url' => array('controller' => 'httpfiles', 'action' => 'index')));
	    echo $form->input('search',  array( 'type'=>'text','label' => __('Search: ', true), 'default' => $srchd));
	    echo $form->input('relevance', array('options'=>$relevanceoptions,'all','empty'=>__('-',true),'default'=>$relevance));
		echo $form->end(__('Go', true));
	?>

	</div>

 <table class='shadow-box-bottom'>
	<tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="username"><?php echo $paginator->sort(__('Filename', true), 'file_name'); ?></th>
		<th class="size"><?php echo $paginator->sort(__('Size', true), 'file_size'); ?></th>
		<th class="number"><?php echo $paginator->sort(__('Complete', true), 'file_stat'); ?></th>
		<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
		<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	    <th class="info"><?php __('Info'); ?></th>
	</tr>
 <?php
 	$i=0;
 	foreach ($httpfiles as $httpfile):
 	$i++;
 	if ($httpfile['Httpfile']['first_visualization_user_id']) : 
 	// if (true) : 
 		?>
  	<tr>
		<td><?php echo $httpfile['Httpfile']['capture_date']; ?></td>
		<td><?php echo $html->link( substr($httpfile['Httpfile']['file_name'],0,50),'/httpfiles/file/'.$httpfile['Httpfile']['id'] ) ?></td>
		<td><?php echo $httpfile['Httpfile']['file_size']; ?></td>
	    <td><?php echo $httpfile['Httpfile']['file_stat']; ?></td>

		<td><?php 
			echo $this->Form->create('EditRel',array('url' => '/httpfiles/index/'.$httpfile['Httpfile']['id']));
			echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$httpfile['Httpfile']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
			echo $this->Form->hidden('id', array('value' => $httpfile['Httpfile']['id']));
			echo $this->Form->end();
			?>	    	
	    </td>
		<td><?php 
			echo $this->Form->create('EditCom',array('url' => '/httpfiles/index/'.$httpfile['Httpfile']['id']));	
			echo $this->Form->input('comments',array('type'=>'string','rows'=>'2','default' => $httpfile['Httpfile']['comments'],'label' => false));
			echo $this->Form->hidden('id', array('value' => $httpfile['Httpfile']['id']));
			echo $this->Form->end();
			?>
		</td>
	    <td class="pinfo"><a href="#" onclick="popupVetrina('/httpfiles/info/<?php echo $httpfile['Httpfile']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $httpfile['Httpfile']['id']); ?></div></td>
	</tr>
 <?php else : ?>
  	<tr>
		<td><?php echo $httpfile['Httpfile']['capture_date']; ?></td>
		<td><?php echo $html->link(substr($httpfile['Httpfile']['file_name'],0,50),'/httpfiles/file/' . $httpfile['Httpfile']['id'])?></td>
		<td><?php echo $httpfile['Httpfile']['file_size']; ?></td>
	    <td><?php echo $httpfile['Httpfile']['file_stat']; ?></td>
		<td><?php 
			echo $this->Form->create('EditRel',array('url' => '/httpfiles/index/'.$httpfile['Httpfile']['id']));
			echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$httpfile['Httpfile']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
			echo $this->Form->hidden('id', array('value' => $httpfile['Httpfile']['id']));
			echo $this->Form->end();
			?>	    	
	    </td>
		<td><?php 
			echo $this->Form->create('EditCom',array('url' => '/httpfiles/index/'.$httpfile['Httpfile']['id']));	
			echo $this->Form->input('comments',array('type'=>'string','rows'=>'2','default' => $httpfile['Httpfile']['comments'],'label' => false));
			echo $this->Form->hidden('id', array('value' => $httpfile['Httpfile']['id']));
			echo $this->Form->end();
			?>
		</td>
	    <td class="pinfo" ><a href="#" onclick="popupVetrina('/httpfiles/info/<?php echo $httpfile['Httpfile']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $httpfile['Httpfile']['id']); ?></div>
	    </td>
	</tr>
 <?php endif ?>
<?php endforeach; ?>
</table>

<?php echo $this->element('paginator'); ?>

</div>