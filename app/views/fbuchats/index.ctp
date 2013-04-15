
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom">Facebook Chats</h2>
	<div class="search shadow-box-bottom">
		<?php echo $form->create('Search', array( 'url' => array('controller' => 'fbuchats', 'action' => 'index')));
		      echo $form->input('search', array( 'type'=>'text', 'label'=>__('Search: ', true), 'default' => $srchd));
		      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
		 echo $form->end(__('Go', true));?>
	</div>

	<table class="shadow-box-bottom">
		<tr>
			<th><?php echo $paginator->sort(__('Users', true), 'user'); ?></th>
			<th><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
			<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
		</tr>
	<?php foreach ($fb_users as $user): ?>
	  	<tr>
	        <td><a href="<?php echo '/fbuchats/user/' . $user['Fbuchat']['id']; ?>"><script type="text/javascript"> var txt="<?php echo $user['Fbuchat']['user']; ?>"; document.write(txt); </script></a>
	        </td>
		    <td><?php 
				echo $form->create('Edit',array( 'url' => '/fbuchats/index/'));
				echo $form->select('relevance', $relevanceoptions, $user['Fbuchat']['relevance'] ,array('empty'=> __('-', true),'default'=>$relevance)); ?>
			</td>
			<td><?php
				echo $form->hidden('id', array('value' => $user['Fbuchat']['id']));
				echo $form->input ('comments', array ('default' => $user['Fbuchat']['comments'],'label' => false, 'size' =>'90%')       );
				
				echo $form->end(__('Save', true)); ?>
			</td>
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
