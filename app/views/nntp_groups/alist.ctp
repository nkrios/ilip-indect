<!--
Copyright: Gianluca Costa & Andrea de Franceschi 2007-2010, http://www.xplico.org
 Version: MPL 1.1/GPL 2.0/LGPL 2.1
-->
<div class="generic">
<div class="search">
<center>
<?php echo $form->create('Search', array( 'url' => '/nntp_groups/alist'));
      echo $form->input('search', array('type'=>'text','size' => '40', 'label' => __('Search:', true), 'default' => $srchd));
      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-- Choose relevance --',true),'default'=>$relevance));
      echo $form->end(__('Go', true));?>
</center>
</div>
<br/>
<table class="headers-table" summary="Message headers" cellpadding="2" cellspacing="0">
<tbody>
<tr>
	<td class="header-title"><?php echo __('Title',true); ?></td>
	<td class="date" width="90%"><?php echo $nntp_group['Nntp_group']['name']; ?></td>
</tr>
<tr>
	<td class="header-title"><?php echo __('Relevance',true); ?></td>
	<td class="date" width="90%"><?php echo $nntp_group['Nntp_group']['relevance']?></td>
</tr>
<tr>
	<td class="header-title"><?php echo __('Comments',true); ?></td>
	<td class="date" width="90%"><?php
		echo $form->create('Edit_Nntp',array( 'url' => '/nntp_groups/alist/'.$nntp_group['Nntp_group']['id']));
		echo $form->input('comments', array ('default' => $nntp_group['Nntp_group']['comments'],'label' => false, 'size' => '100%'));
		echo $form->end(__('Save', true));
	     ?>
	</td>
</tr>
</tbody></table>

<br/>
 <table id="messagelist" summary="Message list" cellspacing="0">
 <tr>
	<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
	<th class="subject"><?php echo $paginator->sort(__('Subject', true), 'subject'); ?></th>
	<th class="from"><?php echo $paginator->sort(__('Sender', true), 'sender'); ?></th>
	<th class="size"><?php echo $paginator->sort(__('Size', true), 'data_size'); ?></th>
	<th class="relevance"><?php echo $paginator->sort(__('Relevance',true), 'relevance'); ?></th>
	<th><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
 </tr>
 <?php foreach ($nntp_articles as $article): ?>
 <?php if ($article['Nntp_article']['first_visualization_user_id']) : ?>
  <tr>
	<td><?php echo $article['Nntp_article']['capture_date']; ?></td>
        <?php if ($article['Nntp_article']['subject'] == "") : ?>
        <td><?php echo $html->link("--",'/nntp_groups/view/' . $article['Nntp_article']['id']); ?></td>
        <?php else : ?>
	<td><?php echo $html->link($article['Nntp_article']['subject'],'/nntp_groups/view/' . $article['Nntp_article']['id']); ?></td>
        <?php endif; ?>
	<td><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $article['Nntp_article']['sender'])); ?></td>
	<td><?php echo $article['Nntp_article']['data_size']; ?></td>
        <td><?php
		if (  (0 <  $article['Nntp_article']['relevance']) &&  ($article['Nntp_article']['relevance'] <= max($relevanceoptions)) ) {
		  echo $article['Nntp_article']['relevance'];
		}
	    ?>
	</td>
	<td><?php echo $article['Nntp_article']['comments']; ?></td>
  </tr>
 <?php else : ?>
  <tr>
	<td><b><?php echo $article['Nntp_article']['capture_date']; ?></b></td>
        <?php if ($article['Nntp_article']['subject'] == "") : ?>
        <td><b><?php echo $html->link("--",'/nntp_groups/view/' . $article['Nntp_article']['id']); ?></b></td>
        <?php else : ?>
	<td><b><?php echo $html->link($article['Nntp_article']['subject'],'/nntp_groups/view/' . $article['Nntp_article']['id']); ?></td>
        <?php endif; ?>
	<td><b><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $article['Nntp_article']['sender'])); ?></b></td>
	<td><b><?php echo $article['Nntp_article']['data_size']; ?></b></td>
        <td><?php
		if (  (0 <  $article['Nntp_article']['relevance']) &&  ($article['Nntp_article']['relevance'] <= max($relevanceoptions)) ) {
		  echo $article['Nntp_article']['relevance'];
		}
	    ?>
	</td>
	<td><?php echo $article['Nntp_article']['comments']; ?></td>
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
