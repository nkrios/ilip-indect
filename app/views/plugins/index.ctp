<div class="generic boxstyle_white">
  <h2 class="shadow-box-bottom"><?php __('Plugins'); ?></h2>

  <table class="shadow-box-bottom">
    <thead>
      <tr>
    	  <!--<th class="id"><?php //echo $this->Paginator->sort('Id','pluginId');?></th>-->
    	  <th class="username"><?php echo $this->Paginator->sort('Name','pluginName');?></th>
    	  <th class="info"><?php echo $this->Paginator->sort('Mime Type','pluginType');?></th>
    	  <th class="url"><?php echo $this->Paginator->sort('URI','pluginURI');?></th>
    	  <th class="comments"><?php echo $this->Paginator->sort('Description','pluginDescription');?></th>
    	  <th class="actions"><?php __('Actions');?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($plugins as $plugin): ?>
      <tr>
	      <!--<td><?php //echo $plugin['Plugin']['pluginID']; ?>&nbsp;</td>-->
	      <td><?php echo $html->link($plugin['Plugin']['pluginName'], array('action' => 'edit', $plugin['Plugin']['pluginID'])); ?></td>
	      <td><?php echo $plugin['Plugin']['pluginType']; ?>&nbsp;</td>
	      <td><?php echo $plugin['Plugin']['pluginURI']; ?>&nbsp;</td>
	      <td><?php echo $plugin['Plugin']['pluginDescription']; ?>&nbsp;</td>
	      <td>
		      <!--<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $plugin['Plugin']['pluginID'])); ?>-->
		      <?php
            echo $this->Html->link(
              $html->image('/img/view.png',array('class'=>'button','alt'=>'View/Edit','title'=>'View/Edit')), 
              array('action' => 'edit', $plugin['Plugin']['pluginID']),
              array('escape'=>false)
              );
              
              echo $this->Html->link(
              $html->image('/img/training.png',array('class'=>'button','alt'=>'Train','title'=>'Train')), 
              array('action' => 'train', $plugin['Plugin']['pluginID']),
              array('escape'=>false)
              );
             
		        echo $this->Html->link(
              $html->image('/img/delete2.png',array('class'=>'button','alt'=>'Delete','title'=>'Delete')),
              array('action' => 'delete', $plugin['Plugin']['pluginID']),
              array('escape'=>false),
              // array('class'=>'button','alt'=>'Delete','title'=>'Delete'), 
              sprintf(__('Are you sure you want to delete %s?', true), $plugin['Plugin']['pluginName']) 
              ); 
          ?>
	      </td>
      </tr>
      <?php endforeach; ?>
      <tr>
        <th colspan="5"><?php echo $this->Html->link(__('Add a plugin', true), array('action' => 'add'),array('class'=>'button')); ?></th>
      </tr>
    </tbody>
    </table>

<?php echo $this->element('paginator'); ?>

</div>
