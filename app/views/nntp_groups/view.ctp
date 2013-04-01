
<script language="text/javascript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic">
	

	<div id="messageframe" >

		<h2><?php echo __('Article from ').$html->link($mailObj['from'], '/nntp_groups/grp/'.$article['Nntp_article']['nntp_group_id']);?></h2>
		
		<table class="headers-table shadow-box-bottom">

			<tbody>
				<tr>
					<th class="header-title"><?php __('Subject:'); ?></th>
					<td class="subject"><?php echo $mailObj['Subject']?></td>
				</tr>
				<tr>
					<th class="header-title"><?php __('Sender:'); ?></th>
					<td class="from"><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $mailObj['from'])) ?> </td>
				</tr>
				<tr>
					<th class="header-title"><?php __('Recipient:'); ?></th>
					<td class="to"><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $mailObj['to'])) ?></td>
				</tr>
				<tr>
					<th class="header-title"><?php __('Date:'); ?></th>
					<td class="date"><?php echo $mailObj['Date']?></td>
				</tr>
				<tr>
					<th class="header-title"><?php __('EML file:'); ?></th>
					<td class="date"><?php echo $html->link('article.eml', '/nntp_groups/eml') ?></td>
				</tr>
				<tr>
					<th class="header-title"><?php __('Info:'); ?></th>
					<td class="date pinfo"><a href="#" onclick="popupVetrina('/nntp_groups/info','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/'); ?></div>
					</td>
				</tr>
			</tbody>
		</table>

		<div id="web_view">
		    <?php echo $this->Form->create('Edit', array('url' => '/nntp_groups/view/'.$article['Nntp_article']['id']));?>

			<h3><?php __('Edit'); ?></h3>
			<?php 
			echo $this->Form->input('relevance', array('options' => $relevanceoptions, 'default' => $article['Nntp_article']['relevance'] ,'empty'=>'-'));
			echo $this->Form->input('comments', array('type'=>'textarea','default' => $article['Nntp_article']['comments']));
			?>

		    <?php echo $this->Form->end(__('Save', true)); ?>
			    
		</div>

		<br>

		<div id="contents_view">
			<h3>Contents</h3>
			<?php if ($mailObj['Type'] == 'html') : ?>
				<object class="html" type="text/html" data="/nntp_groups/content/<?php echo strrchr($mailObj['DataFile'], '/')?>">
					<p>backup content</p>
				</object>
			<?php elseif ($mailObj['Type'] == 'text') : ?>
				<div>
					<textarea rows="15" cols="150" readonly="readonly"><?php echo file_get_contents($mailObj['DataFile']); ?></textarea>
				</div>
			<?php endif; ?>
			<?php if (isset($mailObj['Attachments'])) : ?>
			  <table class="headers-table">
				  <tbody>
				  <?php foreach($mailObj['Attachments'] as $attachment) : ?>
				    <tr>
				    <td class="header-title">Attached <?php echo $attachment['Type'] ?></td>
				    <?php if (isset($attachment['FileName'])) : ?>
				    <td class="date"><?php echo $html->link($attachment['FileName'], '/nntp_groups/content'.strrchr($attachment['DataFile'], '/')) ?></td>
				    <?php elseif (isset($attachment['Description'])) : ?>
				    <td class="date"><?php echo $html->link($attachment['Description'], '/nntp_groups/content'.strrchr($attachment['DataFile'], '/')) ?></td>
				    <?php endif; ?>
				    </tr>
				  <?php endforeach; ?>
				  </tbody>
				</table>
			<?php endif; ?>

		</div>

	</div>
</div>
