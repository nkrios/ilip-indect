<head>
<!-- 	<meta http-equiv="refresh" content="5" url="/pluginManager/pluginmanager" > -->
</head>

<div class="generic">
    <div class="search">
	<p>
	<?php echo $this->Html->link(__('Clear cache', true), array('action' => 'clear'), null, sprintf(__('Are you sure you want to delete all contents in the cache?', true))); ?>
	</p>
    </div>
    <br />
    <table id="messagelist" cellpadding="0" cellspacing="0">
	<thead>
	    <tr>
	      <th class="name"><?php echo $this->Paginator->sort(__('Name',true),'Content.contentName');?></th>
	      <th class="hash"><?php echo $this->Paginator->sort(__('Hash',true),'contentHash');?></th>
	      <th class="length"><?php echo $this->Paginator->sort(__('Length',true),'contentLength');?></th>
	      <th class="description"><?php echo $this->Paginator->sort(__('Description',true),'processMessage');?></th>
	      <th class="relevance"><?php echo $this->Paginator->sort(__('Relevance',true),'contentPriority');?></th>
	      <th width="100px"><?php __('Actions',true);?></th>
	    </tr>
	 </thead>
	 <tbody>
	    <?php foreach ($cacheContents as $cacheContent): ?>
		<tr>
		    <td>
			<?php echo $this->Html->link($cacheContent['Content']['contentName'], array('controller'=>'contents','action' => 'edit', $cacheContent['CacheContent']['contentID'])); ?></td>
		    <td><?php echo $cacheContent['CacheContent']['contentHash']; ?>&nbsp;</td>
		    <td><?php echo $cacheContent['CacheContent']['contentLength']; ?>&nbsp;</td>
		    <td><?php echo $cacheContent['CacheContent']['processMessage']; ?>&nbsp;</td>
		    <td><?php 
			if ( $cacheContent['CacheContent']['contentPriority'] > 0 ) {
			  echo $cacheContent['CacheContent']['contentPriority'];
			}
		    	?>&nbsp;
		    </td>
		    <td class="actions">
			    <?php echo $this->Html->link(__('View', true), array('action' => 'view', $cacheContent['CacheContent']['contentID'])); ?>
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
