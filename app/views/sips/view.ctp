<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
    function popupVoip(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=370,height=110,toolbar=no,resizable=no,menubar=no');
      return false;
    }
</script>

<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('SIP'); ?></h2>

	<div>
		<table id='email_view' class="shadow-box-bottom divamiddle">
			<tbody>
				<tr>
					<th ><?php __('Date:'); ?></th>
					<td class="date" ><?php echo $sip['Sip']['capture_date']; ?></td>
					<td></td>
				</tr>
				<tr>
					<th ><?php __('From:'); ?></th>
					<td class="from" ><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['from_addr'])); ?></td>
					<td><a href="#" onclick="popupVoip('/sips/caller_play/<?php echo $sip['Sip']['id']?>','scrollbar=auto'); return false"><?php __('play'); ?></a></td>
				</tr>
				<tr>
					<th ><?php __('To:'); ?></th>
					<td class="to" ><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['to_addr'])); ?></td>
					<td><a href="#" onclick="popupVoip('/sips/called_play/<?php echo $sip['Sip']['id']?>','scrollbar=auto'); return false"><?php __('play'); ?></a></td>
				</tr>
				<tr>
					<th ><?php __('Duration:'); ?></th>
					<?php
					 /* time in HH:MM:SS */
					 $h = (int)($sip['Sip']['duration']/3600);
					 $m = (int)(($sip['Sip']['duration']-3600*$h)/60);
					 $s = $sip['Sip']['duration'] - 3600*$h - 60*$m;
					 $hms=''.$h.':'.$m.':'.$s;
					?>
					<td class="date" ><?php echo $hms; ?></td>
					<td></td>
				</tr>
				<tr>
					<th ><?php __('Commands:'); ?></th>
					<td class="date" ><a href="#" onclick="popupVetrina('/sips/cmds/<?php echo $sip['Sip']['id']?>','scrollbar=auto'); return false">cmd.txt</a></td>
					<td></td>
				</tr>
					<th ><?php __('Info:'); ?></th>
					<td class="date pinfo" ><a href="#" onclick="popupVetrina('/sips/info/<?php echo $sip['Sip']['id']?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div></td>
					<td></td>
				</tr>
				<tr>
					<th ><?php __('Transcription Date:'); ?></th>
					<td class="date pinfo"><?php
						if($conversation['Conversation']['transcription_date']){
							echo $conversation['Conversation']['transcription_date'];
						}
						else{
							echo '-';
						}
					?></td>
					<td></td>
				</tr>
				<tr>
					<th ><?php __('Conversation Name:'); ?></th>
					<td class="date pinfo"><?php
						if($conversation['Conversation']['transcription_date']){
							echo $html->link($conversation['Conversation']['name'],'/conversations/view/' . $conversation['Conversation']['id']);
						}
						else{
							echo '-';
						}
					?>
					<td></td>
				</tr>
			</tbody>

		</table>

		<div id="contents_view" class="generic boxstyle_white divamiddle">
		    <!-- <h3><?php __('Edit'); ?></h3> -->
		    <?php echo $this->Form->create('Edit', array('url' => '/sips/view/'.$sip['Sip']['id']));
			    echo $this->Form->input('relevance', array('options' => $relevanceoptions, 'default' => $sip['Sip']['relevance'] ,'empty'=>'-'));
			    echo $this->Form->input('comments', array('type'=>'string', 'default' => $sip['Sip']['comments']));
			?>
		    <?php echo $this->Form->end(__('Save', true)); ?>		    
		</div>

	</div>

	<div class="messageframe">

		<!-- <h3><?php __('Contents'); ?></h3> -->
		<div class="voip_flash">
			<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="100%" height="220" id="sound" align="middle">
					<param name="allowScriptAccess" value="sameDomain"></param>
					<param name="allowFullScreen" value="false"></param>
					<param name="movie" value="/files/xplico_voip_mix.swf"></param>
					<param name="quality" value="high"></param>
					<param name="bgcolor" value="#8C63A2"></param>
					<param name=FlashVars  value="audio_url=<?php echo '/sips/mix/'.$sip['Sip']['id']; ?>"></param>
					<embed src="/files/xplico_voip_mix.swf" quality="high" bgcolor="#8C63A2" width="100%" height="220"  FlashVars="audio_url=<?php echo '/sips/mix/'.$sip['Sip']['id']; ?>" name="sound" align="middle" wmode="window" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_en"></embed>
			</object>
		</div>
	</div>

</div>