
<div class="generic">
	<div id="messageframe">
	<table class="shadow-box-bottom">

	<tbody>
		<tr>
			<th><?php __('Url:'); ?></th>
			<td class="subject"><?php echo $irc['Irc']['url']?></td>
		</tr>
		<tr>
			<th><?php __('Commands:'); ?></th>
			<td class="date"><a href="#" onclick="popupVetrina('/ircs/cmd','scrollbar=auto'); return false">cmd.txt</a></td>
		</tr>
		<tr>
			<th><?php echo __('Relevance',true); ?></th>
			<td class="date"><?php echo $irc['Irc']['relevance']?></td>
		</tr>
		<tr>
			<th><?php echo __('Comments',true); ?></th>
			<td class="date"><?php
			echo $form->create('Edit_Irc',array( 'url' => '/ircs/view/'.$irc['Irc']['id']));
			echo $form->textarea('comments', array ('default' => $irc['Irc']['comments'],'label' => false, 'row'=>3,'size' => '100%'));
			echo $form->end();
		     ?>
			</td>
		</tr>

		<tr>
			<th><?php __('Info:'); ?></td>
			<td class="date pinfo"><a href="#" onclick="popupVetrina('/ircs/info','scrollbar=auto'); return false">info.xml</a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div></td>
		</tr>
	</tbody>
</table>

<table class="shadow-box-bottom">
	<tr>
		<th><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th><?php echo $paginator->sort(__('Channel', true), 'channel'); ?></th>
		<th><?php echo $paginator->sort(__('End', true), 'end_date'); ?></th>
		<th class="relevance"><?php echo $paginator->sort(__('Relevance', true), 'relevance'); ?></th>
		<th><?php echo $paginator->sort(__('Comments', true), 'comments'); ?></th>
		<th>Info</th>
	</tr>
	<?php foreach ($irc_channel as $data_file): ?>
	<tr>
		<td><?php echo $data_file['Irc_channel']['capture_date']; ?></td>
		<td>
			<a href="#" onclick="popupVetrina('/ircs/channel/<?php echo $data_file['Irc_channel']['id']; ?>','scrollbar=auto'); return false"><?php echo $data_file['Irc_channel']['channel']; ?></a>
		</td>
		<td><?php echo $data_file['Irc_channel']['end_date']; ?></td>

		<td><?php 
			echo $this->Form->create('EditRel',array( 'url' => '/ircs/view/'.$irc['Irc']['id']));
			echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$data_file['Irc_channel']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
			echo $form->hidden('id', array('value' => $data_file['Irc_channel']['id']));
			echo $this->Form->end();
			?>	    	
	    </td>
		<td><?php 
			echo $this->Form->create('EditCom',array( 'url' => '/ircs/view/'.$irc['Irc']['id']));	
			echo $this->Form->textarea('comments',array('type'=>'string','rows'=>'2','default' => $data_file['Irc_channel']['comments'],'label' => false));
			echo $form->hidden('id', array('value' => $data_file['Irc_channel']['id']));
			echo $this->Form->end();
			?>
		</td>

		<td class="pinfo">
			<a href="#" onclick="popupVetrina('/ircs/info_channel/<?php echo $data_file['Irc_channel']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
			<div class="ipcap"><?php echo $html->link('pcap', 'pcap/'.$data_file['Irc_channel']['id']); ?></div>
		</td>
	</tr>
<?php endforeach; ?>
</table>

</div>

<?php echo $this->element('paginator'); ?>

</div>
