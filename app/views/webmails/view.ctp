
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('Webmail to'); ?> <?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $mailObj['to']))?></h2>

	<div>

		<table id='email_view' class="shadow-box-bottom divamiddle">

			<tr>
				<th ><?php __('Subject:'); ?></th>
				<td class="subject"><?php echo htmlentities($mailObj['Subject']); ?></td>
			</tr>
			<tr>
				<th ><?php __('Sender:'); ?></th>
				<td class="from"><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $mailObj['from']))?></td>
			</tr>
			<tr>
				<th ><?php __('Recipient:'); ?></th>
				<td class="to"><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $mailObj['to']))?></td>
			</tr>
			<?php if (isset($mailObj['Date'])) : ?>
			<tr>
				<th ><?php __('Date:'); ?></th>
				<td class="date"><?php echo $mailObj['Date']; ?></td>
			</tr>
			<?php endif; ?>
			<tr>
				<th ><?php __('EML file:'); ?></th>
				<td class="date"><?php echo $html->link(__('email.eml', true), '/webmails/eml') ?></td>
			</tr>
			<tr>
				<th ><?php __('Info:'); ?></th>
				<td class="date pinfo"><a href="#" onclick="popupVetrina('/webmails/info','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div>
				</td>
			</tr>

		</table>

		<div id="contents_view" class="generic boxstyle_white divamiddle">
		    <?php echo $this->Form->create('Edit', array('url' => '/webmails/view/'.$email['Webmail']['id']));
			    echo $this->Form->input('relevance', array('options' => $relevanceoptions, 'default' => $email['Webmail']['relevance'] ,'empty'=>'-'));
			    echo $this->Form->input('comments', array('type'=>'string','rows'=>'3', 'default' => $email['Webmail']['comments']));
			?>
		    <?php echo $this->Form->end(); ?>
		</div>
	</div>

	<div class="messageframe">
		<div>
			<?php if ($mailObj['Type'] == 'html') : ?>
			<object class="html" type="text/html" data="/webmails/content/<?php echo strrchr($mailObj['DataFile'], '/'); ?>">
			</object>
			<?php elseif ($mailObj['Type'] == 'text') : ?>
			<div class="centered">
				<textarea rows="10" cols="75" readonly="readonly">
				<?php if (!empty($mailObj['DataFile'])) {
				  echo file_get_contents($mailObj['DataFile']);
				}?>
				</textarea>
			</div>
			<?php endif; ?>
			<?php if (isset($mailObj['Attachments'])) : ?>
			  <table>
				  <?php foreach($mailObj['Attachments'] as $attachment) : ?>
				    <tr>
				    	<td >Attached <?php echo $attachment['Type'] ?></td>
				    <?php if (isset($attachment['FileName'])) : ?>
				    	<td class="date"><?php echo $html->link($attachment['FileName'], '/webmails/content'.strrchr($attachment['DataFile'], '/')) ?></td>
				    <?php elseif (isset($attachment['Description'])) : ?>
				    	<td class="date"><?php echo $html->link($attachment['Description'], '/webmails/content'.strrchr($attachment['DataFile'], '/')) ?></td>
				    <?php endif; ?>
				    </tr>
				  <?php endforeach; ?>
			</table>
			<?php endif; ?>
		</div>

	</div>

</div>