<head>
<!-- 	<meta http-equiv="refresh" content="5" url="/pluginManager/pluginmanager" > -->
</head>

<div class="cache_contents view">
  <div class="body">

	<!-- ACTIONS -->
	<div class="cache_contents actions_2">
	  <div class="search">
	    <?php echo $this->Html->link(__('Clear all Cache Contents', true), array('action' => 'clear'), null, sprintf(__('Are you sure you want to delete all the cache contents?', true))); ?>
	  </div>
	</div>
	<br/>
	<!-- INFO -->
	<div class="cache_contentsInfo view_2">
	  <fieldset>
	      <legend><?php __('View Cache Content'); ?></legend>
	      <br/>
			<dl>
				<dt><?php __('Content ID'); ?></dt>
				<dd>
					<?php echo $cacheContent['CacheContent']['contentID']; ?>
					&nbsp;
				</dd>
				<dt><?php __('Content Hash'); ?></dt>
				<dd>
					<?php echo $cacheContent['CacheContent']['contentHash']; ?>
					&nbsp;
				</dd>
				<dt><?php __('Content Length'); ?></dt>
				<dd>
					<?php echo $cacheContent['CacheContent']['contentLength']; ?>
					&nbsp;
				</dd>
				<dt><?php __('Content Relevance'); ?></dt>
				<dd>
					<?php 
					if ( $cacheContent['CacheContent']['contentPriority'] > 0 ) {
					  echo $cacheContent['CacheContent']['contentPriority'];
					}
					?>
					&nbsp;
				</dd>
				<dt><?php __('Content Description'); ?></dt>
				<dd>
					<?php echo $cacheContent['CacheContent']['processMessage']; ?>
					&nbsp;
				</dd>
			</dl>
		</fieldset>
	</div> <br>
  </div>
</div>

