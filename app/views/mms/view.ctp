<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic boxstyle_white">


<div class="search shadow-box-bottom">
	<?php 
	echo $form->create('Search',array( 'url' => '/mms/view/'.$mm['Mm']['id']));
    echo $form->input('search', array('type'=>'text', 'label'=> __('Search: ', true), 'default' => $srchd));
    echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
    echo $form->end(__('Go', true));?>
</div>

<table id='email_view' class="shadow-box-bottom">
	<tbody>
		<tr>
			<td><?php __('From:'); ?></td>
			<td class="subject" ><?php echo $mm['Mm']['from_num']?></td>
		</tr>
		<tr>
			<td><?php __('To:'); ?></td>
			<td class="date" ><?php echo $mm['Mm']['to_num']?></td>
		</tr>
		<tr>
			<td><?php __('Cc:'); ?></td>
			<td class="date" ><?php echo $mm['Mm']['cc_num']?></td>
		</tr>
		<tr>
			<td><?php __('Bcc:'); ?></td>
			<td class="date" ><?php echo $mm['Mm']['bcc_num']?></td>
		</tr>
		<tr>
			<td><?php echo __('Relevance',true); ?></td>
			<td class="date"><?php echo $mm['Mm']['relevance']?></td>
		</tr>
		<tr>
			<td><?php echo __('Comments',true); ?></td>
			<td class="date"><?php
			echo $form->create('Edit_Mm',array( 'url' => '/mms/view/'.$mm['Mm']['id']));
			echo $form->input('comments', array ('default' => $mm['Mm']['comments'],'label' => false, 'size' => '100%'));
			echo $form->end(__('Save', true));
		     ?>
		</td>
		</tr>
		<tr>
			<td><?php __('Info:'); ?></td>
			<td class="date pinfo" ><a href="#" onclick="popupVetrina('/mms/info/<?php echo $mm['Mm']['id']?>','scrollbar=auto'); return false">info.xml</a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div></td>
		</tr>
	</tbody>
</table>

<table class="shadow-box-bottom">
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
		<td rowspan='2'><a href="#" onclick="popupVetrina('/mms/data_file/<?php echo  $data_file['Mmscontent']['id']?>','scrollbar=auto'); return false"><?php echo  $data_file['Mmscontent']['filename']?></a>
		<td rowspan='2'><?php echo $data_file['Mmscontent']['file_size']; ?></td>
	        <td>
		<?php 
			echo $form->create('Edit',array( 'url' => '/mms/view/'.$mm['Mm']['id']));
			echo $form->select('relevance', $relevanceoptions, $data_file['Mmscontent']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
		</td>
		<td><?php
			echo $form->hidden('id', array('value' => $data_file['Mmscontent']['id']));
			echo $form->input ('comments', array ('default' => $data_file['Mmscontent']['comments'],'label' => false, 'size' => '90%'));
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
	<div class="centered messageframe">
		<img src=/mms/data_file/<?php echo  $data_file['Mmscontent']['id']?> />
	</div>
	<?php elseif(stristr($data_file['Mmscontent']['content_type'], "text") != null) : ?>
	<div class="centered messageframe">
	   <textarea id="contenuto" readonly="readonly"><?php echo file_get_contents($data_file['Mmscontent']['file_path']); ?>
	   </textarea>
	</div>
<?php endif; ?>
<?php endforeach; ?>
</div>
