
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('Cache'); ?></h2>

    <table class="shadow-box-bottom">
		<thead>
		    <tr>
				<th class="name"><?php echo $this->Paginator->sort(__('Name',true),'Content.contentName');?></th>
				<th class="hash"><?php echo $this->Paginator->sort(__('Hash',true),'contentHash');?></th>
				<th class="length"><?php echo $this->Paginator->sort(__('Length',true),'contentLength');?></th>
				<th class="description"><?php echo $this->Paginator->sort(__('Description',true),'processMessage');?></th>
				<th class="relevance"><?php echo $this->Paginator->sort(__('Relevance',true),'contentPriority');?></th>
				<!-- <th class="actions"><?php __('Actions',true);?></th> -->
		    </tr>
		</thead>
		<tbody>
		    <?php foreach ($cacheContents as $cacheContent): ?>
			<tr>
			    <td>
				<?php echo $this->Html->link($cacheContent['Content']['contentName'], array('controller'=>'contents','action' => 'edit', $cacheContent['CacheContent']['contentID'])); ?></td>
			    <td><?php echo $cacheContent['CacheContent']['contentHash']; ?></td>
			    <td><?php echo $cacheContent['CacheContent']['contentLength']; ?></td>
			    <td><?php echo $cacheContent['CacheContent']['processMessage']; ?></td>
			    <td><?php if($cacheContent['CacheContent']['contentPriority'] > 0){
						echo $cacheContent['CacheContent']['contentPriority'];
					}?>
			    </td>
			    <td class="actions">
				    <?php echo $this->Html->link(__('View', true), array('action' => 'view', $cacheContent['CacheContent']['contentID'])); ?>
			    </td>
			</tr>
		    <?php endforeach; ?>
		    <tr>
	        	<th colspan="5"><?php echo $this->Html->link(__('Clear cache', true), array('action' => 'clear'), array('class'=>'button'), sprintf(__('Are you sure you want to delete all contents in the cache?', true))); ?></th>
	      </tr>
		</tbody>
    </table>

    <table id="listpage" class="shadow-box-bottom">
      <tr>
        <th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
              <th><?php echo $paginator->numbers(); echo ' ('.$paginator->counter().')';?></th>
        <th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
      </tr>
  </table>
</div>
