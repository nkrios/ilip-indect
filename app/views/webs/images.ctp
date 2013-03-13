
<!--
Copyright: Gianluca Costa & Andrea de Franceschi 2007-2010, http://www.xplico.org
 Version: MPL 1.1/GPL 2.0/LGPL 2.1
-->
<script language="JavaScript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=620,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic">
<div class="search">
<center>
<?php echo $form->create('Search',array( 'url' => array('controller' => 'webs', 'action' => 'images')));
      echo $form->input('search', array('type'=>'text','size' => '40', 'label'=>__('Search:', true), 'default' => $srchd));
      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-- Choose relevance --',true),'default'=>$relevance));
      echo $form->input('size', array('size' => '10'));
 echo $form->end(__('Go', true));?>
</div>
</center>
<br/>
<table cellspacing="0">

<?php for ($grp=0; $grp!=3; $grp++): ?>
 <tr>
   <td class="webimgs">
   <?php if (!empty($images[($grp*4)])) : ?>

	<a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)]['Web']['id']; ?>','scrollbar=auto'); return false">

   <img class="webimgs" src="/webs/resBody/<?php echo $images[($grp*4)]['Web']['id']; ?>" />
   <?php endif ?>
   </td>
   <td class="webimgs">
   <?php if (!empty($images[($grp*4)+1])) : ?>

      <a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)+1]['Web']['id']; ?>','scrollbar=auto'); return false">

   <img class="webimgs" src="/webs/resBody/<?php echo $images[($grp*4)+1]['Web']['id']; ?>" />
   <?php endif ?>
   </td>
   <td class="webimgs">
   <?php if (!empty($images[($grp*4)+2])) : ?>

	<a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)+2]['Web']['id']; ?>','scrollbar=auto'); return false">

   <img class="webimgs" src="/webs/resBody/<?php echo $images[($grp*4)+2]['Web']['id']; ?>" "/>
   <?php endif ?>
   </td>
   <td class="webimgs">
   <?php if (!empty($images[($grp*4)+3])) : ?>

	<a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)+3]['Web']['id']; ?>','scrollbar=auto'); return false">

   <img class="webimgs" src="/webs/resBody/<?php echo $images[($grp*4)+3]['Web']['id']; ?>" />
   <?php endif ?>
   </td>
 </tr>
 <tr>
   <td class="webimgs">
   <?php if (!empty($images[($grp*4)])) : ?>
   <?php echo $images[($grp*4)]['Web']['host']; ?><br/>

      <table><tr>
	<td>Relevance:
	    <?php if (  (0 <  $images[($grp*4)]['Web']['relevance'])) {
	      echo $images[($grp*4)]['Web']['relevance'];
	    }?>
	</td>
	<td>Size: <?php echo $images[($grp*4)]['Web']['rs_bd_size']; ?></td>
	<td><?php echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)]['Web']['id']); ?>
	<?php __('or'); ?> 
   <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a>  <?php __('or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

	</td></tr>
      </table>

   <?php endif ?>
   </td>
   <td class="webimgs">
   <?php if (!empty($images[($grp*4)+1])) : ?>
   <?php echo $images[($grp*4)+1]['Web']['host']; ?><br/>

      <table><tr>
	<td>Relevance:
	    <?php if (  (0 <  $images[($grp*4)+1]['Web']['relevance'])) {
	      echo $images[($grp*4)+1]['Web']['relevance'];
	    }?>
	</td>
	<td>Size: <?php echo $images[($grp*4)+1]['Web']['rs_bd_size']; ?></td>
	<td><?php echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)+1]['Web']['id']); ?>
	<?php __('or'); ?> 
   <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)+1]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a> <?php __(' or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)+1]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

	</td></tr>
      </table>
   <?php endif ?>
   </td>
   <td class="webimgs">
   <?php if (!empty($images[($grp*4)+2])) : ?>
   <?php echo $images[($grp*4)+2]['Web']['host']; ?><br/>

      <table><tr>
	<td>Relevance:
	    <?php if (  (0 <  $images[($grp*4)+2]['Web']['relevance'])) {
	      echo $images[($grp*4)+2]['Web']['relevance'];
	    }?>
	</td>
	<td>Size: <?php echo $images[($grp*4)+2]['Web']['rs_bd_size']; ?></td>
	<td><?php echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)+2]['Web']['id']); ?>
	<?php __('or'); ?> 
   <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)+2]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a>  <?php __('or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)+2]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

	</td></tr>
      </table>
   <?php endif ?>
   </td>
   <td class="webimgs">
   <?php if (!empty($images[($grp*4)+3])) : ?>
   <?php echo $images[($grp*4)+3]['Web']['host']; ?><br/>

      <table><tr>
	<td>Relevance:
	    <?php if (  (0 <  $images[($grp*4)+3]['Web']['relevance'])) {
	      echo $images[($grp*4)+3]['Web']['relevance'];
	    }?>
	</td>
	<td>Size: <?php echo $images[($grp*4)+3]['Web']['rs_bd_size']; ?></td>
	<td><?php echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)+3]['Web']['id']); ?>
	<?php __('or'); ?> 
   <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)+3]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a> <?php __(' or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)+3]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

	</td></tr>
      </table>
   <?php endif ?>
   </td>
 </tr>
<?php endfor; ?>
</table>
<table id="listpage" summary="Message list" cellspacing="0">
<tr>
	<th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
       	<th><?php echo $paginator->numbers(); echo '<br/>'.$paginator->counter(); ?></th>
	<th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
</tr>
</table>
</div>
