<head>
<!-- 	<meta http-equiv="refresh" content="5" url="/pluginManager/pluginmanager" > -->
</head>

<div class="generic">
  <div class="search">
     <p>
     <?php echo $this->Html->link(__('New MIME type / Plugin Rule', true), array('action' => 'add')); ?>
     </p>
  </div>
  </br>
    
  <?php echo $session->flash(); ?>
  <table id="messagelist" summary="Message list" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
	  <th class="type"><?php echo $this->Paginator->sort(__('MIME Type',true),'type');?></th>
	  <th class="order"><?php echo $this->Paginator->sort(__('Plugin Order',true),'pluginOrder');?></th>
	  <th class="name"><?php echo $this->Paginator->sort(__('Plugin Name',true),'pluginName');?></th>
	  <th width="100px"><?php __('Actions');?></th>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($typesPlugins as $typesPlugin): ?>
      <tr>
	      <td><?php echo $typesPlugin['TypesPlugin']['type']; ?>&nbsp;</td>
	      <td><?php echo $typesPlugin['TypesPlugin']['pluginOrder']; ?>&nbsp;</td>
	      <td>
		      <?php 
			      echo $html->link($typesPlugin['Plugin']['pluginName'], array('controller' => 'plugins', 'action' => 'edit', $typesPlugin['TypesPlugin']['pluginID']));
			?>
	      </td>
	      <td class="actions">
		      <!--<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $typesPlugin['TypesPlugin']['ruleID'])); ?>-->
		      <?php echo $this->Html->link(__('Edit/View', true), array('action' => 'edit', $typesPlugin['TypesPlugin']['ruleID'])); ?>
		      <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $typesPlugin['TypesPlugin']['ruleID']), null, sprintf(__('Are you sure you want to delete # %s?', true), $typesPlugin['TypesPlugin']['ruleID'])); ?>
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
