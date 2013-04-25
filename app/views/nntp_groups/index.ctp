
<div class="generic boxstyle_white">
  <h2 class="shadow-box-bottom"><?php __('Nntp'); ?></h2>

  <div class="search shadow-box-bottom">
    <?php echo $form->create('Search',array( 'url' => array('controller' => 'nntp_groups', 'action' => 'index')));
        echo $form->input('search', array('type'=>'text','maxlength'=>'40', 'label'=> __('Search: ', true), 'default' => $srchd));
        echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
        echo $form->end(__('Go', true));?>

  </div>

  <table class="shadow-box-bottom">
    <tr>
    	<th class="from"><?php echo $paginator->sort(__('Title', true), 'name'); ?></th>
    	<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
    	<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
    </tr>
  <?php foreach ($nntp_groups as $grp): ?>
    <tr>
        <td><?php echo $html->link($grp['Nntp_group']['name'],'/nntp_groups/grp/' . $grp['Nntp_group']['id']); ?></td>
        <td><?php echo $grp['Nntp_group']['relevance']; ?></td>
    	<td title="<?php echo htmlentities($grp['Nntp_group']['comments']) ?>">
            <?php
            if( strlen(htmlentities($grp['Nntp_group']['comments'])) > 100 ){
                echo substr(htmlentities($grp['Nntp_group']['comments']),0,100).'...'; 
            }else{
                echo htmlentities($grp['Nntp_group']['comments']); 
            }
            ?>
        </td>
    </tr>
  <?php endforeach; ?>
  </table>

<?php echo $this->element('paginator'); ?>
</div>
