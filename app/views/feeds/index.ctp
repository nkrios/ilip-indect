<!--
Copyright: Gianluca Costa & Andrea de Franceschi 2007-2010, http://www.xplico.org
 Version: MPL 1.1/GPL 2.0/LGPL 2.1
-->
<script language="JavaScript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>
<div class="generic">
<div class="search">

<center>
<?php echo $form->create('Search',array( 'url' => array('controller' => 'feeds', 'action' => 'index')));
      echo $form->input('search', array('type'=>'text','size' => '40','maxlength'=>'40', 'label'=> __('Search:', true), 'default' => $srchd));
      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-- Choose relevance --',true),'default'=>$relevance));
      echo $form->end(__('Go', true));?>
</center>
</div>
<br/>
<table id="messagelist" summary="Message list" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('Title', true), 'name'); ?></th>
	<th><?php echo $paginator->sort(__('Site', true), 'site'); ?></th>
	<th><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
	<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	<th width="70px"><?php __('Actions');?></th>
</tr>
<?php foreach ($feeds as $feed): ?>
  <tr>
	<td><b><?php echo $html->link($feed['Feed']['name'],'/feeds/view/' . $feed['Feed']['id']); ?></b></td>
        <td><b><?php echo $feed['Feed']['site']; ?></b></td>
        <td>
	<?php
		if (  (0 <  $feed['Feed']['relevance']) &&  ($feed['Feed']['relevance'] <= max($relevanceoptions)) ) {
 			echo $feed['Feed']['relevance'];
		}
	    ?>
	</td>
	<td><?php echo $feed['Feed']['comments']; ?></td>
	<td><b><?php echo $html->link('View/Edit','/feeds/view/' . $feed['Feed']['id']); ?></b></td>
  </tr>
<?php endforeach; ?>
</table>

<table id="listpage" summary="Message list" cellspacing="0">
<tr>
	<th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
       	<th><?php echo $paginator->numbers(); echo '<br/>'.$paginator->counter(); ?></th>
	<th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
</tr>
</table>
</div>
