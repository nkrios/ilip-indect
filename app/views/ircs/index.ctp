
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom">IRC Chats</h2>

	<div class="search shadow-box-bottom">
	<?php echo $form->create('Search',array( 'url' => array('controller' => 'msn_chats', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	     echo $form->end(__('Go', true));?>
	</div>

<table class="shadow-box-bottom">
<tr>
	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
	<th class="url"><?php echo $paginator->sort(__('Url', true), 'url'); ?></th>
	<th class="number"><?php echo $paginator->sort(__('Channels', true), 'channel_num'); ?></th>
	<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
	<th class='comments'><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
</tr>
<?php foreach ($ircs as $irc): ?>
<?php if ($irc['Irc']['first_visualization_user_id']) : ?>
  <tr>
	<td><?php echo $irc['Irc']['capture_date']; ?></td>
	<td><?php echo $html->link($irc['Irc']['url'],'/ircs/view/' . $irc['Irc']['id']); ?></td>
	<td><?php echo $irc['Irc']['channel_num']; ?></td>
    <td><?php 
		if((0 < $irc['Irc']['relevance']) && ($irc['Irc']['relevance'] <= max($relevanceoptions))){
		  echo $irc['Irc']['relevance'];
		}
	    ?>
	</td>

	<td title="<?php echo htmlentities($irc['Irc']['comments']) ?>">
		<?php
		if( strlen(htmlentities($irc['Irc']['comments'])) > 50 ){
		 	echo substr(htmlentities($irc['Irc']['comments']),0,50).'...'; 
		}else{
			echo htmlentities($irc['Irc']['comments']); 
		}
		?>
	</td>

  </tr>
<?php else : ?>
 <tr>
	<td><?php echo $html->link($irc['Irc']['capture_date'],'/ircs/view/' . $irc['Irc']['id']); ?></td>
	<td><?php echo $html->link($irc['Irc']['url'],'/ircs/view/' . $irc['Irc']['id']); ?></td>
	<td><?php echo $irc['Irc']['channel_num']; ?></td>
    <td><?php 
		if ((0 < $irc['Irc']['relevance']) &&  ($irc['Irc']['relevance'] <= max($relevanceoptions)) ) {
		  echo $irc['Irc']['relevance'];
		}
	    ?>
	</td>
	<td title="<?php echo htmlentities($irc['Irc']['comments']) ?>">
		<?php
		if( strlen(htmlentities($irc['Irc']['comments'])) > 50 ){
		 	echo substr(htmlentities($irc['Irc']['comments']),0,50).'...'; 
		}else{
			echo htmlentities($irc['Irc']['comments']); 
		}
		?>
	</td>
  </tr>
<?php endif ?>
<?php endforeach; ?>
</table>

<?php echo $this->element('paginator'); ?>
</div>
