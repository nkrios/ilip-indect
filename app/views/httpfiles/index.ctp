
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('HTTP Files'); ?></h2>

	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search', array( 'url' => array('controller' => 'httpfiles', 'action' => 'index')));
	    echo $form->input('search',  array( 'type'=>'text','label' => __('Search: ', true), 'default' => $srchd));
	    echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
		echo $form->end(__('Go', true));
	?>

	</div>

 <table class='shadow-box-bottom'>
	<tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="username"><?php echo $paginator->sort(__('Filename', true), 'file_name'); ?></th>
		<th class="size"><?php echo $paginator->sort(__('Size', true), 'file_size'); ?></th>
		<th class="number"><?php echo $paginator->sort(__('Complete', true), 'file_stat'); ?></th>
		<!-- <th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th> -->
		<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	    <th class="info"><?php __('Info'); ?></th>
	</tr>
 <?php
 	$i=0;
 	foreach ($httpfiles as $httpfile):
 	$i++;
 	if ($httpfile['Httpfile']['first_visualization_user_id']) : ?>
  	<tr>
		<td><?php echo $httpfile['Httpfile']['capture_date']; ?></td>
		<td><?php echo $html->link( substr($httpfile['Httpfile']['file_name'],0,50),'/httpfiles/file/'.$httpfile['Httpfile']['id'] ) ?></td>
		<td><?php echo $httpfile['Httpfile']['file_size']; ?></td>
	    <td><?php echo $httpfile['Httpfile']['file_stat']; ?></td>
		<td><?php 
			echo $this->Form->create('Edit'.$i,array( 'action' => 'index'));
			echo $this->Form->select('relevance', $relevanceoptions, $httpfile['Httpfile']['relevance'] ,array('empty' => __('-', true)));
			?>
		</td>
		<td><?php 
			// echo $this->Form->hidden('id', array('value' => $httpfile['Httpfile']['id']));
			echo $this->Form->input('comments', array ('default' => $httpfile['Httpfile']['comments'],'label' => false));
			echo $this->Form->end(__('Save', true));
			// echo $form->end();
			?>
		</td>
	    <td class="pinfo"><a href="#" onclick="popupVetrina('/httpfiles/info/<?php echo $httpfile['Httpfile']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $httpfile['Httpfile']['id']); ?></div></td>
	</tr>
 <?php else : ?>
  	<tr>
		<td><?php echo $httpfile['Httpfile']['capture_date']; ?></td>
		<td><?php echo $html->link(substr($httpfile['Httpfile']['file_name'],0,50),'/httpfiles/file/' . $httpfile['Httpfile']['id'])?></td>
		<td><?php echo $httpfile['Httpfile']['file_size']; ?></td>
	    <td><?php echo $httpfile['Httpfile']['file_stat']; ?></td>
		<td><?php 
			echo $this->Form->create('Edit',array( 'url' => '/httpfiles/index'));
			
			echo $this->Form->input('comments', array ('default' => $httpfile['Httpfile']['comments'],'label' => false));
			// echo $this->Form->select('relevance', $relevanceoptions, $httpfile['Httpfile']['relevance'] ,array('empty' => __('-', true),'label'=>'Rel:'));
			echo $this->Form->input('relevance', array('options' =>$relevanceoptions, 'default'=>$httpfile['Httpfile']['relevance']) ,array('type'=>'select','empty' => __('-', true),'label'=>'Rel:'));
			echo $this->Form->hidden('id', array('value' => $httpfile['Httpfile']['id']));
			echo $this->Form->end();
			?>
		</td>
	    <td class="pinfo" ><a href="#" onclick="popupVetrina('/httpfiles/info/<?php echo $httpfile['Httpfile']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $httpfile['Httpfile']['id']); ?></div></td>
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


<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=620,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
    //Submit data when element loses the focus
    $("table input").blur(function () {
    	console.log('table input blur')
    	sendData($(this))
     	return false;
    });
    $("table select").blur(function () {
    	console.log('table select blur')
    	sendData($(this))
     	return false;
    });

    function sendData(elemOfForm){
    	var frm = elemOfForm.parent().parent();
    	$.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                console.log('ok');
            },
            error: function() {
            	console.log('error');
            }
        });
    }

</script>
