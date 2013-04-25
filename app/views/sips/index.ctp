
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('SIP'); ?></h2>

	<div class="search shadow-box-bottom">

	<?php echo $form->create('Search',array( 'url' => array('controller' => 'sips', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text','label'=> __('Search: ', true), 'default' => $srchd));
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
	<?php foreach ($sips as $sip):
	 /* time in HH:MM:SS */
	 $h = (int)($sip['Sip']['duration']/3600);
	 $m = (int)(($sip['Sip']['duration']-3600*$h)/60);
	 $s = $sip['Sip']['duration'] - 3600*$h - 60*$m;
	 $hms=''.$h.':'.$m.':'.$s;

	if ($sip['Sip']['first_visualization_user_id']) : 

	?>
	  <tr>
		<td><?php echo $html->link($sip['Sip']['capture_date'],'/sips/view/' . $sip['Sip']['id']); ?></td>
	    <td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['from_addr'])); ?> </td>
	    <td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['to_addr'])); ?></td>
		<td><?php echo $html->link($hms,'/sips/view/' . $sip['Sip']['id']); ?></td>
		<td><?php if($sip['Sip']['relevance'] > 0){
				echo $sip['Sip']['relevance'];
			}?></td>
		<td title="<?php echo htmlentities($sip['Sip']['comments']) ?>">
			<?php
    		if( strlen(htmlentities($sip['Sip']['comments'])) > 50 ){
    		 	echo substr(htmlentities($sip['Sip']['comments']),0,50).'...'; 
    		}else{
    			echo htmlentities($sip['Sip']['comments']); 
    		}
    		?>
		</td>
	    <td class="pinfo"><a href="#" onclick="popupVetrina('/sips/info/<?php echo $sip['Sip']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $sip['Sip']['id']); ?></div>
	    </td>
	  </tr>
	<?php else : ?>
	 <tr>
		<td><?php echo $html->link($sip['Sip']['capture_date'],'/sips/view/' . $sip['Sip']['id']); ?></td>
	    <td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['from_addr'])); ?></td>
	    <td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $sip['Sip']['to_addr'])); ?></td>
		<td><?php echo $html->link($hms,'/sips/view/' . $sip['Sip']['id']); ?></td>
		<td><?php
			if($sip['Sip']['relevance'] > 0){
				echo $sip['Sip']['relevance'];
			}
		 ?></td>
		<td title="<?php echo htmlentities($sip['Sip']['comments']) ?>">
			<?php
    		if( strlen(htmlentities($sip['Sip']['comments'])) > 50 ){
    		 	echo substr(htmlentities($sip['Sip']['comments']),0,50).'...'; 
    		}else{
    			echo htmlentities($sip['Sip']['comments']); 
    		}
    		?>
		</td>

	    <td class="pinfo"><a href="#" onclick="popupVetrina('/sips/info/<?php echo $sip['Sip']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $sip['Sip']['id']); ?></div>
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
