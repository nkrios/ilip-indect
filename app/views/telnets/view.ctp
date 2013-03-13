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
<h2><?php __('Telnet to'); ?> <?php echo $telnet['Telnet']['hostname']; ?></h2>

<div id="messageframe">
<table class="headers-table" summary="Message headers" cellpadding="2" cellspacing="0">

<tbody>
<tr>
<td class="header-title"><?php __('Host:'); ?></td>
<td class="subject"><?php echo $telnet['Telnet']['hostname']; ?></td>
</tr>
<td class="header-title"><?php __('Username:'); ?></td>
<td class="date"><?php echo $telnet['Telnet']['username']; ?></td>
</tr>
<tr>
<td class="header-title"><?php __('Password:'); ?></td>
<td class="date"><?php echo $telnet['Telnet']['password']; ?></td>
</tr>
<tr>
<td class="header-title"><?php __('Info:'); ?></td>
<td class="date pinfo"><a href="#" onclick="popupVetrina('/telnets/info','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div></td>
</tr>
</tbody></table>

<div class="generic centered">
	<div id="web_view" style="float:left;width:40%;">
	    <fieldset>
	    <legend><?php __('Edit'); ?></legend>
	    <?php echo $this->Form->create('Edit', array('url' => '/telnets/view/'.$telnet['Telnet']['id']));
		    echo $this->Form->input('relevance', array('options' => $relevanceoptions, 'default' => $telnet['Telnet']['relevance'] ,'empty'=>'-- Choose relevance --'));
		    echo $this->Form->input('comments', array('type'=>'string', 'style' => 'width:400px','default' => $telnet['Telnet']['comments']));
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
