<!--
Copyright: Gianluca Costa & Andrea de Franceschi 2007-2010, http://www.xplico.org
 Version: MPL 1.1/GPL 2.0/LGPL 2.1
-->
<script language="JavaScript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic">
<div class="search">

<center>
<?php echo $form->create('Search',array( 'url' => '/tftps/view/'.$tftp['Tftp']['tftp_id']));
      echo $form->input('search', array('type'=>'text','size' => '40','maxlength'=>'40', 'label'=> __('Search:', true), 'default' => $srchd));
      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-- Choose relevance --',true),'default'=>$relevance));
      echo $form->end(__('Go', true));?>
</center>
</div>
<br/>

<div id="messageframe">
<table class="headers-table" summary="Message headers" cellpadding="2" cellspacing="0">

<tbody><tr>
<td class="header-title"><?php __('Url:'); ?>&nbsp;</td>
<td class="subject" width="90%"><?php echo $tftp['Tftp']['url']?></td>
</tr>
<tr>
<td class="header-title"><?php __('Commands:'); ?>&nbsp;</td>
<td class="date" width="90%"><A href="#" onclick="popupVetrina('/tftps/cmd','scrollbar=auto'); return false">cmd.txt</A></td>
</tr>
<tr>
<td class="header-title"><?php echo __('Relevance',true); ?></th>
<td class="date" width="90%"><?php echo $tftp['Tftp']['relevance']?></td>
</tr>
<tr>
<td class="header-title"><?php echo __('Comments',true); ?></th>
<td class="date" width="90%"><?php
	echo $form->create('Edit_Tftp',array( 'url' => '/tftps/view/'.$tftp['Tftp']['id']));
	echo $form->input('comments', array ('default' => $tftp['Tftp']['comments'],'label' => false, 'size' => '100%'));
	echo $form->end(__('Save', true));
     ?>
</td>
</tr>

<tr>
<td class="header-title"><?php __('Info:'); ?>&nbsp;</td>
<td class="date pinfo" width="90%"><a href="#" onclick="popupVetrina('/tftps/info','scrollbar=auto'); return false"><?php __('info.xml'); ?></a></td>
</tr>
<tr>
<td class="header-title"><?php __('PCAP:'); ?>&nbsp;</td>
<td class="date pinfo" width="90%"><?php echo $html->link('pcap', 'pcap/'); ?></td>
</tr>

</tbody></table>

<table id="messagelist" cellpadding="2" cellspacing="0">
<tr>
	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
	<th class="from"><?php echo $paginator->sort(__('Name', true), 'filename'); ?></th>
	<th class="size"><?php echo $paginator->sort(__('Size', true), 'file_size'); ?></th>
	<th class="size"><?php echo $paginator->sort(__('Dir', true), 'dowloaded'); ?></th>
	<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
	<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	<th class="info">Info</th>
</tr>
<?php foreach ($tftp_file as $data_file): ?>
<tr>
<td rowspan='2'><?php echo $data_file['Tftp_file']['capture_date']; ?></td>
<td rowspan='2'><?php echo $html->link($data_file['Tftp_file']['filename'], 'data_file/' . $data_file['Tftp_file']['id']); ?></td>
<td rowspan='2'><?php echo $data_file['Tftp_file']['file_size']; ?></td>
<td rowspan='2'><?php if ($data_file['Tftp_file']['dowloaded']) echo 'down'; else echo 'up'; ?></td>
<td>
<?php 
	echo $form->create('Edit',array( 'url' => '/tftps/view/'.$tftp['Tftp']['tftp_id']));
	echo $form->select('relevance', $relevanceoptions, $data_file['Tftp_file']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
</td>
<td><?php
		echo $form->hidden('id', array('value' => $data_file['Tftp_file']['id']));
		echo $form->input ('comments', array ('default' => $data_file['Tftp_file']['comments'],'label' => false), 'size' => '90%' );
	?>
</td>

<td class="pinfo" rowspan='2'><a href="#" onclick="popupVetrina('/tftps/info_data/<?php echo $data_file['Tftp_file']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'.$data_file['Tftp_file']['id']); ?></div></td>
</tr>
<tr>
<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>

<table id="listpage" summary="Message list" cellspacing="0">
<tr>
	<th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
       	<th><?php echo $paginator->numbers(); echo '<br/>'.$paginator->counter(); ?></th>
	<th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
</tr>
</table>
</div>
