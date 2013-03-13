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
<?php echo $form->create('Search',array( 'url' => '/mms/view/'.$mm['Mm']['id']));
      echo $form->input('search', array('type'=>'text','size' => '40', 'label'=> __('Search:', true), 'default' => $srchd));
      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-- Choose relevance --',true),'default'=>$relevance));
      echo $form->end(__('Go', true));?>
</center>
</div>
<br/>

<table class="headers-table" summary="Message headers" cellpadding="2" cellspacing="0">
<tbody>
<tr>
<td class="header-title"><?php __('From:'); ?>&nbsp;</td>
<td class="subject" ><?php echo $mm['Mm']['from_num']?></td>
</tr>
<tr>
<td class="header-title"><?php __('To:'); ?>&nbsp;</td>
<td class="date" ><?php echo $mm['Mm']['to_num']?></td>
</tr>
<tr>
<td class="header-title"><?php __('Cc:'); ?>&nbsp;</td>
<td class="date" ><?php echo $mm['Mm']['cc_num']?></td>
</tr>
<tr>
<td class="header-title"><?php __('Bcc:'); ?>&nbsp;</td>
<td class="date" ><?php echo $mm['Mm']['bcc_num']?></td>
</tr>
<tr>
<td class="header-title"><?php echo __('Relevance',true); ?></td>
<td class="date" width="90%"><?php echo $mm['Mm']['relevance']?></td>
</tr>
<tr>
<td class="header-title"><?php echo __('Comments',true); ?></td>
<td class="date" width="90%"><?php
	echo $form->create('Edit_Mm',array( 'url' => '/mms/view/'.$mm['Mm']['id']));
	echo $form->input('comments', array ('default' => $mm['Mm']['comments'],'label' => false, 'size' => '100%'));
	echo $form->end(__('Save', true));
     ?>
</td>
</tr>
<tr>
<td class="header-title"><?php __('Info:'); ?>&nbsp;</td>
<td class="date pinfo" ><a href="#" onclick="popupVetrina('/mms/info/<?php echo $mm['Mm']['id']?>','scrollbar=auto'); return false">info.xml</a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div></td>
</tr>
</tbody></table>

<table id="messagelist" cellpadding="2" cellspacing="0">
<tr>
	<th class="from"><?php echo $paginator->sort(__('Content Type', true),'content_type'); ?></th>
	<th class="from"><?php echo $paginator->sort(__('File name', true),'filename'); ?></th>
	<th class="size"><?php echo $paginator->sort(__('Size', true),'file_size'); ?></th>
	<th class="relevance"><?php echo $paginator->sort(__('Relevance', true), 'relevance'); ?></th>
	<th><?php echo $paginator->sort(__('Comments', true), 'comments'); ?></th>
</tr>
<?php foreach ($mmscontent as $data_file): ?>
<tr>
	<td rowspan='2'><?php echo $data_file['Mmscontent']['content_type']; ?></td>
	<td rowspan='2'><A href="#" onclick="popupVetrina('/mms/data_file/<?php echo  $data_file['Mmscontent']['id']?>','scrollbar=auto'); return false"><?php echo  $data_file['Mmscontent']['filename']?></A>
	<td rowspan='2'><?php echo $data_file['Mmscontent']['file_size']; ?></td>
        <td>
	<?php 
		echo $form->create('Edit',array( 'url' => '/mms/view/'.$mm['Mm']['id']));
		echo $form->select('relevance', $relevanceoptions, $data_file['Mmscontent']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
	</td>
	<td><?php
		echo $form->hidden('id', array('value' => $data_file['Mmscontent']['id']));
		echo $form->input ('comments', array ('default' => $data_file['Mmscontent']['comments'],'label' => false, 'size' => '90%')       );
		?>
	</td>
</tr>
<tr>
	<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php foreach ($mmscontent as $data_file): ?>
 <?php if (stristr($data_file['Mmscontent']['content_type'], "image") != null) : ?>
 <div class="centered">
   <img src=/mms/data_file/<?php echo  $data_file['Mmscontent']['id']?> />
 </div>
 <?php elseif(stristr($data_file['Mmscontent']['content_type'], "text") != null) : ?>
 <div class="centered">
   <textarea id="contenuto" cols="80" rows="2" style="text-align: left;" readonly="readonly"><?php echo file_get_contents($data_file['Mmscontent']['file_path']); ?>
   </textarea>
 </div>
 <?php endif; ?>
<?php endforeach; ?>
</div>
