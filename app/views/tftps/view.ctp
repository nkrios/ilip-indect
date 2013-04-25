
<div class="search shadow-box-bottom">
	<h2 class="shadow-box-bottom"><?php echo 'TFTP - URL: '.$tftp['Tftp']['url'] ?></h2>

	<div>
	<?php 
	echo $form->create('Search',array( 'url' => '/tftps/view/'.$tftp['Tftp']['tftp_id']));
	echo $form->input('search', array('type'=>'text','maxlength'=>'40', 'label'=> __('Search:', true), 'default' => $srchd));
	echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	echo $form->end(__('Go', true));?>
	</div>

	<table class="shadow-box-bottom">

		<tbody>
			<tr>
				<td><?php __('Url:'); ?></td>
				<td class="subject"><?php echo $tftp['Tftp']['url']?></td>
			</tr>
			<tr>
				<td><?php __('Commands:'); ?></td>
				<td class="date"><a href="#" onclick="popupVetrina('/tftps/cmd','scrollbar=auto'); return false">cmd.txt</A></td>
			</tr>
			<tr>
				<td><?php echo __('Relevance',true); ?></th>
				<td class="date"><?php echo $tftp['Tftp']['relevance']?></td>
			</tr>
			<tr>
				<td><?php echo __('Comments',true); ?></th>
				<td class="date"><?php
				echo $form->create('Edit_Tftp',array( 'url' => '/tftps/view/'.$tftp['Tftp']['id']));
				echo $form->input('comments', array ('default' => $tftp['Tftp']['comments'],'label' => false, 'size' => '100%'));
				echo $form->end(__('Save', true));
			     ?>
			</td>
			</tr>

			<tr>
			<td><?php __('Info:'); ?></td>
			<td class="date pinfo"><a href="#" onclick="popupVetrina('/tftps/info','scrollbar=auto'); return false"><?php __('info.xml'); ?></a></td>
			</tr>
			<tr>
			<td><?php __('PCAP:'); ?></td>
			<td class="date pinfo"><?php echo $html->link('pcap', 'pcap/'); ?></td>
			</tr>

		</tbody>
	</table>

	<table class="shadow-box-bottom">
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
			<td><?php echo $data_file['Tftp_file']['capture_date']; ?></td>
			<td><?php echo $html->link($data_file['Tftp_file']['filename'], 'data_file/' . $data_file['Tftp_file']['id']); ?></td>
			<td><?php echo $data_file['Tftp_file']['file_size']; ?></td>
			<td><?php if ($data_file['Tftp_file']['dowloaded']) echo 'down'; else echo 'up'; ?></td>
			<td>
			<?php 
				echo $form->create('EditRel',array( 'url' => '/tftps/view/'.$tftp['Tftp']['tftp_id']));
				echo $this->Form->input('relevance', array('options' =>$relevanceoptions, 'default'=>$data_file['Tftp_file']['relevance'],'type'=>'select','empty' => __('-', true),'label'=>false));
				echo $this->Form->hidden('id', array('value' => $data_file['Ftp_file']['id']));
				echo $this->Form->end();
			?>
			</td>
			<td>
			<?php
				echo $this->Form->create('EditCom','url' => '/tftps/view/'.$tftp['Tftp']['tftp_id']));
				echo $this->Form->textarea('comments', array ('default' => $tftp['Tftp']['tftp_id']['comments'],'label' => false));
				echo $this->Form->hidden('id', array('value' => $tftp['Tftp']['tftp_id']));
				echo $this->Form->end();
			?>
			</td>
			<td class="pinfo"><a href="#" onclick="popupVetrina('/tftps/info_data/<?php echo $data_file['Tftp_file']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'.$data_file['Tftp_file']['id']); ?></div></td>
		</tr>
		<?php endforeach; ?>
		</table>

<?php echo $this->element('paginator'); ?>
</div>
