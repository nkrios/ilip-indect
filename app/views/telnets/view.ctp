
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
			    echo $this->Form->textarea('comments', array('type'=>'string','rows' => 3,'default' => $telnet['Telnet']['comments']));
			?>
		    <?php echo $this->Form->end(); ?>
		</div>

	</div>

	<div class="messageframe">
		<textarea cols="81" rows="16" readonly="readonly" ><?php echo utf8_encode(file_get_contents($telnet['Telnet']['cmd'])); ?></textarea>
	</div>

</div>
