<!--
Copyright: Gianluca Costa & Andrea de Franceschi 2007-2010, http://www.xplico.org
 Version: MPL 1.1/GPL 2.0/LGPL 2.1
-->
<div class="generic">
<div class="search">

<center>
<?php echo $form->create('Search',array( 'url' => array('controller' => 'tftps', 'action' => 'index')));
      echo $form->input('search', array('type'=>'text','size' => '40', 'label'=>__('Search:', true), 'default' => $srchd));
      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-- Choose relevance --',true),'default'=>$relevance));
      echo $form->end(__('Go', true));?>
</center>
</div>
<br/>
<table id="messagelist" summary="Message list" cellspacing="0">
<tr>
	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
	<th class="from"><?php echo $paginator->sort(__('Url', true), 'url'); ?></th>
	<th class="number"><?php echo $paginator->sort(__('Download', true), 'download_num'); ?></th>
	<th class="number"><?php echo $paginator->sort(__('Upload', true), 'upload_num'); ?></th>
	<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
	<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
</tr>
<?php foreach ($tftps as $tftp): ?>
<?php if ($tftp['Tftp']['first_visualization_user_id']) : ?>
  <tr>
	<td><?php echo $tftp['Tftp']['capture_date']; ?></td>
	<td><?php echo $html->link($tftp['Tftp']['url'],'/tftps/view/' . $tftp['Tftp']['id']); ?></td>
	<td><?php echo $tftp['Tftp']['download_num']; ?></td>
	<td><?php echo $tftp['Tftp']['upload_num']; ?></td>
        <td><?php 
		if (  (0 <  $tftp['Tftp']['relevance']) &&  ($tftp['Tftp']['relevance'] <= max($relevanceoptions)) ) {
		  echo $tftp['Tftp']['relevance'];
		}
	    ?>
	</td>
	<td><?php echo $tftp['Tftp']['comments']; ?></td>
  </tr>
<?php else : ?>
 <tr>
	<td><b><?php echo $tftp['Tftp']['capture_date']; ?></b></td>
	<td><b><?php echo $html->link($tftp['Tftp']['url'],'/tftps/view/' . $tftp['Tftp']['id']); ?></b></td>
	<td><b><?php echo $tftp['Tftp']['download_num']; ?></b></td>
	<td><b><?php echo $tftp['Tftp']['upload_num']; ?></b></td>
        <td><b><?php 
		if (  (0 <  $tftp['Tftp']['relevance']) &&  ($tftp['Tftp']['relevance'] <= max($relevanceoptions)) ) {
		  echo $tftp['Tftp']['relevance'];
		}
	    ?>
	</b></td>
	<td><b><?php echo $tftp['Tftp']['comments']; ?></b></td>
  </tr>
<?php endif ?>
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
