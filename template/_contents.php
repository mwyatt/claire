<?php if ($contents): ?>
	
	<div class="contents js-contents">

	<?php foreach ($contents as $content): ?>
		<?php require($this->getPathTemplate('_content')) ?>
	<?php endforeach ?>
		
	</div>

<?php endif ?>
