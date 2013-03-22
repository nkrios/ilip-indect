
<script language="text/javascript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=620,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>
<div class="generic">
	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search', array( 'url' => array('controller' => 'httpfiles', 'action' => 'index')));
	    echo $form->input('search',  array( 'type'=>'text','size' => '40', 'label' => __('Search:', true), 'default' => $srchd));
	    echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
		echo $form->end(__('Go', true));
	?>

	</div>

 <table id="messagelist" class='shadow-box-bottom'>
 <tr>
	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
	<th><?php echo $paginator->sort(__('Filename', true), 'file_name'); ?></th>
	<th class="size"><?php echo $paginator->sort(__('Size', true), 'file_size'); ?></th>
	<th class="number"><?php echo $paginator->sort(__('Complete', true), 'file_stat'); ?></th>
	<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
	<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
    <th class="info"><?php __('Info'); ?></th>
 </tr>
 <?php foreach ($httpfiles as $httpfile): ?>
 <?php if ($httpfile['Httpfile']['first_visualization_user_id']) : ?>
  	<tr>
		<td><?php echo $httpfile['Httpfile']['capture_date']; ?></td>
		<td><?php echo $html->link($httpfile['Httpfile']['file_name'],'/httpfiles/file/' . substr($httpfile['Httpfile']['id'],0,50)); ?></td>
		<td><?php echo $httpfile['Httpfile']['file_size']; ?></td>
	    <td><?php echo $httpfile['Httpfile']['file_stat']; ?></td>
		<td>
		<?php 
			echo $form->create('Edit',array( 'url' => '/httpfiles/index'));
			echo $form->select('relevance', $relevanceoptions, $httpfile['Httpfile']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true)));
		?>
		</td>
		<td><?php echo $form->hidden('id', array('value' => $httpfile['Httpfile']['id']));echo $form->input ('comments', array ('default' => $httpfile['Httpfile']['comments'],'label' => false, 'size' => '90%'));
			?></td>
	    <td class="pinfo"><a href="#" onclick="popupVetrina('/httpfiles/info/<?php echo $httpfile['Httpfile']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $httpfile['Httpfile']['id']); ?></div></td>
	</tr>
	<tr>
		<td><?php echo $form->end(__('Save', true)); ?></td>
  	</tr>
 <?php else : ?>
  	<tr>
		<td><?php echo $httpfile['Httpfile']['capture_date']; ?></td>
		<td><?php echo $html->link($httpfile['Httpfile']['file_name'],'/httpfiles/file/' . substr($httpfile['Httpfile']['id'],0,50)); ?></td>
		<td><?php echo $httpfile['Httpfile']['file_size']; ?></td>
	    <td><?php echo $httpfile['Httpfile']['file_stat']; ?></td>
		<td><?php echo $form->create('Edit',array( 'url' => '/httpfiles/index'));
		?>
		<?php echo $form->select('relevance', $relevanceoptions, $httpfile['Httpfile']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
		</td>
		<td><?php echo $form->hidden('id', array('value' => $httpfile['Httpfile']['id']));echo $form->input ('comments', array ('default' => $httpfile['Httpfile']['comments'],'label' => false, 'size' => '90%'));
			?></td>
	    <td class="pinfo" ><a href="#" onclick="popupVetrina('/httpfiles/info/<?php echo $httpfile['Httpfile']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $httpfile['Httpfile']['id']); ?></div></td>
	</tr>
	<tr>
		<td><?php echo $form->end(__('Save', true)); ?></td>
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
