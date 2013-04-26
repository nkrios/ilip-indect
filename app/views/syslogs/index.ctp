<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom">Syslogs</h2>
  	<div class="search shadow-box-bottom">
  	<?php echo $form->create('Search',array( 'url' => array('controller' => 'msn_chats', 'action' => 'index')));
        echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
        echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
       echo $form->end(__('Go', true));?>
  	</div>

  <table class="shadow-box-bottom">
 	<tr>
		<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
		<th class="ip"><?php echo $paginator->sort(__('Hosts', true), 'hosts'); ?></th>
		<th class="size"><?php echo $paginator->sort(__('Size', true), 'cmd_size'); ?></th>
		<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
		<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	</tr>

 <?php foreach ($syslogs as $syslog): ?>
 <?php if ($syslog['Syslog']['first_visualization_user_id']) : ?>
  <tr>
	<td><?php echo $html->link($syslog['Syslog']['capture_date'],'/syslogs/view/' . $syslog['Syslog']['id']); ?></td>
	<td><?php echo $html->link($syslog['Syslog']['hosts'],'/syslogs/view/' . $syslog['Syslog']['id']); ?></td>
	<td><?php echo $syslog['Syslog']['log_size']; ?></td>
    <td><?php 
		if (  (0 <  $syslog['Syslog']['relevance']) &&  ($syslog['Syslog']['relevance'] <= max($relevanceoptions)) ) {
		  echo $syslog['Syslog']['relevance'];
		}
	    ?>
	</td>
		<td title="<?php echo htmlentities($syslog['Syslog']['comments']) ?>">
			<?php
			if( strlen(htmlentities($syslog['Syslog']['comments'])) > 50 ){
			 	echo substr(htmlentities($syslog['Syslog']['comments']),0,50).'...'; 
			}else{
				echo htmlentities($syslog['Syslog']['comments']); 
			}
			?>
		</td>
  </tr>
 <?php else : ?>
  <tr>
	<td><?php echo $html->link($syslog['Syslog']['capture_date'],'/syslogs/view/' . $syslog['Syslog']['id']); ?></td>
	<td><?php echo $html->link($syslog['Syslog']['hosts'],'/syslogs/view/' . $syslog['Syslog']['id']); ?></td>
	<td><?php echo $syslog['Syslog']['log_size']; ?></td>
    <td><?php 
		if ((0 < $syslog['Syslog']['relevance']) &&  ($syslog['Syslog']['relevance'] <= max($relevanceoptions))) {
		  echo $syslog['Syslog']['relevance'];
		}
	    ?>
	</td>
	<td title="<?php echo htmlentities($syslog['Syslog']['comments']) ?>">
		<?php
		if( strlen(htmlentities($syslog['Syslog']['comments'])) > 50 ){
		 	echo substr(htmlentities($syslog['Syslog']['comments']),0,50).'...'; 
		}else{
			echo htmlentities($syslog['Syslog']['comments']); 
		}
		?>
	</td>
  </tr>
 <?php endif ?>
<?php endforeach; ?>
</table>
</table>

<?php echo $this->element('paginator'); ?>
</div>
