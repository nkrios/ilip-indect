<script language="text/javascript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic">


<div id="messageframe">

	<h2><?php __('Telnet to'); ?> <?php echo $telnet['Telnet']['hostname']; ?></h2>
	
<table class="headers-table" class="shadow-box-bottom">

<tbody>
<tr>
<th class="header-title"><?php __('Host:'); ?></th>
<td class="subject"><?php echo $telnet['Telnet']['hostname']; ?></td>
</tr>
<th class="header-title"><?php __('Username:'); ?></th>
<td class="date"><?php echo $telnet['Telnet']['username']; ?></td>
</tr>
<tr>
<th class="header-title"><?php __('Password:'); ?></th>
<td class="date"><?php echo $telnet['Telnet']['password']; ?></td>
</tr>
<tr>
<th class="header-title"><?php __('Info:'); ?></th>
<td class="date pinfo"><a href="#" onclick="popupVetrina('/telnets/info','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div></td>
</tr>
</tbody></table>

<div class="generic centered">
	<div id="web_view" >
	    <fieldset>
	    <legend><?php __('Edit'); ?></legend>
	    <?php echo $this->Form->create('Edit', array('url' => '/telnets/view/'.$telnet['Telnet']['id']));
		    echo $this->Form->input('relevance', array('options' => $relevanceoptions, 'default' => $telnet['Telnet']['relevance'] ,'empty'=>'-- Choose relevance --'));
		    echo $this->Form->input('comments', array('type'=>'string','default' => $telnet['Telnet']['comments']));
		?>
	    <p/>
	    <?php echo $this->Form->end(__('Save', true)); ?>
	    </fieldset>
	</div>
	<div id="contents_view">
	    <fieldset>
	    <legend><?php __('Contents'); ?></legend>

		<div class="centered">
		<textarea cols="81" rows="16" readonly="readonly" ><?php echo file_get_contents($telnet['Telnet']['cmd']); ?></textarea>
		</div>
	</div>
</div>
</div>
</div>
