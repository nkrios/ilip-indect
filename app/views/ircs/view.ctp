
<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

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
			echo $form->input('comments', array ('default' => $irc['Irc']['comments'],'label' => false, 'size' => '100%'));
			echo $form->end(__('Save', true));
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
		<td rowspan='2'><?php echo $data_file['Irc_channel']['capture_date']; ?></td>
		<td rowspan='2'>
			<a href="#" onclick="popupVetrina('/ircs/channel/<?php echo $data_file['Irc_channel']['id']; ?>','scrollbar=auto'); return false"><?php echo $data_file['Irc_channel']['channel']; ?></a>
		</td>
		<td rowspan='2'><?php echo $data_file['Irc_channel']['end_date']; ?></td>
	        <td>
		<?php 
			echo $form->create('Edit',array( 'url' => '/ircs/view/'.$irc['Irc']['id']));
			echo $form->select('relevance', $relevanceoptions, $data_file['Irc_channel']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
		</td>
		<td><?php
			echo $form->hidden('id', array('value' => $data_file['Irc_channel']['id']));
			echo $form->input ('comments', array ('default' => $data_file['Irc_channel']['comments'],'label' => false, 'size' => '90%')       );
			?>
		</td>
		<td class="pinfo" rowspan='2'>
			<a href="#" onclick="popupVetrina('/ircs/info_channel/<?php echo $data_file['Irc_channel']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
			<div class="ipcap"><?php echo $html->link('pcap', 'pcap/'.$data_file['Irc_channel']['id']); ?></div>
		</td>
	</tr>
	<tr>
		<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
	</tr>
<?php endforeach; ?>
</table>

</div>
  <table id="listpage" class="shadow-box-bottom">
    <tr>
      <th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
      <th><?php echo $paginator->numbers(); echo ' ('.$paginator->counter().')';?></th>
      <th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
    </tr>
  </table>
</div>
