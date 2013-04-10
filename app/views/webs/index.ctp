<script>
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=620,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }

    $(function() {
		// setup overlay actions to buttons
		$("button[rel]").overlay({
			// use the Apple effect for overlay
			effect: 'apple',
			expose: '#789',		
			onLoad: function(content) {
				// find the player contained inside this overlay and load it
				this.getOverlay().find("a.player").flowplayer(0).load();
			},			
			onClose: function(content) {
				$f().unload();
			}
		});				
		
		// install flowplayers
		$("a.player").flowplayer("/files/flowplayer-3.2.2.swf");
	});	
</script>

<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('Sites'); ?></h2>
	
	<div class="search shadow-box-bottom">

		<!-- CODE FOR SELECTING WEB TYPE CONTENTS-->
		<?php echo $form->create('Search',array('url'=>array('controller'=>'webs','action'=>'index')));
		      echo '<h3>'.__('Web URLs:', true).'</h3>';
		      echo $form->radio('type', array(
		      	__('Html', true),
		      	__('Image', true), 
		      	__('Flash', true), 
		      	__('Video', true), 
		      	__('Audio', true), 
		      	__('JSON', true), 
		      	__('All', true)) ,
		      	array('separator'=> ' ','legend'=>false,'default'=>$checked)
		      );
		      echo '<br>';
		      echo $form->input('search', array('type'=>'text','size' => '40', 'label' => __('Search: ', true), 'default' => $srchd));
		      echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'label' => __('Relevance: ', true),'default'=>$relevance));
		      //echo $form->input('size', array('type'=>'hidden','size' => '10', 'label'=>'Minimum size to show', 'default' => $size));
		echo $form->end(__('Go', true));?>

	</div>

	<table class="shadow-box-bottom withcomments">
		<thead>
			<tr>
				<!--<th class="id"><?php //echo $paginator->sort('Id', 'id'); ?></th>-->
				<th class="date"><?php echo $paginator->sort(__('Date', true), 'capture_date'); ?></th>
				<th class="url"><?php echo $paginator->sort(__('Url', true), 'url'); ?></th>
				<!-- <th class="plfl"><p></p></th> -->
				<th class="type"><?php echo $paginator->sort(__('Content Type',true), 'content_type'); ?></th>
				<th class="size"><?php echo $paginator->sort(__('Size', true), 'rs_bd_size'); ?></th>
				<th class="method"><?php echo $paginator->sort(__('Method', true), 'method'); ?></th>
				<th class="relevance"><?php echo $paginator->sort(__('Rel.',true), 'relevance'); ?></th>
				<th class="comments"><?php echo $paginator->sort(__('Comments',true), 'comments'); ?></th>
				<th class="actions"><?php __('Actions');?></th>
				<th class="info"><?php __('Info'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($webs as $web): ?>
			<?php if($web['Web']['first_visualization_user_id']): ?>
			  <tr>
				<!--<td><?php //echo $web['Web']['id']; ?></td>-->
				<td><?php echo $web['Web']['capture_date']; ?></td>

			<?php if (stripos($web['Web']['content_type'], 'video') === false && stripos($web['Web']['url'], '.flv') === false) : ?>
			    <td class="url">
					<a href="/webs/view/<?php echo $web['Web']['id']; ?>" title="<?php echo htmlentities($web['Web']['url']);?>" onclick="popupVetrina('/webs/view/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false">
						<?php echo substr(htmlentities($web['Web']['url']),0,30).'...'; ?></a>
				</td>
			<?php else : ?>
			    <td class="url">
					<?php echo $html->link(substr(htmlentities($web['Web']['url']),0,30),'/webs/play/' . $web['Web']['id']); ?>
				</td>
			    <td>
			    	<button rel="<?php echo '#overlay'. $web['Web']['id']; ?>"></button>
			    	<div class="overlay" id="<?php echo 'overlay'. $web['Web']['id']; ?>">
			    		<a class="player" href="<?php echo '/webs/resBody/' . $web['Web']['id'] . '?.flv'; ?>">&nbsp;</a>
			    	</div>
			    </td>			    
			    
			<?php endif ?>
			    <td><?php echo $web['Web']['content_type']; ?></td>
			    <td><?php echo $web['Web']['rs_bd_size']; ?></td>
			    <td><?php echo $web['Web']['method']; ?></td>
			    <td><?php if ( $web['Web']['relevance'] > 0 ) {
			    	echo $web['Web']['relevance'];
			    }?></td>
			    <td><?php echo substr($web['Web']['comments'],0,30).'...' ?></td>

				<td><?php echo $html->link('View/Edit','/webs/method/' . $web['Web']['id']); ?></td>

			    <td class="pinfo">
					<a href="#" onclick="popupVetrina('/webs/info/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
					<div class="iweb">
				   		<div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $web['Web']['id']); ?>
				   		</div>
			           	<div><a title="Enable the Proxy before click!" href="#" onclick="popupVetrina('http://<?php echo $web['Web']['host']; ?>/webs/hijacking/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false">cookies</a></div>
			       </div>
		        </td>
			  </tr>
			<?php else : ?>
			 <tr>
				<!--<td><?php //echo $web['Web']['id']; ?></td>-->
				<td><?php echo $web['Web']['capture_date']; ?></td>
			        
			    <?php if (stripos($web['Web']['content_type'], 'video') === false && stripos($web['Web']['url'], '.flv') === false) : ?>

			    <td class="url">
			    	<a href="/webs/view/<?php echo $web['Web']['id']; ?>" title="<?php echo htmlentities($web['Web']['url']);?>" onclick="popupVetrina('/webs/view/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false"><?php echo substr($web['Web']['url'],0,50).'...'; ?>
			    	</a>
				</td>
			          
			    <?php else : ?>
			      	
			    <td class="url"><?php echo $html->link(substr(htmlentities($web['Web']['url']),0,30),'/webs/play/' . $web['Web']['id']); ?></td>
			    <td>
		        	<button rel="<?php echo '#overlay'. $web['Web']['id']; ?>"></button>
		        	<div class="overlay" id="<?php echo 'overlay'. $web['Web']['id']; ?>">
						<a class="player" href="<?php echo '/webs/resBody/' . $web['Web']['id'] . '?.flv'; ?>">&nbsp;</a>
		            </div>
		        </td>
			            
			    <?php endif ?>

		        <td><?php echo $web['Web']['content_type']; ?></td>
		        <td><?php echo $web['Web']['rs_bd_size']; ?></td>
		        <td><?php echo $web['Web']['method']; ?></td>

		        <td><?php if((0 < $web['Web']['relevance']) && ($web['Web']['relevance'] <= max($relevanceoptions))){
					echo $web['Web']['relevance'];
					}
			    ?></td>
		        <td><?php echo substr($web['Web']['comments'],0,30).'...' ?></td>

				<td>
					<?php echo $html->link('View/Edit','/webs/method/'.$web['Web']['id']); ?>
				</td>

		        <td class="pinfo"><a href="#" onclick="popupVetrina('/webs/info/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
		        	<div class="iweb">
		        		<div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $web['Web']['id']); ?>
		        		</div>
		         		<div><a title="Enable the Proxy before click!" href="#" onclick="popupVetrina('http://<?php echo $web['Web']['host']; ?>/webs/hijacking/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false">cookies</a></div>
		         	</div>
		        </td>
			  </tr>
			<?php endif ?>
			<?php endforeach; ?>
		</tbody>
	</table>

	<table id="listpage" class="shadow-box-bottom">
		<tr>
			<th class="next"><?php echo $paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled')); ?></th>
		       	<th><?php echo $paginator->numbers(); echo ' ('.$paginator->counter().')';?></th>
			<th class="next"><?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?></th>
		</tr>
	</table>

</div>
