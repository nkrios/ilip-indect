<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=620,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic boxstyle_white">
    <h2 class="shadow-box-bottom">Undecoded</h2>
    <div class="search shadow-box-bottom">
    <?php echo $form->create('Search',array( 'url' => array('controller' => 'msn_chats', 'action' => 'index')));
        echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
        echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
       echo $form->end(__('Go', true));?>
    </div>

<table class="shadow-box-bottom">
     <tr>
    	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
    	<th class="ip"><?php echo $paginator->sort(__('Destination', true), 'dst'); ?></th>
        <th class="size"><?php echo $paginator->sort(__('Port', true), 'dst_port'); ?></th>
        <th class="date"><?php echo $paginator->sort(__('Protocol', true), 'l7prot'); ?></th>
        <th class="size"><?php echo $paginator->sort(__('Duration [s]', true), 'duration'); ?></th>
    	<th class="size"><?php echo $paginator->sort(__('Size [byte]', true), 'size'); ?></th>
    	<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
    	<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>

       	<th class="info"><?php __('Info'); ?></th>
     </tr>
     <?php foreach ($unknows as $unknow): ?>
     <?php if ($unknow['Unknow']['first_visualization_user_id']) : ?>
      <tr>
    	<td rowspan='2'><?php echo $unknow['Unknow']['capture_date']; ?></td>
           	<?php if ($unknow['Unknow']['file_path'] != 'None'): ?>
        <td rowspan='2'><?php echo $html->link(substr($unknow['Unknow']['dst'],0,30),'/unknows/file/' . $unknow['Unknow']['id']); ?></td>
            <?php else : ?>
        <td rowspan='2'><?php echo $unknow['Unknow']['dst']; ?></td>
            <?php endif ?>
        <td rowspan='2'><?php echo $unknow['Unknow']['dst_port']; ?></td>
        <td rowspan='2'><?php echo $unknow['Unknow']['l7prot']; ?></td>
    	<td rowspan='2'><?php echo $unknow['Unknow']['duration']; ?></td>
    	<td rowspan='2'><?php echo $unknow['Unknow']['size']; ?></td>
        <td><?php 
    		echo $form->create('Edit',array( 'url' => '/unknows/index'));
    		echo $form->select('relevance', $relevanceoptions, $unknow['Unknow']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true)));
    	?>
    	</td>
    	<td><?php
    		echo $form->hidden('id', array('value' => $unknow['Unknow']['id']));
    		echo $form->input ('comments', array ('default' => $unknow['Unknow']['comments'],'label' => false));
    	?>
    	</td>
        <td class="pinfo" rowspan='2'><a href="#" onclick="popupVetrina('/unknows/info/<?php echo $unknow['Unknow']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $unknow['Unknow']['id']); ?></div></td>
      </tr>
    <tr>
    	<td colspan='2'><?php echo $form->end(__('Save', true)); ?></td>
    </tr>
     <?php else : ?>
      <tr>
    	<td rowspan='2'><?php echo $unknow['Unknow']['capture_date']; ?></td>
            <?php if ($unknow['Unknow']['file_path'] != 'None'): ?>
        <td rowspan='2'><?php echo $html->link(substr($unknow['Unknow']['dst'],0,30),'/unknows/file/' . $unknow['Unknow']['id']); ?></td>
            <?php else : ?>
        <td rowspan='2'><?php echo $unknow['Unknow']['dst']; ?></td>
            <?php endif ?>
    	<td rowspan='2'><?php echo $unknow['Unknow']['dst_port']; ?></td>
    	<td rowspan='2'><?php echo $unknow['Unknow']['l7prot']; ?></td>
    	<td rowspan='2'><?php echo $unknow['Unknow']['duration']; ?></td>
    	<td rowspan='2'><?php echo $unknow['Unknow']['size']; ?></td>
        <td><?php 
    		echo $form->create('Edit',array( 'url' => '/unknows/index'));
    		echo $form->select('relevance', $relevanceoptions, $unknow['Unknow']['relevance'] ,array('label' => __('Choose relevance', true), 'empty' => __('-', true)));
    	?>
    	</td>
    	<td><?php
    		echo $form->hidden('id', array('value' => $unknow['Unknow']['id']));
    		echo $form->input ('comments', array ('default' => $unknow['Unknow']['comments'],'label' => false));
    	?>
    	</td>
        <td class="pinfo" rowspan='2'><a href="#" onclick="popupVetrina('/unknows/info/<?php echo $unknow['Unknow']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a> <div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $unknow['Unknow']['id']); ?></div></td>
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
