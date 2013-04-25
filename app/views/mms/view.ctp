
<div class="generic boxstyle_white">

<h2 class="shadow-box-bottom"><?php echo 'MMS: '.$mm['Mm']['url'] ?></h2>
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
			<th><?php __('From:'); ?></th>
			<td class="subject" ><?php echo $mm['Mm']['from_num']?></td>
		</tr>
		<tr>
			<th><?php __('To:'); ?></th>
			<td class="date" ><?php echo $mm['Mm']['to_num']?></td>
		</tr>
		<tr>
			<th><?php __('Cc:'); ?></th>
			<td class="date" ><?php echo $mm['Mm']['cc_num']?></td>
		</tr>
		<tr>
			<th><?php __('Bcc:'); ?></th>
			<td class="date" ><?php echo $mm['Mm']['bcc_num']?></td>
		</tr>
		<tr>
			<th><?php echo __('Relevance',true); ?></th>
			<td class="date"><?php echo $mm['Mm']['relevance']?></td>
		</tr>
		<tr>
			<th><?php echo __('Comments',true); ?></th>
			<td class="date"><?php
			echo $form->create('Edit_Mm',array( 'url' => '/mms/view/'.$mm['Mm']['id']));
			echo $form->textarea('comments', array ('default' => $mm['Mm']['comments'],'label' => false,'rows'=>'2','size' => '100%'));
			echo $form->end();
		     ?>
		</td>
		</tr>
		<tr>
			<th><?php __('Info:'); ?></th>
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
		<th class="comments"><?php echo $paginator->sort(__('Comments', true), 'comments'); ?></th>
	</tr>
	<?php foreach ($mmscontent as $data_file): ?>
	<tr>
		<td><?php echo $data_file['Mmscontent']['content_type']; ?></td>
		<td><a href="#" onclick="popupVetrina('/mms/data_file/<?php echo  $data_file['Mmscontent']['id']?>','scrollbar=auto'); return false"><?php echo  $data_file['Mmscontent']['filename']?></a>
		<td><?php echo $data_file['Mmscontent']['file_size']; ?></td>
	    <td>
	    <?php 
			echo $this->Form->create('EditRel',array( 'url' => '/mms/view/'.$mm['Mm']['id']));
			echo $this->Form->input('relevance', array('options' =>$relevanceoptions, 'default'=>$data_file['Mmscontent']['relevance'],'type'=>'select','empty' => __('-', true),'label'=>false));
			echo $this->Form->hidden('id', array('value' => $data_file['Mmscontent']['id']));
			echo $this->Form->end();
		?>
		</td>
		<td>
		<?php 
			echo $this->Form->create('EditCom',array( 'url' => '/mms/view/'.$mm['Mm']['id']));
			echo $this->Form->textarea('comments', array ('default' => $data_file['Mmscontent']['comments'],'label' => false));
			echo $this->Form->hidden('id', array('value' => $data_file['Mmscontent']['id']));
			echo $this->Form->end();
		?>
		</td>
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
