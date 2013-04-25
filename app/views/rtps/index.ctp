
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('RTP'); ?></h2>

	<div class="search shadow-box-bottom">
	<?php echo $form->create('Search',array( 'url' => array('controller' => 'rtps', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text', 'label'=> __('Search: ', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	      echo $form->end(__('Go', true));?>
	</div>


<table class="shadow-box-bottom">
<tr>
	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
	<th class="from"><?php echo $paginator->sort(__('From', true), 'from_addr'); ?></th>
    <th class="to"><?php echo $paginator->sort(__('To', true), 'to_addr'); ?></th>
	<th class="number"><?php echo $paginator->sort(__('Duration', true), 'duration'); ?></th>
	<th class="relevance"><?php echo $paginator->sort(__('Rel.',true), 'relevance'); ?></th>
	<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
    <th class="info"><?php __('Info'); ?></th>
</tr>
<?php foreach ($rtps as $rtp): ?>
<?php
 /* time in HH:MM:SS */
 $h = (int)($rtp['Rtp']['duration']/3600);
 $m = (int)(($rtp['Rtp']['duration']-3600*$h)/60);
 $s = $rtp['Rtp']['duration'] - 3600*$h - 60*$m;
 $hms=''.$h.':'.$m.':'.$s;
?>
<?php if ($rtp['Rtp']['first_visualization_user_id']) : ?>
  <tr>
	<td><?php echo $html->link($rtp['Rtp']['capture_date'],'/rtps/view/' . $rtp['Rtp']['id']) ; ?></td>
    <td><?php echo $rtp['Rtp']['from_addr']; ?></td>
    <td><?php echo $rtp['Rtp']['to_addr']; ?></td>
	<td><?php echo $html->link($hms,'/rtps/view/' . $rtp['Rtp']['id']); ?></td>
	<td><?php
		if($rtp['Rtp']['relevance'] > 0){
			echo $rtp['Rtp']['relevance'];
		}
	 ?></td>
	<td title="<?php echo htmlentities($rtp['Rtp']['comments']) ?>">
		<?php
		if( strlen(htmlentities($rtp['Rtp']['comments'])) > 50 ){
		 	echo substr(htmlentities($rtp['Rtp']['comments']),0,50).'...'; 
		}else{
			echo htmlentities($rtp['Rtp']['comments']); 
		}
		?>
	</td>
    <td class="pinfo"><a href="#" onclick="popupVetrina('/rtps/info/<?php echo $rtp['Rtp']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $rtp['Rtp']['id']); ?></div></td>
  </tr>
<?php else : ?>
	<tr>
		<td><?php echo $html->link($rtp['Rtp']['capture_date'],'/rtps/view/' . $rtp['Rtp']['id']) ; ?></td>
	    <td><?php echo $rtp['Rtp']['from_addr']; ?></td>
	    <td><?php echo $rtp['Rtp']['to_addr']; ?></td>
		<td><?php echo $html->link($hms,'/rtps/view/' . $rtp['Rtp']['id']); ?></td>
		<td><?php
			if($rtp['Rtp']['relevance'] > 0){
				echo $rtp['Rtp']['relevance'];
			}
		 ?></td>
		<td title="<?php echo htmlentities($rtp['Rtp']['comments']) ?>">
		<?php
		if( strlen(htmlentities($rtp['Rtp']['comments'])) > 50 ){
		 	echo substr(htmlentities($rtp['Rtp']['comments']),0,50).'...'; 
		}else{
			echo htmlentities($rtp['Rtp']['comments']); 
		}
		?>
		</td>
		<td class="pinfo"><a href="#" onclick="popupVetrina('/rtps/info/<?php echo $rtp['Rtp']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $rtp['Rtp']['id']); ?></div>
		</td>
	</tr>
<?php endif ?>
<?php endforeach; ?>
</table>

<?php echo $this->element('paginator'); ?>

<!--Export to .csv-->
<?php
   echo $form->create('ParserCSV',array( 'url' => array('controller' => 'sips', 'action' => 'export')));
   echo $form->end(__('Export to .csv file', true));
?>
</div>
