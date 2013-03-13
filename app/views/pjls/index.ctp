<!--
Copyright: Gianluca Costa & Andrea de Franceschi 2007-2010, http://www.xplico.org
 Version: MPL 1.1/GPL 2.0/LGPL 2.1
-->
<script language="JavaScript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic">
<div class="search">
<center>
<?php echo $form->create('Search',array( 'url' => array('controller' => 'pjls', 'action' => 'index')));
      echo $form->input('search', array('type'=>'text','size' => '40', 'label' => __('Search:', true), 'default' => $srchd));
      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-- Choose relevance --',true),'default'=>$relevance));
     echo $form->end(__('Go', true));?>
</center>
</div>

<h2><?php __('List printed file'); ?></h2>

<table id="messagelist" summary="Message list" cellspacing="0">
<tr>
	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
	<th class="from"><?php echo $paginator->sort(__('Url', true), 'url'); ?></th>
	<th class="size"><?php echo $paginator->sort(__('Data Size', true), 'pdf_size'); ?></th>
	<th><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
	<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
	<th class="info"><?php __('Info'); ?></th>
</tr>
<?php foreach ($pjls as $pjl): ?>
<?php if ($pjl['Pjl']['first_visualization_user_id']) : ?>
  <tr>
	<td rowspan='2'><?php echo $pjl['Pjl']['capture_date']; ?></td>
        <td rowspan='2'><?php echo $html->link($pjl['Pjl']['url'], 'view/' . $pjl['Pjl']['id']); ?></td>

	<td rowspan='2'><?php echo $pjl['Pjl']['pdf_size']; ?></td>
        <td>
	<?php 
		echo $form->create('Edit',array( 'url' => '/pjls/index/'));
		echo $form->select('relevance', $relevanceoptions, $pjl['Pjl']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
	</td>
	<td><?php
		echo $form->hidden('id', array('value' => $pjl['Pjl']['id']));
		echo $form->input ('comments', array ('default' => $pjl['Pjl']['comments'],'label' => false)       );
		?>
	</td>
        <td class="pinfo" rowspan='2'><a href="#" onclick="popupVetrina('/pjls/info/<?php echo $pjl['Pjl']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $pjl['Pjl']['id']); ?></div></td>
  </tr><tr>
	<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
  </tr>
<?php else : ?>
 <tr>
	<td rowspan='2'><b><?php echo $pjl['Pjl']['capture_date']; ?></b></td>
        <td rowspan='2'><b><?php echo $html->link($pjl['Pjl']['url'], 'view/' . $pjl['Pjl']['id']); ?></b></td>
	<td rowspan='2'><b><?php echo $pjl['Pjl']['pdf_size']; ?></b></td>
        <td><b>
	<?php 
		echo $form->create('Edit',array( 'url' => '/pjls/index/'));
		echo $form->select('relevance', $relevanceoptions, $pjl['Pjl']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
	</b></td>
	<td><b><?php
		echo $form->hidden('id', array('value' => $pjl['Pjl']['id']));
		echo $form->input ('comments', array ('default' => $pjl['Ftp']['comments'],'label' => false)       );
		?>
	</b></td>
        <td class="pinfo" rowspan='2'><b><a href="#" onclick="popupVetrina('/pjls/info/<?php echo $pjl['Pjl']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a></b><div class="ipcap"><b><?php echo $html->link('pcap', 'pcap/' . $pjl['Pjl']['id']); ?></b></div></td>

  </tr><tr>
	<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
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
