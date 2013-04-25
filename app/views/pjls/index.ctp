
<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php echo 'Printer' ?></h2>

	<div class="search shadow-box-bottom">
	<?php echo $form->create('Search',array( 'url' => array('controller' => 'pjls', 'action' => 'index')));
	      echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
	      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
	     echo $form->end(__('Go', true));?>
	</div>

	<table class="shadow-box-bottom">
		<tr>
			<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
			<th class="url"><?php echo $paginator->sort(__('Url', true), 'url'); ?></th>
			<th class="size"><?php echo $paginator->sort(__('Data Size', true), 'pdf_size'); ?></th>
			<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
			<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
			<th class="info"><?php __('Info'); ?></th>
		</tr>
		<?php foreach ($pjls as $pjl): ?>
		<?php if ($pjl['Pjl']['first_visualization_user_id']) : ?>
		<tr>
			<td><?php echo $pjl['Pjl']['capture_date']; ?></td>
		    <td><?php echo $html->link($pjl['Pjl']['url'], 'view/' . $pjl['Pjl']['id']); ?></td>
			<td><?php echo $pjl['Pjl']['pdf_size']; ?></td>
		    <td>
		    	<?php 
			    echo $this->Form->create('EditRel',array('url' => '/pjls/index/'.$pjl['Pjl']['id']));
				echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$pjl['Pjl']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
				echo $this->Form->hidden('id', array('value' => $pjl['Pjl']['id']));
				echo $this->Form->end();
				?>
			</td>
			<td>
				<?php 
				echo $this->Form->create('EditCom',array('url' => '/pjls/index/'. $pjl['Pjl']['id']));	
				echo $this->Form->input('comments',array('default' => $pjl['Pjl']['comments'],'label' => false));
				echo $this->Form->hidden('id', array('value' => $pjl['Pjl']['id']));
				echo $this->Form->end();
				?>
			</td>
		    <td class="pinfo" ><a href="#" onclick="popupVetrina('/pjls/info/<?php echo $pjl['Pjl']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $pjl['Pjl']['id']); ?></div></td>
		</tr>
	<?php else : ?>
		<tr>
			<td><?php echo $pjl['Pjl']['capture_date']; ?></td>
		    <td><?php echo $html->link($pjl['Pjl']['url'], 'view/' . $pjl['Pjl']['id']); ?></td>
			<td><?php echo $pjl['Pjl']['pdf_size']; ?></td>
		    <td>
		    	<?php 
			    echo $this->Form->create('EditRel',array('url' => '/pjls/index/'.$pjl['Pjl']['id']));
				echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$pjl['Pjl']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
				echo $this->Form->hidden('id', array('value' => $pjl['Pjl']['id']));
				echo $this->Form->end();
				?>
			</td>
			<td>
				<?php 
				echo $this->Form->create('EditCom',array('url' => '/pjls/index/'. $pjl['Pjl']['id']));	
				echo $this->Form->input('comments',array('default' => $pjl['Pjl']['comments'],'label' => false));
				echo $this->Form->hidden('id', array('value' => $pjl['Pjl']['id']));
				echo $this->Form->end();
				?>
			</td>
		    <td class="pinfo" >
	        	<a href="#" onclick="popupVetrina('/pjls/info/<?php echo $pjl['Pjl']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $pjl['Pjl']['id']); ?></div>
	        </td>
		</tr>
	<?php endif ?>
	<?php endforeach; ?>
	</table>

<?php echo $this->element('paginator'); ?>
</div>