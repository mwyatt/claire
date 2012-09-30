<li class="row status-<?php echo $posts->getRow('status'); ?>" data-id="<?php echo $posts->getRow('id'); ?>" data-type="<?php echo $posts->getRow('type'); ?>">
		
	<div class="cell tick js-tick"><span></span></div>
	
	<div class="cell title">
		<a href="<?php echo $view->urlCurrent(
			'?edit='.$posts->getRow('id')
		); ?>" title="Edit <?php echo $posts->getRow('title'); ?>"><?php echo $posts->getRow('title'); ?></a>
	</div>
	
	<div class="cell date"><?php echo date("dS M Y", strtotime($posts->getRow('date_published'))); ?></div>
	
	<div class="actions">
	
		<a class="delete js-delete" title="Delete <?php echo $posts->getRow('title'); ?>"></a>
		<a class="visibility js-visibility" title="Toggle Visibility"></a>
		<!--<a class="attached js-attached" title="<?php echo $attached; ?>"></a>-->
		<!--<a class="tags js-tags" title="<?php echo $tags; ?>"></a>-->
		<a class="permalink js-permalink" href="<?php echo $posts->getRow('guid'); ?>" title="Permalink to <?php echo $posts->getRow('title'); ?>"></a>
	
	</div>
	
</li>