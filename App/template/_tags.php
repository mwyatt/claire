<?php if (isset($tags)): ?>
	
<div class="tags clearfix">

	<?php foreach ($tags as $tag): ?>
		<?php include($this->getTemplatePath('_tag')) ?>
	<?php endforeach ?>
		
</div>

<?php endif ?>