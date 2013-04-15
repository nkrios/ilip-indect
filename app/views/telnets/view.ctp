<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic boxstyle_white">
	<h2><?php __('Telnet to'); ?> <?php echo $telnet['Telnet']['hostname']; ?></h2>

	<div>

		<table id='email_view' class="shadow-box-bottom divamiddle">

			<tr>
				<th><?php __('Host:'); ?></th>
				<td class="subject"><?php echo $telnet['Telnet']['hostname']; ?></td>
			</tr>
				<th><?php __('Username:'); ?></th>
				<td class="date"><?php echo $telnet['Telnet']['username']; ?></td>
			</tr>
			<tr>
				<th><?php __('Password:'); ?></th>
				<td class="date"><?php echo $telnet['Telnet']['password']; ?></td>
			</tr>
			<tr>
				<th><?php __('Info:'); ?></th>
				<td class="date pinfo"><a href="#" onclick="popupVetrina('/telnets/info','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div>
				</td>
			</tr>

		</table>

		<div id="contents_view" class="generic boxstyle_white divamiddle">

		    <?php echo $this->Form->create('Edit', array('url' => '/telnets/view/'.$telnet['Telnet']['id']));
			    echo $this->Form->input('relevance', array('options' => $relevanceoptions, 'default' => $telnet['Telnet']['relevance'] ,'empty'=>'-'));
			    echo $this->Form->input('comments', array('type'=>'string','default' => $telnet['Telnet']['comments']));
			?>
		    <?php echo $this->Form->end(__('Save', true)); ?>
		</div>

	</div>

	<div class="messageframe">
		<textarea cols="81" rows="16" readonly="readonly" ><?php echo file_get_contents($telnet['Telnet']['cmd']); ?></textarea>
	</div>

</div>
