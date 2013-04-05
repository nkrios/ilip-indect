
<script language="text/javascript">
    function popupVetrina(whatopen){
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=620,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="generic boxstyle_white">
   <h2 class="shadow-box-bottom"><?php __('Images'); ?></h2>
   <div class="search shadow-box-bottom" style="width:60%">

   <?php echo $form->create('Search',array( 'url' => array('controller' => 'webs', 'action' => 'images')));
         echo $form->input('search', array('type'=>'text','label'=>__('Search:', true), 'default' => $srchd));
         echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'default'=>$relevance));
         echo $form->input('size', array('size' => '10'));
    echo $form->end(__('Go', true));?>
   </div>

   <table class="shadow-box-bottom">

   <?php for ($grp=0; $grp!=3; $grp++): ?>
    <tr>
      <td >
      <?php if (!empty($images[($grp*4)])) : ?>

   	<a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)]['Web']['id']; ?>','scrollbar=auto'); return false">

      <img  src="/webs/resBody/<?php echo $images[($grp*4)]['Web']['id']; ?>" />
      <?php endif ?>
      </td>
      <td >
      <?php if (!empty($images[($grp*4)+1])) : ?>

         <a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)+1]['Web']['id']; ?>','scrollbar=auto'); return false">

      <img  src="/webs/resBody/<?php echo $images[($grp*4)+1]['Web']['id']; ?>" />
      <?php endif ?>
      </td>
      <td >
      <?php if (!empty($images[($grp*4)+2])) : ?>

   	<a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)+2]['Web']['id']; ?>','scrollbar=auto'); return false">

      <img  src="/webs/resBody/<?php echo $images[($grp*4)+2]['Web']['id']; ?>" />
      <?php endif ?>
      </td>
      <td >
      <?php if (!empty($images[($grp*4)+3])) : ?>

   	<a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)+3]['Web']['id']; ?>','scrollbar=auto'); return false">

      <img  src="/webs/resBody/<?php echo $images[($grp*4)+3]['Web']['id']; ?>" />
      <?php endif ?>
      </td>
    </tr>
    <tr>
      <td >
      <?php if (!empty($images[($grp*4)])) : ?>
      <?php echo $images[($grp*4)]['Web']['host']; ?><br/>

         <table>
            <tr>
            	<td>Relevance:
            	    <?php if ((0 < $images[($grp*4)]['Web']['relevance'])) {
            	      echo $images[($grp*4)]['Web']['relevance'];
            	    }?>
            	</td>
            	<td>Size: <?php echo $images[($grp*4)]['Web']['rs_bd_size']; ?></td>
            	<td><?php echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)]['Web']['id']); ?>
            	<?php __('or'); ?> 
               <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a>  <?php __('or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

            	</td>
            </tr>
         </table>

      <?php endif ?>
      </td>
      <td >
      <?php if (!empty($images[($grp*4)+1])) : ?>
      <?php echo $images[($grp*4)+1]['Web']['host']; ?><br/>

         <table>
            <tr>
            	<td>Relevance:
            	    <?php if ((0 < $images[($grp*4)+1]['Web']['relevance'])) {
            	      echo $images[($grp*4)+1]['Web']['relevance'];
            	    }?>
            	</td>
            	<td>Size: <?php echo $images[($grp*4)+1]['Web']['rs_bd_size']; ?></td>
            	<td><?php echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)+1]['Web']['id']); ?>
            	<?php __('or'); ?> 
               <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)+1]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a> <?php __(' or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)+1]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

            	</td>
            </tr>
         </table>
      <?php endif ?>
      </td>
      <td >
      <?php if (!empty($images[($grp*4)+2])) : ?>
      <?php echo $images[($grp*4)+2]['Web']['host']; ?><br/>

         <table>
            <tr>
            	<td>Relevance:
            	    <?php if ((0 < $images[($grp*4)+2]['Web']['relevance'])) {
            	      echo $images[($grp*4)+2]['Web']['relevance'];
            	    }?>
            	</td>
            	<td>Size: <?php echo $images[($grp*4)+2]['Web']['rs_bd_size']; ?></td>
            	<td><?php echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)+2]['Web']['id']); ?>
            	<?php __('or'); ?> 
               <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)+2]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a>  <?php __('or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)+2]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

            	</td>
            </tr>
         </table>
      <?php endif ?>
      </td>
      <td >
      <?php if (!empty($images[($grp*4)+3])) : ?>
      <?php echo $images[($grp*4)+3]['Web']['host']; ?><br/>

         <table>
            <tr>
            	<td>Relevance:
            	    <?php if ((0 < $images[($grp*4)+3]['Web']['relevance'])) {
            	      echo $images[($grp*4)+3]['Web']['relevance'];
            	    }?>
            	</td>
            	<td>Size: <?php echo $images[($grp*4)+3]['Web']['rs_bd_size']; ?></td>
            	<td><?php echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)+3]['Web']['id']); ?>
            	<?php __('or'); ?> 
               <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)+3]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a> <?php __(' or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)+3]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

            	</td>
            </tr>
         </table>
      <?php endif ?>
      </td>
    </tr>
   <?php endfor; ?>
   </table>

   <table id="listpage" class="shadow-box-bottom">
      <tr>
         <th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
         <th><?php echo $paginator->numbers(); echo ' ('.$paginator->counter().')';?></th>
         <th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
      </tr>
   </table>
</div>
