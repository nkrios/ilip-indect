
<div class="generic boxstyle_white">
    <h2 class="shadow-box-bottom">Undecoded</h2>
    <div class="search shadow-box-bottom">
    <?php echo $form->create('Search',array( 'url' => array('controller' => 'msn_chats', 'action' => 'index')));
        echo $form->input('search', array('type'=>'text', 'maxlength' =>'40','label' => __('Search: ', true), 'default' => $srchd));
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
    	<td><?php echo $unknow['Unknow']['capture_date']; ?></td>
           	<?php if ($unknow['Unknow']['file_path'] != 'None'): ?>
        <td><?php echo $html->link(substr($unknow['Unknow']['dst'],0,30),'/unknows/file/' . $unknow['Unknow']['id']); ?></td>
            <?php else : ?>
        <td><?php echo $unknow['Unknow']['dst']; ?></td>
            <?php endif ?>
        <td><?php echo $unknow['Unknow']['dst_port']; ?></td>
        <td><?php echo $unknow['Unknow']['l7prot']; ?></td>
    	<td><?php echo $unknow['Unknow']['duration']; ?></td>
    	<td><?php echo $unknow['Unknow']['size']; ?></td>

        <td><?php 
            echo $this->Form->create('EditRel',array( 'url' => '/unknows/index'));
            echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$unknow['Unknow']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
            echo $form->hidden('id', array('value' => $unknow['Unknow']['id']));
            echo $this->Form->end();
            ?>          
        </td>
        <td><?php 
            echo $this->Form->create('EditCom',array('url' => '/unknows/index'));    
            echo $this->Form->textarea('comments',array('type'=>'string','rows'=>'2','default' => $unknow['Unknow']['comments'],'label' => false));
            echo $form->hidden('id', array('value' => $unknow['Unknow']['id']));
            echo $this->Form->end();
            ?>
        </td>

        <td class="pinfo"><a href="#" onclick="popupVetrina('/unknows/info/<?php echo $unknow['Unknow']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $unknow['Unknow']['id']); ?></div></td>
      </tr>

     <?php else : ?>
      <tr>
    	<td><?php echo $unknow['Unknow']['capture_date']; ?></td>
            <?php if ($unknow['Unknow']['file_path'] != 'None'): ?>
        <td><?php echo $html->link(substr($unknow['Unknow']['dst'],0,30),'/unknows/file/' . $unknow['Unknow']['id']); ?></td>
            <?php else : ?>
        <td><?php echo $unknow['Unknow']['dst']; ?></td>
            <?php endif ?>
    	<td><?php echo $unknow['Unknow']['dst_port']; ?></td>
    	<td><?php echo $unknow['Unknow']['l7prot']; ?></td>
    	<td><?php echo $unknow['Unknow']['duration']; ?></td>
    	<td><?php echo $unknow['Unknow']['size']; ?></td>
        <td><?php 
            echo $this->Form->create('EditRel',array( 'url' => '/unknows/index'));
            echo $this->Form->input('relevance',array('options' =>$relevanceoptions, 'default'=>$unknow['Unknow']['relevance'],'type'=>'select','empty' => '-', 'label'=>false));
            echo $form->hidden('id', array('value' => $unknow['Unknow']['id']));
            echo $this->Form->end();
            ?>          
        </td>
        <td><?php 
            echo $this->Form->create('EditCom',array('url' => '/unknows/index'));    
            echo $this->Form->textarea('comments',array('type'=>'string','rows'=>'2','default' => $unknow['Unknow']['comments'],'label' => false));
            echo $form->hidden('id', array('value' => $unknow['Unknow']['id']));
            echo $this->Form->end();
            ?>
        </td>
        <td class="pinfo"><a href="#" onclick="popupVetrina('/unknows/info/<?php echo $unknow['Unknow']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $unknow['Unknow']['id']); ?></div></td>
      </tr>

 <?php endif ?>
<?php endforeach; ?>

</table>

<?php echo $this->element('paginator'); ?>
</div>
