<div class="generic boxstyle_white">
	<h2 class="shadow-box-bottom"><?php __('Sites'); ?></h2>
	
	<div class="search shadow-box-bottom">

		<?php 
		echo $form->create('Search',array('url'=>array('controller'=>'webs','action'=>'index')));
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
		echo $form->input('search', array('type'=>'text', 'label' => __('Search: ', true), 'default' => $srchd));
		echo $form->input('relevance', array('options'=>$relevanceoptions, 'all','empty'=>__('-',true),'label' => __('Relevance: ', true),'default'=>$relevance));
		//echo $form->input('size', array('type'=>'hidden','size' => '10', 'label'=>'Minimum size to show', 'default' => $size));
		echo $form->end(__('Go', true));
		?>

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
				<!-- <th class="actions"><?php __('Actions');?></th> -->
				<th class="info"><?php __('Info'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($webs as $web): ?>
			<?php if($web['Web']['first_visualization_user_id']): ?>
		  	<tr>
				<!--<td><?php //echo $web['Web']['id']; ?></td>-->
				<td><?php echo $html->link($web['Web']['capture_date'],'/webs/method/'.$web['Web']['id']); ?></td>

		<?php if (stripos($web['Web']['content_type'], 'video') === false && stripos($web['Web']['url'], '.flv') === false) : ?>
		    	<td class="url"><a href="/webs/view/<?php echo $web['Web']['id']; ?>" title="<?php echo htmlentities($web['Web']['url']);?>" onclick="popupVetrina('/webs/view/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false" title="<?php htmlentities($web['Web']['url']) ?>">
		    		<?php
		    		if( strlen(htmlentities($web['Web']['url'])) > 50 ){
		    		 	echo substr(htmlentities($web['Web']['url']),0,50).'...'; 
		    		}else{
		    			echo htmlentities($web['Web']['url']); 
		    		}
		    		?>
		    	</a></td>
		<?php else : ?>
		    	<td class="url">
				<?php echo $html->link(substr(htmlentities($web['Web']['url']),0,50),'/webs/play/' . $web['Web']['id'], array('title' =>htmlentities($web['Web']['url']))) ?>
				</td>
		    	<td><button rel="<?php echo '#overlay'. $web['Web']['id']; ?>"></button><div class="overlay" id="<?php echo 'overlay'. $web['Web']['id']; ?>">
		    		<a class="player" href="<?php echo '/webs/resBody/' . $web['Web']['id'] . '?.flv'; ?>"></a>
		    	</div></td>			    
			    
		<?php endif ?>
			    <td><?php echo $web['Web']['content_type']; ?></td>
			    <td><?php echo $web['Web']['rs_bd_size']; ?></td>
			    <td><?php echo $web['Web']['method']; ?></td>
			    <td><?php if ( $web['Web']['relevance'] > 0 ) {
			    	echo $web['Web']['relevance'];
			    }?></td>
			    <td class="tr-tail" title="<?php echo htmlentities($web['Web']['comments']) ?>">
			    	<!-- <div class="tail" style="display:none"><?php echo htmlentities($web['Web']['comments']) ?></div> -->
			    	<?php
		    		if( strlen(htmlentities($web['Web']['comments'])) > 50 ){
		    		 	echo substr(htmlentities($web['Web']['comments']),0,50).'...'; 
		    		}else{
		    			echo htmlentities($web['Web']['comments']); 
		    		}?>
			    </td>

			    <td class="pinfo">
					<a href="#" onclick="popupVetrina('/webs/info/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
					<div class="iweb">
				   		<div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $web['Web']['id']); ?></div>
			           	<div><a title="Enable the Proxy before click!" href="#" onclick="popupVetrina('http://<?php echo $web['Web']['host']; ?>/webs/hijacking/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false">cookies</a></div>
			       </div>
		        </td>
			  </tr>
			<?php else : ?>
			 <tr>
				<!--<td><?php //echo $web['Web']['id']; ?></td>-->
				<td><?php  echo $html->link($web['Web']['capture_date'],'/webs/method/'.$web['Web']['id']);	?></td>
			        
			    <?php if (stripos($web['Web']['content_type'], 'video') === false && stripos($web['Web']['url'], '.flv') === false) : ?>

			    <td class="url">
			    	<a href="/webs/view/<?php echo $web['Web']['id']; ?>" title="<?php echo htmlentities($web['Web']['url']);?>" onclick="popupVetrina('/webs/view/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false">
				    	<?php
			    		if( strlen(htmlentities($web['Web']['url'])) > 50 ){
			    		 	echo substr(htmlentities($web['Web']['url']),0,50).'...'; 
			    		}else{
			    			echo htmlentities($web['Web']['url']); 
			    		}?>
			    	</a>
				</td>
			          
			    <?php else : ?>
			      	
			    <td class="url">
		    		<?php
		    		if( strlen(htmlentities($web['Web']['url'])) > 50 ){
		    		 	echo $html->link(substr(htmlentities($web['Web']['url']),0,50),'/webs/play/' . $web['Web']['id']);
		    		}else{
		    			echo $html->link(htmlentities($web['Web']['url']),'/webs/play/' . $web['Web']['id']);
		    		}?>
			    </td>
			    <td>
		        	<button rel="<?php echo '#overlay'. $web['Web']['id']; ?>"></button><div class="overlay" id="<?php echo 'overlay'. $web['Web']['id']; ?>"><a class="player" href="<?php echo '/webs/resBody/' . $web['Web']['id'] . '?.flv'; ?>"></a></div>
		        </td>
			            
			    <?php endif ?>

		        <td><?php echo $web['Web']['content_type']; ?></td>
		        <td><?php echo $web['Web']['rs_bd_size']; ?></td>
		        <td><?php echo $web['Web']['method']; ?></td>

		        <td><?php if((0 < $web['Web']['relevance']) && ($web['Web']['relevance'] <= max($relevanceoptions))){
					echo $web['Web']['relevance'];
					}
			    ?></td>
			    <td class="tr-tail" title="<?php echo htmlentities($web['Web']['comments']) ?>">
			    	<!-- <div class="tail" style="display:none"><?php echo htmlentities($web['Web']['comments']) ?></div> -->
			    	<?php
			    	if( strlen(htmlentities($web['Web']['comments'])) > 50 ){
		    		 	echo substr(htmlentities($web['Web']['comments']),0,50).'...'; 
		    		}else{
		    			echo htmlentities($web['Web']['comments']); 
		    		}?>
			    </td>

		        <td class="pinfo"><a href="#" onclick="popupVetrina('/webs/info/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false"><?php __('info.xml'); ?></a>
	        		<div class="ipcap"><?php echo $html->link('pcap', 'pcap/' . $web['Web']['id']); ?>
	        		</div>
	         		<div><a title="Enable the Proxy before click!" href="#" onclick="popupVetrina('http://<?php echo $web['Web']['host']; ?>/webs/hijacking/<?php echo $web['Web']['id']; ?>','scrollbar=auto'); return false">cookies</a></div>
		        </td>
			  </tr>
			<?php endif ?>
			<?php endforeach; ?>
		</tbody>
	</table>

<?php echo $this->element('paginator'); ?>

</div>

<script>
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
		// $("a.player").flowplayer("/files/flowplayer-3.2.2.swf");
	});

	// $(".tr-tail").bind('mousemove', function(e){
	//     $('.tail').css({
	//     	display: 'block',
	//        left:  e.pageX,
	//        top:   e.pageY
	//     });
	// });

	// $(".tr-tail").bind('mouseout', function(e){
	//     $('.tail').css({
	//     	display: 'none'
	//     });
	// });
</script>
