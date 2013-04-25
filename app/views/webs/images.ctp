
<div class="generic boxstyle_white">
   <h2 class="shadow-box-bottom"><?php __('Images'); ?></h2>
   
   <div class="search shadow-box-bottom" style="width:60%">

   <?php 
        echo $form->create('Search',array( 'url' => array('controller' => 'webs', 'action' => 'images')));
        echo $form->input('search', array('type'=>'text','label'=>__('Search: ', true), 'default' => $srchd));
        echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','label'=>__('Relevance: ', true),'empty'=>__('-',true),'default'=>$relevance));
        echo $form->input('size', array('size' => '5'));
        echo $form->end(__('Go', true));?>
   </div>

    <table class="shadow-box-bottom">

        <?php for ($grp=0; $grp!=3; $grp++): ?>
        <tr>
            <td>
            <?php if (!empty($images[($grp*4)])) : ?>
   	            <a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)]['Web']['id']; ?>','scrollbar=auto'); return false"><img src="/webs/resBody/<?php echo $images[($grp*4)]['Web']['id']; ?>" />
            <?php endif ?>
            </td>
            <td>
            <?php if (!empty($images[($grp*4)+1])) : ?>
                <a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)+1]['Web']['id']; ?>','scrollbar=auto'); return false"><img  src="/webs/resBody/<?php echo $images[($grp*4)+1]['Web']['id']; ?>" />
            <?php endif ?>
            </td>
            <td>
            <?php if (!empty($images[($grp*4)+2])) : ?>
                <a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)+2]['Web']['id']; ?>','scrollbar=auto'); return false"><img src="/webs/resBody/<?php echo $images[($grp*4)+2]['Web']['id']; ?>" />
            <?php endif ?>
            </td>
            <td>
            <?php if (!empty($images[($grp*4)+3])) : ?>
                <a href="#" onclick="popupVetrina('/webs/viewContent/<?php echo $images[($grp*4)+3]['Web']['id']; ?>','scrollbar=auto'); return false"><img src="/webs/resBody/<?php echo $images[($grp*4)+3]['Web']['id']; ?>" />
            <?php endif ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php if (!empty($images[($grp*4)])) :
                echo $images[($grp*4)]['Web']['host']; ?>
                <table>
                    <tr>
                        <td>Relevance:
                            <?php if ((0 < $images[($grp*4)]['Web']['relevance'])) {
                	           echo $images[($grp*4)]['Web']['relevance'];
                            }?>
                        </td>
                        <td>Size: <?php echo $images[($grp*4)]['Web']['rs_bd_size']; ?></td>
                        <td><?php 
                            echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)]['Web']['id']). 'or'; ?> 
                            <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a>
                            <?php __('or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

                	   </td>
                    </tr>
                </table>

                <?php endif ?>
            </td>
            <td>
            <?php if (!empty($images[($grp*4)+1])) :
            echo $images[($grp*4)+1]['Web']['host']; ?>
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
            <td>
                <?php if (!empty($images[($grp*4)+2])) :
                echo $images[($grp*4)+2]['Web']['host']; ?>
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
            <td>
                <?php if (!empty($images[($grp*4)+3])) :
                echo $images[($grp*4)+3]['Web']['host']; ?>
                <table>
                    <tr>
                    	<td>Relevance:
                    	    <?php if ((0 < $images[($grp*4)+3]['Web']['relevance'])) {
                    	      echo $images[($grp*4)+3]['Web']['relevance'];
                    	    }?>
                    	</td>
                    	<td>Size: <?php echo $images[($grp*4)+3]['Web']['rs_bd_size']; ?></td>
                    	<td><?php echo $html->link('View/Edit','/webs/method/' . $images[($grp*4)+3]['Web']['id']).' or '?> 
                            <a href="#" onclick="popupVetrina('/webs/view/<?php echo $images[($grp*4)+3]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Image'); ?></a> <?php __(' or'); ?> <a href="#" onclick="popupVetrina('/webs/imgpage/<?php echo $images[($grp*4)+3]['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('Page'); ?></a>

                    	</td>
                    </tr>
                </table>
            <?php endif ?>
            </td>
        </tr>
    <?php endfor; ?>
    </table>

<?php echo $this->element('paginator'); ?>

</div>
