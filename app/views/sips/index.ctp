
<script language="text/javascript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('SIP'); ?></h2>

	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search',array( 'url' => array('controller' => 'sips', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text','label'=> __('Search:', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	      echo $form->end(__('Go', true));?>

	</div>

<table id="messagelist" class="shadow-box-bottom">
<tr>
	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
	<th class="from"><?php echo $paginator->sort(__('From', true), 'from_addr'); ?></th>
    <th class="to"><?php echo $paginator->sort(__('To', true), 'to_addr'); ?></th>
	<th class="number"><?php echo $paginator->sort(__('Duration', true), 'duration'); ?></th>
	<th class="relevance"><?php echo $paginator->sort(__('Rel.',true), 'relevance'); ?></th>
	<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
    <th class="date"><?php __('Info'); ?></th>
</tr>
<?php foreach ($sips as $sip): ?>
<?php
 /* time in HH:MM:SS */
 $h = (int)($sip['Sip']['duration']/3600);
 $m = (int)(($sip['Sip']['duration']-3600*$h)/60);
 $s = $sip['Sip']['duration'] - 3600*$h - 60*$m;
 $hms=''.$h.':'.$m.':'.$s;
?>
<?php if ($sip['Sip']['first_visualization_user_id']) : ?>
  <tr>
	<td><?php echo $sip['Sip']['capture_date']; ?></td>
        <td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['from_addr'])); ?> </td>
        <td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['to_addr'])); ?></td>
	<td><?php echo $html->link($hms,'/sips/view/' . $sip['Sip']['id']); ?></td>
	<td><?php if($sip['Sip']['relevance'] > 0){
			echo $sip['Sip']['relevance'];
		}?></td>
	<td><?php echo $sip['Sip']['comments']; ?></td>
        <td class="pinfo"><a href="#" onclick="popupVetrina('/sips/info/<?php echo $sip['Sip']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $sip['Sip']['id']); ?></div></td>
  </tr>
<?php else : ?>
 <tr>
	<td><?php echo $sip['Sip']['capture_date']; ?></td>
        <td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['from_addr'])); ?></td>
        <td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['to_addr'])); ?></td>
	<td><?php echo $html->link($hms,'/sips/view/' . $sip['Sip']['id']); ?></td>
	<td><?php
		if($sip['Sip']['relevance'] > 0){
			echo $sip['Sip']['relevance'];
		}
	 ?></td>
	<td><?php echo $sip['Sip']['comments']; ?></td>

        <td class="pinfo"><a href="#" onclick="popupVetrina('/sips/info/<?php echo $sip['Sip']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $sip['Sip']['id']); ?></div></td>
  </tr>
<?php endif ?>
<?php endforeach; ?>
</table>

	<table id="listpage" class="shadow-box-bottom">
		<tr>
			<th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
		       	<th><?php echo $paginator->numbers(); echo ' ('.$paginator->counter().')';?></th>
			<th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
		</tr>
	</table>

<!--Export to .csv-->
<?php
   echo $form->create('ParserCSV',array( 'url' => array('controller' => 'sips', 'action' => 'export')));
   echo $form->end(__('Export to .csv file', true));
?>
</div>
