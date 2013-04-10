
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
<h2 class="shadow-box-bottom"><?php __('RTP'); ?></h2>

	<div>
		<table id='email_view' class="shadow-box-bottom divamiddle">
			<tbody>
			<tr>
				<th ><?php __('Date:'); ?></th>
				<td class="date" ><?php echo $rtp['Rtp']['capture_date']; ?></td>
				<td></td>
			</tr>
			<tr>
				<th ><?php __('From:'); ?></th>
				<td class="from" ><?php echo $rtp['Rtp']['from_addr']; ?></td>
				<td><a href="#" onclick="popupVoip('/rtps/caller_play/<?php echo $rtp['Rtp']['id']?>','scrollbar=auto'); return false"><?php __('play'); ?></a></td>
			</tr>
			<tr>
				<th ><?php __('To:'); ?></th>
				<td class="to" ><?php echo $rtp['Rtp']['to_addr']; ?></td>
				<td><a href="#" onclick="popupVoip('/rtps/called_play/<?php echo $rtp['Rtp']['id']?>','scrollbar=auto'); return false"><?php __('play'); ?></a></td>
			</tr>
			<tr>
				<th ><?php __('Duration:'); ?></th>
			<?php
			 /* time in HH:MM:SS */
			 $h = (int)($rtp['Rtp']['duration']/3600);
			 $m = (int)(($rtp['Rtp']['duration']-3600*$h)/60);
			 $s = $rtp['Rtp']['duration'] - 3600*$h - 60*$m;
			 $hms=''.$h.':'.$m.':'.$s;
			?>
				<td class="date" ><?php echo $hms; ?></td>
				<td></td>
			</tr>
			<tr>
				<th ><?php __('Info:'); ?></th>
				<td class="date pinfo" ><a href="#" onclick="popupVetrina('/rtps/info/<?php echo $rtp['Rtp']['id']?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div></td>
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
				<td class="date pinfo">
					<?php
					if($conversation['Conversation']['transcription_date']){
						echo $html->link($conversation['Conversation']['name'],'/conversations/view/' . $conversation['Conversation']['id']);
					}else{echo '-';}
					?>
					<td></td>
			</tr>
			</tbody>
		</table>



		<div id="contents_view" class="generic boxstyle_white divamiddle">
		    <!-- <h3><?php __('Edit'); ?></h3> -->
		    <?php echo $this->Form->create('Edit', array('url' => '/rtps/view/'.$rtp['Rtp']['id']));
			    echo $this->Form->input('relevance', array('options' => $relevanceoptions, 'default' => $rtp['Rtp']['relevance'] ,'empty'=>'-'));
			    echo $this->Form->input('comments', array('type'=>'string','default' => $rtp['Rtp']['comments']));
			?>
		    <?php echo $this->Form->end(__('Save', true)); ?>
		</div>

</div>

	<div id="messageframe">
	    <!-- <h3><?php __('Contents'); ?></h3> -->
			<div class="voip_flash">
				<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="100%" height="220" id="sound">
					<param name="allowScriptAccess" value="sameDomain"></param>
					<param name="allowFullScreen" value="false"></param>
					<param name="movie" value="/files/xplico_voip_mix.swf"></param>
					<param name="quality" value="high"></param>
					<param name="bgcolor" value="#8C63A2"></param>
					<param name=FlashVars  value="audio_url=<?php echo '/rtps/mix/'.$rtp['Rtp']['id']; ?>"></param>
					<embed src="/files/xplico_voip_mix.swf" quality="high" bgcolor="#8C63A2" width="100%" height="220"  FlashVars="audio_url=<?php echo '/rtps/mix/'.$rtp['Rtp']['id']; ?>" name="sound" wmode="window" allowscriptaccess="sameDomain" allowfullscreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_en"></embed>
				</object>
			</div>
	</div>
</div>

</div>
