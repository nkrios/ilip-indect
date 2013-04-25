
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php echo 'URL: http://'.substr(htmlentities($message['Web']['url']),0,50).'...'; ?></h2>

	<div>
		<table id='web_view' class="shadow-box-bottom divamiddle">
			<tbody>
				<tr>
					<th><?php __('HTTP Request'); ?></th>
				    <th><?php __('HTTP Response'); ?></th>
				</tr>

				<tr>
				    <td>ip:port => <?php echo $src_ip_port ?> </td>
				    <td>ip:port => <?php echo $dst_ip_port ?> </td>
				</tr>

				<tr>
			        <td>
			        	<?php __('Header: Click to '); ?><span class="clickable" onclick="makeRequest('<?php echo '/webs/reqHeader/'.$message['Web']['id']; ?>')"><?php __('View'); ?>
			        	</span><?php echo 'or '.$html->link(__('Download', true), 'reqHeader/' . $message['Web']['id']); ?>
			        </td>
			        <td>
			        	<?php __('Header: Click to '); ?><span class="clickable" onclick="makeRequest('<?php echo '/webs/resHeader/'.$message['Web']['id']; ?>')"> <?php __('View'); ?></span> <?php echo 'or '.$html->link(__('Download', true), 'resHeader/' . $message['Web']['id']); ?>
			        </td>
				</tr>

				<tr>
			        <?php if ($message['Web']['rq_bd_size'] == 0) : ?>
			        <td><?php __('Body: None'); ?></td>
			        <?php else : ?>
			        <td><?php __('Body: Click to '); ?><span class="clickable" onclick="makeRequest('<?php echo '/webs/reqBody/'.$message['Web']['id']; ?>')"> <?php __('View'); ?></span> <?php echo'or '.$html->link(__('Download', true), 'reqBody/' . $message['Web']['id']) ?>
			        </td>
			        <?php endif ?>
			        
			        <?php if ($message['Web']['rs_bd_size'] == 0) : ?>
			        <td><?php __('Body: None'); ?></td>
			        <?php else : ?>
			        <td>
			        	<?php __('Body: Click to '); ?><span class="clickable" onclick="makeRequest('<?php echo '/webs/resBody/'.$message['Web']['id']; ?>')"> <?php __('View'); ?></span> <?php echo'or '.$html->link(__('Download', true), 'resBody/' . $message['Web']['id']).'  (sz:'.$message['Web']['rs_bd_size'].'b) content type:'.$message['Web']['content_type']?>
			        </td>
			        <?php endif ?>
				</tr>
			<tbody>
		</table>

		<div id="contents_view" class="generic boxstyle_white divamiddle">			
		    <?php 
		    echo $this->Form->create('Edit', array('url' => '/webs/method/'.$message['Web']['id']));
			echo $this->Form->input('relevance', array('options' => $relevanceoptions, 'default' => $message['Web']['relevance'] ,'empty'=>'-','label'=>'Relevance: '));
			echo $this->Form->input('comments', array('type'=>'string','rows'=>'3','default' => $message['Web']['comments']));
			echo $this->Form->end(); 
			?>
		</div>

	</div>

	<div class="messageframe">
		<div>
			<div id="displ"></div>
			<textarea  id="contenuto" readonly="readonly" style="text-align: left" rows="10" cols="75"></textarea>
		</div>
	</div>

</div>