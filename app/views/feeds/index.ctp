
<script language="text/javascript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('FEEDS'); ?></h2>
	<div class="search shadow-box-bottom">
		<?php echo $form->create('Search',array( 'url' => array('controller' => 'feeds', 'action' => 'index')));
		      echo $form->input('search', array('type'=>'text','maxlength'=>'40', 'label'=> __('Search:', true), 'default' => $srchd));
		      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
		      echo $form->end(__('Go', true));?>

	</div>

	<table class="shadow-box-bottom">
	<tr>
		<th><?php echo $paginator->sort(__('Title', true), 'name'); ?></th>
		<th class='url'><?php echo $paginator->sort(__('Site', true), 'site'); ?></th>
		<th class='relevance'><?php echo $paginator->sort(__('Rel.',true), 'relevance'); ?></th>
		<th class='comments'><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php foreach ($feeds as $feed): ?>
	  <tr>
		<td><?php echo $html->link($feed['Feed']['name'],'/feeds/view/' . $feed['Feed']['id']); ?></td>
	    <td><?php echo $feed['Feed']['site']; ?></td>
	    <td>
		<?php
			if (  (0 <  $feed['Feed']['relevance']) &&  ($feed['Feed']['relevance'] <= max($relevanceoptions)) ) {
	 			echo $feed['Feed']['relevance'];
			}
		    ?>
		</td>
		<td><?php echo $feed['Feed']['comments']; ?></td>
		<td><?php echo $html->link('View/Edit','/feeds/view/' . $feed['Feed']['id']); ?></td>
	  </tr>
	<?php endforeach; ?>
	</table>

	<table id="listpage" class="shadow-box-bottom">
		<tr>
			<th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
		       	<th><?php echo $paginator->numbers(); echo ' ('.$paginator->counter().')';?></th>
			<th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
		</tr>
	</table>
</div>
