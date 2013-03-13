<!--
Copyright: Gianluca Costa & Andrea de Franceschi 2007-2010, http://www.xplico.org
 Version: MPL 1.1/GPL 2.0/LGPL 2.1
-->
<div class="generic">
<div class="search">
<center>
	<?php echo $form->create('Search', array( 'url' => array('controller' => 'fbuchats', 'action' => 'index')));
	      echo $form->input('search', array( 'type'=>'text','size' => '40', 'label'=>__('Search:', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-- Choose relevance --',true),'default'=>$relevance));
	 echo $form->end(__('Go', true));?>
</center>
</div>
<br/>
<table id="messagelist" summary="Message list" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort(__('Users', true), 'user'); ?></th>
	<th width="80px"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
	<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
</tr>
<?php foreach ($fb_users as $user): ?>
  <tr>
        <td rowspan='2'><b><a href="<?php echo '/fbuchats/user/' . $user['Fbuchat']['id']; ?>"><script type="text/javascript"> var txt="<?php echo $user['Fbuchat']['user']; ?>"; document.write(txt); </script></a></b></td>
        <td>
	<?php 
		echo $form->create('Edit',array( 'url' => '/fbuchats/index/'));
		echo $form->select('relevance', $relevanceoptions, $user['Fbuchat']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
	</td>
	<td><?php
		echo $form->hidden('id', array('value' => $user['Fbuchat']['id']));
		echo $form->input ('comments', array ('default' => $user['Fbuchat']['comments'],'label' => false, 'size' =>'90%')       );
		?>
	</td>
  </tr><tr>
	<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
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
