<li class="row status-<?php echo $status; ?>" data-id="<?php echo $id; ?>" data-type="<?php echo $type; ?>">
		
	<div class="cell tick js-tick"><span></span></div>
	
	<div class="cell title"><?php echo $title; ?></div>
	
	<div class="cell date"><?php echo date("dS M Y", strtotime($date_published)); ?></div>
	
	<div class="actions">
	
		<a class="delete js-delete" title="Delete <?php echo $title; ?>"></a>
		<a class="visibility js-visibility" title="Toggle Visibility"></a>
		<a class="attached js-attached" title="<?php echo $attached; ?>"></a>
		<a class="tags js-tags" title="<?php echo $tags; ?>"></a>
		<a class="permalink js-permalink" href="<?php echo $guid; ?>" title="Permalink to <?php echo $title; ?>"></a>
	
	</div>
	
</li>