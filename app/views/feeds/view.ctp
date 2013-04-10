<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic boxstyle_white">

	<h2 class="shadow-box-bottom"><?php echo 'Feed: http://'.substr(htmlentities($message['Web']['url']),0,50).' ...'; ?></h2>

	<div class="search">
		<?php 
		echo $form->create('Search',array( 'url' => '/feeds/view/'.$feed['Feed']['id']));
	    echo $form->input('search', array('type'=>'text','size' => '40','maxlength'=>'40', 'label'=> __('Search: ', true), 'default' => $srchd));
	    echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','label'=> __('Relevance: ', true),'empty'=>__('-',true),'default'=>$relevance));
	    echo $form->end(__('Go', true));
	    ?>
	</div>

	<table id='web_view' class="shadow-box-bottom divamiddle">
		<tbody>
			<tr>
				<th class="header-title"><?php echo __('Relevance',true); ?></th>
				<td class="date" width="90%"><?php echo $feed['Feed']['relevance']?></td>
			</tr>
			<tr>
				<th class="header-title"><?php echo __('Comments',true); ?></th>
				<td class="date">
					<?php
					echo $form->create('Edit_Feed',array( 'url' => '/feeds/view/'.$feed['Feed']['id']));
					echo $form->input('comments', array ('default' => $feed['Feed']['comments'],'label' => false));
					echo $form->end(__('Save', true));
			    	?>
				</td>
			</tr>
		</tbody>
	</table>

	<table id='web_view' class="shadow-box-bottom divamiddle">
		<tr>
			<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
			<th class="url"><?php echo $paginator->sort(__('Url', true), 'url'); ?></th>
			<th class="size"><?php echo $paginator->sort(__('Size', true), 'rs_bd_size'); ?></th>
			<th class="relevance"><?php echo $paginator->sort('Relevance', 'relevance'); ?></th>
			<th class="comments"><?php echo $paginator->sort('Comments', 'comments'); ?></th>
			<th class="info"><?php __('Info'); ?></th>
		</tr>
		<?php foreach ($feeds_xml as $feed):?>

		<?php if ($feed['Feed_xml']['first_visualization_user_id']) : ?>
		<tr>
			<td rowspan='2'><?php echo $feed['feed_xml']['capture_date']; ?></td>
		    <td rowspan='2'><a href="#" onclick="popupVetrina('/feeds/xml/<?php echo $feed['Feed_xml']['id']; ?>','scrollbar=auto'); return false"><?php echo $feed['Feed_xml']['url']; ?></a></td>
		    <td rowspan='2'><?php echo $feed['Feed_xml']['rs_bd_size']; ?></td>
		    <td><?php 
				echo $form->create('Edit',array( 'url' => '/feeds/view/'.$feed['Feed']['id']));
				echo $form->select('relevance', $relevanceoptions, $feed['Feed_xml']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
			</td>
			<td><?php
					echo $form->hidden('id', array('value' => $feed['Feed_xml']['id']));
					echo $form->input ('comments', array ('default' => $feed['Feed_xml']['comments'],'label' => false)       );
				?>
			</td>
		    <td class="pinfo" rowspan='2'><a href="#" onclick="popupVetrina('/feeds/info/<?php echo $feed['Feed_xml']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $feed['Feed_xml']['id']); ?></div></td>
		</tr>
		<tr>
			<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
		</tr>
		<?php else : ?>
		<tr>
			<td rowspan='2'><?php echo $feed['Feed_xml']['capture_date']; ?></td>
		    <td rowspan='2'><a href="#" onclick="popupVetrina('/feeds/xml/<?php echo $feed['Feed_xml']['id']; ?>','scrollbar=auto'); return false"><?php echo $feed['Feed_xml']['url']; ?></a></td>
		    <td rowspan='2'><?php echo $feed['Feed_xml']['rs_bd_size']; ?></td>
		    <td>
				<?php 
				echo $form->create('Edit',array( 'url' => '/feeds/view/'.$feed['Feed_xml']['feed_id']));
				echo $form->select('relevance', $relevanceoptions, $feed['Feed_xml']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true))); ?>
			</td>
			<td><?php
					echo $form->hidden('id', array('value' => $feed['Feed_xml']['id']));
					echo $form->input ('comments', array ('default' => $feed['Feed_xml']['comments'],'label' => false));
				?>
			</td>
		    <td class="pinfo" rowspan='2'>
		    	<a href="#" onclick="popupVetrina('/feeds/info/<?php echo $feed['Feed_xml']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
		    	<div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $feed['Feed_xml']['id']); ?></div>
		    </td>
		</tr>
		<tr>
			<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
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

</div>
