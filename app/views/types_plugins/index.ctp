
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('Plugins Rules'); ?></h2>
    
  	<table class="shadow-box-bottom">
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
			    <?php echo $html->link($typesPlugin['Plugin']['pluginName'], array('controller' => 'plugins', 'action' => 'edit', $typesPlugin['TypesPlugin']['pluginID'])); ?>
		      	</td>
		      	<td class="actions">
			      <!--<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $typesPlugin['TypesPlugin']['ruleID'])); ?>-->
			    <?php 

		            echo $this->Html->link(
		              $html->image('/img/view.png',array('class'=>'button','alt'=>'View/Edit','title'=>'View/Edit')), 
		              array('action' => 'edit', $typesPlugin['TypesPlugin']['ruleID']),
		              array('escape'=>false)
		              );

				        echo $this->Html->link(
		              $html->image('/img/delete2.png',array('class'=>'button','alt'=>'Delete','title'=>'Delete')),
		              array('action' => 'delete', $typesPlugin['TypesPlugin']['ruleID']),
		              array('escape'=>false),
		              // array('class'=>'button','alt'=>'Delete','title'=>'Delete'), 
		              sprintf(__('Are you sure you want to delete %s?', true), $typesPlugin['TypesPlugin']['ruleID']) 
		              ); 
				?>
		      	</td>
		  	</tr>
	      	<?php endforeach; ?>
	      	<tr>
	        	<th colspan="4"><?php echo $this->Html->link(__('New MIME type / Plugin Rule', true), array('action' => 'add'),array('class'=>'button')); ?></th>
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

<?php echo $session->flash(); ?>
