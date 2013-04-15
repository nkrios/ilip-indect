<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic boxstyle_white">
	<h2><?php __('Syslog [from - to]'); ?> <?php echo $syslog['Syslog']['hosts']; ?></h2>

	<div>
		<table id='email_view' class="shadow-box-bottom divamiddle">
			<tbody>
				<tr>
					<th><?php __('Hosts:'); ?></th>
					<td class="subject"><?php echo $syslog['Syslog']['hosts']; ?></td>
				</tr>
				<tr>
					<th><?php __('Info:'); ?></th>
					<td class="date pinfo"><a href="#" onclick="popupVetrina('/syslogs/info','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div></td>
				</tr>
			</tbody>
		</table>

		<div id="contents_view" class="generic boxstyle_white divamiddle">
		    <?php echo $this->Form->create('Edit', array('url' => '/syslogs/view/'.$syslog['Syslog']['id']));
			    echo $this->Form->input('relevance', array('options' => $relevanceoptions, 'default' => $syslog['Syslog']['relevance'] ,'empty'=>'-'));
			    echo $this->Form->input('comments', array('type'=>'string', 'style' => 'width:400px','default' => $syslog['Syslog']['comments']));
			?>
		    <?php echo $this->Form->end(__('Save', true)); ?>
		</div>

	</div>
		
	<div class="messageframe">
	    <div>
			<textarea cols="81" rows="16" readonly="readonly" ><?php echo file_get_contents($syslog['Syslog']['log']); ?></textarea>
		</div>
	</div>

</div>
