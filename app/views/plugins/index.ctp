<div class="generic">
  <div class="search">
      <p>
      <?php echo $this->Html->link(__('Add a plugin', true), array('action' => 'add')); ?>
      </p>
  </div> 
  </br>
  <table id="messagelist" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
	  <!--<th class="id"><?php //echo $this->Paginator->sort('Id','pluginId');?></th>-->
	  <th class="name"><?php echo $this->Paginator->sort('Name','pluginName');?></th>
	  <th class="type"><?php echo $this->Paginator->sort('Mime Type','pluginType');?></th>
	  <th class="url"><?php echo $this->Paginator->sort('URI','pluginURI');?></th>
	  <th class="description"><?php echo $this->Paginator->sort('Description','pluginDescription');?></th>
	  <th width="100px"><?php __('Actions');?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($plugins as $plugin): ?>
      <tr>
	      <!--<td><?php //echo $plugin['Plugin']['pluginID']; ?>&nbsp;</td>-->
	      <td><?php echo $html->link($plugin['Plugin']['pluginName'], array('action' => 'edit', $plugin['Plugin']['pluginID'])); ?></td>
	      <td><?php echo $plugin['Plugin']['pluginType']; ?>&nbsp;</td>
	      <td class="url"><?php echo $plugin['Plugin']['pluginURI']; ?>&nbsp;</td>
	      <td><?php echo $plugin['Plugin']['pluginDescription']; ?>&nbsp;</td>
	      <td class="actions">
		      <!--<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $plugin['Plugin']['pluginID'])); ?>-->
		      <?php echo $this->Html->link(__('View/Edit', true), array('action' => 'edit', $plugin['Plugin']['pluginID'])); ?>
		      <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $plugin['Plugin']['pluginID']), null, sprintf(__('Are you sure you want to delete %s?', true), $plugin['Plugin']['pluginName'])); ?>
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
