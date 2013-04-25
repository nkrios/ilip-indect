
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('Feeds'); ?></h2>
	<div class="search shadow-box-bottom">
	<?php 
		echo $form->create('Search',array( 'url' => array('controller' => 'feeds', 'action' => 'index')));
		echo $form->input('search', array('type'=>'text','maxlength'=>'40', 'label'=> __('Search: ', true), 'default' => $srchd));
		echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','label'=> __('Relevance: ', true),'empty'=>__('-',true),'default'=>$relevance));
		echo $form->end(__('Go', true));
	?>
	</div>

	<table class="shadow-box-bottom">
	<tr>
		<th class="username"><?php echo $paginator->sort(__('Title', true), 'name'); ?></th>
		<th class='url'><?php echo $paginator->sort(__('Site', true), 'site'); ?></th>
		<th class='relevance'><?php echo $paginator->sort(__('Rel.',true), 'relevance'); ?></th>
		<th class='comments'><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>		
	</tr>
	<?php foreach ($feeds as $feed): ?>
	  <tr>
		<td><?php echo $html->link($feed['Feed']['name'],'/feeds/view/' . $feed['Feed']['id']); ?></td>
	    <td><?php echo $feed['Feed']['site']; ?></td>
	    <td>
		<?php if((0 < $feed['Feed']['relevance']) && ($feed['Feed']['relevance'] <= max($relevanceoptions))){
	 			echo $feed['Feed']['relevance'];
			}?>
		</td>
		<td>
			<?php
	    	if( strlen(htmlentities($feed['Feed']['comments'])) > 50 ){
    		 	echo substr(htmlentities($feed['Feed']['comments']),0,50).'...'; 
    		}else{
    			echo htmlentities($feed['Feed']['comments']); 
    		}?>
		</td>
		
	  </tr>
	<?php endforeach; ?>
	</table>

<?php echo $this->element('paginator'); ?>
</div>