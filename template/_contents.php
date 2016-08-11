<?php if ($contents): ?>
	
	<div class="contents js-contents">

	<?php foreach ($contents as $content): ?>
		<?php require($this->getTemplatePath('_content')) ?>
	<?php endforeach ?>
		
	</div>

<?php endif ?>
