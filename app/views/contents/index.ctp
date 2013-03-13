<head>
<!-- 	<meta http-equiv="refresh" content="5" url="/pluginManager/pluginmanager" > -->

	<script language="JavaScript">
		function imagePopUp(img) 
		{
			var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=950, height=700, top=85, left=140";
			window.open(img,"",opciones);  
		}
	</script>

</head>

<div class="generic">
    <div class="search">
	<p>
	<?php
	    echo $form->create(null, array ('type'=>'file', 'name'=>'path', 'action' => 'update'));
	    echo "<label>" . __(' Upload new content: ',true) . "</label>";
	    echo $form->file('New Content', array('size' => '14','style' => 'width:360px', 'name'=>'path'));
	    echo $form->end(__('Upload',true));
	?>
        </p>
	<p>
        <?php echo $this->Html->link(__('Clear all Contents', true), array('action' => 'clearAll'), null, sprintf(__('Are you sure you want to delete all the contents?', true))); ?>
	</p>
    </div>
    <br />

    <table id="messagelist" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
	    <th class="name"><?php echo $this->Paginator->sort(__('Name',true),'contentName');?></th>
	    <th class="path"><?php echo $this->Paginator->sort(__('Path',true),'contentPath');?></th>
	    <th class="type"><?php echo $this->Paginator->sort(__('Type',true),'contentType');?></th>
	    <th class="description"><?php echo $this->Paginator->sort(__('Description',true),'description');?></th>
	    <th class="relevance"><?php echo $this->Paginator->sort(__('Relevance',true),'priorityAssociated');?></th>
	    <th width="170px"><?php __('Actions');?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($contents as $content): ?>
	<tr>
		<td><?php echo "<a class=\"path\" title=".$content['Content']['contentName']." href=\"javascript:imagePopUp('$contentsContainerURI"; echo $content['Content']['contentName']; echo "')\">"; echo $content['Content']['contentName']; echo"</a>"; ?>&nbsp;</td>
		<td><?php echo $content['Content']['contentPath']; ?>&nbsp;</td>
		<td><?php echo $content['Content']['contentType']; ?>&nbsp;</td>
		<td><?php echo $content['Content']['description']; ?>&nbsp;</td>
		<td>
		    <?php 
			if ( $content['Content']['priorityAssociated'] > 0 ) {
			  echo $content['Content']['priorityAssociated'];
			}
		    ?>
		    
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Analyze', true), array('action' => 'analyze', $content['Content']['contentID'])); ?>
			<?php echo $this->Html->link(__('Train', true), array('action' => 'view', $content['Content']['contentID'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $content['Content']['contentID'])); ?>
			<?php echo $this->Html->link(__('Reset', true), array('action' => 'reset', $content['Content']['contentID'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $content['Content']['contentID']), null, sprintf(__('Are you sure you want to delete # %s: %s?', true), $content['Content']['contentID'], $content['Content']['contentName'])); ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
    </table>

    <table id="listpage" summary="Message list" cellspacing="0">
	<tr>
	    <th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
	    <th><?php echo $paginator->numbers(); echo '<br/>'.$paginator->counter(); ?></th>
	    <th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
	</tr>
    </table>
</div>
