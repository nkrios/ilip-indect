
<div class="generic">
  <div class="search shadow-box-bottom">
  <?php echo $form->create('Search',array( 'url' => array('controller' => 'msn_chats', 'action' => 'index')));
        echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
        echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
       echo $form->end(__('Go', true));?>
  </div>

  <table id="messagelist" class="shadow-box-bottom">
    
    <tr>
        <th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
        <th class="date"><?php echo $paginator->sort(__('End', true), 'end_date'); ?></th>
        <th class="from"><?php echo $paginator->sort(__('User-Nick name', true), 'user_nick'); ?></th>
        <th class="info"><?php __('Info'); ?></th>

    </tr>
  <?php foreach ($paltalk_exps as $paltalk): ?>
  <?php if ($paltalk['Paltalk_exp']['first_visualization_user_id']) : ?>
    <tr>
      	<td><?php echo $paltalk['Paltalk_exp']['capture_date']; ?></td>
      	<td><?php echo $paltalk['Paltalk_exp']['end_date']; ?></td>
        <td><a href="#" onclick="popupVetrina('/paltalk_exps/chat/<?php echo $paltalk['Paltalk_exp']['id']; ?>','scrollbar=auto'); return false"><?php echo $paltalk['Paltalk_exp']['user_nick']; ?></a></td>
        <td class="pinfo"><a href="#" onclick="popupVetrina('/paltalk_exps/info/<?php echo $paltalk['Paltalk_exp']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $paltalk['Paltalk_exp']['id']); ?></div></td>
    </tr>
  <?php else : ?>
    <tr>
        <td><?php echo $paltalk['Paltalk_exp']['capture_date']; ?></td>
        <td><?php echo $paltalk['Paltalk_exp']['end_date']; ?></td>
        <td><a href="#" onclick="popupVetrina('/paltalk_exps/chat/<?php echo $paltalk['Paltalk_exp']['id']; ?>','scrollbar=auto'); return false"><?php echo $paltalk['Paltalk_exp']['user_nick']; ?></a></td>
        <td class="pinfo"><a href="#" onclick="popupVetrina('/paltalk_exps/info/<?php echo $paltalk['Paltalk_exp']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a><div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $paltalk['Paltalk_exp']['id']); ?></div></td>
    </tr>
  <?php endif ?>
  <?php endforeach; ?>
  </table>

<?php echo $this->element('paginator'); ?>
</div>
