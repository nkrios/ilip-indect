
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom">Telnet</h2>

 	<div class="search shadow-box-bottom">
  	<?php echo $form->create('Search',array( 'url' => array('controller' => 'msn_chats', 'action' => 'index')));
		echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
		echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	   echo $form->end(__('Go', true));?>
  	</div>

  <table class="shadow-box-bottom">
 	<tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="subject"><?php echo $paginator->sort(__('Host', true), 'hostname'); ?></th>
		<th class="from"><?php echo $paginator->sort(__('Username', true), 'username'); ?></th>
		<th class="size"><?php echo $paginator->sort(__('Size', true), 'cmd_size'); ?></th>
		<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
		<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
 	</tr>
 <?php foreach ($telnets as $telnet): ?>
 <?php if ($telnet['Telnet']['first_visualization_user_id']) : ?>
	  <tr>
		<td><?php echo $html->link($telnet['Telnet']['capture_date'],'/telnets/view/' . $telnet['Telnet']['id']);?></td>
		<td><?php echo $html->link($telnet['Telnet']['hostname'],'/telnets/view/' . $telnet['Telnet']['id']); ?></td>
		<td><?php echo $telnet['Telnet']['username']; ?></td>
		<td><?php echo $telnet['Telnet']['cmd_size']; ?></td>
		<td><?php 
			if ( $telnet['Telnet']['relevance'] > 0 ) {
			  echo $telnet['Telnet']['relevance'];
			}
			?></td>
		<td title="<?php echo htmlentities($telnet['Telnet']['comments']) ?>">
			<?php
			if( strlen(htmlentities($telnet['Telnet']['comments'])) > 50 ){
			 	echo substr(htmlentities($telnet['Telnet']['comments']),0,50).'...'; 
			}else{
				echo htmlentities($telnet['Telnet']['comments']); 
			}
			?>
		</td>
	  </tr>
	 <?php else : ?>
	  <tr>
		<td><?php echo $html->link($telnet['Telnet']['capture_date'],'/telnets/view/' . $telnet['Telnet']['id']);?></td>
		<td><?php echo $html->link($telnet['Telnet']['hostname'],'/telnets/view/' . $telnet['Telnet']['id']); ?></td>
		<td><?php echo $telnet['Telnet']['username']; ?></td>
		<td><?php echo $telnet['Telnet']['cmd_size']; ?></td>
		<td><?php 
			if ( $telnet['Telnet']['relevance'] > 0 ) {
			  echo $telnet['Telnet']['relevance'];
			}
			?></td>
		<td title="<?php echo htmlentities($telnet['Telnet']['comments']) ?>">
			<?php
			if( strlen(htmlentities($telnet['Telnet']['comments'])) > 50 ){
			 	echo substr(htmlentities($telnet['Telnet']['comments']),0,50).'...'; 
			}else{
				echo htmlentities($telnet['Telnet']['comments']); 
			}
			?>
		</td>
	  </tr>
 <?php endif ?>
<?php endforeach; ?>
</table>

<?php echo $this->element('paginator'); ?>
</div>
