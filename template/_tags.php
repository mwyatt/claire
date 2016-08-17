<?php if ($tags): ?>
	
<div class="tags clearfix">

	<?php foreach ($tags as $tag): ?>
		<?php include($this->getPathTemplate('_tag')) ?>
	<?php endforeach ?>
		
</div>

<?php endif ?>
