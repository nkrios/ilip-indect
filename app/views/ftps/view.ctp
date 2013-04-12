
<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic boxstyle_white">

	<h2 class="shadow-box-bottom"><?php echo 'FTP - URI: '.$ftp['Ftp']['url'] ?></h2>

	<div class="search shadow-box-bottom">
		<?php 
		echo $this->Form->create('Search',array( 'url' => '/ftps/view/'.$ftp_id));
	    echo $this->Form->input('search', array('type'=>'text','maxlength'=>'40', 'label'=> __('Search: ', true), 'default' => $srchd));
	    echo $this->Form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	    echo $this->Form->end(__('Go', true));
	    ?>
	</div>

<table id='email_view' class="shadow-box-bottom">

	<tbody>
		<tr>
			<th><?php __('Url:'); ?></th>
			<td class="subject" ><?php echo $ftp['Ftp']['url']?></td>
		</tr>
		<tr>
			<th><?php __('Username:'); ?></th>
			<td class="date" ><?php echo $ftp['Ftp']['username']?></td>
		</tr>
		<tr>
			<th><?php __('Password:'); ?></th>
			<td class="date" ><?php echo $ftp['Ftp']['password']?></td>
		</tr>
		<tr>
			<th><?php __('Commands:'); ?></th>
			<td class="date" ><a href="#" onclick="popupVetrina('/ftps/cmd','scrollbar=auto'); return false">cmd.txt</a></td>
		</tr>
		<tr>
			<th><?php echo __('Relevance',true); ?></th>
			<td class="date" ><?php echo $ftp['Ftp']['relevance']?></td>
		</tr>
		<tr>
			<th><?php echo __('Comments',true); ?></th>
			<td class="date"><?php
			echo $this->Form->create('Edit_Ftp',array( 'url' => '/ftps/view/'.$ftp['Ftp']['id']));
			echo $this->Form->input('comments', array ('default' => $ftp['Ftp']['comments'],'label' => false));
			echo $this->Form->end();
		     ?></td>
		</tr>
		<tr>
			<th><?php __('Info:'); ?></th>
			<td class="date pinfo" ><a href="#" onclick="popupVetrina('/ftps/info','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div></td>
		</tr>
	</tbody>
</table>

<table class="shadow-box-bottom">
	<tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="from"><?php echo $paginator->sort(__('Name', true), 'filename'); ?></th>
		<th class="size"><?php echo $paginator->sort(__('Size', true), 'file_size'); ?></th>
		<th class="size"><?php echo $paginator->sort(__('Dir', true), 'dowloaded'); ?></th>
		<!-- <th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th> -->
		<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
		<th class="info">Info</th>
	</tr>
	<?php foreach ($ftp_file as $data_file): ?>
	<tr>
		<td><?php echo $data_file['Ftp_file']['capture_date']; ?></td>
		<td><?php echo $html->link($data_file['Ftp_file']['filename'], 'data_file/' . $data_file['Ftp_file']['id']); ?></td>
		<td><?php echo $data_file['Ftp_file']['file_size']; ?></td>
		<td><?php if ($data_file['Ftp_file']['dowloaded']) echo 'down'; else echo 'up'; ?></td>
		<td>
		<?php 
			echo $this->Form->create('Edit',array( 'url' => '/ftps/view/'.$ftp['Ftp']['id']));
			echo $this->Form->input('comments', array ('default' => $data_file['Ftp_file']['comments'],'label' => false, 'size' => '90%'));
			// echo $this->Form->select('relevance', $relevanceoptions, $data_file['Ftp_file']['relevance'] ,array('label' => __('-', true), 'empty' => __('-', true)));
			echo $this->Form->input('relevance', array('options' =>$relevanceoptions, 'default'=>$data_file['Ftp_file']['relevance']) ,array('type'=>'select','empty' => __('-', true),'label'=>'Rel:'));
			echo $this->Form->hidden('id', array('value' => $data_file['Ftp_file']['id']));
			echo $this->Form->end();
		?>
		</td>
		<td class="pinfo">
			<a href="#" onclick="popupVetrina('/ftps/info_data/<?php echo $data_file['Ftp_file']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
			<div class="ipcap"><?php echo $html->link('pcap', 'pcap/'.$data_file['Ftp_file']['id']); ?></div>
		</td>
	</tr>
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
