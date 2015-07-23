<?php if ($divisions): ?>
	
	<div class="divisions js-divisions">

	<?php foreach ($divisions as $division): ?>
		<?php require($this->getTemplatePath('_division')) ?>
	<?php endforeach ?>
		
	</div>

<?php endif ?>
