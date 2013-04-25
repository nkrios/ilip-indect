<?php function unicode2html($string) {
    return preg_replace('/\\\\u([0-9a-z]{4})/', '&#x$1;', $string);
} ?>

<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom">Facebook Chats</h2>
	<div class="search shadow-box-bottom">
		<?php echo $this->Form->create('Search', array( 'url' => array('controller' => 'fbuchats', 'action' => 'index')));
		      echo $this->Form->input('search', array( 'type'=>'text', 'label'=>__('Search: ', true), 'default' => $srchd));
		      echo $this->Form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
		 echo $this->Form->end(__('Go', true));?>
	</div>

	<table class="shadow-box-bottom">
		<tr>
			<th><?php echo $paginator->sort(__('Users', true), 'user'); ?></th>
			<th><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
			<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
		</tr>
	<?php foreach ($fb_users as $user): ?>
	  	<tr>
	        <td><a href="<?php echo '/fbuchats/user/'.$user['Fbuchat']['id']; ?>"><?php echo unicode2html($user['Fbuchat']['user']) ?></a>
	        </td>
			<td><?php
				echo $this->Form->create('EditRel',array('url' => '/fbuchats/index/'.$user['Fbuchat']['id']));
				echo $this->Form->select('relevance', $relevanceoptions, $user['Fbuchat']['relevance'] ,array('empty'=> __('-', true),'default'=>$relevance));
				echo $this->Form->hidden('id', array('value' => $user['Fbuchat']['id']));
				echo $this->Form->end();
				?>	    	
		    </td>
			<td><?php 
				echo $this->Form->create('EditCom',array('url' => '/fbuchats/index/'.$user['Fbuchat']['id']));
				echo $this->Form->textarea('comments', array ('default' => $user['Fbuchat']['comments'],'rows'=>'2','label' => false));
				echo $this->Form->hidden('id', array('value' => $user['Fbuchat']['id']));
				echo $this->Form->end();
				?>	
			</td>
	  </tr>
	<?php endforeach; ?>
	</table>

<?php echo $this->element('paginator'); ?>
</div>

